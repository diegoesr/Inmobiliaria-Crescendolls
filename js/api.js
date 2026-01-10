// ============================================
// API Client para Inmobiliaria Crescendolls
// Maneja todas las peticiones al backend PHP
// ============================================

const API_BASE_URL = 'php/api.php';

/**
 * Función genérica para hacer peticiones al API
 */
async function fetchAPI(action, params = {}) {
    try {
        // Construir URL con parámetros
        const url = new URL(API_BASE_URL, window.location.origin);
        url.searchParams.append('action', action);
        
        // Agregar parámetros adicionales
        Object.keys(params).forEach(key => {
            url.searchParams.append(key, params[key]);
        });
        
        console.log('Haciendo petición a:', url.toString());
        
        const response = await fetch(url.toString(), {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        });
        
        console.log('Respuesta recibida:', {
            status: response.status,
            statusText: response.statusText,
            ok: response.ok
        });
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Error en respuesta:', errorText);
            throw new Error(`Error HTTP ${response.status}: ${response.statusText}`);
        }
        
        const data = await response.json();
        console.log('Datos parseados:', data);
        
        if (!data.success) {
            throw new Error(data.error || 'Error desconocido en la respuesta del API');
        }
        
        return data;
        
    } catch (error) {
        console.error('Error en fetchAPI:', error);
        console.error('URL intentada:', API_BASE_URL);
        console.error('Action:', action);
        console.error('Params:', params);
        throw error;
    }
}

/**
 * Obtener todas las propiedades disponibles
 */
async function obtenerPropiedades() {
    try {
        const response = await fetchAPI('propiedades');
        return response.data;
    } catch (error) {
        console.error('Error al obtener propiedades:', error);
        return [];
    }
}

/**
 * Obtener propiedades destacadas (limitadas)
 */
async function obtenerPropiedadesDestacadas(limit = 3) {
    try {
        console.log(`Obteniendo ${limit} propiedades destacadas...`);
        const response = await fetchAPI('propiedades-destacadas', { limit });
        console.log('Respuesta del API:', response);
        
        if (response && response.data) {
            console.log(`Se recibieron ${response.data.length} propiedades`);
            return response.data;
        } else {
            console.warn('La respuesta del API no contiene data:', response);
            return [];
        }
    } catch (error) {
        console.error('Error al obtener propiedades destacadas:', error);
        console.error('Detalles del error:', {
            message: error.message,
            stack: error.stack
        });
        return [];
    }
}

/**
 * Obtener una propiedad específica por ID
 */
async function obtenerPropiedad(id) {
    try {
        const response = await fetchAPI('propiedad', { id });
        return response.data;
    } catch (error) {
        console.error('Error al obtener propiedad:', error);
        return null;
    }
}

/**
 * Enviar formulario de contacto
 */
async function enviarContacto(formData) {
    try {
        const response = await fetch('php/procesar_contacto.php', {
            method: 'POST',
            body: formData
        });
        
        return response;
    } catch (error) {
        console.error('Error al enviar contacto:', error);
        throw error;
    }
}

/**
 * Enviar formulario de contacto general
 */
async function enviarFormularioContacto(formData) {
    try {
        const response = await fetch('php/procesar_formulario_contacto.php', {
            method: 'POST',
            body: formData
        });
        
        return response;
    } catch (error) {
        console.error('Error al enviar formulario de contacto:', error);
        throw error;
    }
}

// Exportar funciones para uso global
window.API = {
    obtenerPropiedades,
    obtenerPropiedadesDestacadas,
    obtenerPropiedad,
    enviarContacto,
    enviarFormularioContacto
};
