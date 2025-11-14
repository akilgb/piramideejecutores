/****************************************************
 * psigna_main.js (carga modelos 100% en línea)
 * by loading from GitHub y storage.googleapis.com
 ****************************************************/

// 1. Registrar Service Worker (opcional, si quieres caching)
async function registrarServiceWorker() {
  if ('serviceWorker' in navigator) {
    try {
      const registration = await navigator.serviceWorker.register('/service-worker.js');
      console.log('[psigna_main.js] SW registrado con alcance:', registration.scope);
    } catch(err) {
      console.error('[psigna_main.js] Error al registrar SW:', err);
    }
  } else {
    console.warn('[psigna_main.js] El navegador no soporta Service Workers.');
  }
}

// 2. Cargar modelos face-api completamente desde GitHub
async function cargarModelosFaceApi() {
  try {
    // Ejemplo con tag 0.22.2 (estable),
    // Cambia si deseas la rama master (pero podría romper en el futuro).
    const baseUrl = 'https://raw.githubusercontent.com/justadudewhohacks/face-api.js/0.22.2/weights';

    // 1) ssdMobilenetv1
    await faceapi.nets.ssdMobilenetv1.loadFromUri(baseUrl);

    // 2) faceRecognitionNet
    await faceapi.nets.faceRecognitionNet.loadFromUri(baseUrl);

    // 3) faceLandmark68Net
    await faceapi.nets.faceLandmark68Net.loadFromUri(baseUrl);

    console.log('[psigna_main.js] Modelos face-api cargados desde GitHub.');

  } catch(err) {
    console.error('[psigna_main.js] Error al cargar modelos face-api:', err);
    // Si falla, opcionalmente limpiamos la Cache Storage
    try {
      if ('caches' in window) {
        const keys = await caches.keys();
        for (const key of keys) {
          await caches.delete(key);
        }
        console.warn('[psigna_main.js] Caché limpiada; próxima recarga reintentará.');
      }
    } catch(e) {
      console.error('[psigna_main.js] Error intentando limpiar cache:', e);
    }
  }
}

/***************************************
 * Resto de la lógica original
 ***************************************/

// Variables globales
let nombrePersonal         = "Desconocido",
    ipPublica             = "",
    ipLocal               = "",
    dispositivoDetectado  = false,
    fraudeDetectado       = false,
    cambioDeRostro        = false,
    marcacionExitosa      = false;

const pantallaCarga       = document.getElementById("pantallaCarga"),
      videoWebcam         = document.getElementById("videoWebcam"),
      canvasDeteccion     = document.getElementById("canvasDeteccion"),
      btnIniciar          = document.getElementById("btnIniciar"),
      btnMarcarAsistencia = document.getElementById("btnMarcarAsistencia"),
      imagenCapturada     = document.getElementById("imagenCapturada"),
      imagenReferencia    = document.getElementById("imagenReferencia"),
      resultadoDeteccion  = document.getElementById("resultadoDeteccion"),
      estadoProcesamiento = document.getElementById("estadoProcesamiento"),
      porcentajeSimilitud = document.getElementById("porcentajeSimilitud"),
      contenedorImagenesRef= document.getElementById("contenedorImagenesRef"),
      mensajeFraude       = document.getElementById("mensajeFraude"),
      mensajeObservado    = document.getElementById("mensajeObservado"),
      estadoVerificacion  = document.getElementById("estadoVerificacion"),
      mensajeExito        = document.getElementById("mensajeExito");

const ctxDeteccion = canvasDeteccion.getContext("2d");

let webcamStream      = null,
    descriptoresRef   = [],
    modeloObjetos     = null,  // COCO-SSD
    deteccionActiva   = false,
    descriptorReconocido = null,
    verificando       = false,
    intervaloVerificacion = null,
    tiempoAcumulado   = 0,
    tiempoVerificacion= 25;

const dispositivosConPantalla = ["computer monitor","tv","laptop","cell phone"];
const urlListaImagenes = "https://www.piramideejecutores.com/recursos/personal/list_images.php",
      urlBase          = "https://www.piramideejecutores.com/recursos/personal/",
      endpointPHP      = "https://www.piramideejecutores.com/app3plus_endpoint.php";

