let currentContact = window.currentContact

// Auto-resize textarea
const messageInput = document.getElementById('messageInput');
if (messageInput) {
    messageInput.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
}

// Función para manejar Enter en el textarea
function handleKeyPress(event) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        sendMessage(event);
    }
}

// Función para enviar mensaje
function sendMessage(event) {
    event.preventDefault();

    if (!currentContact) {
        return;
    }

    const input = document.getElementById('messageInput');
    const message = input.value.trim();

    console.log('Enviando mensaje:', message);
    console.log('Contacto actual:', currentContact);
    if (message === '') return;

    // Enviar mensaje vía AJAX
    fetch('../includes/chat_send_message.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `contact=${currentContact}&mensaje=${encodeURIComponent(message)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Agregar mensaje al chat
                addMessage(message, true, data.fecha);
                // Limpiar input
                input.value = '';
                input.style.height = 'auto';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Función para agregar mensaje al chat
function addMessage(text, isOwn, time = null) {
    const messagesContainer = document.getElementById('messagesContainer');

    // Remover mensaje de chat vacío si existe
    const emptyChat = messagesContainer.querySelector('.empty-chat');
    if (emptyChat) {
        emptyChat.remove();
    }

    const messageDiv = document.createElement('div');
    const timeString = time || new Date().toLocaleTimeString('es-ES', {
        hour: '2-digit',
        minute: '2-digit'
    });

    messageDiv.className = `message ${isOwn ? 'own' : 'other'}`;

    if (isOwn) {
        messageDiv.innerHTML = `
                    <div>
                        <div class="message-bubble">
                            ${text}
                        </div>
                        <div class="message-time">${timeString}</div>
                    </div>
                `;
    } else {
        messageDiv.innerHTML = `
                    <img src="../assets/App-images/default_profile.png" alt="Contact" class="message-avatar">
                    <div>
                        <div class="message-bubble">
                            ${text}
                        </div>
                        <div class="message-time">${timeString}</div>
                    </div>
                `;
    }

    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Función para seleccionar contacto
function selectContact(userId, userName, userAvatar) {
    currentContact = userId;
    document.getElementById('currentContactId').value = userId;

    // Actualizar header del chat
    document.getElementById('chatUserName').textContent = userName;
    document.getElementById('chatAvatar').src = userAvatar;

    // Actualizar contacto activo
    document.querySelectorAll('.contact-item').forEach(item => {
        item.classList.remove('active');
    });
    event.currentTarget.classList.add('active');

    // Cargar mensajes del contacto
    loadContactMessages(userId);

    // Habilitar input
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.querySelector('.send-button');
    messageInput.disabled = false;
    messageInput.placeholder = 'Escribe tu mensaje...';
    sendButton.disabled = false;

    // Cerrar sidebar en móvil
    if (window.innerWidth <= 768) {
        toggleSidebar();
    }
}

// Función para cargar mensajes del contacto
function loadContactMessages(userId) {
    const messagesContainer = document.getElementById('messagesContainer');
    messagesContainer.innerHTML = '<div class="text-center py-3"><div class="spinner-border text-primary" role="status"></div></div>';

    fetch('../includes/chat_get_messages.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `contact_id=${userId}`
    })
        .then(response => response.json())
        .then(data => {
            messagesContainer.innerHTML = '';

            if (data.success && data.mensajes.length > 0) {
                data.mensajes.forEach(msg => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `message ${msg.es_propio ? 'own' : 'other'}`;

                    if (msg.es_propio) {
                        messageDiv.innerHTML = `
                                <div>
                                    <div class="message-bubble">
                                        ${msg.contenido}
                                    </div>
                                    <div class="message-time">${msg.fecha}</div>
                                </div>
                            `;
                    } else {
                        messageDiv.innerHTML = `
                                <img src="${msg.foto_origen}" alt="${msg.usuario_origen}" class="message-avatar">
                                <div>
                                    <div class="message-bubble">
                                        ${msg.contenido}
                                    </div>
                                    <div class="message-time">${msg.fecha}</div>
                                </div>
                            `;
                    }

                    messagesContainer.appendChild(messageDiv);
                });
            } else {
                messagesContainer.innerHTML = `
                        <div class="empty-chat">
                            <i class="bi bi-chat-square-text"></i>
                            <p>No hay mensajes en esta conversación</p>
                            <small>Envía el primer mensaje para empezar</small>
                        </div>
                    `;
            }

            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        })
        .catch(error => {
            console.error('Error:', error);
            messagesContainer.innerHTML = `
                    <div class="empty-chat">
                        <i class="bi bi-exclamation-triangle text-danger"></i>
                        <p>Error al cargar mensajes</p>
                    </div>
                `;
        });
}

// Función para toggle del sidebar en móvil
function toggleSidebar() {
    const sidebar = document.getElementById('contactsSidebar');
    sidebar.classList.toggle('show');
}

// Función para toggle de búsqueda de usuarios
function toggleUserSearch() {
    const dropdown = document.getElementById('userSearchDropdown');
    const isVisible = dropdown.style.display !== 'none';
    dropdown.style.display = isVisible ? 'none' : 'block';

    if (!isVisible) {
        document.getElementById('userSearchInput').focus();
    }
}

// Función para buscar usuarios
function searchUsers(query) {
    const resultsDiv = document.getElementById('userSearchResults');

    fetch(`../includes/buscar.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `term=${encodeURIComponent(query)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.usuarios && data.usuarios.length > 0) {
                let html = '';
                data.usuarios.forEach(user => {
                    const userImage = "." + user.URL_FOTO || '../assets/App-images/default_profile.png';
                    html += `
                            <div class="d-flex align-items-center py-2 px-2 border-bottom cursor-pointer" onclick="startConversation('${user.USUARIO}', '${user.USUARIO}', '${userImage}')" style="cursor: pointer;">
                                <img src="${userImage}" alt="${user.USUARIO}" class="rounded-circle me-2" width="32" height="32">
                                <span>${user.USUARIO}</span>
                            </div>
                        `;
                });
                resultsDiv.innerHTML = html;
            } else {
                resultsDiv.innerHTML = '<small class="text-muted">No se encontraron usuarios</small>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            resultsDiv.innerHTML = '<small class="text-danger">Error en la búsqueda</small>';
        });
}

// Función para iniciar conversación con un usuario nuevo
function startConversation(userId, userName, userAvatar) {
    // Cerrar búsqueda
    document.getElementById('userSearchDropdown').style.display = 'none';
    document.getElementById('userSearchInput').value = '';

    // Obtener el ID del usuario usando su nombre de usuario
    fetch('../includes/buscar.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `term=${encodeURIComponent(userName)}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.usuarios && data.usuarios.length > 0) {
                const user = data.usuarios.find(u => u.USUARIO === userName);
                if (user) {
                    // Seleccionar como contacto actual usando el ID obtenido
                    currentContact = user.IDUSUARIO || userId;
                    document.getElementById('currentContactId').value = currentContact;

                    // Actualizar header
                    document.getElementById('chatUserName').textContent = userName;
                    document.getElementById('chatAvatar').src = userAvatar;

                    // Limpiar selección activa
                    document.querySelectorAll('.contact-item').forEach(item => {
                        item.classList.remove('active');
                    });

                    // Mostrar chat vacío
                    const messagesContainer = document.getElementById('messagesContainer');
                    messagesContainer.innerHTML = `
                            <div class="empty-chat">
                                <i class="bi bi-chat-square-text"></i>
                                <p>Conversación con ${userName}</p>
                                <small>Envía el primer mensaje para empezar</small>
                            </div>
                        `;

                    // Habilitar input
                    const messageInput = document.getElementById('messageInput');
                    const sendButton = document.querySelector('.send-button');
                    messageInput.disabled = false;
                    messageInput.placeholder = 'Escribe tu mensaje...';
                    sendButton.disabled = false;
                    messageInput.focus();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Cerrar sidebar al hacer click fuera en móvil
document.addEventListener('click', function (event) {
    const sidebar = document.getElementById('contactsSidebar');
    const menuBtn = document.querySelector('.mobile-menu-btn');
    const userSearch = document.getElementById('userSearchDropdown');

    if (window.innerWidth <= 768 &&
        !sidebar.contains(event.target) &&
        !menuBtn.contains(event.target) &&
        sidebar.classList.contains('show')) {
        sidebar.classList.remove('show');
    }

    // Cerrar búsqueda de usuarios si se hace click fuera
    if (!userSearch.contains(event.target) && !event.target.closest('.btn[onclick="toggleUserSearch()"]')) {
        userSearch.style.display = 'none';
    }
});

// Función de búsqueda de contactos
document.getElementById('searchContacts').addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase();
    const contacts = document.querySelectorAll('.contact-item');

    contacts.forEach(contact => {
        const name = contact.querySelector('.contact-name');
        if (name && name.textContent.toLowerCase().includes(searchTerm)) {
            contact.style.display = 'flex';
        } else {
            contact.style.display = 'none';
        }
    });
});

// Auto scroll al final de los mensajes
document.addEventListener('DOMContentLoaded', function () {
    const messagesContainer = document.getElementById('messagesContainer');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});

// Marcar notificaciones como leídas al hacer click
const notificacionesElement = document.getElementById('Notificaciones');
if (notificacionesElement) {
    notificacionesElement.addEventListener('click', function () {
        fetch('../includes/leer_notificaciones.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Notificaciones marcadas como leídas.');
                } else {
                    console.error('Error al marcar las notificaciones como leídas:', data.message);
                }
            })
            .catch(error => {
                console.error('Error al procesar la respuesta:', error);
            });
    });
}