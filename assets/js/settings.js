// Image preview function
function previewImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];

        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            input.value = '';
            return;
        }

        // Validate file type
        if (!file.type.match('image.*')) {
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('imagePreview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}

// Auto-dismiss alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Bio character counter
    const bioTextarea = document.getElementById('bio');
    if (bioTextarea) {
        const charCount = document.createElement('small');
        charCount.className = 'text-muted float-end';
        bioTextarea.parentNode.appendChild(charCount);

        function updateCharCount() {
            const remaining = 500 - bioTextarea.value.length;
            charCount.textContent = `${bioTextarea.value.length}/500 caracteres`;
            charCount.className = remaining < 50 ? 'text-warning float-end' : 'text-muted float-end';
        }

        bioTextarea.addEventListener('input', updateCharCount);
        updateCharCount(); // Initial count
    }

    // Delete account confirmation
    const deleteForm = document.getElementById('deleteAccountForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function (e) {

            // Show loading state
            const submitBtn = deleteForm.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Eliminando...';
            submitBtn.disabled = true;
        });
    }
});

// Mark notifications as read when clicked
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
                    // Hide notification badge
                    const badge = document.querySelector('.badge.bg-danger');
                    if (badge) {
                        badge.style.display = 'none';
                    }
                } else {
                }
            })
            .catch(error => {
            });
    });
}