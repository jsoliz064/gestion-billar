1. Copie el archivo .env.example a .env

```
    cp .env.example .env
```

2. Rellene los datos del .env

```
ASSET_URL=/public

GESTION_PORT=8000

DB_CONNECTION=mysql
DB_HOST=mysql-billar
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=root
DB_PASSWORD=
```

3. Ejecute Contenedor de Base de datos

```
    docker-compose -f docker-compose-db.yml up -d
```

4. Ejecute Contenedor de Laravel

```
    docker-compose up -d
```

5. Ejecute Comandos Adicionales del Contenedor de Laravel

```
    composer install
    
    docker exec gestion-billar chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

    docker exec gestion-billar chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

    php artisan optimize
```
