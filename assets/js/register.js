document.addEventListener('DOMContentLoaded', function () {
    // Obtain the input element
    const birthdateInput = document.getElementById('birthdate');

    // Function to calculate minimum and maximum dates
    function configurarFechasLimite() {
        const hoy = new Date();

        // Max date: 100 years
        const fechaMinima = new Date(hoy.getFullYear() - 100, hoy.getMonth(), hoy.getDate());

        // Min date: 16 years
        const fechaMaxima = new Date(hoy.getFullYear() - 16, hoy.getMonth(), hoy.getDate());

        // Establish the limits in the input
        birthdateInput.min = fechaMinima.toISOString().split('T')[0];
        birthdateInput.max = fechaMaxima.toISOString().split('T')[0];
    }

    // Config the limit dates on page load
    configurarFechasLimite();

    // Add the change event listener
    birthdateInput.addEventListener('change', function () {
        const fechaNacimiento = new Date(this.value);
        const hoy = new Date();
        let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();

        // Adjust the age if the birthday hasn't occurred yet
        if (hoy.getMonth() < fechaNacimiento.getMonth() ||
            (hoy.getMonth() === fechaNacimiento.getMonth() && hoy.getDate() < fechaNacimiento.getDate())) {
            edad--;
        }

        // Validate age range
        if (edad < 16) {
            this.setCustomValidity('Debes tener al menos 16 años para registrarte.');
        } else if (edad > 100) {
            this.setCustomValidity('La edad máxima permitida es de 100 años.');
        } else {
            this.setCustomValidity('');
        }

    });

});