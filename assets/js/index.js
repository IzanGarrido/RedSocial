document.addEventListener('DOMContentLoaded', function () {

  const searchInput = document.getElementById('searchInput');
  const searchResults = document.getElementById('searchResults');

  // Functionality for the search input
  if (searchInput) {
    let searchTimeout;
    // Event listener for keyup on the search input
    searchInput.addEventListener('keyup', function () {
      clearTimeout(searchTimeout);
      const value = this.value.trim();
      // If the input is empty, hide the results
      if (value.length < 1) {
        searchResults.classList.add('d-none');
        searchResults.innerHTML = '';
        return;
      }
      // Timeout to delay the search
      searchTimeout = setTimeout(() => {
        // Fetch the search results
        fetch('includes/buscar.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'term=' + encodeURIComponent(value)
        })
          .then(res => res.json())
          .then(data => {
            // Clear previous results
            let html = '';
            if (data.usuarios && data.usuarios.length) {
              html += '<div class="px-3 py-1 text-muted small">Usuarios</div>';

              // Iterate over the users and create the HTML for user results
              data.usuarios.forEach(u => {
                html += `<div class="result-item" onclick="window.location='./pages/user.php?user=${encodeURIComponent(u.USUARIO)}'">
                <img src="${u.URL_FOTO || './assets/img/default_profile.png'}" class="rounded-circle me-2" width="28" height="28">
                ${u.USUARIO}
              </div>`;
              });
            }

            // Iterate over the games and create the HTML for game results
            if (data.juegos && data.juegos.length) {
              html += '<div class="px-3 py-1 text-muted small">Juegos</div>';
              data.juegos.forEach(j => {
                html += `<div class="result-item" onclick="window.location='./pages/games.php?id=${j.IDJUEGO}'">
                <img src="${j.URL_IMAGEN}" class="rounded-5 me-2" width="28" height="28">
                ${j.JUEGO}
              </div>`;
              });
            }

            // Iterate over the categories and create the HTML for category results
            if (data.categorias && data.categorias.length) {
              html += '<div class="px-3 py-1 text-muted small">Categorías</div>';
              data.categorias.forEach(c => {
                html += `<div class="result-item" onclick="window.location='./pages/categories.php?id=${c.ID_CATEGORIA}'">
                <i class="bi bi-controller me-2"></i>
                ${c.CATEGORIA}
              </div>`;
              });
            }
            // If there are no results, show a message
            if (!html) html = '<div class="result-item text-muted">Sin resultados</div>';
            searchResults.innerHTML = html;
            searchResults.classList.remove('d-none');
          })
          .catch(() => {
            searchResults.innerHTML = '<div class="result-item text-danger">Error en la búsqueda</div>';
            searchResults.classList.remove('d-none');
          });
      }, 100);
    });

    // Hide results when the input loses focus
    searchInput.addEventListener('blur', function () {
      setTimeout(() => searchResults.classList.add('d-none'), 200);
    });
    searchInput.addEventListener('focus', function () {
      if (searchResults.innerHTML) searchResults.classList.remove('d-none');
    });
  }


  // Toggle for showing/hiding categories
  const btnToggleCategories = document.getElementById('btn-toggle-categorias');
  const listaPrincipal = document.getElementById('categorias-lista');
  const listaCompleta = document.getElementById('categorias-todas');

  if (btnToggleCategories) {
    btnToggleCategories.addEventListener('click', function () {
      if (listaCompleta.style.display === 'none') {
        // Show all categories
        listaPrincipal.style.display = 'none';
        listaCompleta.style.display = 'block';
        btnToggleCategories.textContent = 'Mostrar menos';
      } else {
        // Show only some categories
        listaPrincipal.style.display = 'block';
        listaCompleta.style.display = 'none';
        btnToggleCategories.textContent = 'Ver más categorías';
      }
    });
  }

  // Toggle for showing/hiding games
  const btnToggleGames = document.getElementById('btn-toggle-juegos');
  const gamesPrincipal = document.getElementById('juegos-lista');
  const gamesCompleta = document.getElementById('juegos-todos');

  if (btnToggleGames) {
    btnToggleGames.addEventListener('click', function () {
      if (gamesCompleta.style.display === 'none') {
        // Show all games
        gamesPrincipal.style.display = 'none';
        gamesCompleta.style.display = 'block';
        btnToggleGames.textContent = 'Mostrar menos';
      } else {
        // Show only some games
        gamesPrincipal.style.display = 'block';
        gamesCompleta.style.display = 'none';
        btnToggleGames.textContent = 'Ver más juegos';
      }
    });
  }

  // Functionality for media preview in the create post modal
  const postMedia = document.getElementById('postMedia');
  const imagePreview = document.getElementById('imagePreview');
  const videoPreview = document.getElementById('videoPreview');
  const mediaPreview = document.getElementById('mediaPreview');
  const addPhotoBtn = document.getElementById('addPhotoBtn');
  const addVideoBtn = document.getElementById('addVideoBtn');
  const mediaError = document.getElementById('mediaError');

  // Function to show media validation errors
  function showMediaError(message) {
    if (mediaError) {
      mediaError.textContent = message;
      mediaError.classList.remove('d-none');
    }
  }

  // Function to hide media validation errors
  function hideMediaError() {
    if (mediaError) {
      mediaError.classList.add('d-none');
    }
  }

  // Function to validate the file size
  function validateFileSize(file) {
    const minSize = 1024; // 1KB en bytes
    const maxSize = 25 * 1024 * 1024; // 25MB en bytes


    if (file.size < minSize) {
      showMediaError(`El archivo es demasiado pequeño. Tamaño mínimo: 1KB`);
      return false;
    }

    if (file.size > maxSize) {
      showMediaError(`El archivo es demasiado grande. Tamaño máximo: 50MB`);
      return false;
    }

    return true;
  }

  // Function to validate the video duration
  function validateVideoDuration(videoElement) {
    return new Promise((resolve) => {
      videoElement.onloadedmetadata = function () {
        const maxDuration = 120;

        if (videoElement.duration > maxDuration) {
          showMediaError(`El video es demasiado largo. Duración máxima: 2 minutos`);
          resolve(false);
        } else {
          hideMediaError();
          resolve(true);
        }
      };
    });
  }

  // Function to validate the file size
  if (postMedia) {
    postMedia.addEventListener('change', async function () {
      // Reset the previews and errors
      imagePreview.classList.add('d-none');
      videoPreview.classList.add('d-none');
      hideMediaError();

      if (this.files && this.files[0]) {
        const file = this.files[0];

        // Validate file size
        if (!validateFileSize(file)) {
          this.value = '';
          return;
        }

        const fileReader = new FileReader();

        // Show the preview container
        mediaPreview.classList.remove('d-none');

        if (file.type.match('image.*')) {
          // Is an image
          fileReader.onload = function (e) {
            imagePreview.src = e.target.result;
            imagePreview.classList.remove('d-none');
          };
          fileReader.readAsDataURL(file);
        } else if (file.type.match('video.*')) {
          // Is a video
          fileReader.onload = async function (e) {
            videoPreview.src = e.target.result;
            videoPreview.classList.remove('d-none');

            // Validate the video duration
            const isValidDuration = await validateVideoDuration(videoPreview);

            if (!isValidDuration) {
              postMedia.value = ''; // Limpiar el input
              videoPreview.classList.add('d-none');
            }
          };
          fileReader.readAsDataURL(file);
        }
      } else {
        // If there is no file, hide the preview
        mediaPreview.classList.add('d-none');
      }
    });
  }

  // Buttons to add photo or video
  if (addPhotoBtn) {
    addPhotoBtn.addEventListener('click', function () {
      postMedia.setAttribute('accept', 'image/*');
      postMedia.click();
    });
  }

  if (addVideoBtn) {
    addVideoBtn.addEventListener('click', function () {
      postMedia.setAttribute('accept', 'video/*');
      postMedia.click();
    });
  }

  // Validate the form for creating a post
  const createPostForm = document.getElementById('createPostForm');

  if (createPostForm) {
    createPostForm.addEventListener('submit', function (e) {
      e.preventDefault();

      const postContent = document.getElementById('postContent').value;
      const mediaFile = postMedia.files[0];

      // Validate that there is at least content or a media file
      if (!postContent) {
        showMediaError('Por favor, añade un texto.');
        return;
      }

      if (!mediaFile) {
        showMediaError('Por favor, añade una imagen o un video.');
        return;
      }

      // If all is correct, submit the form
      this.submit();
    });
  }

  // Events for the create post modal
  const createPostModal = document.getElementById('createPostModal');

  if (createPostModal) {
    // Clean the form when the modal is closed
    createPostModal.addEventListener('hidden.bs.modal', function () {
      if (createPostForm) createPostForm.reset();
      if (mediaPreview) mediaPreview.classList.add('d-none');
      if (imagePreview) imagePreview.classList.add('d-none');
      if (videoPreview) videoPreview.classList.add('d-none');
      hideMediaError();
    });
  }

  // Styles for the datalist 
  const gameInput = document.getElementById('gameInput');
  if (gameInput) {
    // Styles when is focused
    gameInput.addEventListener('focus', function () {
      this.classList.add('focused-datalist');
    });

    gameInput.addEventListener('blur', function () {
      this.classList.remove('focused-datalist');
    });
  }


  // Function to open the comments modal and load comments
  window.openCommentsModal = function (postId) {
    // Put the post ID in the form
    document.getElementById('post_id').value = postId;

    // Load comments
    loadComments(postId);

    // Open the modal
    var commentsModal = new bootstrap.Modal(document.getElementById('commentsModal'));
    commentsModal.show();
  }

  // Function to load comments
  function loadComments(postId) {
    const commentsContainer = document.getElementById('comments-container');

    commentsContainer.innerHTML = `
      <div class="text-center py-3">
        <div class="text-primary" role="status">
          <span class="visually-hidden">Cargando...</span>
        </div>
      </div>
    `;

    // Realizar petición AJAX para obtener comentarios
    fetch('includes/cargar_comentarios.php', {
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

  // Handler for the comment form
  document.getElementById('commentForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const postId = document.getElementById('post_id').value;
    const content = document.getElementById('commentContent').value;

    if (!content.trim()) return;

    // Send comment
    fetch('includes/guardar_comentario.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'post_id=' + postId + '&content=' + encodeURIComponent(content)
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Load the comments
          loadComments(postId);

          // Clear the text field
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


  // Mark as read the notifications
  document.getElementById('Notificaciones').addEventListener('click', function () {
    // Mark notifications as read
    fetch('includes/leer_notificaciones.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
    })
      .then(response => response.json())
      .then(data => {
        console.log('Data:', data);
        if (data.success) {
          console.log('Notificaciones marcadas como leídas.');
        } else {
          console.error('Error al marcar las notificaciones como leídas.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
  });

});



// Function to add or remove a like to a post
function toggleLike(btn, userId, publicacionId, $numLikes) {
  const likeado = btn.dataset.likeado === '1' ? 'quitar' : 'dar';

  fetch('includes/likesControl.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `user_id=${userId}&publicacion_id=${publicacionId}&accion=${likeado}&numlikes=${$numLikes}`
  })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        const span = btn.querySelector('.like-count');
        span.textContent = data.likes;
        console.log(data.likes);

        // Change classes
        if (likeado === 'dar') {
          btn.classList.remove('like-btn');
          btn.classList.add('like-btn-red');
          btn.dataset.likeado = '1';
        } else {
          btn.classList.remove('like-btn-red');
          btn.classList.add('like-btn');
          btn.dataset.likeado = '0';
        }
      } else {
        console.error('Error:', data.message);
      }
    });
}