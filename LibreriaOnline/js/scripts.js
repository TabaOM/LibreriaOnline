document.addEventListener("DOMContentLoaded", function () {
    if (document.getElementById("librosContainer")) {
        cargarLibros();
    }
    if (document.getElementById("carritoContainer")) {
        cargarCarrito();
    }
});

function cargarLibros() {
    fetch("/php/obtener_libros.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("Error al obtener los libros.");
            }
            return response.json();
        })
        .then(libros => {
            let librosContainer = document.getElementById("librosContainer");
            if (!librosContainer) return;

            console.log("Libros obtenidos:", libros); // Para depuración en consola

            librosContainer.innerHTML = "";

            if (libros.length === 0 || libros.error) {
                librosContainer.innerHTML = "<p>No hay libros disponibles o hubo un error.</p>";
                return;
            }

            libros.forEach(libro => {
                let libroCard = `
                    <div class="col-md-4">
                        <div class="card m-2">
                            <div class="card-body">
                                <h5 class="card-title">${libro.titulo}</h5>
                                <p class="card-text">Autor: ${libro.autor}</p>
                                <p class="card-text">Precio: $${libro.precio}</p>
                                <p class="card-text">Disponibles: ${libro.cantidad}</p>
                                <button class="btn btn-primary" onclick="agregarAlCarrito(${libro.id})">Agregar al carrito</button>
                            </div>
                        </div>
                    </div>`;
                librosContainer.innerHTML += libroCard;
            });
        })
        .catch(error => {
            console.error("Error al cargar libros:", error);
            document.getElementById("librosContainer").innerHTML = "<p>Error al cargar los libros.</p>";
        });
}

function agregarAlCarrito(id_libro) {
    fetch("/LibreriaOnline/php/carrito.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `accion=agregar&id_libro=${id_libro}&cantidad=1`
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje || data.error);
        cargarCarrito();
    })
    .catch(error => console.error("Error al agregar al carrito:", error));
}

function cargarCarrito() {
    fetch("/LibreriaOnline/php/carrito.php")
        .then(response => response.json())
        .then(carrito => {
            let carritoContainer = document.getElementById("carritoContainer");
            if (!carritoContainer) return;

            carritoContainer.innerHTML = "<h3>Productos en tu carrito</h3>";

            if (Object.keys(carrito).length === 0) {
                carritoContainer.innerHTML += "<p>El carrito está vacío.</p>";
                return;
            }

            for (let id in carrito) {
                let item = carrito[id];
                let itemHtml = `
                    <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                        <div>
                            <h6>${item.titulo}</h6>
                            <p>${item.cantidad} x $${item.precio}</p>
                        </div>
                        <button class="btn btn-danger btn-sm" onclick="eliminarDelCarrito(${id})">Eliminar</button>
                    </div>`;
                carritoContainer.innerHTML += itemHtml;
            }
        })
        .catch(error => console.error("Error al cargar el carrito:", error));
}

function eliminarDelCarrito(id_libro) {
    fetch("/LibreriaOnline/php/carrito.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `accion=eliminar&id_libro=${id_libro}`
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        cargarCarrito();
    })
    .catch(error => console.error("Error al eliminar del carrito:", error));
}

function finalizarCompra() {
    fetch("/LibreriaOnline/php/carrito.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "accion=vaciar"
    })
    .then(response => response.json())
    .then(data => {
        alert(data.mensaje);
        cargarCarrito();
    })
    .catch(error => console.error("Error al finalizar la compra:", error));
}
