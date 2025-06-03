let currentContact = null

function getCorrectImagePath(imagePath) {
    if (!imagePath || imagePath === '') {
        return '../assets/App-images/default_profile.png';
    }

    // If the path starts with ./ we convert it to ../
    if (imagePath.startsWith('./')) {
        return imagePath.replace('./', '../');
    }

    // If the path starts with /, http, or ../ we return it as is
    if (!imagePath.startsWith('/') && !imagePath.startsWith('http') && !imagePath.startsWith('../')) {
        return '../' + imagePath;
    }

    return imagePath;
}

// Auto-resize input
const messageInput = document.getElementById('messageInput');
if (messageInput) {
    messageInput.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
}

// Function to handle Enter key press in the message input
function handleKeyPress(event) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        sendMessage(event);
    }
}

// Function to send message
function sendMessage(event) {
    event.preventDefault();
    
    // Verify that there is a selected contact
    if (!currentContact) {
        return;
    }

    const input = document.getElementById('messageInput');
    const message = input.value.trim();

    if (message === '') {
        return;
    }

    // Disable the send button and change its text to a loading icon
    const sendButton = document.querySelector('.send-button');
    const originalText = sendButton.innerHTML;
    sendButton.disabled = true;
    sendButton.innerHTML = '<i class="bi bi-hourglass-split"></i>';

    // Send the message to the server
    fetch('../includes/chat_send_message.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `contact=${encodeURIComponent(currentContact)}&mensaje=${encodeURIComponent(message)}`
    })
        .then(response => {
            return response.json();
        })
        .then(data => {

            if (data.success) {
                // Add message to chat
                addMessage(message, true, data.fecha);
                // Clear the input and reset its height
                input.value = '';
                input.style.height = 'auto';
            } else {
            }
        })
        .finally(() => {
            // Enable the send button and restore its original text
            sendButton.disabled = false;
            sendButton.innerHTML = originalText;
        });
}

// Function to  add a message to the chat
function addMessage(text, isOwn) {
    const messagesContainer = document.getElementById('messagesContainer');

    // Remove empty chat message if it exists
    const emptyChat = messagesContainer.querySelector('.empty-chat');
    if (emptyChat) {
        emptyChat.remove();
    }

    const messageDiv = document.createElement('div');


    messageDiv.className = `message ${isOwn ? 'own' : 'other'}`;

    if (isOwn) {
        messageDiv.innerHTML = `
            <div>
                <div class="message-bubble">
                    ${text}
                </div>
            </div>
        `;
    } else {
        // For other users' messages, get the image of the active contact
        const activeContact = document.querySelector('.contact-item.active');
        let contactImage = '../assets/App-images/default_profile.png';

        if (activeContact) {
            const dataImage = activeContact.getAttribute('data-contact-image');
            contactImage = getCorrectImagePath(dataImage);
        }

        messageDiv.innerHTML = `
            <img src="${contactImage}" 
                 alt="Contact" 
                 class="message-avatar"
                 onerror="this.src='../assets/App-images/default_profile.png'">
            <div>
                <div class="message-bubble">
                    ${text}
                </div>

            </div>
        `;
    }

    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Function to select a contact and load their messages
function selectContact(userId, userName, userAvatar) {

    // Establish current contact
    currentContact = userId;
    window.currentContact = userId;
    document.getElementById('currentContactId').value = userId;

    // Correct image path 
    const correctedAvatar = getCorrectImagePath(userAvatar);

    // Update chat header with user name and avatar
    document.getElementById('chatUserName').textContent = userName;
    const chatAvatar = document.getElementById('chatAvatar');
    chatAvatar.src = correctedAvatar;

    // Update the active contact in the sidebar
    document.querySelectorAll('.contact-item').forEach(item => {
        item.classList.remove('active');
    });

    // Find the clicked contact and mark it as active
    const clickedContact = event?.currentTarget || document.querySelector(`[data-contact-id="${userId}"]`);
    if (clickedContact) {
        clickedContact.classList.add('active');
        clickedContact.setAttribute('data-contact-image', correctedAvatar);
    }

    // Enable message input and send button
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.querySelector('.send-button');
    const moreOptionsBtn = document.querySelector('.btn[title="Más opciones"]');

    messageInput.disabled = false;
    messageInput.placeholder = 'Escribe tu mensaje...';
    sendButton.disabled = false;
    if (moreOptionsBtn) moreOptionsBtn.disabled = false;

    // Load messages for the selected contact
    loadContactMessages(userId);

    // Close the sidebar if on mobile
    if (window.innerWidth <= 768) {
        toggleSidebar();
    }

}

document.addEventListener('DOMContentLoaded', function () {
    const messageForm = document.getElementById('messageForm');
    if (messageForm) {
        messageForm.addEventListener('submit', sendMessage);
    }

    // Add event listener to the send button
    const sendButton = document.querySelector('.send-button');
    if (sendButton) {
        sendButton.addEventListener('click', function (e) {
            e.preventDefault();
            sendMessage(e);
        });
    }
});

// Function to load messages for the selected contact
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
                        </div>
                    `;
                    } else {
                        const correctImagePath = getCorrectImagePath(msg.foto_origen);
                        messageDiv.innerHTML = `
                        <img src="${correctImagePath}" 
                             alt="${msg.usuario_origen}" 
                             class="message-avatar"
                             onerror="this.src='../assets/App-images/default_profile.png'">
                        <div>
                            <div class="message-bubble">
                                ${msg.contenido}
                            </div>
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
            messagesContainer.innerHTML = `
            <div class="empty-chat">
                <i class="bi bi-exclamation-triangle text-danger"></i>
                <p>Error al cargar mensajes</p>
            </div>
        `;
        });
}

