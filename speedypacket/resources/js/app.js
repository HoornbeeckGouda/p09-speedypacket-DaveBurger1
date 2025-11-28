import './bootstrap';

import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet-routing-machine';
import 'leaflet-routing-machine/dist/leaflet-routing-machine.css';

// Fix for default markers in Leaflet
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon-2x.png',
    iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
});

// Geocoding function using Nominatim
async function geocodeAddress(address) {
    try {
        // Clean the address by removing newlines and extra spaces
        const cleanAddress = address.replace(/\n/g, ', ').replace(/\s+/g, ' ').trim();
        console.log('Geocoding address:', cleanAddress);
        const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(cleanAddress)}&limit=1&countrycodes=NL`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        console.log('Geocoding response for', cleanAddress, ':', data);
        if (data && data.length > 0) {
            return [parseFloat(data[0].lat), parseFloat(data[0].lon)];
        }
    } catch (error) {
        console.warn('Geocoding failed for address:', address, error);
    }
    // Fallback to dummy coordinates for demo
    console.log('Using fallback coords for', address);
    return [52.3676 + Math.random() * 0.1, 4.9041 + Math.random() * 0.1];
}

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
            console.log('Addresses to geocode:', addresses);
            // Geocode all addresses
            Promise.all(addresses.map(address => geocodeAddress(address))).then(coords => {
                console.log('Geocoded coords:', coords);
                const validCoords = coords.filter(coord => coord !== null);
                console.log('Valid coords:', validCoords);

                if (validCoords.length > 0) {
                    // Add markers
                    const markers = validCoords.map((coord, index) => {
                        const marker = L.marker(coord).addTo(map);
                        if (index === 0) {
                            marker.bindPopup(`<b>Start: ${addresses[index]}</b>`);
                        } else {
                            marker.bindPopup(`<b>${index}. ${addresses[index]}</b>`);
                        }
                        return marker;
                    });

                    // Fit map to show all markers
                    if (markers.length > 1) {
                        const group = new L.featureGroup(markers);
                        map.fitBounds(group.getBounds());
                    }

                    // Add routing if more than one point
                    if (validCoords.length > 1) {
                        L.Routing.control({
                            waypoints: validCoords.map(coord => L.latLng(coord[0], coord[1])),
                            routeWhileDragging: false,
                            createMarker: () => null, // Disable default markers, we have our own
                            lineOptions: {
                                styles: [{ color: 'blue', weight: 6 }]
                            }
                        }).addTo(map);
                    }
                } else {
                    console.warn('No valid coordinates found for addresses');
                }
            }).catch(error => {
                console.error('Geocoding error:', error);
            });
        } else {
            console.log('No addresses to display');
        }
    }
});
