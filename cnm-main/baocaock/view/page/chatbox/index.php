<?php
// Bạn có thể kiểm tra đăng nhập ở đây nếu muốn
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chatbox Người dùng & Nhân viên</title>
    <style>
        #chatbox-container {
            width: 400px;
            margin: 40px auto;
            border: 1px solid #ccc;
            border-radius: 8px;
            background: #f9f9f9;
            display: flex;
            flex-direction: column;
            height: 500px;
        }
        #messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            border-bottom: 1px solid #eee;
        }
        #chat-form {
            display: flex;
            padding: 10px;
        }
        #chat-input {
            flex: 1;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        #send-btn {
            margin-left: 8px;
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            background: #10b981;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div id="chatbox-container">
    <div id="messages"></div>
    <form id="chat-form" onsubmit="return false;">
        <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." autocomplete="off" />
        <button type="button" class="button button-green" id="send-btn">Gửi</button>
    </form>
</div>
<script>
    const ws = new WebSocket('ws://localhost:8080');
    const messages = document.getElementById('messages');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');

    ws.onmessage = function(event) {
        const msg = document.createElement('div');
        msg.textContent = event.data;
        messages.appendChild(msg);
        messages.scrollTop = messages.scrollHeight;
    };

    form.onsubmit = function(e) {
        e.preventDefault();
        if (input.value.trim() !== '') {
            ws.send(input.value);

            // Lưu tin nhắn vào database
            fetch('baocaock/model/chatbox_add.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    cauhoi: input.value,
                    cautraloi: '' // Nếu là nhân viên trả lời thì điền vào đây
                })
            });

            const msg = document.createElement('div');
            msg.textContent = "Bạn: " + input.value;
            msg.style.textAlign = "right";
            messages.appendChild(msg);
            messages.scrollTop = messages.scrollHeight;
            input.value = '';
        }
    };

    document.getElementById('send-btn').onclick = form.onsubmit;
</script>
</body>
</html>