// Evento onload principal
window.addEventListener("load", async () => {
  pantallaCarga.style.display = "flex";

  // Registrar SW (opcional)
  await registrarServiceWorker();

  // Cargar face-api en línea
  await cargarModelosFaceApi();

  // Cargar COCO-SSD en línea (sin especificar modelUrl => usará la default)
  // o si quieres un base distinto (mobilenet_v2, etc.) config. 
  try {
    modeloObjetos = await cocoSsd.load(); // = base: lite_mobilenet_v2
    // Notar que con cocoSsd.load() sin parámetros, coge un default 
    // (descargado de 'storage.googleapis.com') 
    // Para un base distinto => cocoSsd.load({ base: 'mobilenet_v2' });

    // Cargar imágenes referencia
    await cargarImagenesReferencia();
  } catch(err) {
    resultadoDeteccion.textContent =
      "Error al cargar COCO-SSD o imágenes de referencia: " + err;
  } finally {
    pantallaCarga.style.display = "none";
  }
});

// Cargar imágenes de referencia
async function cargarImagenesReferencia(){
  estadoProcesamiento.textContent = "Cargando imágenes de referencia...";
  contenedorImagenesRef.innerHTML = "";
  descriptoresRef = [];

  try {
    const resp = await fetch(urlListaImagenes);
    if(!resp.ok) throw new Error("No se pudo obtener la lista de imágenes.");
    const lista = await resp.json();

    const promesas = lista.map(async (imgName) => {
      const fullUrl = urlBase + imgName;
      const imageEl = new Image();
      imageEl.src   = fullUrl;
      imageEl.alt   = imgName;
      contenedorImagenesRef.appendChild(imageEl);

      await imageEl.decode();

      const detection = await faceapi
        .detectSingleFace(imageEl)
        .withFaceLandmarks()
        .withFaceDescriptor();

      if(detection && detection.descriptor){
        descriptoresRef.push({
          nombre:     imgName,
          descriptor: detection.descriptor
        });
      }
    });

    await Promise.all(promesas);
    estadoProcesamiento.textContent = "";

  } catch(error) {
    contenedorImagenesRef.innerHTML = `<div style="color:red;">Error al cargar imágenes: ${error.message}</div>`;
    estadoProcesamiento.textContent = "Error al cargar imágenes de referencia.";
  }
}

// Iniciar Reconocimiento (similar al tuyo original)
async function iniciarReconocimiento(){
  try {
    webcamStream = await navigator.mediaDevices.getUserMedia({ video: true });
    videoWebcam.srcObject = webcamStream;
    videoWebcam.onloadedmetadata = () => {
      videoWebcam.play();
      canvasDeteccion.width  = videoWebcam.videoWidth;
      canvasDeteccion.height = videoWebcam.videoHeight;
      videoWebcam.style.display = "block";
      canvasDeteccion.style.display = "block";
    };

    btnMarcarAsistencia.disabled = false;
    btnIniciar.disabled          = true;

    deteccionActiva      = true;
    fraudeDetectado      = false;
    cambioDeRostro       = false;
    verificando          = false;
    dispositivoDetectado = false;
    marcacionExitosa     = false;
    tiempoAcumulado      = 0;

    mensajeExito.style.display       = "none";
    mensajeFraude.style.display      = "none";
    mensajeObservado.style.display   = "none";
    estadoVerificacion.style.display = "none";

    detectarDispositivosPantalla();

  } catch(error) {
    resultadoDeteccion.textContent = "Error al acceder a la cámara: " + error;
  }
}

