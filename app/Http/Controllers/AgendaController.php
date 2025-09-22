<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index()
    {
        // Upcoming: strictly after today to avoid duplicating today's agendas
        $upcomingAgenda = Agenda::where('status', 1)  // 1 = published
                               ->whereDate('tanggal', '>', now()->format('Y-m-d'))
                               ->orderBy('tanggal', 'asc')
                               ->orderBy('waktu_mulai', 'asc')
                               ->paginate(12);

        $todayAgenda = Agenda::where('status', 1)  // 1 = published
                            ->whereDate('tanggal', now()->format('Y-m-d'))
                            ->orderBy('waktu_mulai', 'asc')
                            ->get();

        // Agenda yang sedang berlangsung (hari ini)
        $ongoingAgenda = Agenda::where('status', 1)
                              ->whereDate('tanggal', now()->format('Y-m-d'))
                              ->where('waktu_mulai', '<=', now()->format('H:i:s'))
                              ->where(function($query) {
                                  $query->where('waktu_selesai', '>=', now()->format('H:i:s'))
                                        ->orWhereNull('waktu_selesai');
                              })
                              ->orderBy('waktu_mulai', 'asc')
                              ->get();

        // Agenda yang sudah terlaksana (tanggal sudah lewat atau hari ini tapi waktu sudah lewat)
        $pastAgenda = Agenda::where('status', 1)
                           ->where(function($query) {
                               $query->where('tanggal', '<', now()->format('Y-m-d'))
                                     ->orWhere(function($subQuery) {
                                         $subQuery->whereDate('tanggal', now()->format('Y-m-d'))
                                                 ->where('waktu_selesai', '<', now()->format('H:i:s'));
                                     });
                           })
                           ->orderBy('tanggal', 'desc')
                           ->orderBy('waktu_mulai', 'desc')
                           ->paginate(6, ['*'], 'past_page');

        return view('agenda', compact('upcomingAgenda', 'todayAgenda', 'ongoingAgenda', 'pastAgenda'));
    }

    public function show($id)
    {
        $agenda = Agenda::where('status', 1)->findOrFail($id);

        // Get related agendas (same category, exclude current agenda, limit to 3)
        $relatedAgendas = Agenda::where('status', 1)
            ->where('kategori', $agenda->kategori)
            ->where('id', '!=', $agenda->id)
            ->where('tanggal', '>=', now()->format('Y-m-d'))
            ->orderBy('tanggal', 'asc')
            ->limit(3)
            ->get();

        // If no related agendas from same category, get latest published agendas
        if ($relatedAgendas->isEmpty()) {
            $relatedAgendas = Agenda::where('status', 1)
                ->where('id', '!=', $agenda->id)
                ->where('tanggal', '>=', now()->format('Y-m-d'))
                ->orderBy('tanggal', 'asc')
                ->limit(3)
                ->get();
        }

        return view('agenda-detail', compact('agenda', 'relatedAgendas'));
    }
}
