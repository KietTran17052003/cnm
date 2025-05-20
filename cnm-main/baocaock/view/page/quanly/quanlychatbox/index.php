<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Chatbox - Nhân viên</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; }
        .wrapper {
            display: flex;
            height: 100vh;
        }
        .content {
            flex-grow: 1;
            padding: 0;
            background: #f0f2f5;
            overflow-y: auto;
        }
        .messenger-container {
            display: flex;
            height: 90vh;
            max-width: 1000px;
            margin: 30px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px #ccc;
            overflow: hidden;
        }
        .user-list {
            width: 300px;
            border-right: 1px solid #eee;
            background: #f7f7f7;
            overflow-y: auto;
        }
        .user-item {
            padding: 16px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            transition: background 0.2s;
        }
        .user-item.active, .user-item:hover {
            background: #e6f0fa;
        }
        .user-item.has-new-message {
            background: #fffbe6 !important;
        }
        .user-avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: #10b981;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-right: 12px;
        }
        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f0f2f5;
        }
        .chat-header {
            padding: 16px;
            background: #fff;
            border-bottom: 1px solid #eee;
            font-weight: bold;
            font-size: 18px;
        }
        .messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .msg-row {
            display: flex;
        }
        .msg-row.customer { justify-content: flex-start; }
        .msg-row.staff { justify-content: flex-end; }
        .msg-bubble {
            max-width: 60%;
            padding: 10px 16px;
            border-radius: 18px;
            font-size: 15px;
            line-height: 1.5;
            box-shadow: 0 1px 2px #eee;
        }
        .msg-row.customer .msg-bubble {
            background: #fff;
            color: #222;
            border-bottom-left-radius: 4px;
        }
        .msg-row.staff .msg-bubble {
            background: #10b981;
            color: #fff;
            border-bottom-right-radius: 4px;
        }
        .chat-input-area {
            display: flex;
            padding: 16px;
            background: #fff;
            border-top: 1px solid #eee;
        }
        .chat-input {
            flex: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ccc;
            font-size: 15px;
        }
        .sen-btn {
            margin-left: 10px;
            padding: 10px 22px;
            border-radius: 20px;
            border: none;
            background: #10b981;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
        }
        .badge {
            display: inline-block;
            min-width: 18px;
            padding: 2px 6px;
            font-size: 12px;
            background: #e74c3c;
            color: #fff;
            border-radius: 12px;
            text-align: center;
            margin-left: 8px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <?php include_once("../layout/sidebar.php"); ?>
    <div class="content">
        <div class="messenger-container">
            <div class="user-list" id="user-list">
                <!-- Danh sách khách hàng sẽ được render ở đây -->
            </div>
            <div class="chat-area">
                <div class="chat-header" id="chat-header">Chọn khách hàng để chat</div>
                <div class="messages" id="messages"></div>
                <form class="chat-input-area" id="chat-form" style="display:none;">
                    <input type="text" id="chat-input" class="chat-input" placeholder="Nhập tin nhắn..." autocomplete="off" />
                    <button type="submit" class="sen-btn">Gửi</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
// Lấy danh sách khách hàng đã chat
let currentUserId = null;
let currentUserName = '';
const userList = document.getElementById('user-list');
const messagesDiv = document.getElementById('messages');
const chatHeader = document.getElementById('chat-header');
const chatForm = document.getElementById('chat-form');
const chatInput = document.getElementById('chat-input');

// Lấy danh sách khách hàng
function loadUserList() {
    fetch('/cnm-main/baocaock/model/chatbox_staff_users.php')
        .then(res => res.json())
        .then(data => {
            userList.innerHTML = '';
            if (data.success && data.users.length > 0) {
                data.users.forEach(user => {
                    const lastMsg = user.last_message ? `<div style="font-size:13px;color:#888;">${user.last_message}</div>` : '';
                    const badge = (user.unread_count && user.unread_count > 0)
                        ? `<span class="badge">${user.unread_count > 9 ? '9+' : user.unread_count}</span>`
                        : '';
                    const div = document.createElement('div');
                    div.className = 'user-item';
                    div.dataset.userid = user.id_user;
                    div.innerHTML = `
        <div class="user-avatar">👤</div>
        <div style="flex:1">
            <div style="display:flex;align-items:center;justify-content:space-between;">
                <b>${user.hoten || 'Khách ' + user.id_user}</b>
                ${badge}
            </div>
            ${lastMsg}
        </div>
    `;
                    div.onclick = () => selectUser(user.id_user, user.hoten || 'Khách ' + user.id_user);
                    userList.appendChild(div);
                });
            } else {
                userList.innerHTML = '<div style="padding:20px;color:#888;">Chưa có khách hàng nào chat</div>';
            }
        });
}

// Lấy lịch sử chat với khách hàng
function loadMessages(userId) {
    fetch('/cnm-main/baocaock/model/chatbox_staff_history.php?id_user=' + userId)
        .then(res => res.json())
        .then(data => {
            messagesDiv.innerHTML = '';
            if (data.success && data.messages.length > 0) {
                data.messages.forEach(msg => {
                    if (msg.cauhoi && msg.cauhoi.trim() !== '') {
                        // Tin nhắn của khách
                        const row = document.createElement('div');
                        row.className = 'msg-row customer';
                        row.innerHTML = `<div class="msg-bubble">${msg.cauhoi}</div>`;
                        messagesDiv.appendChild(row);
                    }
                    if (msg.cautraloi && msg.cautraloi.trim() !== '') {
                        // Tin nhắn của nhân viên
                        const row = document.createElement('div');
                        row.className = (msg.id_role == 1) ? 'msg-row staff' : 'msg-row customer';
                        row.innerHTML = `<div class="msg-bubble">${msg.cautraloi}</div>`;
                        messagesDiv.appendChild(row);
                    }
                });
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            } else {
                messagesDiv.innerHTML = '<div style="color:#888;text-align:center;margin-top:30px;">Chưa có tin nhắn</div>';
            }
        });
}

// Chọn khách hàng để chat
function selectUser(id, name) {
    currentUserId = id;
    currentUserName = name;
    document.querySelectorAll('.user-item').forEach(item => {
        item.classList.toggle('active', item.dataset.userid == id);
    });
    chatHeader.textContent = name;
    chatForm.style.display = 'flex';
    loadMessages(id);

    // Đánh dấu đã đọc
    fetch('/cnm-main/baocaock/model/chatbox_mark_read.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({id_user: id})
    }).then(() => loadUserList());
}

