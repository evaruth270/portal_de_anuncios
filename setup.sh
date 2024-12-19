# Crea la carpeta principal del proyecto
mkdir portal_anuncios
cd portal_anuncios

# Crea subcarpetas principales
mkdir admin assets config controllers views partials

# Crea carpetas dentro de /assets/
mkdir -p assets/css assets/js assets/uploads/anuncios

# Crea archivos principales
touch index.php
touch .env
touch README.md

# Crea archivos dentro de /admin/
touch admin/index.php
touch admin/anuncios.php
touch admin/usuarios.php

# Crea archivos dentro de /assets/css/
touch assets/css/style.css

# Crea archivos dentro de /assets/js/
touch assets/js/script.js

# Crea archivos dentro de /config/
touch config/conexion.php
touch config/funciones.php

# Crea archivos dentro de /controllers/
touch controllers/AuthController.php
touch controllers/AnuncioController.php

# Crea archivos dentro de /views/
touch views/index.php
touch views/login.php
touch views/registro.php
touch views/publicar.php
touch views/anuncios.php
touch views/detalle.php

# Crea archivos dentro de /partials/
touch partials/header.php
touch partials/navbar.php
