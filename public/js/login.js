document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById('login-form');

    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const cedula = document.getElementById("cedula_user").value;

        // Definir los datos que se enviarán en la solicitud POST
        const formData = new FormData();
        formData.append('cedula_user', cedula);

        // Configurar las opciones de la solicitud Fetch
        const requestOptions = { 
            method: 'POST',
            body: formData,
        };

        // Realizar la solicitud Fetch al controlador
        fetch('../Controllers/validate_login.php', requestOptions)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Hubo un problema al realizar la solicitud.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Autenticación exitosa, mostrar un mensaje antes de redirigir
                    Swal.fire({
                        icon: 'success',
                        title: 'Ingresaste correctamente',
                        text: data.message,
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        // Redireccionar a la página correspondiente después de que el usuario cierre la alerta
                        window.location.href = data.redirect;
                    });
                } else {
                    // Mostrar un mensaje de error utilizando SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al Ingresar',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                // Manejar errores si ocurren durante la solicitud
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Hubo un error en la solicitud. Inténtalo de nuevo.'
                });
            });
    });
});