// Lập kết nối WebSocket
let ws = new WebSocket('ws://localhost:8080');
let lastNotifiedUserId = null;
ws.onmessage = function(event) {
    let data = {};
    try {
        data = JSON.parse(event.data);
    } catch (e) {}
    if (currentUserId) loadMessages(currentUserId);
    loadUserList();
    // Hiển thị thông báo popup nếu có tin nhắn mới từ khách
    if (Notification.permission === "granted" && data.type === 'new_message') {
        // Không thông báo nếu chính mình gửi
        if (data.user_id !== currentUserId) {
            new Notification("Tin nhắn mới từ " + (data.user_name || "Khách"), {
                body: data.message || "Bạn có tin nhắn mới!",
                icon: "/path/to/icon.png"
            });
        }
    }
};
// Yêu cầu quyền thông báo khi load trang
if (window.Notification && Notification.permission !== "granted") {
    Notification.requestPermission();
}

// Khi gửi tin nhắn, gửi qua WebSocket
chatForm.onsubmit = function(e) {
    e.preventDefault();
    if (!currentUserId || chatInput.value.trim() === '') return;
    fetch('/cnm-main/baocaock/model/chatbox_staff_reply.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            id_user: currentUserId,
            cautraloi: chatInput.value
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            ws.send(JSON.stringify({
                type: 'new_message',
                user_id: currentUserId,
                user_name: currentUserName,
                message: chatInput.value
            }));
            chatInput.value = '';
            loadMessages(currentUserId);
        } else {
            alert('Gửi tin nhắn thất bại!');
        }
    });
};

loadUserList();
</script>
</body>
</html>