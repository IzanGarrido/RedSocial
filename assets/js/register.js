// Script for calculate max date
document.addEventListener('DOMContentLoaded', function() {
    // Obtain the input element
    const birthdateInput = document.getElementById('birthdate');
    
    // Calc the max date
    function calcularFechaMaxima() {
        const hoy = new Date();
        const fechaMinima = new Date(hoy.getFullYear() - 16, hoy.getMonth(), hoy.getDate());
        return fechaMinima.toISOString().split('T')[0]; // Formato YYYY-MM-DD
    }
    
    // Establish the max date
    birthdateInput.max = calcularFechaMaxima();
    
    // Add the change event listener
    birthdateInput.addEventListener('change', function() {
        const fechaNacimiento = new Date(this.value);
        const hoy = new Date();
        let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
        
        // Adjust the age if the birthday hasn't occurred yet
        if (hoy.getMonth() < fechaNacimiento.getMonth() || 
            (hoy.getMonth() === fechaNacimiento.getMonth() && hoy.getDate() < fechaNacimiento.getDate())) {
            edad--;
        }
        
    });
    
});