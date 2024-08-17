<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Ejecutar en desarrollo

### 1. Clone el repositorio:
```
git clone https://github.com/laravel/laravel.git
```

### 2. Ingresar en el directorio:
```
cd laradockDocker
```

### 3. Ejecutar el docker-compose:
```
docker-compose up -d
```

### 4. Ingresar al workspace virtual de desarrollo en docker:
```
 docker exec -it nrs-workspace-1 /bin/sh
```
El nombre del workspace virtual de docker lo puede verificar con la imagen nrs-workspace:
```
docker ps
```

### 5. Ejecutar composer para instalar las dependencias:
```
composer install
```

### 6. Ejecutar las migraciones:
```
php artisan migrate
```

### 6. Ingresar a la aplicación desde el navegador:
```
http://localhost
```
