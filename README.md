## Finco API – Autenticación y Perfil (Laravel + Sanctum)

API REST para autenticación (tokens Bearer con Sanctum) y gestión de perfil de usuario (1:1 User–Profile). Lista para ser consumida desde Android u otros clientes.

## Requisitos

-   PHP 8.2+
-   Composer
-   Base de datos (MySQL/PostgreSQL/SQLite)
-   Node (opcional, solo para frontend de bienvenida)

## Configuración rápida

1. Copia .env y configura la base de datos y APP_URL
    - APP_URL=http://localhost:8000
2. Instala dependencias
3. Genera clave de app
4. Ejecuta migraciones
5. Enlaza el storage público (para fotos de perfil)
6. Arranca el servidor de desarrollo

Comandos sugeridos (opcional):

```
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
```

## Autenticación

Bearer tokens con Laravel Sanctum.

Rutas (prefix /api):

-   POST /auth/register – Registro y emisión de token
-   POST /auth/login – Login y emisión de token
-   POST /auth/logout – Logout (requiere Bearer)

Headers para rutas protegidas:

-   Authorization: Bearer <TOKEN>

### Registro

Body (JSON):

```
{
	"name": "name",
	"email": "name@example.com",
	"password": "secret123",
	"password_confirmation": "secret123"
}
```

Respuesta: data con { user, token, token_type }

### Login

Body (JSON):

```
{ "email": "name@example.com", "password": "secret123" }
```

Respuesta: data con { user, token, token_type }

### Logout

Body (JSON) opcional:

```
{ "all_devices": true } // para cerrar sesión en todos los dispositivos
```

## Perfil de usuario

Rutas (auth:sanctum):

-   GET /profile/me – Retorna el perfil del usuario autenticado
-   PUT/PATCH /profile – Actualiza el perfil (texto y/o foto)

Campos aceptados (update):

-   first_name, last_name, birth_date (YYYY-MM-DD), gender (male|female|other), phone, address, bio, occupation
-   profile_photo: string (URL) – opcional, guarda la URL
-   profile_photo_file: archivo imagen (jpg/jpeg/png/webp, máx 2MB) – opcional, sube y guarda la ruta

Notas sobre fotos de perfil:

-   Los archivos se guardan en storage/app/public/profile_photos
-   La URL pública se devuelve como `profile_photo_url` (requiere `php artisan storage:link`)
-   Si envías `profile_photo_file`, se prioriza sobre `profile_photo`

### Ejemplos

Multipart (subir archivo):

```
PUT /api/profile
Headers: Authorization: Bearer <TOKEN>
Body (multipart/form-data):
	- profile_photo_file: [archivo imagen]
	- first_name: Name
	- birth_date: 1995-12-31
```

Solo URL:

```
PUT /api/profile
Headers: Authorization: Bearer <TOKEN>
Body (multipart/form-data o JSON):
	- profile_photo: https://cdn.tuapp.com/u/123.png
```

## Formato de respuesta

Se usa un helper `ApiResponse` para estandarizar:

```
{
	"success": true,
	"message": "Texto",
	"data": { ... },
	"meta": {}
}
```

En errores:

```
{
	"success": false,
	"message": "Detalle del error",
	"errors": { "campo": ["mensaje"] }
}
```

## Seguridad y buenas prácticas

-   Usa HTTPS en producción.
-   Configura CORS si el cliente está en otro origen.
-   Ajusta throttling/rate-limiting para login/registro.
-   Mantén APP_URL correctamente en .env para URLs públicas de storage.

## Tests (pendiente sugerido)

-   Feature: register, login, profile me/update, logout.
-   Unit: servicios de Auth y Profile.

## Licencia

MIT
