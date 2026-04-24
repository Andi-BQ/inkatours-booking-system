document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.querySelector('.edit-profile-form');
    const alertContainer = document.querySelector('.profile-card');

    if (!profileForm || !alertContainer) {
        return;
    }

    // Function to display alerts
    const showAlert = (message, type) => {
        // Remove existing alert
        const existingAlert = alertContainer.querySelector('.alert');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type}`;
        alertDiv.textContent = message;
        
        // Insert after the h3 tag
        alertContainer.insertBefore(alertDiv, profileForm);

        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    };

    profileForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(profileForm);
        const submitButton = profileForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Guardando...';

        fetch(profileForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showAlert(data.message, 'success');
                
                // Update form fields
                if (data.user) {
                    document.getElementById('nombre').value = data.user.nombre;
                    document.getElementById('telefono').value = data.user.telefono;
                    document.getElementById('pais').value = data.user.pais;

                    // Update sidebar name
                    const sidebarName = document.querySelector('.profile-avatar h3');
                    if (sidebarName) {
                        sidebarName.textContent = data.user.nombre;
                    }
                }
                
                // Clear password fields
                document.getElementById('password').value = '';
                document.getElementById('password_confirm').value = '';

            } else {
                showAlert(data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Ocurrió un error de red. Por favor, inténtalo de nuevo.', 'danger');
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.textContent = 'Guardar Cambios';
        });
    });
});
