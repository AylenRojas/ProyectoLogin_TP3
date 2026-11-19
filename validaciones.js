document.addEventListener("DOMContentLoaded", () => {
    const formLogin = document.getElementById("formLogin");
    const formRegistro = document.getElementById("formRegistro");

    // Validación Login
    if (formLogin) {
        formLogin.addEventListener("submit", (e) => {
            const correo = document.getElementById("correo").value.trim();
            const password = document.getElementById("password").value.trim();
            const errorMsg = document.getElementById("errorLogin");

            errorMsg.textContent = "";

            if (correo === "" || password === "") {
                e.preventDefault();
                errorMsg.textContent = "Todos los campos son obligatorios.";
                return;
            }

            if (!correo.endsWith("@gmail.com")) {
                e.preventDefault();
                errorMsg.textContent = "El correo debe ser @gmail.com.";
                return;
            }

            if (password.length < 8) {
                e.preventDefault();
                errorMsg.textContent = "La contraseña debe tener al menos 8 caracteres.";
            }
        });
    }

    // Validación Registro
    if (formRegistro) {
        formRegistro.addEventListener("submit", (e) => {
            const nombre = document.getElementById("nombre").value.trim();
            const apellido = document.getElementById("apellido").value.trim();
            const correo = document.getElementById("correo").value.trim();
            const password = document.getElementById("password").value;
            const confirmar = document.getElementById("confirmar_password").value;
            const errorMsg = document.getElementById("errorRegistro");

            errorMsg.textContent = "";

            if (!nombre || !apellido || !correo || !password || !confirmar) {
                e.preventDefault();
                errorMsg.textContent = "Por favor, complete todos los campos obligatorios.";
                return;
            }

            if (!correo.endsWith("@gmail.com")) {
                e.preventDefault();
                errorMsg.textContent = "El correo debe tener el dominio @gmail.com.";
                return;
            }

            // Min 8 chars, mayúscula, minúscula, número y símbolo
            const regexSeguridad = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
            if (!regexSeguridad.test(password)) {
                e.preventDefault();
                errorMsg.textContent = "La contraseña debe tener mín. 8 caracteres, mayúscula, minúscula, número y símbolo.";
                return;
            }

            if (password !== confirmar) {
                e.preventDefault();
                errorMsg.textContent = "Las contraseñas no coinciden.";
            }
        });
    }
});