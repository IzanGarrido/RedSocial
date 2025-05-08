// Script for controll show/hide categories
document.addEventListener('DOMContentLoaded', function() {
    const btnToggle = document.getElementById('btn-toggle-categorias');
    const listaPrincipal = document.getElementById('categorias-lista');
    const listaCompleta = document.getElementById('categorias-todas');
    
    if (btnToggle) {
        btnToggle.addEventListener('click', function() {
            if (listaCompleta.style.display === 'none') {
                // Show all categories
                listaPrincipal.style.display = 'none';
                listaCompleta.style.display = 'block';
                btnToggle.textContent = 'Mostrar menos';
            } else {
                // Show only some categories
                listaPrincipal.style.display = 'block';
                listaCompleta.style.display = 'none';
                btnToggle.textContent = 'Ver más categorías';
            }
        });
    }

    // Función para ajustar las alturas basadas en la ventana
  function adjustHeights() {
    const windowHeight = window.innerHeight;
    const navbarHeight = document.querySelector('header').offsetHeight;
    const footerHeight = document.querySelector('footer').offsetHeight;
    const availableHeight = windowHeight - navbarHeight - 40; // 40px de margen
    
    // Ajustar la altura del contenedor principal
    const mainContainer = document.querySelector('.main-content-container');
    if (mainContainer) {
      mainContainer.style.height = `${availableHeight}px`;
    }
    
    // Ajustar la altura del contenedor de la barra lateral
    const sidebarContainer = document.querySelector('.sidebar-container');
    if (sidebarContainer) {
      sidebarContainer.style.height = `${availableHeight}px`;
      sidebarContainer.style.top = `${navbarHeight + 10}px`; // 10px de margen superior
    }
    
    // Ajustar la altura máxima de cada sección de la barra lateral
    const sidebarSections = document.querySelectorAll('.sidebar-section');
    const sectionCount = sidebarSections.length;
    if (sectionCount > 0) {
      const sectionHeight = (availableHeight / sectionCount) - 20; // 20px de margen entre secciones
      sidebarSections.forEach(section => {
        section.style.maxHeight = `${sectionHeight}px`;
      });
    }
  }
  
  // Inicializar alturas
  adjustHeights();
  
  // Ajustar alturas cuando cambie el tamaño de la ventana
  window.addEventListener('resize', adjustHeights);

});