// scripts.js

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar AOS
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            once: true
        });
    }

    // Desplazamiento suave para enlaces internos
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    smoothScrollLinks.forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Cambio de fondo del navbar al hacer scroll
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('bg-white');
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 1)';
            } else {
                navbar.classList.remove('bg-white');
                navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.9)';
            }
        });
    }

    // Visibilidad del botón de WhatsApp
    const whatsappBtn = document.querySelector('.whatsapp-btn');
    if (whatsappBtn) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                whatsappBtn.style.display = 'flex';
            } else {
                whatsappBtn.style.display = 'none';
            }
        });
    }

    // Envío del formulario de contacto
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('¡Gracias por tu mensaje! Te contactaremos pronto.');
            contactForm.reset();
        });
    }

    // Envío de formularios adicionales en Contacto.html
    const allForms = document.querySelectorAll('form');
    allForms.forEach(form => {
        if (form.id !== 'contactForm') { // Excluir el formulario principal
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formType = this.getAttribute('data-form-type') || 'mensaje';
                let message = `¡Gracias por tu ${formType}! Procesaremos tu solicitud lo antes posible.`;
                alert(message);
                this.reset();
            });
        }
    });

    // Inicializar el mapa de Leaflet si está presente
    const mapElement = document.getElementById('map');
    if (typeof L !== 'undefined' && mapElement) {
        var map = L.map('map').setView([-12.0752, -77.0643], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.marker([-12.0752, -77.0643]).addTo(map)
            .bindPopup('Pirámide Ejecutores E.I.R.L.<br>Av. Antonio Jose de Sucre 195, Pueblo Libre.')
            .openPopup();
    }
});
