# ¿Qué es? 👀

Backend realizado para una clínica dental. El cliente puede pedir cita y ver sus citas pendientes. Los trabajadores podrán ver un listado de clientes, de citas y buscar a clientes por su id.

- Laravel
- Eloquent
- SQL
- REST Client

<br>

# Cómo lanzarlo 🚀

- Descargar [repo](https://github.com/RosaSabater/appClinicaDentalPHP-b).
- Ejecutar:
	- `php artisan serve`

<br>

# Deploy ☁

- El proyecto está deployado en [Heroku](https://appclinicadentalphp.herokuapp.com/api).
- Puede usarse en su front deployado en [Netlify](https://clinicadental.netlify.app)

<br>

# Endpoints 📃
Se pueden ejecutar sin necesidad de Postman con la extensión REST Client.<br>
Encontraremos un archivo llamado test.rest donde podremos ejecutarlos.

<br>

**Endpoints ADMIN** 🤴

<br>

- **GET** /admin/mostrarUsuarios/

<br>

- **GET** /admin/mostrarCitas/

<br>

- **GET** /admin/:id/
```
Buscamos a un usuario específico con su id.
```

<br>

**Endpoints USUARIO** 👥

<br>

- **POST** /registro/
```json
{
    "nombre": "Test",
    "apellidos": "Test",
    "telefono": "999999999",
    "email": "test@gmail.com",
    "password": "12345678" 
}
```

<br>


- **POST** /areaclientes/login/
```json
{
    "email": "ejemplo@gmail.com",
    "password": "1234"
}
```
```
Aquí se crea el token.
```

<br>

- **GET** /areaclientes/logout/
```json
Authorization: {{token}}
```

<br>

- **DELETE** /areaclientes/baja/
```json
Authorization: {{token}}
```

<br>

**Endpoints CITAS** 🕐

<br>

- **POST** /areaclientes/nuevacita/
```json
Authorization: {{token}}
{
    "fecha": "2020-10-19 16:29",
    "usuarioId": "5f8c457392d0260017eb2184",
    "motivo": "Cita para empaste"
}
```

<br>

- **POST** /areaclientes/citas/:id/
```json
Authorization: {{token}}
```

<br>

- **PUT** /areaclientes/cancelarcita/:id/
```json
Authorization: {{token}}
```
```
Buscamos con la id de la cita para cancelarla.
```
