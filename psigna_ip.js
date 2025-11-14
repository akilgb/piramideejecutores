// IP Pública (ipify.org)
fetch('https://api64.ipify.org?format=json')
  .then(r => r.json())
  .then(data => {
    ipPublica = data.ip || '';
    document.getElementById('ipPublica').textContent = ipPublica;
  })
  .catch(() => {
    ipPublica = 'No disponible';
    document.getElementById('ipPublica').textContent = ipPublica;
  });

// IP Local (WebRTC)
function obtenerIPLocal(callback) {
  const pc = new RTCPeerConnection({ iceServers: [] });
  pc.createDataChannel('');
  pc.createOffer()
    .then(offer => pc.setLocalDescription(offer))
    .catch(() => {});

  pc.onicecandidate = (e) => {
    if (!e || !e.candidate) {
      pc.close();
      return;
    }
    const candidato = e.candidate.candidate;
    const regexIP = /([0-9]{1,3}\.){3}[0-9]{1,3}/;
    const match = regexIP.exec(candidato);
    if (match) {
      callback(match[0]);
    }
  };
}

if (window.RTCPeerConnection) {
  obtenerIPLocal(ip => {
    ipLocal = ip;
    document.getElementById('ipLocal').textContent = ip;
  });
} else {
  ipLocal = 'No soportado o bloqueado';
  document.getElementById('ipLocal').textContent = ipLocal;
}
