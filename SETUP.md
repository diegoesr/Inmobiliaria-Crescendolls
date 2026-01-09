# 🚀 Guía de Configuración para Producción

Esta guía te ayudará a configurar el proyecto correctamente antes de subirlo a GitHub o a un servidor de hosting.

## ⚠️ IMPORTANTE: Antes de Subir a GitHub

### 1. Verificar Archivos Sensibles

Asegúrate de que estos archivos **NO** estén siendo rastreados por Git:

```bash
# Verificar si config.php está siendo rastreado
git ls-files | grep config.php

# Si aparece, eliminarlo del índice (NO del disco)
git rm --cached php/config.php
```

### 2. Archivos que NO deben subirse a GitHub

- ✅ `php/config.php` - Contiene credenciales reales
- ✅ `password_bd.txt` - Contiene contraseñas
- ✅ `*.sql` (excepto `database/inmobiliaria.sql`) - Respaldos locales
- ✅ Archivos temporales y de respaldo

Todos estos están configurados en `.gitignore`.

## 📋 Pasos para Configuración en Producción

### Paso 1: Configurar Base de Datos

1. **Crear la base de datos en tu servidor:**
   ```sql
   CREATE DATABASE inmobiliaria_db;
   ```

2. **Importar el esquema:**
   - Accede a phpMyAdmin o tu cliente MySQL
   - Importa el archivo `database/inmobiliaria.sql`

### Paso 2: Configurar Credenciales

1. **Copiar el archivo de ejemplo:**
   ```bash
   cp php/config.example.php php/config.php
   ```

2. **Editar `php/config.php` con tus credenciales de producción:**
   ```php
   define('DB_HOST', 'localhost');           // Tu servidor de BD
   define('DB_USER', 'tu_usuario_produccion');
   define('DB_PASS', 'tu_contraseña_segura');
   define('DB_NAME', 'inmobiliaria_db');
   ```

### Paso 3: Configurar Permisos (Linux/Unix)

```bash
# Dar permisos de lectura al archivo de configuración
chmod 644 php/config.php

# Asegurar que los directorios sean accesibles
chmod 755 php/
chmod 755 js/
chmod 755 css/
chmod 755 img/
```

### Paso 4: Configurar .htaccess (Opcional pero Recomendado)

Crea un archivo `.htaccess` en la raíz del proyecto para mejorar la seguridad:

```apache
# Proteger archivos sensibles
<Files "config.php">
    Order Allow,Deny
    Deny from all
</Files>

# Prevenir listado de directorios
Options -Indexes

# Proteger archivos de configuración
<FilesMatch "\.(env|log|sql|bak)$">
    Order Allow,Deny
    Deny from all
</FilesMatch>
```

## 🌐 Configuración para Hosting con Dominio

### Estructura de URLs

Una vez subido a tu hosting, las rutas serán:

- **Página principal:** `https://tudominio.com/` o `https://tudominio.com/index.html`
- **Propiedades:** `https://tudominio.com/php/propiedades.php`
- **Contacto:** `https://tudominio.com/php/contacto.php`
- **Nosotros:** `https://tudominio.com/nosotros.html`

### Requisitos del Servidor

- ✅ PHP 7.4 o superior
- ✅ MySQL 5.7+ o MariaDB 10.3+
- ✅ Extensiones PHP: `mysqli`, `mbstring`
- ✅ Servidor web: Apache o Nginx

### Variables de Entorno (Alternativa Recomendada)

Para mayor seguridad, considera usar variables de entorno en lugar de `config.php`:

1. Crea un archivo `.env` (asegúrate de que esté en `.gitignore`):
   ```
   DB_HOST=localhost
   DB_USER=tu_usuario
   DB_PASS=tu_contraseña
   DB_NAME=inmobiliaria_db
   ```

2. Usa una librería como `vlucas/phpdotenv` para cargar las variables.

## ✅ Checklist Pre-Deploy

Antes de subir a producción, verifica:

- [ ] `php/config.php` no está en el repositorio Git
- [ ] `password_bd.txt` fue eliminado
- [ ] Archivos SQL duplicados fueron eliminados
- [ ] `.gitignore` está configurado correctamente
- [ ] Las credenciales en `config.php` son las de producción
- [ ] La base de datos está creada e importada
- [ ] Los permisos de archivos están configurados
- [ ] El sitio funciona correctamente en local

## 🔒 Seguridad Adicional

1. **Cambiar contraseñas por defecto** en producción
2. **Usar HTTPS** (SSL/TLS) en producción
3. **Validar y sanitizar** todas las entradas de usuario (ya implementado)
4. **Hacer respaldos regulares** de la base de datos
5. **Mantener PHP actualizado** con las últimas versiones de seguridad

## 📞 Soporte

Si tienes problemas durante la configuración, revisa:
- Los logs de PHP (`error_log`)
- Los logs del servidor web
- La configuración de la base de datos

---

**Nota:** Este archivo puede ser eliminado después de la configuración inicial si lo deseas, pero es recomendable mantenerlo para referencia futura.

