<?php
if (!isset($_SESSION['dangnhap']['id_role']) || $_SESSION['dangnhap']['id_role'] != 4) return;
?>
<style>
/* Messenger-like Chatbox CSS */
#open-chat-btn {
    position: fixed;
    right: 24px;
    bottom: 24px;
    z-index: 9999;
    background: #0084ff;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 56px;
    height: 56px;
    font-size: 28px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.18);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: box-shadow 0.2s;
}
#open-chat-btn:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.22);
}

#chatbox-container {
    display: none;
    position: fixed;
    right: 24px;
    bottom: 90px;
    width: 370px;
    max-width: 95vw;
    background: #fff;
    border-radius: 18px 18px 8px 8px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    z-index: 9999;
    flex-direction: column;
    overflow: hidden;
    font-family: 'Segoe UI', Arial, sans-serif;
}

#chatbox-header {
    background: #0084ff;
    color: #fff;
    padding: 14px 18px;
    font-weight: 600;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 17px;
    border-radius: 18px 18px 0 0;
}

#close-chat-btn {
    background: none;
    border: none;
    color: #fff;
    font-size: 22px;
    cursor: pointer;
    font-weight: bold;
    transition: color 0.2s;
}
#close-chat-btn:hover {
    color: #e4e6eb;
}

#messages {
    height: 320px;
    overflow-y: auto;
    padding: 18px 12px 12px 12px;
    background: #f0f2f5;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.msg-row {
    display: flex;
    margin-bottom: 2px;
}

.msg-bubble {
    max-width: 75%;
    padding: 9px 14px;
    border-radius: 18px;
    font-size: 15px;
    line-height: 1.4;
    word-break: break-word;
    box-shadow: 0 1px 2px rgba(0,0,0,0.04);
}

.msg-row.customer {
    justify-content: flex-end;
}
.msg-row.customer .msg-bubble {
    background: #0084ff;
    color: #fff;
    border-bottom-right-radius: 6px;
    border-bottom-left-radius: 18px;
}

.msg-row.staff {
    justify-content: flex-start;
}
.msg-row.staff .msg-bubble {
    background: #e4e6eb;
    color: #050505;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 18px;
}

#chat-form {
    display: flex;
    border-top: 1px solid #e4e6eb;
    background: #fff;
    padding: 10px 12px;
    align-items: center;
    gap: 8px;
}

#chat-input {
    flex: 1;
    border: none;
    padding: 10px 14px;
    font-size: 15px;
    border-radius: 20px;
    background: #f0f2f5;
    outline: none;
    transition: background 0.2s;
}
#chat-input:focus {
    background: #fff;
}

#send-btn {
    background: #0084ff;
    color: #fff;
    border: none;
    padding: 0 22px;
    font-size: 15px;
    border-radius: 20px;
    cursor: pointer;
    height: 38px;
    transition: background 0.2s;
}
#send-btn:hover {
    background: #006fd6;
}
</style>

<button id="open-chat-btn" title="Chat với nhân viên"><i class="fas fa-comments"></i></button>
<div id="chatbox-container">
    <div id="chatbox-header">
        Chat hỗ trợ
        <button id="close-chat-btn" title="Đóng">&times;</button>
    </div>
    <div id="messages"></div>
    <form id="chat-form" autocomplete="off">
        <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." autocomplete="off" />
        <button type="button" id="send-btn">Gửi</button>
    </form>
</div>

<script>
// Hiển thị/ẩn chatbox
document.getElementById('open-chat-btn').onclick = function() {
    document.getElementById('chatbox-container').style.display = 'flex';
    this.style.display = 'none';
};
document.getElementById('close-chat-btn').onclick = function() {
    document.getElementById('chatbox-container').style.display = 'none';
    document.getElementById('open-chat-btn').style.display = 'block';
};

// Xử lý gửi tin nhắn
const form = document.getElementById('chat-form');
const input = document.getElementById('chat-input');
const messages = document.getElementById('messages');
form.onsubmit = function(e) {
    e.preventDefault();
    if (input.value.trim() !== '') {
        fetch('/cnm-main/baocaock/model/chatbox_add.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                cauhoi: input.value,
                cautraloi: ''
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
document.getElementById('send-btn').onclick = function() {
    form.onsubmit(new Event('submit'));
};

// Lấy lịch sử chat khi load trang
fetch('/cnm-main/baocaock/model/chatbox_history.php')
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            data.messages.forEach(msg => {
                const div = document.createElement('div');
                if (msg.id_role == 4) {
                    div.innerHTML = '<span style="font-size:18px;">👤</span> ' + msg.cauhoi;
                    div.style.textAlign = "right";
                } else {
                    div.innerHTML = '<span style="font-size:18px;">💼</span> ' + msg.cautraloi;
                    div.style.textAlign = "left";
                }
                messages.appendChild(div);
            });
            messages.scrollTop = messages.scrollHeight;
        }
    });
</script>