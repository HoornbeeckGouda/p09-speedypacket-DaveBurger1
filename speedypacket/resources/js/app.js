import './bootstrap';

import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

// Fix for default markers in Leaflet
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
    iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
});

// Initialize map if element exists
document.addEventListener('DOMContentLoaded', function() {
    const mapElement = document.getElementById('map');
    if (mapElement) {
        const map = L.map('map').setView([52.3676, 4.9041], 10); // Default to Amsterdam

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Get addresses from data attribute
        const addresses = JSON.parse(mapElement.dataset.addresses || '[]');

        if (addresses.length > 0) {
            const markers = [];
            addresses.forEach((address, index) => {
                // For simplicity, use a geocoding service or assume coordinates
                // In a real app, you'd geocode the addresses
                // Here, I'll use dummy coordinates for demonstration
                const lat = 52.3676 + (index * 0.01);
                const lng = 4.9041 + (index * 0.01);

                const marker = L.marker([lat, lng]).addTo(map);
                marker.bindPopup(`<b>${index + 1}. ${address}</b>`);
                markers.push(marker);
            });

            // Fit map to show all markers
            if (markers.length > 1) {
                const group = new L.featureGroup(markers);
                map.fitBounds(group.getBounds());
            }
        }
    }
});
