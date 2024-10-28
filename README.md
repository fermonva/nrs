<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Ejecutar en desarrollo

### 1. Clone el repositorio:
```
git clone https://github.com/laravel/laravel.git
```

### 2. Ingresar en el directorio:
```
sail up -d
```

### 3. Ejecutar composer para instalar las dependencias:
```
sail composer install
```

### 4. Ejecutar las migraciones:
```
sail artisan migrate
```

### 5. Ejecutar el seeder:
```
sail artisan db:seed --class=GasQualitiesTableSeeder
```

### 6. Ingresar a la aplicación desde el navegador:
```
http://localhost
```
