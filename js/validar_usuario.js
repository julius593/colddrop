// ========================================================
// VALIDACIÓN DEL FORMULARIO DE REGISTRO DE USUARIOS
// ========================================================
$(document).ready(function() {
    $("#formUsuarios").validate({
        rules: {
            CI: { required: true, number: true },
            Nombre: { required: true, minlength: 3 },
            Apellido: { required: true, minlength: 3 },
            Usuario: { required: true, minlength: 3 },
            Contrasena: { required: true, minlength: 4 },
            Direccion: { required: true },
            Rol: { required: true },
            Estado: { required: true }
        },
        messages: {
            CI: { required: "El CI es obligatorio.", number: "Ingresa un número válido." },
            Nombre: { required: "El nombre es obligatorio.", minlength: "Mínimo 3 caracteres." },
            Apellido: { required: "El apellido es obligatorio.", minlength: "Mínimo 3 caracteres." },
            Usuario: { required: "El usuario es obligatorio.", minlength: "Mínimo 3 caracteres." },
            Contrasena: { required: "La contraseña es obligatoria.", minlength: "Mínimo 4 caracteres." },
            Direccion: { required: "La dirección es obligatoria." },
            Rol: { required: "Indica el rol." },
            Estado: { required: "Indica el estado." }
        }
    });
});
  
// ========================================================
// VALIDACIÓN DEL FORMULARIO DE REGISTRO DE USUARIOS
// ========================================================
$(document).ready(function() {
    $("#formUsuarios").validate({
        rules: {
            CI: { required: true, number: true },
            Nombre: { required: true, minlength: 3 },
            Apellido: { required: true, minlength: 3 },
            Usuario: { required: true, minlength: 3 },
            Contrasena: { required: true, minlength: 4 },
            Direccion: { required: true },
            Rol: { required: true },
            Estado: { required: true }
        },
        messages: {
            CI: { required: "El CI es obligatorio.", number: "Ingresa un número válido." },
            Nombre: { required: "El nombre es obligatorio.", minlength: "Mínimo 3 caracteres." },
            Apellido: { required: "El apellido es obligatorio.", minlength: "Mínimo 3 caracteres." },
            Usuario: { required: "El usuario es obligatorio.", minlength: "Mínimo 3 caracteres." },
            Contrasena: { required: "La contraseña es obligatoria.", minlength: "Mínimo 4 caracteres." },
            Direccion: { required: "La dirección es obligatoria." },
            Rol: { required: "Indica el rol." },
            Estado: { required: "Indica el estado." }
        }
    });
});