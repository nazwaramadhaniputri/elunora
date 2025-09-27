@extends('layouts.app')

@section('title', 'Asisten AI')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, var(--elunora-primary), var(--elunora-primary-dark)); color: white;">
                    <h5 class="mb-0"><i class="fas fa-robot me-2"></i>Elunora AI Assistant</h5>
                </div>
                <div class="card-body">
                    <div id="ai-messages" class="mb-3" style="min-height: 240px; max-height: 480px; overflow-y: auto;"></div>
                    <div class="input-group">
                        <input type="text" id="ai-input" class="form-control" placeholder="Tulis pertanyaan..." />
                        <button class="btn btn-primary" id="ai-send"><i class="fas fa-paper-plane me-1"></i>Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function(){
    const input = document.getElementById('ai-input');
    const send = document.getElementById('ai-send');
    const box = document.getElementById('ai-messages');

    function append(role, text) {
        const wrap = document.createElement('div');
        wrap.className = role === 'user' ? 'mb-2 text-end' : 'mb-2';
        wrap.innerHTML = role === 'user'
            ? `<div class="d-inline-block px-3 py-2 rounded-3 bg-primary text-white">${escapeHtml(text)}</div>`
            : `<div class="d-inline-block px-3 py-2 rounded-3 bg-light border">${escapeHtml(text)}</div>`;
        box.appendChild(wrap);
        box.scrollTop = box.scrollHeight;
    }

    function escapeHtml(str){
        return (str||'').replace(/[&<>"']/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[s]));
    }

    async function ask(){
        const msg = (input.value||'').trim();
        if(!msg) return;
        append('user', msg);
        input.value='';
        const thinking = document.createElement('div');
        thinking.className = 'mb-2';
        thinking.innerHTML = '<div class="d-inline-block px-3 py-2 rounded-3 bg-light border text-muted"><i class="fas fa-spinner fa-spin me-2"></i>AI sedang menjawab...</div>';
        box.appendChild(thinking);
        box.scrollTop = box.scrollHeight;
        // Try streaming first
        try{
            const controller = new AbortController();
            const timeout = setTimeout(() => controller.abort(), 10000); // 10s safety timeout
            const resp = await fetch('{{ route('ai.stream') }}', {
                method: 'POST',
                headers: {
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'text/event-stream'
                },
                body: JSON.stringify({ message: msg }),
                signal: controller.signal
            });
            clearTimeout(timeout);
            const ctype = resp.headers.get('content-type') || '';
            if(!resp.ok || !ctype.includes('text/event-stream')){ throw new Error('stream_not_ok'); }
            thinking.remove();
            const wrap = document.createElement('div');
            wrap.className = 'mb-2';
            const bubble = document.createElement('div');
            bubble.className = 'd-inline-block px-3 py-2 rounded-3 bg-light border';
            const contentSpan = document.createElement('span');
            contentSpan.className = 'ai-content';
            contentSpan.innerHTML = '<i class="fas fa-ellipsis-h me-1 text-muted"></i> Sedang menulis...';
            bubble.appendChild(contentSpan);
            wrap.appendChild(bubble);
            box.appendChild(wrap);
            box.scrollTop = box.scrollHeight;

            const reader = resp.body.getReader();
            const decoder = new TextDecoder();
            let buffer = '';
            let firstChunk = true;
            let gotAny = false;
            while(true){
                const {value, done} = await reader.read();
                if(done) break;
                buffer += decoder.decode(value, {stream:true});
                const lines = buffer.split(/\n\n/);
                buffer = lines.pop();
                for(const line of lines){
                    if(!line.startsWith('data:')) continue;
                    const payload = line.slice(5).trim();
                    try{
                        const obj = JSON.parse(payload);
                        if(obj.done){ break; }
                        if(obj.content){
                            if(firstChunk){ bubble.textContent = ''; firstChunk = false; }
                            bubble.textContent += obj.content;
                            gotAny = true;
                        }
                    }catch(_){ /* ignore */ }
                }
                box.scrollTop = box.scrollHeight;
            }
            if(gotAny) return; // success
            // if no chunks received, fallback to non-stream
        }catch(_e){
            // Fallback to non-stream endpoint
        }
        try{
            const res = await fetch('{{ route('ai.ask') }}', {
                method:'POST',
                headers:{
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept':'application/json'
                },
                body: JSON.stringify({ message: msg })
            });
            const data = await res.json();
            thinking.remove();
            if(!res.ok || !data.success){
                const detail = data && data.error ? `\nDetail: ${data.error}` : '';
                append('assistant', (data.message || 'Gagal menghubungi layanan AI.') + detail);
            } else {
                append('assistant', data.answer || '(tidak ada jawaban)');
            }
        }catch(e){
            thinking.remove();
            append('assistant', 'Terjadi kesalahan saat menghubungi layanan AI.');
        }
    }

    send.addEventListener('click', ask);
    input.addEventListener('keydown', function(e){ if(e.key === 'Enter'){ ask(); }});
})();
</script>
@endsection