// Detección de dispositivos (COCO-SSD)
async function detectarDispositivosPantalla(){
  if(!deteccionActiva || !modeloObjetos) {
    requestAnimationFrame(detectarDispositivosPantalla);
    return;
  }
  if(fraudeDetectado || cambioDeRostro){
    requestAnimationFrame(detectarDispositivosPantalla);
    return;
  }

  ctxDeteccion.clearRect(0,0, canvasDeteccion.width, canvasDeteccion.height);
  ctxDeteccion.drawImage(videoWebcam, 0,0, canvasDeteccion.width, canvasDeteccion.height);

  const predictions = await modeloObjetos.detect(canvasDeteccion);
  for(const pred of predictions){
    if(pred.score > 0.5){
      const [x, y, w, h] = pred.bbox;
      ctxDeteccion.beginPath();
      ctxDeteccion.lineWidth   = 3;
      ctxDeteccion.strokeStyle = "red";
      ctxDeteccion.strokeRect(x, y, w, h);
      ctxDeteccion.fillStyle   = "red";

      const label = pred.class + " " + Math.round(pred.score*100) + "%";
      ctxDeteccion.fillText(label, x, (y>20 ? y-5 : 10));

      if(["computer monitor","tv","laptop","cell phone"]
          .includes(pred.class.toLowerCase())){
        manejarFraude("Detectado dispositivo electrónico.");
      }
    }
  }

  requestAnimationFrame(detectarDispositivosPantalla);
}

// Manejar fraude
function manejarFraude(mensaje = "Intento de fraude detectado."){
  fraudeDetectado = true;
  if(mensaje.toLowerCase().includes("dispositivo")){
    dispositivoDetectado = true;
  }
  mensajeFraude.textContent   = mensaje;
  mensajeFraude.style.display = "block";
  resultadoDeteccion.textContent = mensaje;
  estadoVerificacion.style.display= "none";
  mensajeExito.style.display      = "none";
  mensajeObservado.style.display  = "block";

  const tempCanvas = document.createElement("canvas");
  tempCanvas.width  = videoWebcam.videoWidth;
  tempCanvas.height = videoWebcam.videoHeight;
  tempCanvas.getContext("2d").drawImage(videoWebcam,0,0);

  const dataUrl = tempCanvas.toDataURL("image/png");
  imagenCapturada.src = dataUrl;
  imagenCapturada.style.display = "block";

  btnMarcarAsistencia.disabled = true;
  if(intervaloVerificacion){
    clearInterval(intervaloVerificacion);
    intervaloVerificacion = null;
  }
  enviarDatosAlServidor();
}

// Manejar cambio de rostro
function manejarObservado(msg = "La persona cambió. Marcación observada."){
  cambioDeRostro = true;
  mensajeObservado.textContent   = msg;
  mensajeObservado.style.display = "block";
  resultadoDeteccion.textContent = msg;
  estadoVerificacion.style.display= "none";
  mensajeExito.style.display      = "none";

  const tempCanvas = document.createElement("canvas");
  tempCanvas.width  = videoWebcam.videoWidth;
  tempCanvas.height = videoWebcam.videoHeight;
  tempCanvas.getContext("2d").drawImage(videoWebcam,0,0);

  const dataUrl = tempCanvas.toDataURL("image/png");
  imagenCapturada.src = dataUrl;
  imagenCapturada.style.display = "block";

  btnMarcarAsistencia.disabled = true;
  if(intervaloVerificacion){
    clearInterval(intervaloVerificacion);
    intervaloVerificacion = null;
  }
  enviarDatosAlServidor();
}