// Function to toggle the sidebar in mobile view
function toggleSidebar() {
    const sidebar = document.getElementById('contactsSidebar');
    sidebar.classList.toggle('show');
}
// Function to toggle user search dropdown
function toggleUserSearch() {
    const dropdown = document.getElementById('userSearchDropdown');
    const isVisible = dropdown.style.display !== 'none';
    dropdown.style.display = isVisible ? 'none' : 'block';

    if (!isVisible) {
        document.getElementById('userSearchInput').focus();
    }
}

// Function to search users
function searchUsers(query) {
    const resultsDiv = document.getElementById('userSearchResults');

    // Obtain existing contacts from the sidebar
    const existingContacts = Array.from(document.querySelectorAll('.contact-item')).map(item => {
        const contactName = item.querySelector('.contact-name');
        return contactName ? contactName.textContent.trim() : '';
    }).filter(name => name !== '');

    // Obtain the current username from the session
    const currentUsername = document.querySelector('#userDropdown span')?.textContent?.trim() || '';

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
                // Filter out existing contacts and the current user
                const filteredUsers = data.usuarios.filter(user => {
                    return !existingContacts.includes(user.USUARIO) &&
                        user.USUARIO !== currentUsername;
                });

                if (filteredUsers.length > 0) {
                    let html = '';
                    filteredUsers.forEach(user => {
                        const userImage = user.URL_FOTO ?
                            (user.URL_FOTO.startsWith('./') ? user.URL_FOTO.replace('./', '../') : user.URL_FOTO) :
                            '../assets/App-images/default_profile.png';

                        html += `
                            <div class="d-flex align-items-center py-2 px-2 border-bottom cursor-pointer search-user-item" 
                                 onclick="startConversation('${user.IDUSUARIO || user.USUARIO}', '${user.USUARIO}', '${userImage}')" 
                                 style="cursor: pointer; transition: background-color 0.2s;">
                                <img src="${userImage}" alt="${user.USUARIO}" class="rounded-circle me-2" width="32" height="32" 
                                     onerror="this.src='../assets/App-images/default_profile.png'">
                                <span>${user.USUARIO}</span>
                            </div>
                        `;
                    });
                    resultsDiv.innerHTML = html;

                    // Add hover effect to search results
                    document.querySelectorAll('.search-user-item').forEach(item => {
                        item.addEventListener('mouseenter', function () {
                            this.style.backgroundColor = '#f8f9fa';
                        });
                        item.addEventListener('mouseleave', function () {
                            this.style.backgroundColor = '';
                        });
                    });
                } else {
                    resultsDiv.innerHTML = '<small class="text-muted">No se encontraron usuarios nuevos</small>';
                }
            } else {
                resultsDiv.innerHTML = '<small class="text-muted">No se encontraron usuarios</small>';
            }
        })
        .catch(error => {
            resultsDiv.innerHTML = '<small class="text-danger">Error en la búsqueda</small>';
        });
}

// Function to start a conversation with a new user
function startConversation(userId, userName, userAvatar) {
    // Close user search dropdown 
    document.getElementById('userSearchDropdown').style.display = 'none';
    document.getElementById('userSearchInput').value = '';

    // Obtain the user ID from the server
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
                    // Select current contact
                    currentContact = user.IDUSUARIO || userId;
                    document.getElementById('currentContactId').value = currentContact;

                    // Update header
                    document.getElementById('chatUserName').textContent = userName;
                    document.getElementById('chatAvatar').src = userAvatar;

                    // Clear active contact
                    document.querySelectorAll('.contact-item').forEach(item => {
                        item.classList.remove('active');
                    });

                    // Show empty chat message
                    const messagesContainer = document.getElementById('messagesContainer');
                    messagesContainer.innerHTML = `
                            <div class="empty-chat">
                                <i class="bi bi-chat-square-text"></i>
                                <p>Conversación con ${userName}</p>
                                <small>Envía el primer mensaje para empezar</small>
                            </div>
                        `;

                    // Enable message input and send button
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
        });
}

// Close sidebar when clicking outside in mobile view
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

    // Close user search if clicked outside
    if (!userSearch.contains(event.target) && !event.target.closest('.btn[onclick="toggleUserSearch()"]')) {
        userSearch.style.display = 'none';
    }
});

// Function to search contacts in the sidebar
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

// Auto scroll to the bottom of the messages container when it loads
document.addEventListener('DOMContentLoaded', function () {
    const messagesContainer = document.getElementById('messagesContainer');
    if (messagesContainer) {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});

// Set as read notifications when clicking on the notifications icon
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

            })
    });
}