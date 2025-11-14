const CACHE_NAME = 'psigna-cache-v1';
const urlsToCache = [
  '/psigna.html',
  '/psigna.css',
  '/psigna_main.js',
  // Y cualquier otro archivo base, más tus modelos locales:
  '/models/ssd_mobilenetv1/model.json',
  '/models/ssd_mobilenetv1/weights.bin',
  '/models/face_landmark_68/model.json',
  '/models/face_landmark_68/weights.bin',
  '/models/face_recognition/model.json',
  '/models/face_recognition/weights.bin',

  // COCO-SSD
  '/models/coco-ssd/mobilenet_v2/model.json',
  '/models/coco-ssd/mobilenet_v2/group1-shard1of1.bin'
];

// Evento install -> se descargan y cachean
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      return cache.addAll(urlsToCache);
    })
  );
});

// Evento fetch -> servir desde caché
self.addEventListener('fetch', (event) => {
  event.respondWith(
    caches.match(event.request).then(resp => {
      if (resp) {
        return resp; // usar caché
      }
      // Si no está en caché, pedimos a la red y guardamos en caché
      return fetch(event.request).then(netResp => {
        if(netResp && netResp.ok) {
          return caches.open(CACHE_NAME).then(cache => {
            cache.put(event.request, netResp.clone());
            return netResp;
          });
        }
        return netResp;
      });
    })
  );
});
