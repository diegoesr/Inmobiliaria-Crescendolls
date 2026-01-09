# Guía para Subir el Proyecto a GitHub

## 📋 Pasos para Subir el Proyecto

### 1. Verificar que los archivos sensibles estén protegidos

✅ **IMPORTANTE**: El archivo `.gitignore` ya está configurado para excluir:
- `php/config.php` (contiene credenciales de base de datos)
- Archivos de contraseñas
- Archivos temporales y del sistema

### 2. Inicializar Git en el proyecto

Abre PowerShell o Git Bash en la carpeta del proyecto y ejecuta:

```bash
# Inicializar repositorio Git
git init

# Configurar tu nombre y email (si no lo has hecho antes)
git config user.name "Tu Nombre"
git config user.email "tu.email@ejemplo.com"
```

### 3. Agregar archivos al staging

```bash
# Ver qué archivos se van a agregar
git status

# Agregar todos los archivos (excepto los del .gitignore)
git add .

# Verificar que config.php NO esté incluido
git status
```

**⚠️ VERIFICACIÓN CRÍTICA**: Asegúrate de que `php/config.php` NO aparezca en la lista de archivos agregados.

### 4. Crear el primer commit

```bash
git commit -m "Initial commit: Proyecto Inmobiliaria Crescendolls"
```

### 5. Crear el repositorio en GitHub

1. Ve a [GitHub.com](https://github.com) e inicia sesión
2. Haz clic en el botón **"+"** en la esquina superior derecha
3. Selecciona **"New repository"**
4. Completa los datos:
   - **Repository name**: `inmobiliaria-crescendolls`
   - **Description**: "Sitio web de inmobiliaria con catálogo de propiedades"
   - **Visibility**: Elige **Public** o **Private**
   - **NO marques** "Initialize this repository with a README" (ya tienes uno)
5. Haz clic en **"Create repository"**

### 6. Conectar el repositorio local con GitHub

GitHub te mostrará comandos. Usa estos (reemplaza `TU_USUARIO` con tu usuario de GitHub):

```bash
# Agregar el repositorio remoto
git remote add origin https://github.com/TU_USUARIO/inmobiliaria-crescendolls.git

# Verificar que se agregó correctamente
git remote -v
```

### 7. Subir el código a GitHub

```bash
# Cambiar a la rama main (si es necesario)
git branch -M main

# Subir el código
git push -u origin main
```

Si te pide credenciales:
- **Usuario**: Tu usuario de GitHub
- **Contraseña**: Usa un **Personal Access Token** (no tu contraseña de GitHub)
  - Cómo crear un token: [GitHub Docs - Personal Access Tokens](https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/creating-a-personal-access-token)

## 🔒 Seguridad - Archivos Sensibles

### Verificar que config.php NO se suba

```bash
# Verificar que config.php está en .gitignore
git check-ignore php/config.php

# Si NO aparece nada, significa que NO está siendo ignorado
# En ese caso, agrégalo manualmente:
echo "php/config.php" >> .gitignore
git add .gitignore
git commit -m "Asegurar que config.php esté en .gitignore"
```

### Si accidentalmente subiste config.php

```bash
# Eliminar del historial de Git (CUIDADO: esto reescribe el historial)
git rm --cached php/config.php
git commit -m "Remove config.php from repository"
git push --force
```

**⚠️ IMPORTANTE**: Si ya subiste `config.php` públicamente:
1. Considera cambiar las credenciales de la base de datos
2. Elimina el archivo del repositorio
3. Actualiza las credenciales en producción

## 📝 Archivo config.example.php

El archivo `php/config.example.php` SÍ debe subirse a GitHub como plantilla. Los usuarios pueden copiarlo y renombrarlo a `config.php` con sus propias credenciales.

## 🚀 Actualizaciones Futuras

Para subir cambios futuros:

```bash
# Ver cambios
git status

# Agregar archivos modificados
git add .

# Crear commit
git commit -m "Descripción de los cambios"

# Subir cambios
git push
```

## 📋 Checklist Pre-Subida

- [ ] Verificar que `.gitignore` incluye `php/config.php`
- [ ] Verificar que `php/config.example.php` existe y está actualizado
- [ ] Revisar que no hay contraseñas hardcodeadas en el código
- [ ] Verificar que `git status` NO muestra `php/config.php`
- [ ] Leer el `README.md` y asegurarse de que esté actualizado
- [ ] Verificar que todas las rutas de imágenes son correctas

## 🆘 Solución de Problemas

### Error: "remote origin already exists"
```bash
git remote remove origin
git remote add origin https://github.com/TU_USUARIO/inmobiliaria-crescendolls.git
```

### Error: "failed to push some refs"
```bash
# Primero hacer pull
git pull origin main --allow-unrelated-histories
# Luego push
git push -u origin main
```

### Ver qué archivos están siendo rastreados
```bash
git ls-files | findstr config.php
# Si aparece config.php, está siendo rastreado (MALO)
```

## 📚 Recursos Adicionales

- [GitHub Docs - Getting Started](https://docs.github.com/en/get-started)
- [Git Documentation](https://git-scm.com/doc)
- [GitHub Desktop](https://desktop.github.com/) - Alternativa con interfaz gráfica

