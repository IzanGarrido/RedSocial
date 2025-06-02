  // Ajustar rutas para archivos en subdirectorios
        document.addEventListener('DOMContentLoaded', function() {

            // Marcar notificaciones como leídas
            const notificacionesElement = document.getElementById('Notificaciones');
            if (notificacionesElement) {
                notificacionesElement.addEventListener('click', function() {
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
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            }
        });

        // Función para toggle like
        function toggleLike(btn, userId, publicacionId) {
            const likeado = btn.dataset.likeado === '1' ? 'quitar' : 'dar';

            fetch('../includes/likesControl.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `user_id=${userId}&publicacion_id=${publicacionId}&accion=${likeado}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const span = btn.querySelector('.like-count');
                        span.textContent = data.likes;

                        if (likeado === 'dar') {
                            btn.classList.remove('like-btn');
                            btn.classList.add('like-btn-red');
                            btn.dataset.likeado = '1';
                        } else {
                            btn.classList.remove('like-btn-red');
                            btn.classList.add('like-btn');
                            btn.dataset.likeado = '0';
                        }
                    }
                });
        }

        // Función para abrir modal de comentarios
        window.openCommentsModal = function(postId) {
            document.getElementById('post_id').value = postId;
            loadComments(postId);

            var commentsModal = new bootstrap.Modal(document.getElementById('commentsModal'));
            commentsModal.show();
        }

        // Función para cargar comentarios
        function loadComments(postId) {
            const commentsContainer = document.getElementById('comments-container');

            commentsContainer.innerHTML = `
                <div class="text-center py-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            `;

            fetch('../includes/cargar_comentarios.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'post_id=' + postId
                })
                .then(response => response.text())
                .then(data => {
                    commentsContainer.innerHTML = data;
                })
                .catch(error => {
                    commentsContainer.innerHTML = '<p class="text-danger">Error al cargar los comentarios.</p>';
                    console.error('Error:', error);
                });
        }

        // Handler para el formulario de comentarios
        document.getElementById('commentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const postId = document.getElementById('post_id').value;
            const content = document.getElementById('commentContent').value;

            if (!content.trim()) return;

            fetch('../includes/guardar_comentario.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'post_id=' + postId + '&content=' + encodeURIComponent(content)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadComments(postId);
                        document.getElementById('commentContent').value = '';
                    } else {
                        alert(data.message || 'Error al guardar el comentario.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al guardar el comentario.');
                });
        });