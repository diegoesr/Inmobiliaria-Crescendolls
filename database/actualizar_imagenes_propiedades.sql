-- =============================================
-- Script para actualizar imágenes de propiedades
-- Coincide con las imágenes usadas en index.html
-- =============================================

-- Actualizar imágenes de las propiedades destacadas para que coincidan con index.html
UPDATE propiedades 
SET imagen = 'img/propiedades/propiedad1.webp' 
WHERE nombre = 'Casa Moderna' AND id = 1;

UPDATE propiedades 
SET imagen = 'img/propiedades/propiedad2.webp' 
WHERE nombre = 'Departamento Centro' AND id = 2;

UPDATE propiedades 
SET imagen = 'img/propiedades/propiedad3.webp' 
WHERE nombre = 'Casa de Lujo' AND id = 3;

-- Actualizar imágenes de otras propiedades
UPDATE propiedades 
SET imagen = 'img/propiedades/propiedad4.webp' 
WHERE nombre = 'Departamento Familiar' AND id = 4;

UPDATE propiedades 
SET imagen = 'img/propiedades/propiedad5.webp' 
WHERE nombre = 'Casa Colonial' AND id = 5;

UPDATE propiedades 
SET imagen = 'img/propiedades/propiedad6.webp' 
WHERE nombre = 'Penthouse Ejecutivo' AND id = 6;

-- Verificar los cambios
SELECT id, nombre, imagen FROM propiedades ORDER BY id;

