document.addEventListener('DOMContentLoaded', () => {
  // Verificar si el usuario est芍 autenticado usando check_session.php
  fetch('check_session.php')
    .then(res => res.json())
    .then(data => {
      if (!data.authenticated) {
        window.location.href = 'login.html';
      }
    })
    .catch(err => {
      console.error('Error verificando la sesi車n:', err);
      window.location.href = 'login.html';
    });

  // Actualizar conexi車n al iniciar dashboard
  actualizarConexion();

  // Aqu赤 podr赤as incluir otras funcionalidades espec赤ficas del dashboard
});

function actualizarConexion() {
  // Implementaci車n de la funci車n para actualizar la conexi車n
  console.log('Conexi車n actualizada.');
}
