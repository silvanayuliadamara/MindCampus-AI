@extends('layouts.user')
@section('title', 'Konseling AI (Chatbot)')
@section('page_title', 'Konseling AI')
@section('page_subtitle', 'Curahkan rasa cemas, lelah, dan kejenuhan akademik Anda kapan saja')

@section('content')
<style>
    .chatbot-container {
        display: flex;
        gap: 24px;
        height: calc(100vh - 220px);
        min-height: 500px;
    }

    /* Left Info Sidebar */
    .chatbot-sidebar {
        width: 280px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        flex-shrink: 0;
    }
    .status-card {
        padding: 20px;
        border-radius: var(--radius-md, 12px);
        background: rgba(255, 255, 255, 0.45);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    [data-theme="dark"] .status-card {
        background: rgba(255, 255, 255, 0.02);
        border: var(--border-glass);
    }
    .status-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-secondary);
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }
    .status-value {
        font-size: 18px;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .status-desc {
        font-size: 12px;
        color: var(--text-secondary);
        line-height: 1.5;
        margin-bottom: 16px;
    }

    /* Right Chat Area */
    .chat-area {
        flex: 1;
        display: flex;
        flex-direction: column;
        border-radius: var(--radius-lg, 16px);
        background: rgba(255, 255, 255, 0.45);
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
        position: relative;
    }
    [data-theme="dark"] .chat-area {
        background: rgba(13, 20, 38, 0.4);
        border: var(--border-glass);
    }

    /* Chat Header */
    .chat-header {
        padding: 16px 24px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(255, 255, 255, 0.2);
    }
    [data-theme="dark"] .chat-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        background: rgba(0, 0, 0, 0.15);
    }
    .bot-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .bot-avatar {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, #14b8a6, #0d9488);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 4px 10px rgba(20, 184, 166, 0.25);
    }
    .bot-status-text {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 2px;
    }
    .bot-status-indicator {
        font-size: 11px;
        color: #10b981;
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 600;
    }
    .bot-status-indicator span {
        width: 6px;
        height: 6px;
        background: #10b981;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 1.5s infinite;
    }

    /* Messages History */
    .messages-list {
        flex: 1;
        padding: 24px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Message Bubble */
    .message-row {
        display: flex;
        width: 100%;
    }
    .message-row.user {
        justify-content: flex-end;
    }
    .message-bubble {
        max-width: 75%;
        padding: 14px 18px;
        border-radius: 16px;
        font-size: 13px;
        line-height: 1.6;
        position: relative;
    }
    .message-row.bot .message-bubble {
        background: rgba(255, 255, 255, 0.85);
        color: var(--text-dark);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-top-left-radius: 4px;
    }
    [data-theme="dark"] .message-row.bot .message-bubble {
        background: rgba(255, 255, 255, 0.03);
        border: var(--border-glass);
        color: var(--text-dark);
    }
    .message-row.user .message-bubble {
        background: linear-gradient(135deg, #14b8a6, #0d9488);
        color: #fff;
        border-top-right-radius: 4px;
        box-shadow: 0 4px 12px rgba(20, 184, 166, 0.15);
    }
    .message-time {
        font-size: 10px;
        color: rgba(255, 255, 255, 0.7);
        margin-top: 6px;
        text-align: right;
    }
    .message-row.bot .message-time {
        color: var(--text-secondary);
    }

    /* Formatting styling for messages */
    .message-bubble p { margin-bottom: 10px; }
    .message-bubble p:last-child { margin-bottom: 0; }
    .message-bubble blockquote {
        border-left: 3px solid var(--accent);
        padding-left: 12px;
        margin: 12px 0;
        font-style: italic;
        color: var(--text-secondary);
    }
    .message-row.user .message-bubble blockquote {
        border-left-color: rgba(255,255,255,0.4);
        color: rgba(255,255,255,0.9);
    }
    .message-bubble ul, .message-bubble ol {
        padding-left: 20px;
        margin-bottom: 10px;
    }
    .message-bubble li {
        margin-bottom: 4px;
    }

    /* Suggestions chips */
    .suggestions-container {
        padding: 10px 24px;
        display: flex;
        gap: 8px;
        overflow-x: auto;
        border-top: 1px solid rgba(0, 0, 0, 0.03);
        background: rgba(255, 255, 255, 0.1);
        white-space: nowrap;
    }
    [data-theme="dark"] .suggestions-container {
        border-top: 1px solid rgba(255, 255, 255, 0.02);
        background: rgba(0, 0, 0, 0.08);
    }
    .suggestion-chip {
        padding: 8px 16px;
        border-radius: 99px;
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(0, 0, 0, 0.05);
        font-size: 12px;
        font-weight: 600;
        color: var(--text-dark);
        cursor: pointer;
        transition: all 0.2s ease;
    }
    [data-theme="dark"] .suggestion-chip {
        background: rgba(255, 255, 255, 0.03);
        border: var(--border-glass);
    }
    .suggestion-chip:hover {
        background: var(--accent);
        color: #fff;
        border-color: var(--accent);
        transform: translateY(-1px);
    }

    /* Typing Indicator Animation */
    .typing-indicator {
        display: none;
        align-items: center;
        gap: 4px;
        padding: 12px 18px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(0, 0, 0, 0.05);
        width: fit-content;
        margin-bottom: 20px;
    }
    [data-theme="dark"] .typing-indicator {
        background: rgba(255, 255, 255, 0.03);
        border: var(--border-glass);
    }
    .typing-dot {
        width: 6px;
        height: 6px;
        background: var(--text-secondary);
        border-radius: 50%;
        animation: typing 1.4s infinite both;
    }
    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }

    /* Input Bar */
    .chat-input-bar {
        padding: 16px 24px;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        gap: 12px;
        align-items: center;
    }
    [data-theme="dark"] .chat-input-bar {
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        background: rgba(0, 0, 0, 0.15);
    }
    .chat-input {
        flex: 1;
        padding: 12px 18px;
        border-radius: var(--radius-md, 12px);
        border: 1px solid rgba(0, 0, 0, 0.08);
        background: rgba(255, 255, 255, 0.9);
        color: var(--text-dark);
        font-size: 13px;
        outline: none;
        transition: all 0.2s ease;
    }
    [data-theme="dark"] .chat-input {
        border: var(--border-glass);
        background: rgba(255, 255, 255, 0.02);
    }
    .chat-input:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.15);
    }
    .send-btn {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-md, 12px);
        background: linear-gradient(135deg, #14b8a6, #0d9488);
        color: #fff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 18px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(20, 184, 166, 0.25);
    }
    .send-btn:hover {
        transform: scale(1.05);
    }

    @keyframes typing {
        0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
        40% { transform: scale(1); opacity: 1; }
    }
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    @media (max-width: 992px) {
        .chatbot-container { flex-direction: column; height: auto; }
        .chatbot-sidebar { width: 100%; }
        .chat-area { height: 500px; }
    }
