let carrito = [];

document.addEventListener('DOMContentLoaded', () => {
  const carritoGuardado = localStorage.getItem('carrito');
  if (carritoGuardado) {
    carrito = JSON.parse(carritoGuardado);
    actualizarCarrito();
  }

  document.querySelectorAll('.btn-add').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = parseInt(btn.dataset.id);
      const nombre = btn.dataset.nombre;
      const precio = parseFloat(btn.dataset.precio);
      const img = btn.dataset.img;
      agregarAlCarrito(id, nombre, precio, img);
    });
  });
});

function agregarAlCarrito(id, nombre, precio, img) {
  const productoExistente = carrito.find(p => p.id === id);
  if (productoExistente) {
    productoExistente.cantidad++;
  } else {
    carrito.push({ id, nombre, precio, img, cantidad: 1 });
  }
  guardarCarrito();
  actualizarCarrito();
}

function cambiarCantidad(id, cambio) {
  const producto = carrito.find(p => p.id === id);
  if (!producto) return;

  producto.cantidad += cambio;
  if (producto.cantidad < 1) {
    carrito = carrito.filter(p => p.id !== id);
  }

  guardarCarrito();
  actualizarCarrito();
}

document.getElementById('emptyCart').addEventListener('click', () => {
  carrito = [];
  guardarCarrito();
  actualizarCarrito();
});


function actualizarCarrito() {
  const tbody = document.getElementById('contentProducts');
  tbody.innerHTML = '';

  carrito.forEach(producto => {
    const fila = document.createElement('tr');

    fila.innerHTML = `
      <td><img src="${producto.img}" alt="${producto.nombre}" style="width: 50px;"></td>
      <td>${producto.nombre}</td>
      <td>$${producto.precio.toFixed(2)} MXN</td>
      <td>
        <button onclick="cambiarCantidad(${producto.id}, -1)">−</button>
        <span>${producto.cantidad}</span>
        <button onclick="cambiarCantidad(${producto.id}, 1)">+</button>
      </td>
      <td><button onclick="eliminarDelCarrito(${producto.id})">X</button></td>
    `;

    tbody.appendChild(fila);
  });

  calcularTotal();
}

function eliminarDelCarrito(id) {
  carrito = carrito.filter(p => p.id !== id);
  guardarCarrito();
  actualizarCarrito();
}

function calcularTotal() {
  const total = carrito.reduce((acc, prod) => acc + prod.precio * prod.cantidad, 0);
  document.getElementById('total').textContent = `Total: $${total.toFixed(2)}`;
}

function guardarCarrito() {
  localStorage.setItem('carrito', JSON.stringify(carrito));
}