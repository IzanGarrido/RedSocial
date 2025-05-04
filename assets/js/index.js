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
});