// src/assets/js/services.js
const API_URL = 'http://your-api-url-here';

// Ejemplo de función para obtener recetas
async function fetchPrescriptions() {
    const response = await fetch(`${API_URL}/prescriptions`);
    const prescriptions = await response.json();
    return prescriptions;
}

// Ejemplo de función para agregar una receta
async function addPrescription(prescription) {
    const response = await fetch(`${API_URL}/prescriptions`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(prescription)
    });
    return await response.json();
}

// Ejemplo de función para obtener inventario
async function fetchInventory() {
    const response = await fetch(`${API_URL}/inventory`);
    const inventory = await response.json();
    return inventory;
}

// Ejemplo de función para agregar inventario
async function addInventory(inventory) {
    const response = await fetch(`${API_URL}/inventory`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(inventory)
    });
    return await response.json();
}
