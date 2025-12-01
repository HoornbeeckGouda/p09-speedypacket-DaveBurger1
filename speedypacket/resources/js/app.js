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
window.addEventListener('DOMContentLoaded', function() {
    const mapElement = document.getElementById('map');
    console.log('Map script loaded on DOMContentLoaded. mapElement exists:', !!mapElement);
    if (!mapElement) return;

    // Samsung Android Chrome fix: Ensure map container has proper dimensions before initializing
    function ensureMapDimensions(el) {
        const rect = el.getBoundingClientRect();
        console.log('Map element dimensions:', rect.width, 'x', rect.height);

        // Force minimum dimensions for Samsung Android Chrome
        if (rect.height < 50 || rect.width < 50) {
            console.log('Map container too small, forcing dimensions');
            el.style.minHeight = '300px';
            el.style.minWidth = '100%';
            el.style.height = '400px';
            el.style.width = '100%';
            el.style.display = 'block';
        }

        // Additional Samsung fix: Force layout recalculation
        el.offsetHeight; // Trigger layout
    }

    ensureMapDimensions(mapElement);

    function showMapFallback(el, message = 'Kaart kan niet worden geladen op dit apparaat.', withButton = false) {
        console.log('showMapFallback called. withButton=', withButton);
        try {
            const wrapper = document.createElement('div');
            wrapper.className = 'map-fallback';
            wrapper.style.padding = '16px';
            wrapper.style.background = '#fff';
            wrapper.style.borderRadius = '8px';
            wrapper.style.boxShadow = '0 2px 8px rgba(0,0,0,0.05)';
            wrapper.style.color = 'var(--muted)';
            wrapper.innerHTML = `<p style="margin:0 0 8px;font-size:14px">${message}</p>`;

            if (withButton) {
                const btn = document.createElement('button');
                btn.textContent = 'Toon kaart';
                btn.style.padding = '8px 12px';
                btn.style.background = 'var(--accent)';
                btn.style.color = '#fff';
                btn.style.border = 'none';
                btn.style.borderRadius = '6px';
                btn.style.cursor = 'pointer';
                btn.addEventListener('click', function() {
                    // recreate the map element and initialize
                    const newMap = document.createElement('div');
                    newMap.id = 'map';
                    // preserve inline styles if any
                    newMap.style.height = mapElement.style.height || '400px';
                    newMap.style.width = mapElement.style.width || '100%';
                    newMap.style.borderRadius = mapElement.style.borderRadius || '';
                    // attach addresses data if available
                    if (mapElement.dataset && mapElement.dataset.addresses) {
                        newMap.dataset.addresses = mapElement.dataset.addresses;
                    }
                    wrapper.replaceWith(newMap);
                    initMap(newMap);
                });
                wrapper.appendChild(btn);
            }

            mapElement.replaceWith(wrapper);
        } catch (e) {
            console.error('Failed to render map fallback', e);
        }
    }

    async function initMap(el) {
        console.log('initMap called for element:', el && el.id);
        try {
            const map = L.map(el).setView([52.3676, 4.9041], 10);

            const tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Get addresses from data attribute (be robust to HTML-escaped attributes)
            let addresses = [];
            try {
                const raw = el.getAttribute('data-addresses');
                console.log('Raw data-addresses attribute:', raw && raw.substring(0, 200));
                if (raw) {
                    // Some Blade outputs may HTML-escape quotes - try to unescape common entities
                    let cleaned = raw.replace(/&quot;/g, '"').replace(/&amp;/g, '&');
                    // Trim any trailing/leading whitespace
                    cleaned = cleaned.trim();
                    addresses = JSON.parse(cleaned || '[]');
                }
            } catch (err) {
                console.warn('Failed to parse addresses from data-addresses, falling back to dataset or empty', err);
                try { addresses = JSON.parse(el.dataset && el.dataset.addresses ? el.dataset.addresses : '[]'); } catch(e) { addresses = []; }
            }
            console.log('Parsed addresses:', addresses);

            // Prepend fixed starting point
            const fixedStart = 'Overslagweg 2, Waddinxveen, Netherlands';
            addresses = [fixedStart, ...addresses];
            console.log('Parsed addresses with fixed start:', addresses);

            // If the map container has collapsed height on mobile, force a sensible minimum.
            try {
                const rect = el.getBoundingClientRect();
                if (rect.height < 50) {
                    console.log('Map container height is small ('+rect.height+'), applying min-height 300px');
                    el.style.height = '300px';
                }
            } catch(e) { /* ignore */ }

            if (addresses.length > 0) {
                console.log('Addresses to geocode:', addresses);
                // Geocode all addresses
                const coords = await Promise.all(addresses.map(address => geocodeAddress(address)));
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
                        try {
                            L.Routing.control({
                                waypoints: validCoords.map(coord => L.latLng(coord[0], coord[1])),
                                routeWhileDragging: false,
                                createMarker: () => null, // Disable default markers, we have our own
                                lineOptions: {
                                    styles: [{ color: 'blue', weight: 6 }]
                                },
                                showInstructions: true,
                                collapsible: true
                            }).addTo(map);
                            console.log('Routing added successfully');
                        } catch (e) {
                            console.warn('Routing failed to initialize', e);
                        }
                    }
                    
                    // Invalidate size after all content is loaded
                    setTimeout(() => { try { map.invalidateSize(); } catch(e){} }, 300);
                } else {
                    console.warn('No valid coordinates found for addresses');
                    showMapFallback(el, 'Geen locatiegegevens beschikbaar voor deze route.');
                }
            } else {
                console.log('No addresses to display');
                showMapFallback(el, 'Geen route-adressen om te tonen.');
            }
        } catch (e) {
            console.error('Map initialization failed', e);
            showMapFallback(el, 'Kaart kon niet worden geladen op dit apparaat.');
        }
    }

    // Always try to initialize the map, with fallback if it fails
    try {
        initMap(mapElement);
    } catch (e) {
        console.error('Map initialization failed, showing fallback', e);
        showMapFallback(mapElement, 'Kaart kon niet worden geladen op dit apparaat.', true);
    }
});
