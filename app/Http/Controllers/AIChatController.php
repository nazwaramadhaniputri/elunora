<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AIChatController extends Controller
{
    public function index()
    {
        return view('ai');
    }

    public function stream(Request $request)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:4000'],
        ]);

        $apiKey = env('OPENAI_API_KEY');
        $apiBase = rtrim(env('OPENAI_API_BASE', 'https://api.openai.com/v1'), '/');
        $model = env('OPENAI_MODEL', 'gpt-3.5-turbo');

        $response = new StreamedResponse(function () use ($apiKey, $apiBase, $model, $data) {
            @ob_end_flush();
            @ob_implicit_flush(true);
            header('Content-Type: text/event-stream');
            header('Cache-Control: no-cache');

            $send = function (string $chunk) {
                echo 'data: ' . $chunk . "\n\n";
                @ob_flush();
                @flush();
            };

            if (!$apiKey) {
                // offline streaming fallback
                $answer = $this->generateLocalAnswer($data['message']);
                $parts = str_split($answer, 24);
                foreach ($parts as $p) {
                    $send(json_encode(['content' => $p]));
                    usleep(120000); // 120ms
                }
                $send(json_encode(['done' => true]));
                return;
            }

            try {
                $client = new \GuzzleHttp\Client([
                    'base_uri' => $apiBase . '/',
                    'timeout' => 60,
                    // Allow disabling SSL verification on Windows if needed
                    'verify' => filter_var(env('OPENAI_VERIFY', 'true'), FILTER_VALIDATE_BOOLEAN),
                ]);
                $payload = [
                    'model' => $model,
                    'messages' => $this->buildMessages($data['message']),
                    'temperature' => 0.7,
                    'stream' => true,
                ];
                $headers = [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ];
                if (!str_contains($apiBase, 'openrouter.ai')) {
                    if ($org = env('OPENAI_ORG')) { $headers['OpenAI-Organization'] = $org; }
                    if ($proj = env('OPENAI_PROJECT')) { $headers['OpenAI-Project'] = $proj; }
                }
                if (str_contains($apiBase, 'openrouter.ai')) {
                    $site = config('app.url') ?: ($request->getSchemeAndHttpHost() ?? 'http://localhost');
                    $headers['HTTP-Referer'] = $site;
                    $headers['X-Title'] = 'Elunora School AI';
                }
                $res = $client->post('chat/completions', [
                    'headers' => $headers,
                    'json' => $payload,
                    'stream' => true,
                ]);

                $body = $res->getBody();
                while (!$body->eof()) {
                    $line = $body->read(1024);
                    // OpenAI streams lines prefixed with 'data: '
                    // We forward minimal JSON chunks {content: "..."} so the frontend can append text
                    foreach (preg_split("/\r?\n/", $line) as $l) {
                        $l = trim($l);
                        if ($l === '' || !str_starts_with($l, 'data:')) continue;
                        $payload = substr($l, 5);
                        if ($payload === ' [DONE]' || $payload === '[DONE]') {
                            $send(json_encode(['done' => true]));
                            break 2;
                        }
                        $decoded = json_decode($payload, true);
                        $delta = $decoded['choices'][0]['delta']['content'] ?? '';
                        if ($delta !== '') {
                            $send(json_encode(['content' => $delta]));
                        }
                    }
                }
            } catch (\Throwable $e) {
                $payload = ['error' => 'stream_error'];
                if (config('app.debug')) { $payload['message'] = $e->getMessage(); }
                $send(json_encode($payload));
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        return $response;
    }

    private function systemPrompt(): string
    {
        $s = config('school');
        $lines = [
            'You are a helpful, knowledgeable AI assistant. Reply in Bahasa Indonesia by default unless asked otherwise.',
            'Be concise, friendly, and helpful.',
            'If the user asks about Elunora School specifically, use the context below:',
            '- Nama sekolah: ' . ($s['name'] ?? 'Elunora School') . ' (' . ($s['tagline'] ?? 'School of Art') . ').',
            '- Alamat: ' . ($s['address'] ?? 'Jl. Magnolia No. 17, The Aurora Residence, Kota Lavendra') . '.',
            '- Telepon: ' . ($s['phone'] ?? '(021) 7788-9900') . '. Email: ' . ($s['email'] ?? 'info@elunoraschool.sch.id') . '.',
            '- Menu situs: Beranda, Berita, Galeri, Agenda, Profile, Kontak.',
            '- Fitur: Agenda sekolah, Berita, Galeri foto (like & komentar).',
        ];
        if (!empty($s['headmaster'])) {
            $lines[] = '- Kepala Sekolah: ' . $s['headmaster'] . '.';
        }
        if (!empty($s['hours'])) {
            $hours = array_filter($s['hours']);
            if (!empty($hours)) {
                $lines[] = '- Jam operasional: ' . implode('; ', $hours) . '.';
            }
        }
        if (!empty($s['programs'])) {
            $lines[] = '- Program unggulan: ' . implode(', ', (array) $s['programs']) . '.';
        }
        if (!empty($s['vision'])) {
            $lines[] = '- Visi: ' . $s['vision'];
        }
        if (!empty($s['mission'])) {
            $lines[] = '- Misi: ' . implode(' | ', (array) $s['mission']);
        }
        $lines[] = 'Jika tidak yakin, sarankan pengguna membuka menu terkait di situs.';
        return implode("\n", $lines);
    }

    private function buildMessages(string $userMessage): array
    {
        $base = [
            ['role' => 'system', 'content' => 'You are a helpful AI assistant. Reply in Bahasa Indonesia by default unless asked otherwise. Be concise, friendly, and accurate.']
        ];
        $q = mb_strtolower($userMessage);
        $schoolKeywords = ['elunora', 'sekolah', 'alamat', 'kontak', 'kepala sekolah', 'agenda', 'galeri', 'berita', 'biaya', 'visi', 'misi', 'program'];
        foreach ($schoolKeywords as $kw) {
            if (str_contains($q, $kw)) {
                // Inject school-specific context only when relevant
                $base[] = ['role' => 'system', 'content' => $this->systemPrompt()];
                break;
            }
        }
        $base[] = ['role' => 'user', 'content' => $userMessage];
        return $base;
    }

    public function ask(Request $request)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:4000'],
        ]);

        $apiKey = env('OPENAI_API_KEY');
        $apiBase = rtrim(env('OPENAI_API_BASE', 'https://api.openai.com/v1'), '/');
        $model = env('OPENAI_MODEL', 'gpt-3.5-turbo');

        if (!$apiKey) {
            // Offline/local fallback so feature can be used immediately without API key
            $answer = $this->generateLocalAnswer($data['message']);
            return response()->json([
                'success' => true,
                'answer' => $answer,
                'offline' => true,
            ]);
        }

        try {
            $client = new \GuzzleHttp\Client([
                'base_uri' => $apiBase . '/',
                'timeout' => 30,
                'verify' => filter_var(env('OPENAI_VERIFY', 'true'), FILTER_VALIDATE_BOOLEAN),
            ]);

            $payload = [
                'model' => $model,
                'messages' => $this->buildMessages($data['message']),
                'temperature' => 0.7,
            ];

            $headers = [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ];
            if (!str_contains($apiBase, 'openrouter.ai')) {
                if ($org = env('OPENAI_ORG')) { $headers['OpenAI-Organization'] = $org; }
                if ($proj = env('OPENAI_PROJECT')) { $headers['OpenAI-Project'] = $proj; }
            }
            if (str_contains($apiBase, 'openrouter.ai')) {
                $site = config('app.url') ?: (request()->getSchemeAndHttpHost() ?? 'http://localhost');
                $headers['HTTP-Referer'] = $site;
                $headers['X-Title'] = 'Elunora School AI';
            }
            $res = $client->post('chat/completions', [
                'headers' => $headers,
                'json' => $payload,
            ]);

            $body = json_decode((string) $res->getBody(), true);
            $answer = $body['choices'][0]['message']['content'] ?? '';

            return response()->json([
                'success' => true,
                'answer' => $answer,
            ]);
        } catch (\Throwable $e) {
            Log::error('AI ask error: ' . $e->getMessage());
            $resp = [
                'success' => false,
                'message' => 'Gagal menghubungi AI service',
            ];
            if (config('app.debug')) { $resp['error'] = $e->getMessage(); }
            return response()->json($resp, 500);
        }
    }

    private function generateLocalAnswer(string $msg): string
    {
        $q = mb_strtolower(trim($msg));
        // Simple intent detection for quick, offline responses
        if ($q === '' ) return 'Silakan ketik pertanyaan Anda.';
        if (str_contains($q, 'halo') || str_contains($q, 'hai') || str_contains($q, 'hi')) {
            return 'Halo! Ada yang bisa saya bantu?';
        }
        if (str_contains($q, 'alamat') || str_contains($q, 'lokasi')) {
            return 'Alamat Elunora School: Jl. Magnolia No. 17, The Aurora Residence, Kota Lavendra. Hubungi (021) 7788-9900.';
        }
        if (str_contains($q, 'kontak') || str_contains($q, 'telepon') || str_contains($q, 'email')) {
            return 'Kontak Elunora School: Telepon (021) 7788-9900, Email info@elunoraschool.sch.id.';
        }
        if (str_contains($q, 'kepala sekolah') || str_contains($q, 'kepsek')) {
            return 'Informasi kepala sekolah belum tersedia di AI offline. Silakan cek halaman Profil sekolah untuk data terbaru.';
        }
        if (str_contains($q, 'biaya') || str_contains($q, 'pembayaran') || str_contains($q, 'uang sekolah')) {
            return 'Untuk informasi biaya dan pembayaran, silakan hubungi admin via halaman Kontak atau datang ke kantor tata usaha.';
        }
        if (str_contains($q, 'agenda') || str_contains($q, 'kegiatan')) {
            return 'Jadwal agenda dapat dilihat di menu Agenda. Kegiatan terkini dan mendatang ditampilkan lengkap di sana.';
        }
        if (str_contains($q, 'galeri') || str_contains($q, 'foto')) {
            return 'Koleksi foto dapat dilihat di menu Galeri. Anda juga bisa memberi like dan komentar pada foto.';
        }
        if (str_contains($q, 'berita')) {
    		return 'Berita terbaru dapat Anda lihat pada menu Berita. Silakan dibuka untuk informasi terkini.';
        }
        // Default helpful response
        return 'Terima kasih atas pertanyaannya. Untuk informasi lengkap, Anda bisa menjelaskan pertanyaan lebih spesifik atau mengunjungi menu terkait seperti Berita, Agenda, Galeri, atau Profil.';
    }
}
