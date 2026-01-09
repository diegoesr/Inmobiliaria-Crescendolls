# 📸 Capturas de Pantalla

Esta carpeta contiene las capturas de pantalla del proyecto para el README.md.

## 📋 Instrucciones para Agregar Capturas

### 1. Tomar las Capturas

Puedes usar:
- **Windows**: `Win + Shift + S` (herramienta de recorte)
- **Navegador**: Extensiones como "Awesome Screenshot" o "Nimbus Screenshot"
- **Herramientas online**: [Screenshot.guru](https://screenshot.guru/) para capturas completas de páginas

### 2. Nombres de Archivos Recomendados

```
screenshots/
├── homepage.png              # Página principal
├── propiedades.png           # Catálogo de propiedades
├── propiedad-detalle.png     # Detalle de una propiedad
├── contacto.png              # Página de contacto
├── dark-mode.png             # Modo oscuro
├── mobile-view.png           # Vista móvil
├── favoritos.png             # Panel de favoritos
└── reportes.png              # Panel de reportes (si aplica)
```

### 3. Optimizar las Imágenes

**Antes de subir a GitHub:**
- Comprime las imágenes para reducir el tamaño
- Usa herramientas como [TinyPNG](https://tinypng.com/) o [Squoosh](https://squoosh.app/)
- Tamaño recomendado: Máximo 1-2 MB por imagen
- Dimensiones: Máximo 1920px de ancho

### 4. Agregar al README.md

Usa esta sintaxis en el README:

```markdown
![Descripción de la imagen](screenshots/nombre-archivo.png)
```

**Ejemplo:**
```markdown
### Página Principal
![Página Principal](screenshots/homepage.png)
*Descripción opcional debajo de la imagen*
```

### 5. Opciones Avanzadas

**Con enlace a imagen más grande:**
```markdown
[![Página Principal](screenshots/homepage-thumb.png)](screenshots/homepage-full.png)
```

**Con tamaño personalizado (HTML):**
```html
<img src="screenshots/homepage.png" alt="Página Principal" width="800">
```

**En una tabla:**
```markdown
| Vista Desktop | Vista Móvil |
|---------------|--------------|
| ![Desktop](screenshots/desktop.png) | ![Mobile](screenshots/mobile.png) |
```

## 📝 Notas

- GitHub renderiza imágenes PNG, JPG, GIF y SVG
- Las imágenes se muestran automáticamente en el README
- Usa texto alternativo descriptivo para accesibilidad
- Considera crear versiones pequeñas (thumbnails) para mejor carga

