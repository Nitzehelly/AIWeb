document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('select');
  M.FormSelect.init(elems);
  
  var datepickers = document.querySelectorAll('.datepicker');
  M.Datepicker.init(datepickers, {
    format: 'dd/mm/yyyy',
    minDate: new Date(),
    i18n: {
      months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
      weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
      weekdaysAbbrev: ['D', 'L', 'M', 'M', 'J', 'V', 'S']
    }
  });
  
  document.getElementById('filtroEstado').addEventListener('change', aplicarFiltros);
  document.getElementById('filtroFecha').addEventListener('change', aplicarFiltros);
  actualizarContadores();
});

function aplicarFiltros() {
  const estadoSeleccionado = document.getElementById('filtroEstado').value;
  const fechaSeleccionada = document.getElementById('filtroFecha').value;
  const todasCitas = document.querySelectorAll('.cita-card');
  
  let citasVisibles = 0;
  todasCitas.forEach(function(cita) {
    
    let mostrar = true;
    if (estadoSeleccionado !== 'todas') {
      const badge = cita.querySelector('.estado-badge');
      const estadoCita = badge.textContent.toLowerCase().trim();
      if (!estadoCita.includes(estadoSeleccionado)) {
        mostrar = false;
      }
    }
    
    if (fechaSeleccionada && mostrar) {
      const fechaCita = cita.querySelector('.cita-info:nth-child(2) span').textContent;
      if (fechaCita !== fechaSeleccionada) {
        mostrar = false;
      } 
    }
    
    cita.style.display = mostrar ? 'block' : 'none';
    if (mostrar) citasVisibles++;
  });
  
  const sinCitas = document.getElementById('sinCitas');
  const listaCitas = document.getElementById('listaCitas');
  
  if (citasVisibles === 0) {
    listaCitas.style.display = 'none';
    sinCitas.style.display = 'block';
  } else {
    listaCitas.style.display = 'block';
    sinCitas.style.display = 'none';
  }
}

function limpiarFiltros() { 
  document.getElementById('filtroEstado').value = 'todas';
  M.FormSelect.init(document.querySelectorAll('select'));

  document.getElementById('filtroFecha').value = '';
  M.updateTextFields();

  const todasCitas = document.querySelectorAll('.cita-card');
  todasCitas.forEach(function(cita) {
    cita.style.display = 'block';
  });
  
  document.getElementById('sinCitas').style.display = 'none';
  document.getElementById('listaCitas').style.display = 'block';
  
  M.toast({html: 'Filtros limpiados', classes: 'rounded blue'});
}

function confirmarCita(elemento) {
  const card = elemento.closest('.cita-card');
  const badge = card.querySelector('.estado-badge');

  badge.textContent = 'CONFIRMADA';
  badge.className = 'estado-badge confirmada';

  const cardAction = card.querySelector('.card-action');
  cardAction.innerHTML = `
    <a href="#" onclick="marcarCompletada(this); return false;" class="green-text">Marcar como completada</a>
    <a href="#" onclick="cancelarCita(this); return false;" class="red-text">Cancelar</a>
    <a href="#" onclick="verDetalles(this); return false;" class="blue-text">Ver detalles</a>
  `;

  M.toast({html: '✓ Cita confirmada exitosamente', classes: 'rounded green'});  
  actualizarContadores();
}

function marcarCompletada(elemento) {
  const card = elemento.closest('.cita-card');
  const badge = card.querySelector('.estado-badge');

  badge.textContent = 'COMPLETADA';
  badge.className = 'estado-badge completada';

  const cardAction = card.querySelector('.card-action');
  cardAction.innerHTML = `
    <a href="#" onclick="verDetalles(this); return false;" class="blue-text">Ver detalles</a>
    <a href="#" class="grey-text">Cita finalizada</a>
  `;
  
  M.toast({html: '✓ Cita marcada como completada', classes: 'rounded teal'});
  actualizarContadores();
}

function cancelarCita(elemento) {
  if (confirm('¿Estás seguro de que deseas cancelar esta cita?')) {
    const card = elemento.closest('.cita-card');
    card.style.transition = 'all 0.3s ease';
    card.style.opacity = '0';
    card.style.transform = 'translateX(-100px)';

    setTimeout(function() {
      card.remove();
      M.toast({html: 'Cita cancelada', classes: 'rounded red'});

      const citasRestantes = document.querySelectorAll('.cita-card');
      if (citasRestantes.length === 0) {
        document.getElementById('listaCitas').style.display = 'none';
        document.getElementById('sinCitas').style.display = 'block';
      }

      actualizarContadores();
    }, 300);
  }
}

function verDetalles(elemento) {
  const card = elemento.closest('.cita-card');
  const mascota = card.querySelector('h5').textContent.trim();
  const dueno = card.querySelector('.cita-info:nth-child(3) span').textContent;

  M.toast({
    html: `Detalles de ${mascota}<br><small>${dueno}</small>`,
    classes: 'rounded purple darken-2'
  });
}

function actualizarContadores() {
  const todasCitas = document.querySelectorAll('.cita-card');
  let pendientes = 0;
  let confirmadas = 0;
  let urgentes = 0;
  let completadas = 0;

  todasCitas.forEach(function(cita) {
    const badge = cita.querySelector('.estado-badge');
    const estado = badge.textContent.toLowerCase().trim();

    if (estado.includes('pendiente')) pendientes++;
    else if (estado.includes('confirmada')) confirmadas++;
    else if (estado.includes('urgente')) urgentes++;
    else if (estado.includes('completada')) completadas++;
  });

  document.getElementById('contadorPendientes').textContent = pendientes;
  document.getElementById('contadorConfirmadas').textContent = confirmadas;
  document.getElementById('contadorUrgentes').textContent = urgentes;
  document.getElementById('contadorCompletadas').textContent = completadas;
  console.log(`Pendientes: ${pendientes}, Confirmadas: ${confirmadas}, Urgentes: ${urgentes}, Completadas: ${completadas}`);
}

function marcarUrgente(elemento) {
  const card = elemento.closest('.cita-card');
  const badge = card.querySelector('.estado-badge');
  badge.textContent = 'URGENTE';
  badge.style.backgroundColor = '#e53935';
  M.toast({html: '⚠️ Cita marcada como urgente', classes: 'rounded red darken-2'});
  actualizarContadores();
}

function atenderAhora(elemento) {
  if (confirm('¿Comenzar a atender esta urgencia ahora?')) {
    const card = elemento.closest('.cita-card');
    const badge = card.querySelector('.estado-badge');
    badge.textContent = 'EN ATENCIÓN';
    badge.style.backgroundColor = '#ff9800';
    M.toast({html: '⚕️ Atendiendo urgencia...', classes: 'rounded orange darken-2'});
    actualizarContadores();
  }
}