</style>

<div class="chatbot-container">
    
    <!-- LEFT SIDEBAR: MENTAL HEALTH STATUS -->
    <div class="chatbot-sidebar">
        <div class="status-card">
            <div class="status-label">Status Burnout Anda</div>
            @if($latestDiagnosis && $latestDiagnosis->burnoutLevel)
                @php
                    $levelCode = $latestDiagnosis->burnoutLevel->code;
                    $levelColor = match($levelCode) {
                        'B001' => '#10b981',
                        'B002' => '#22c55e',
                        'B003' => '#f59e0b',
                        'B004' => '#f97316',
                        'B005' => '#ef4444',
                        default => '#10b981',
                    };
                @endphp
                <div class="status-value" style="color: {{ $levelColor }};">
                    <i class="ph-fill ph-shield-check"></i>
                    {{ $latestDiagnosis->burnoutLevel->name }}
                </div>
                <div class="status-desc">
                    Tercatat pada {{ $latestDiagnosis->created_at->translatedFormat('d F Y') }} dengan kepastian {{ round($latestDiagnosis->cf_result * 100, 1) }}%.
                </div>
                <a href="{{ route('diagnosis.wizard') }}" class="btn-neo" style="width: 100%; text-align: center; padding: 10px; font-size: 12px; display: block;">
                    <i class="ph-bold ph-arrow-counter-clockwise"></i> Diagnosis Ulang
                </a>
            @else
                <div class="status-value" style="color: var(--text-secondary);">
                    <i class="ph-fill ph-circle-dashed"></i>
                    Belum Ada Data
                </div>
                <div class="status-desc">
                    Anda belum pernah melakukan diagnosis kejenuhan belajar / stres akademik.
                </div>
                <a href="{{ route('diagnosis.wizard') }}" class="btn-neo" style="width: 100%; text-align: center; padding: 10px; font-size: 12px; display: block;">
                    <i class="ph-bold ph-play"></i> Mulai Diagnosis
                </a>
            @endif
        </div>

        <div class="status-card">
            <div class="status-label">Tentang Serenity AI</div>
            <div style="font-size: 12px; color: var(--text-secondary); line-height: 1.6; font-weight: 500;">
                Serenity AI adalah pendengar setia yang siap membantu memetakan stres perkuliahan Anda. Obrolan Anda sepenuhnya rahasia dan aman disimpan di sistem kami.
            </div>
        </div>
    </div>

    <!-- RIGHT SIDEBAR: CHAT WINDOW -->
    <div class="chat-area">
        
        <!-- Header -->
        <div class="chat-header">
            <div class="bot-info">
                <div class="bot-avatar">
                    <i class="ph-fill ph-sparkle"></i>
                </div>
                <div>
                    <div class="bot-status-text">Serenity AI</div>
                    <div class="bot-status-indicator">
                        <span></span> Online
                    </div>
                </div>
            </div>
            
            <form action="{{ route('chatbot.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua riwayat percakapan? Sesi baru akan dimulai.');">
                @csrf
                <button type="submit" class="btn-neo-secondary" style="padding: 6px 12px; font-size: 11px; border-radius: 8px;">
                    <i class="ph-bold ph-trash"></i> Hapus Obrolan
                </button>
            </form>
        </div>

        <!-- Chat History -->
        <div class="messages-list" id="messages-list">
            @foreach($messages as $msg)
                <div class="message-row {{ $msg->sender === 'user' ? 'user' : 'bot' }}">
                    <div class="message-bubble">
                        <div class="message-text" data-raw="{{ $msg->message }}">
                            <!-- Parsed text will render here -->
                        </div>
                        <div class="message-time">
                            {{ $msg->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Typing indicator -->
            <div class="typing-indicator" id="typing-indicator">
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
                <div class="typing-dot"></div>
            </div>
        </div>

        <!-- Suggestion Chips -->
        <div class="suggestions-container">
            <div class="suggestion-chip">Saya lelah & kurang tidur</div>
            <div class="suggestion-chip">Saya menunda tugas kuliah</div>
            <div class="suggestion-chip">Saya cemas dengan ujian</div>
            <div class="suggestion-chip">Beri saya tips relaksasi</div>
            <div class="suggestion-chip">Saya merasa putus asa</div>
        </div>

        <!-- Input Bar -->
        <div class="chat-input-bar">
            <input type="text" id="chat-input" class="chat-input" placeholder="Ketik pesan atau curahan hati Anda di sini..." autocomplete="off">
            <button id="send-btn" class="send-btn">
                <i class="ph-bold ph-paper-plane-right"></i>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const list = document.getElementById('messages-list');
    const input = document.getElementById('chat-input');
    const sendBtn = document.getElementById('send-btn');
    const indicator = document.getElementById('typing-indicator');

    // Parse Markdown helper for clean message rendering
    function parseMarkdown(text) {
        let html = text;
        // Escape HTML tags to prevent XSS
        html = html.replace(/</g, "&lt;").replace(/>/g, "&gt;");
        
        // Blockquotes (must start with &gt; )
        html = html.replace(/^&gt;\s+(.*)$/gm, '<blockquote>$1</blockquote>');
        
        // Bold formatting **text**
        html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        
        // Italic formatting *text*
        html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
        
        // List items
        html = html.replace(/^\*\s+(.*)$/gm, '<li>$1</li>');
        html = html.replace(/^\d+\.\s+(.*)$/gm, '<li>$1</li>');
        
        // Wrap consecutive <li> elements in a list tag
        html = html.replace(/(<li>.*<\/li>)/gs, '<ul>$1</ul>');
        
        // Paragraph newlines
        html = html.replace(/\n/g, '<br>');
        
        return html;
    }

    // Initial parsing of loaded history
    document.querySelectorAll('.message-text').forEach(el => {
        const raw = el.dataset.raw;
        el.innerHTML = parseMarkdown(raw);
    });

    // Auto scroll bottom
    function scrollBottom() {
        list.scrollTop = list.scrollHeight;
    }
    scrollBottom();

    // Send Message Logic
    async function postMessage(messageText) {
        if (!messageText.trim()) return;

        // 1. Render User Message on Screen
        const now = new Date();
        const timeStr = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
        
        const userRow = document.createElement('div');
        userRow.className = 'message-row user';
        userRow.innerHTML = `
            <div class="message-bubble">
                <div class="message-text">${parseMarkdown(messageText)}</div>
                <div class="message-time">${timeStr}</div>
            </div>
        `;
        // Insert before indicator
        list.insertBefore(userRow, indicator);
        scrollBottom();

        // Clear input bar
        input.value = '';
        input.disabled = true;
        sendBtn.disabled = true;

        // 2. Show Typing Indicator
        indicator.style.display = 'flex';
        scrollBottom();

        try {
            // 3. Make API call to backend
            const response = await fetch("{{ route('chatbot.send') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: messageText })
            });

            const data = await response.json();
            
            // Hide indicator after short dynamic delay for typing feel
            setTimeout(() => {
                indicator.style.display = 'none';

                if (data.status === 'success') {
                    // 4. Render Bot Message
                    const botRow = document.createElement('div');
                    botRow.className = 'message-row bot';
                    const botTime = new Date(data.bot_message.created_at);
                    const botTimeStr = String(botTime.getHours()).padStart(2, '0') + ':' + String(botTime.getMinutes()).padStart(2, '0');

                    botRow.innerHTML = `
                        <div class="message-bubble">
                            <div class="message-text">${parseMarkdown(data.bot_message.message)}</div>
                            <div class="message-time">${botTimeStr}</div>
                        </div>
                    `;
                    list.insertBefore(botRow, indicator);
                } else {
                    // Error response
                    const errorRow = document.createElement('div');
                    errorRow.className = 'message-row bot';
                    errorRow.innerHTML = `
                        <div class="message-bubble" style="background: rgba(239,68,68,0.1); color: #ef4444; border-color: rgba(239,68,68,0.2);">
                            <div class="message-text">Maaf, terjadi gangguan koneksi ke Serenity AI. Silakan coba kirim kembali pesan Anda.</div>
                        </div>
                    `;
                    list.insertBefore(errorRow, indicator);
                }
                
                scrollBottom();
                input.disabled = false;
                sendBtn.disabled = false;
                input.focus();
            }, 1000 + Math.random() * 800); // 1 to 1.8 seconds dynamic typing simulation

        } catch (e) {
            indicator.style.display = 'none';
            const errorRow = document.createElement('div');
            errorRow.className = 'message-row bot';
            errorRow.innerHTML = `
                <div class="message-bubble" style="background: rgba(239,68,68,0.1); color: #ef4444; border-color: rgba(239,68,68,0.2);">
                    <div class="message-text">Maaf, terjadi kegagalan jaringan. Pastikan koneksi internet Anda stabil.</div>
                </div>
            `;
            list.insertBefore(errorRow, indicator);
            scrollBottom();
            input.disabled = false;
            sendBtn.disabled = false;
        }
    }

    // Trigger on send button click
    sendBtn.addEventListener('click', () => {
        postMessage(input.value);
    });

    // Trigger on Enter key
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            postMessage(input.value);
        }
    });

    // Trigger on suggestion chips click
    document.querySelectorAll('.suggestion-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            postMessage(chip.textContent);
        });
    });
});
</script>
@endsection
