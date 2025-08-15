class LojasMap {
    constructor() {
        this.map = null;
        this.currentMarker = null;
        this.establishmentMarkers = [];
        this.init();
    }
    
    init() {
        // Inicializar mapa centrado em Recife, PE (próximo à sua localização)
        this.map = L.map('map').setView([-8.0476, -34.8770], 13);
        
        // Adicionar camada do OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(this.map);
        
        // Event listener para cliques no mapa
        this.map.on('click', (e) => {
            this.handleMapClick(e.latlng.lat, e.latlng.lng);
        });
        
        // Tentar obter localização do usuário
        this.getCurrentLocation();
        
        // Configurar event listeners para filtros
        this.setupFilters();
        
        // Configurar busca
        this.setupSearch();
        
        // Mostrar mensagem inicial
        this.showNoResults();
    }
    
    getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    // Centralizar mapa na localização do usuário
                    this.map.setView([lat, lng], 15);
                    
                    // Adicionar marcador da localização atual
                    const userIcon = L.divIcon({
                        html: '<i class="fas fa-map-marker-alt" style="color: #00BFA5; font-size: 24px;"></i>',
                        className: 'custom-div-icon',
                        iconSize: [24, 24],
                        iconAnchor: [12, 24]
                    });
                    
                    L.marker([lat, lng], { icon: userIcon })
                        .addTo(this.map)
                        .bindPopup('Sua localização atual')
                        .openPopup();
                },
                (error) => {
                    console.log('Erro ao obter localização:', error);
                    // Manter localização padrão (Recife)
                }
            );
        }
    }
    
    handleMapClick(lat, lng) {
        // Remover marcador anterior
        if (this.currentMarker) {
            this.map.removeLayer(this.currentMarker);
        }
        
        // Adicionar novo marcador de busca
        const searchIcon = L.divIcon({
            html: '<i class="fas fa-search" style="color: #FF6B35; font-size: 20px;"></i>',
            className: 'custom-div-icon',
            iconSize: [20, 20],
            iconAnchor: [10, 20]
        });
        
        this.currentMarker = L.marker([lat, lng], { icon: searchIcon })
            .addTo(this.map)
            .bindPopup('Buscando estabelecimentos próximos...')
            .openPopup();
        
        // Buscar estabelecimentos
        this.searchNearbyEstablishments(lat, lng);
        
        // Mostrar painel lateral
        document.querySelector('.nearby-stores').style.display = 'block';
    }
    
    async searchNearbyEstablishments(lat, lng) {
        const loading = document.getElementById('loading');
        const storesList = document.getElementById('stores-list');
        const noResults = document.getElementById('no-results');
        
        // Mostrar loading
        loading.style.display = 'block';
        storesList.innerHTML = '';
        noResults.style.display = 'none';
        
        // Limpar marcadores anteriores
        this.clearEstablishmentMarkers();
        
        try {
            const radius = document.getElementById('radius').value;
            const query = this.buildOverpassQuery(lat, lng, radius);
            
            const response = await fetch('https://overpass-api.de/api/interpreter', {
                method: 'POST',
                headers: {
                    'Content-Type': 'text/plain'
                },
                body: query
            });
            
            if (!response.ok) {
                throw new Error('Erro na consulta à API');
            }
            
            const data = await response.json();
            
            // Processar resultados
            this.processResults(data.elements, lat, lng);
            
        } catch (error) {
            console.error('Erro na busca:', error);
            storesList.innerHTML = '<p style="color: #FF6B35; text-align: center;">Erro ao buscar estabelecimentos. Tente novamente.</p>';
        }
        
        loading.style.display = 'none';
    }
    
    buildOverpassQuery(lat, lng, radius) {
        const restaurants = document.getElementById('restaurants').checked;
        const shops = document.getElementById('shops').checked;
        const tourism = document.getElementById('tourism').checked;
        
        let queries = [];
        
        if (restaurants) {
            queries.push(`node["amenity"~"restaurant|fast_food|cafe|bar|pub"](around:${radius},${lat},${lng});`);
        }
        
        if (shops) {
            queries.push(`node["shop"~"supermarket|convenience|mall|department_store|clothes|electronics"](around:${radius},${lat},${lng});`);
        }
        
        if (tourism) {
            queries.push(`node["tourism"~"hotel|attraction|museum"](around:${radius},${lat},${lng});`);
        }
        
        return `
            [out:json][timeout:25];
            (
                ${queries.join('\n')}
            );
            out center meta;
        `;
    }
    
    processResults(elements, centerLat, centerLng) {
        const storesList = document.getElementById('stores-list');
        const noResults = document.getElementById('no-results');
        
        if (elements.length === 0) {
            noResults.style.display = 'block';
            this.currentMarker.bindPopup('Nenhum estabelecimento encontrado próximo');
            return;
        }
        
        // Filtrar e processar estabelecimentos
        const establishments = elements
            .filter(el => el.tags && el.tags.name)
            .map(el => {
                const distance = this.calculateDistance(centerLat, centerLng, el.lat, el.lon);
                return { ...el, distance };
            })
            .sort((a, b) => a.distance - b.distance)
            .slice(0, 20); // Limitar a 20 resultados
        
        // Mostrar resultados
        this.displayResults(establishments);
        
        // Adicionar marcadores no mapa
        this.addEstablishmentMarkers(establishments);
        
        // Atualizar popup do marcador central
        this.currentMarker.bindPopup(`Encontrados ${establishments.length} estabelecimentos próximos`);
    }
    
    displayResults(establishments) {
        const storesList = document.getElementById('stores-list');
        let html = '';
        
        establishments.forEach(est => {
            const type = this.getEstablishmentType(est.tags);
            const icon = this.getEstablishmentIcon(est.tags);
            
            html += `
                <div class="store-card" onclick="lojasMap.focusOnEstablishment(${est.lat}, ${est.lon})">
                    <div class="store-icon">${icon}</div>
                    <div class="store-name">${est.tags.name}</div>
                    <div class="store-type">${type}</div>
                    <div class="store-distance">${est.distance}m de distância</div>
                </div>
            `;
        });
        
        storesList.innerHTML = html;
    }
    
    addEstablishmentMarkers(establishments) {
        establishments.forEach(est => {
            const icon = this.getEstablishmentIcon(est.tags);
            const type = this.getEstablishmentType(est.tags);
            
            const markerIcon = L.divIcon({
                html: `<div style="background: white; border-radius: 50%; padding: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.3);">${icon}</div>`,
                className: 'custom-establishment-marker',
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });
            
            const marker = L.marker([est.lat, est.lon], { icon: markerIcon })
                .addTo(this.map)
                .bindPopup(`
                    <div style="text-align: center; min-width: 150px;">
                        <div style="font-size: 20px; margin-bottom: 5px;">${icon}</div>
                        <strong>${est.tags.name}</strong><br>
                        <em>${type}</em><br>
                        <small style="color: #00BFA5;">Distância: ${est.distance}m</small>
                    </div>
                `);
            
            this.establishmentMarkers.push(marker);
        });
    }
    
    getEstablishmentType(tags) {
        if (tags.amenity) {
            const types = {
                restaurant: 'Restaurante',
                fast_food: 'Fast Food',
                cafe: 'Café',
                bar: 'Bar',
                pub: 'Pub'
            };
            return types[tags.amenity] || 'Alimentação';
        }
        
        if (tags.shop) {
            const types = {
                supermarket: 'Supermercado',
                convenience: 'Conveniência',
                mall: 'Shopping',
                department_store: 'Loja de Departamento',
                clothes: 'Roupas',
                electronics: 'Eletrônicos'
            };
            return types[tags.shop] || 'Loja';
        }
        
        if (tags.tourism) {
            const types = {
                hotel: 'Hotel',
                attraction: 'Atração',
                museum: 'Museu'
            };
            return types[tags.tourism] || 'Turismo';
        }
        
        return 'Estabelecimento';
    }
    
    getEstablishmentIcon(tags) {
        if (tags.amenity && ['restaurant', 'fast_food', 'cafe'].includes(tags.amenity)) return '🍽️';
        if (tags.amenity && ['bar', 'pub'].includes(tags.amenity)) return '🍺';
        if (tags.shop === 'supermarket') return '🏪';
        if (tags.shop === 'mall') return '🏬';
        if (tags.shop === 'clothes') return '👕';
        if (tags.shop === 'electronics') return '📱';
        if (tags.shop) return '🛍️';
        if (tags.tourism === 'hotel') return '🏨';
        if (tags.tourism === 'museum') return '🏛️';
        if (tags.tourism) return '🎯';
        return '📍';
    }
    
    calculateDistance(lat1, lng1, lat2, lng2) {
        const R = 6371e3;
        const φ1 = lat1 * Math.PI/180;
        const φ2 = lat2 * Math.PI/180;
        const Δφ = (lat2-lat1) * Math.PI/180;
        const Δλ = (lng2-lng1) * Math.PI/180;
        
        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                  Math.cos(φ1) * Math.cos(φ2) *
                  Math.sin(Δλ/2) * Math.sin(Δλ/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        
        return Math.round(R * c);
    }
    
    clearEstablishmentMarkers() {
        this.establishmentMarkers.forEach(marker => {
            this.map.removeLayer(marker);
        });
        this.establishmentMarkers = [];
    }
    
    focusOnEstablishment(lat, lng) {
        this.map.setView([lat, lng], 17);
        
        // Encontrar e abrir popup do marcador
        this.establishmentMarkers.forEach(marker => {
            const markerPos = marker.getLatLng();
            if (Math.abs(markerPos.lat - lat) < 0.0001 && Math.abs(markerPos.lng - lng) < 0.0001) {
                marker.openPopup();
            }
        });
    }
    
    setupFilters() {
        const radius = document.getElementById('radius');
        const checkboxes = ['restaurants', 'shops', 'tourism'];
        
        radius.addEventListener('change', () => {
            if (this.currentMarker) {
                const latlng = this.currentMarker.getLatLng();
                this.searchNearbyEstablishments(latlng.lat, latlng.lng);
            }
        });
        
        checkboxes.forEach(id => {
            document.getElementById(id).addEventListener('change', () => {
                if (this.currentMarker) {
                    const latlng = this.currentMarker.getLatLng();
                    this.searchNearbyEstablishments(latlng.lat, latlng.lng);
                }
            });
        });
    }
    
    setupSearch() {
        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.performSearch(searchInput.value);
            }
        });
    }
    
    async performSearch(query) {
        if (!query.trim()) return;
        
        try {
            // Busca simples por nome usando Nominatim (OpenStreetMap)
            const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1&bounded=1&viewbox=-35.0,-7.8,-34.7,-8.2`);
            const results = await response.json();
            
            if (results.length > 0) {
                const result = results[0];
                const lat = parseFloat(result.lat);
                const lng = parseFloat(result.lon);
                
                this.map.setView([lat, lng], 16);
                this.handleMapClick(lat, lng);
            } else {
                alert('Local não encontrado. Tente buscar por um nome mais específico.');
            }
        } catch (error) {
            console.error('Erro na busca:', error);
            alert('Erro ao realizar busca. Tente novamente.');
        }
    }
    
    showNoResults() {
        document.getElementById('no-results').style.display = 'block';
    }
}

// Inicializar quando a página carregar
let lojasMap;
document.addEventListener('DOMContentLoaded', function() {
    lojasMap = new LojasMap();
});