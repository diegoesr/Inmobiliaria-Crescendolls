# 📝 Comandos Git para Actualizar el README

## 🔄 Actualizar README y Subir Cambios

### Opción 1: Solo actualizar el README

```bash
# 1. Agregar el README modificado
git add README.md

# 2. Crear commit con el cambio
git commit -m "Actualizar README con capturas de pantalla"

# 3. Subir cambios a GitHub
git push origin main
```

### Opción 2: Actualizar README + Screenshots + Otros cambios

```bash
# 1. Agregar todos los archivos modificados y nuevos
git add README.md
git add screenshots/
git add .gitignore

# O agregar todo de una vez:
git add .

# 2. Verificar qué se va a subir
git status

# 3. Crear commit
git commit -m "Actualizar README con capturas de pantalla y agregar carpeta screenshots"

# 4. Subir cambios a GitHub
git push origin main
```

### Opción 3: Forzar reemplazo completo del README (si hay conflictos)

```bash
# 1. Agregar el README
git add README.md

# 2. Crear commit
git commit -m "Reemplazar README con versión actualizada"

# 3. Si hay conflictos, forzar push (CUIDADO: solo si es necesario)
git push origin main --force
```

## 📋 Comandos Paso a Paso Detallados

### 1. Ver el estado actual
```bash
git status
```

### 2. Ver los cambios específicos en README
```bash
git diff README.md
```

### 3. Agregar solo el README
```bash
git add README.md
```

### 4. Verificar que se agregó correctamente
```bash
git status
```

### 5. Crear commit con mensaje descriptivo
```bash
git commit -m "Actualizar README: agregar capturas de pantalla reales"
```

### 6. Subir a GitHub
```bash
git push origin main
```

## 🚨 Si Necesitas Reemplazar Completamente

### Escenario: El README en GitHub está desactualizado y quieres reemplazarlo

```bash
# 1. Asegúrate de estar en la rama correcta
git checkout main

# 2. Traer los últimos cambios (por si acaso)
git pull origin main

# 3. Agregar tu README local
git add README.md

# 4. Commit
git commit -m "Actualizar README con capturas de pantalla"

# 5. Push
git push origin main
```

## ⚠️ Comandos de Emergencia

### Si accidentalmente hiciste cambios incorrectos y quieres restaurar

```bash
# Descartar cambios locales en README (CUIDADO: perderás cambios)
git restore README.md

# O restaurar desde el último commit
git checkout HEAD -- README.md
```

### Si quieres descargar el README de GitHub y empezar de nuevo

```bash
# Traer el README de GitHub
git checkout origin/main -- README.md
```

## 📝 Verificación Post-Push

Después de hacer push, verifica en GitHub:

1. Ve a tu repositorio en GitHub
2. Abre el archivo `README.md`
3. Verifica que las imágenes se muestren correctamente
4. Si las imágenes no aparecen, verifica las rutas:
   - Deben ser: `screenshots/nombre-archivo.jpg`
   - No deben tener rutas absolutas

## 🔍 Comandos Útiles Adicionales

```bash
# Ver el historial de commits del README
git log --oneline README.md

# Ver el contenido del README en el último commit
git show HEAD:README.md

# Comparar README local vs remoto
git diff HEAD origin/main -- README.md
```

