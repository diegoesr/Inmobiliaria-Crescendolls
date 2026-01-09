# 🏠 Inmobiliaria Crescendolls

Sitio web inmobiliario moderno con sistema de propiedades, favoritos y modo oscuro.

![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat&logo=javascript&logoColor=black)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white)

## 📋 Descripción

Inmobiliaria Crescendolls es una aplicación web completa para la gestión y visualización de propiedades inmobiliarias. Incluye un diseño moderno, responsivo y con soporte para modo oscuro.

## ✨ Características

- 🏡 **Catálogo de Propiedades** - Visualización de propiedades con carrusel de imágenes
- ❤️ **Sistema de Favoritos** - Guarda tus propiedades favoritas (localStorage)
- 🌙 **Modo Oscuro** - Tema claro/oscuro persistente
- 📱 **Diseño Responsivo** - Adaptable a todos los dispositivos
- 📧 **Formulario de Contacto** - Solicitudes de información y contacto general
- 📊 **Panel de Reportes** - Gestión de solicitudes y mensajes

## 🚀 Instalación

### Requisitos
- Servidor web con PHP (XAMPP, WAMP, LAMP)
- MySQL/MariaDB
- Navegador web moderno

### Pasos

1. **Clona el repositorio**
   ```bash
   git clone https://github.com/tu-usuario/inmobiliaria-crescendolls.git
   ```

2. **Configura la base de datos**
   - Importa el archivo `database/inmobiliaria.sql` en phpMyAdmin
   - Configura las credenciales en `php/config.php`

3. **Configura el servidor**
   - Coloca los archivos en tu carpeta de servidor web
   - Accede desde `http://localhost/inmobiliaria-crescendolls`

## 📁 Estructura del Proyecto

```
inmobiliaria-crescendolls/
├── index.html              # Página principal
├── nosotros.html           # Página "Sobre Nosotros"
├── README.md               # Este archivo
├── .gitignore              # Archivos ignorados por Git
│
├── css/
│   └── style.css           # Estilos principales
│
├── js/
│   ├── app.js              # Funcionalidad común
│   ├── carousel.js         # Carrusel de imágenes
│   ├── dark-mode.js        # Toggle de tema
│   ├── favorites.js        # Sistema de favoritos
│   └── utils.js            # Utilidades (toast, AOS)
│
├── img/                    # Imágenes del sitio
│
├── php/
│   ├── config.php          # Configuración de BD
│   ├── contacto.php        # Página de contacto
│   ├── propiedades.php     # Listado de propiedades
│   ├── reportes.php        # Panel de reportes
│   └── procesar_*.php      # Procesadores de formularios
│
└── database/
    └── inmobiliaria.sql    # Script de base de datos
```

## 🛠️ Tecnologías

| Tecnología | Uso |
|------------|-----|
| HTML5 | Estructura |
| CSS3 | Estilos y animaciones |
| JavaScript | Interactividad |
| PHP | Backend y conexión BD |
| MySQL | Base de datos |
| AOS.js | Animaciones scroll |
| Font Awesome | Iconos |

## 📸 Capturas

### Modo Claro
![Modo Claro](img/preview-light.png)

### Modo Oscuro
![Modo Oscuro](img/preview-dark.png)

## 👥 Equipo

Desarrollado por el equipo de Inmobiliaria Crescendolls.

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.

---

⭐ Si te gusta este proyecto, ¡dale una estrella!

