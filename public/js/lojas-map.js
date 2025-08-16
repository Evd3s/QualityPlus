// Updated lojas-map.js file
let map;
let currentPosition;
let dragging = false;
let startX = 0;
let startY = 0;
let translateX = 0;
let translateY = 0;
let storeMarkers = [
    { id: 1, name: "Americanas Express", rating: 4.2, image: '/images/americanas.png' },
    { id: 2, name: "Mix Mateus", rating: 4.5, image: '/images/mix-mateus.jpg' },
    { id: 3, name: "Atacadão", rating: 4.7, image: '/images/store-placeholder.png' },
    { id: 4, name: "Assaí", rating: 4.0, image: '/images/store-placeholder.png' },
    { id: 5, name: "Carrefour", rating: 4.3, image: '/images/store-placeholder.png' },
];

// Initialize the map
function initMap() {
    // Set up the map container
    const mapContainer = document.getElementById('map');
    
    // Create fake map
    const mapImg = document.createElement('img');
    mapImg.src = '/images/map-recife.jpg'; // The image you provided
    mapImg.id = 'map-image';
    mapImg.style.width = 'auto'; // Don't constrain width
    mapImg.style.height = 'auto'; // Don't constrain height
    mapImg.style.cursor = 'grab';
    mapImg.style.position = 'absolute';
    mapImg.style.transformOrigin = '0 0';
    mapImg.style.transform = 'translate(0px, 0px)';
    mapContainer.appendChild(mapImg);
    
    // Add drag functionality
    mapImg.addEventListener('mousedown', (e) => {
        if (e.button === 0) { // Left click
            dragging = true;
            startX = e.clientX;
            startY = e.clientY;
            mapImg.style.cursor = 'grabbing';
            e.preventDefault(); // Prevent default selection behavior
        }
    });
    
    window.addEventListener('mousemove', (e) => {
        if (!dragging) return;
        
        const dx = e.clientX - startX;
        const dy = e.clientY - startY;
        
        // Update the translation
        translateX += dx;
        translateY += dy;
        
        // Apply the new translation
        mapImg.style.transform = `translate(${translateX}px, ${translateY}px)`;
        
        // Update starting position for next move
        startX = e.clientX;
        startY = e.clientY;
        
        e.preventDefault();
    });
    
    window.addEventListener('mouseup', () => {
        if (dragging) {
            dragging = false;
            mapImg.style.cursor = 'grab';
        }
    });
    
    // Handle right-click to add user location
    mapContainer.addEventListener('contextmenu', (e) => {
        e.preventDefault();
        
        // Get click position relative to map container
        const rect = mapContainer.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        // Add user location marker
        addUserLocationMarker(x, y, mapContainer);
        
        // Show nearby stores
        showNearbyStores();
    });
    
    // Setup search input
    const searchInput = document.getElementById("search-input");
    searchInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            showNearbyStores();
        }
    });
}

// Add user location marker
function addUserLocationMarker(x, y, mapContainer) {
    // Remove existing user marker if any
    const existingMarker = document.querySelector('.user-marker');
    if (existingMarker) {
        existingMarker.remove();
    }
    
    const userMarker = document.createElement('img');
    userMarker.src = '/images/user-location.png';
    userMarker.className = 'user-marker';
    userMarker.style.position = 'absolute';
    userMarker.style.left = `${x}px`;
    userMarker.style.top = `${y}px`;
    userMarker.style.width = '32px';
    userMarker.style.height = '32px';
    userMarker.style.transform = 'translate(-50%, -50%)';
    userMarker.style.zIndex = '200';
    
    mapContainer.appendChild(userMarker);
    currentPosition = { x, y };
}

// Show nearby stores in the side panel
function showNearbyStores() {
    const storesList = document.getElementById("stores-list");
    storesList.innerHTML = '';
    
    storeMarkers.forEach(store => {
        createStoreCard(store);
    });
    
    // Make the nearby stores section visible
    document.querySelector('.nearby-stores').style.display = 'block';
}

// Create a store card
function createStoreCard(store) {
    const storesList = document.getElementById("stores-list");
    const card = document.createElement("div");
    card.className = "store-card";
    
    card.innerHTML = `
        <img src="${store.image}" alt="${store.name}" class="store-logo">
        <div class="store-rating">${store.rating.toFixed(1)} <span class="star">★</span></div>
        <div class="store-name">${store.name}</div>
    `;
    
    storesList.appendChild(card);
}

// Initialize the map when the page loads
document.addEventListener('DOMContentLoaded', initMap);