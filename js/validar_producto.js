// ========================================================
// VALIDACIÓN DEL FORMULARIO DE REGISTRO DE PRODUCTOS
// ========================================================
$(document).ready(function() {
    $("#formProductos").validate({
        rules: {
            Codigo: { required: true, minlength: 4 },
            Nombre: { required: true, minlength: 3 },
            Tipo: { required: true },
            Talla: { required: true },
            Color: { required: true },
            Costo: { required: true, number: true, min: 0 },
            Stock: { required: true, digits: true, min: 0 },
            Imagen: { required: true }
        },
        messages: {
            Codigo: { required: "El código es obligatorio.", minlength: "Mínimo 4 caracteres." },
            Nombre: { required: "El nombre es obligatorio.", minlength: "Mínimo 3 caracteres." },
            Tipo: { required: "Selecciona el tipo." },
            Talla: { required: "Selecciona la talla." },
            Color: { required: "Indica el color." },
            Costo: { required: "El costo es obligatorio.", number: "Precio no válido.", min: "No puede ser menor a 0." },
            Stock: { required: "Ingresa el stock.", digits: "Debe ser número entero.", min: "No puede ser negativo." },
            Imagen: { required: "El nombre de imagen es obligatorio." }
        }
    });
});



// ========================================================
// VALIDACIÓN DEL FORMULARIO DE REGISTRO DE PRODUCTOS
// ========================================================
$(document).ready(function() {
    $("#formProductos").validate({
        rules: {
            Codigo: { required: true, minlength: 4 },
            Nombre: { required: true, minlength: 3 },
            Tipo: { required: true },
            Talla: { required: true },
            Color: { required: true },
            Costo: { required: true, number: true, min: 0 },
            Stock: { required: true, digits: true, min: 0 },
            Imagen: { required: true }
        },
        messages: {
            Codigo: { required: "El código es obligatorio.", minlength: "Mínimo 4 caracteres." },
            Nombre: { required: "El nombre es obligatorio.", minlength: "Mínimo 3 caracteres." },
            Tipo: { required: "Selecciona el tipo." },
            Talla: { required: "Selecciona la talla." },
            Color: { required: "Indica el color." },
            Costo: { required: "El costo es obligatorio.", number: "Precio no válido.", min: "No puede ser menor a 0." },
            Stock: { required: "Ingresa el stock.", digits: "Debe ser número entero.", min: "No puede ser negativo." },
            Imagen: { required: "El nombre de imagen es obligatorio." }
        }
    });
});