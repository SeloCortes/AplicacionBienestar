#!/bin/bash

# Configuración básica
SERVER_DIR="/var/www/bienestar"

echo "🚀 Iniciando despliegue de Aplicación Bienestar (Prototipo)..."

# Ingresar al directorio
cd $SERVER_DIR || exit

# Asegurar que el archivo de base de datos SQLite existe
if [ ! -f database/database.sqlite ]; then
    echo "📄 Creando base de datos SQLite vacía..."
    touch database/database.sqlite
fi

# Instalar dependencias de PHP
echo "📦 Instalando dependencias de Composer..."
composer install --optimize-autoloader --no-dev --no-interaction

# Limpiar y optimizar cachés de Laravel
echo "🧹 Limpiando cachés..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Ejecutar migraciones
echo "🗄️ Ejecutando migraciones..."
php artisan migrate --force

# Actualizar el enlace simbólico del almacenamiento
echo "🔗 Actualizando enlaces simbólicos..."
php artisan storage:link

# Ajustar permisos para el servidor web (www-data)
echo "🔒 Ajustando permisos..."
sudo chown -R www-data:www-data storage bootstrap/cache database/database.sqlite
sudo chmod -R 775 storage bootstrap/cache
sudo chmod 664 database/database.sqlite

echo "✅ Despliegue completado con éxito!"