// Botón "Marcar Asistencia"
async function marcarAsistencia(){
  if(fraudeDetectado || cambioDeRostro){
    resultadoDeteccion.textContent = "No se puede marcar asistencia. Hubo anomalía.";
    return;
  }
  if(!videoWebcam.srcObject){
    resultadoDeteccion.textContent = "Primero inicie la cámara.";
    return;
  }
  if(descriptoresRef.length === 0){
    resultadoDeteccion.textContent = "Espere a que carguen las imágenes de referencia.";
    return;
  }

  const tempCanvas = document.createElement("canvas");
  tempCanvas.width  = videoWebcam.videoWidth;
  tempCanvas.height = videoWebcam.videoHeight;
  tempCanvas.getContext('2d').drawImage(videoWebcam,0,0);

  const dataUrl = tempCanvas.toDataURL("image/png");
  imagenCapturada.src = dataUrl;
  imagenCapturada.style.display = "block";

  try {
    const detection = await faceapi
      .detectSingleFace(tempCanvas)
      .withFaceLandmarks()
      .withFaceDescriptor();

    if(!detection){
      resultadoDeteccion.textContent = "No se detectó ningún rostro.";
      porcentajeSimilitud.textContent= "";
      return;
    }

    let bestMatch    = null;
    let bestDistance = 1.0;
    for(const ref of descriptoresRef){
      const dist = faceapi.euclideanDistance(ref.descriptor, detection.descriptor);
      if(dist < bestDistance){
        bestDistance = dist;
        bestMatch    = ref;
      }
    }

    const similitud = ((1 - bestDistance)*100).toFixed(2);
    porcentajeSimilitud.textContent = "Similitud: " + similitud + "%";

    if(bestMatch && bestDistance < 0.4){
      imagenReferencia.src           = urlBase + bestMatch.nombre;
      imagenReferencia.style.display = "block";
      resultadoDeteccion.textContent = "¡Rostro reconocido! - " + bestMatch.nombre;

      nombrePersonal       = bestMatch.nombre;
      descriptorReconocido = bestMatch.descriptor;

      iniciarVerificacion();

    } else {
      resultadoDeteccion.textContent = "Rostro no reconocido.";
      nombrePersonal = "Desconocido";
      imagenReferencia.style.display = "none";
    }

    estadoProcesamiento.textContent = "Comparación finalizada.";

  } catch(err) {
    resultadoDeteccion.textContent = "Error en la comparación: " + err;
  }
}

// Verificación 25s
function iniciarVerificacion(){
  verificando     = true;
  tiempoAcumulado = 0;
  estadoVerificacion.style.display = "block";
  mensajeExito.style.display       = "none";

  intervaloVerificacion = setInterval(async()=>{
    if(fraudeDetectado || cambioDeRostro){
      clearInterval(intervaloVerificacion);
      intervaloVerificacion = null;
      return;
    }

    const tempCanvas = document.createElement('canvas');
    tempCanvas.width  = videoWebcam.videoWidth;
    tempCanvas.height = videoWebcam.videoHeight;
    tempCanvas.getContext('2d').drawImage(videoWebcam,0,0);

    try {
      const currentDetection = await faceapi
        .detectSingleFace(tempCanvas)
        .withFaceLandmarks()
        .withFaceDescriptor();

      if(!currentDetection){
        estadoVerificacion.textContent =
          "No se detecta rostro (tiempo acumulado: " + tiempoAcumulado + "s).";
        return;
      }

      const dist = faceapi.euclideanDistance(descriptorReconocido, currentDetection.descriptor);
      if(dist > 0.7){
        manejarObservado("La persona cambió. Marcación observada.");
        return;
      }

      tiempoAcumulado++;
      estadoVerificacion.textContent =
        `Verificación en curso: ${tiempoAcumulado} de ${tiempoVerificacion} seg`;

      if(tiempoAcumulado >= tiempoVerificacion){
        clearInterval(intervaloVerificacion);
        intervaloVerificacion = null;
        estadoVerificacion.style.display = "none";
        mensajeExito.style.display = "block";

        verificando      = false;
        marcacionExitosa = true;
        btnMarcarAsistencia.disabled = true;

        enviarDatosAlServidor();
      }

    } catch(err){
      manejarObservado("Error al verificar el rostro. Marcación observada.");
    }
  }, 1000);
}

// Enviar datos al servidor
async function enviarDatosAlServidor(){
  try {
    const payload = {
      nombrePersonal,
      ipPublica,
      ipLocal,
      fotoEvidencia: imagenCapturada.src,
      dispositivoDetectado,
      fraudeDetectado,
      cambioDeRostro,
      marcacionExitosa
    };

    const resp = await fetch(endpointPHP, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(payload)
    });
    const data = await resp.json();
    if(data.ok){
      console.log("[psigna_main.js] Datos guardados correctamente en la BD.");
    } else {
      console.log("[psigna_main.js] Error al guardar datos:", data.error);
    }
  } catch(error){
    console.log("[psigna_main.js] Error en la petición fetch:", error);
  }
}

// Listeners
btnIniciar.addEventListener("click", iniciarReconocimiento);
btnMarcarAsistencia.addEventListener("click", marcarAsistencia);
