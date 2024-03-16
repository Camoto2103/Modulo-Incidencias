const email = document.getElementById("email");
const multimedia = document.getElementById("multimedia");
const url = document.getElementById("url");
const descripcion = document.getElementById('descripcion');
const adjunto = document.getElementById("adjunto");
const form = document.getElementById("formulario");

//MOSTRAR O OCULTAR EL PRIMER FORMULARIO CUANDO SE INGRESA LA CEDULA
//VALIDACION EN EL ../Controllers/validate.php
document.addEventListener("DOMContentLoaded", function () {
    const firstForm = document.getElementById('first-form');
    firstForm.style.display = formDisplay; // Asegúrate de que 'formDisplay' esté definido antes de esta línea.

    // Evento de envío del formulario
    firstForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const cedula = document.getElementById("cedula").value;

        // Definir los datos que se enviarán en la solicitud POST
        const formData = new FormData();
        formData.append('cedula', cedula);

        // Configurar las opciones de la solicitud Fetch
        const requestOptions = {
            method: 'POST',
            body: formData,
        };

        // Realizar la solicitud Fetch
        fetch('../Controllers/validate_cedula.php', requestOptions)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Hubo un problema al realizar la solicitud.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Cédula válida
                    const userData = data.userData;
                    const message = `Cedula: ${userData.cedula}\n Nombre: ${userData.nombre}\nCanal: ${userData.Canal}\nCargo: ${userData.Cargo}`;

                    // Mostrar una alerta personalizada con SweetAlert2
                    Swal.fire({
                        title: 'Verificación de Usuario',
                        text: message,
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Sí',
                        cancelButtonText: 'No',
                        customClass: {
                            confirmButton: 'order-2',
                            cancelButton: 'order-1 right-gap',
                        },
                    }).then(result => {
                        if (result.isConfirmed) {
                            // Si el usuario confirma que es correcto, redirige a la página correspondiente
                            window.location.href = '../Views/formulario.php';
                        } else {
                            // Si el usuario no confirma que es correcto, borra el valor del campo de cédula
                            document.getElementById('cedula').value = '';
                        }
                    });
                } else {
                    // Cédula no válida, muestra una alerta de error con SweetAlert2
                    Swal.fire('Cédula No Válida', data.message, 'error');
                }
            })
            .catch(error => {
                // Manejar errores si ocurren durante la solicitud
                console.error('Error:', error);
            });

    });

    //MOSTRAR O OCULTAR EL FORMULARIO CUANDO SE INGRESA LA CEDULA
    //AQUI ES CUANDO SE VALIDA LA CEDULA
    //VALIDACION PARA ../Controllers/Inser_Form.php
    const secondForm = document.getElementById('second-form');
    secondForm.style.display = secondFormDisplay; // Asegúrate de que 'secondFormDisplay' esté definido antes de esta línea.

    form.addEventListener("submit", function (event) {
        let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        let isValid = true;
        let alertMessages = [];

        if (!regexEmail.test(email.value)) {
            alertMessages.push("EMAIL");
            isValid = false;
        }

        if (multimedia.value === "") {
            alertMessages.push("MULTIMEDIA");
            isValid = false;
        }

        if (url.value === "") {
            alertMessages.push("URL");
            isValid = false;
        }

        if (descripcion.value.trim() === "") {
            alertMessages.push("DESCRIPCIÓN");
            isValid = false;
        }

        if( adjunto.files[0] === undefined){
            alertMessages.push("ADJUNTO");
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
            Swal.fire("Por favor, valida los campos:", alertMessages.join("\n"), "error");
        }
    });
});