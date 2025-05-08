document.addEventListener('DOMContentLoaded', function() {
  // Toggle para mostrar/ocultar categorías
  const btnToggleCategories = document.getElementById('btn-toggle-categorias');
  const listaPrincipal = document.getElementById('categorias-lista');
  const listaCompleta = document.getElementById('categorias-todas');
  
  if (btnToggleCategories) {
    btnToggleCategories.addEventListener('click', function() {
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

  // Toggle para mostrar/ocultar juegos
  const btnToggleGames = document.getElementById('btn-toggle-juegos');
  const gamesPrincipal = document.getElementById('juegos-lista');
  const gamesCompleta = document.getElementById('juegos-todos');
  
  if (btnToggleGames) {
    btnToggleGames.addEventListener('click', function() {
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

  // Funcionalidad para la previsualización de media en el modal de crear post
  const postMedia = document.getElementById('postMedia');
  const imagePreview = document.getElementById('imagePreview');
  const videoPreview = document.getElementById('videoPreview');
  const mediaPreview = document.getElementById('mediaPreview');
  const addPhotoBtn = document.getElementById('addPhotoBtn');
  const addVideoBtn = document.getElementById('addVideoBtn');
  
  // Función para previsualizar archivos subidos
  if (postMedia) {
    postMedia.addEventListener('change', function() {
      // Resetear las vistas previas
      imagePreview.classList.add('d-none');
      videoPreview.classList.add('d-none');
      
      if (this.files && this.files[0]) {
        const file = this.files[0];
        const fileReader = new FileReader();
        
        // Mostrar el contenedor de vista previa
        mediaPreview.classList.remove('d-none');
        
        if (file.type.match('image.*')) {
          // Es una imagen
          fileReader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.classList.remove('d-none');
          };
          fileReader.readAsDataURL(file);
        } else if (file.type.match('video.*')) {
          // Es un video
          fileReader.onload = function(e) {
            videoPreview.src = e.target.result;
            videoPreview.classList.remove('d-none');
          };
          fileReader.readAsDataURL(file);
        }
      } else {
        // No hay archivo, ocultar la vista previa
        mediaPreview.classList.add('d-none');
      }
    });
  }
  
  // Botones para añadir foto o video
  if (addPhotoBtn) {
    addPhotoBtn.addEventListener('click', function() {
      postMedia.setAttribute('accept', 'image/*');
      postMedia.click();
    });
  }
  
  if (addVideoBtn) {
    addVideoBtn.addEventListener('click', function() {
      postMedia.setAttribute('accept', 'video/*');
      postMedia.click();
    });
  }
  
  // Validación del formulario de crear post
  const createPostForm = document.getElementById('createPostForm');
  
  if (createPostForm) {
    createPostForm.addEventListener('submit', function(e) {
      e.preventDefault(); // Evitar el envío normal del formulario
      
      const postContent = document.getElementById('postContent').value;
      const mediaFile = postMedia.files[0];
      
      // Validar que al menos haya contenido o un archivo multimedia
      if (!postContent && !mediaFile) {
        alert('Por favor, escribe algo o añade una foto o video.');
        return;
      }
      
      // Aquí puedes implementar el envío del formulario por AJAX o permitir el envío normal
      // Para este ejemplo, enviamos el formulario normalmente
      this.submit();
    });
  }
  
  // Eventos para el modal de crear post
  const createPostModal = document.getElementById('createPostModal');
  
  if (createPostModal) {
    // Limpiar el formulario cuando se cierra el modal
    createPostModal.addEventListener('hidden.bs.modal', function() {
      if (createPostForm) createPostForm.reset();
      if (mediaPreview) mediaPreview.classList.add('d-none');
      if (imagePreview) imagePreview.classList.add('d-none');
      if (videoPreview) videoPreview.classList.add('d-none');
    });
  }
});