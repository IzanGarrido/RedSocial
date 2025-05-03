// Script para controlar la visualización de categorías
document.addEventListener('DOMContentLoaded', function() {
    const btnToggle = document.getElementById('btn-toggle-categorias');
    const listaPrincipal = document.getElementById('categorias-lista');
    const listaCompleta = document.getElementById('categorias-todas');
    
    if (btnToggle) {
        btnToggle.addEventListener('click', function() {
            if (listaCompleta.style.display === 'none') {
                // Mostrar todas las categorías
                listaPrincipal.style.display = 'none';
                listaCompleta.style.display = 'block';
                btnToggle.textContent = 'Mostrar menos';
            } else {
                // Mostrar solo las primeras categorías
                listaPrincipal.style.display = 'block';
                listaCompleta.style.display = 'none';
                btnToggle.textContent = 'Ver más categorías';
            }
        });
    }
});