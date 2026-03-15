# Monitoreo WebApp

Este proyecto es una aplicación web diseñada para el monitoreo en tiempo real de vehículos (trufis) y el seguimiento de encomiendas durante viajes.

## Requisitos del Sistema

Antes de iniciar, asegúrate de que tu equipo cumple con los siguientes requisitos:

### 1. Verificar PHP
La aplicación requiere **PHP 7.4** o superior (recomendado **8.3**). Para verificar tu versión de PHP, ejecuta:

```bash
php -v
```

### 2. Verificar Composer
Composer es necesario para la gestión de las dependencias del proyecto. Verifica su instalación con:

```bash
composer -v
```

Si no lo tienes instalado, puedes descargarlo desde [getcomposer.org](https://getcomposer.org/).

### 3. Módulos Adicionales de PHP
Asegúrate de que los siguientes módulos estén habilitados en tu archivo `php.ini`:
- `pdo_sqlite` (Necesario para la base de datos SQLite 3)
- `mbstring`
- `openssl`

Puedes listar los módulos activos con el comando:

```bash
php -m
```

---

## Instalación y Configuración

### 1. Descargar el Proyecto
Para obtener el código fuente como un archivo comprimido:
1. Ve a la página principal del repositorio en GitHub.
2. Haz clic en el botón verde **"Code"**.
3. Selecciona **"Download ZIP"**.
4. Extrae el contenido en tu directorio de trabajo local.

### 2. Instalar Dependencias
Abre una terminal en la carpeta raíz del proyecto y ejecuta el siguiente comando para instalar las librerías necesarias (como Bramus Router y PHP Dotenv):

```bash
composer install
```

### 3. Configuración de Base de Datos
El proyecto utiliza una base de datos **SQLite 3**. Asegúrate de que la carpeta `storage/` tenga permisos de escritura para que la aplicación pueda interactuar con el archivo `database.sqlite`.

---

## Ejecución del Proyecto

Para iniciar el servidor local de desarrollo incluido en PHP, ejecuta el siguiente comando desde la raíz del proyecto:

```bash
php -S localhost:8000 -t public
```

Una vez iniciado, abre tu navegador y accede a:
[http://localhost:8000](http://localhost:8000)

---

## Estructura de Carpetas

- `src/`: Lógica central (Controladores, Modelos, Vistas).
- `public/`: Punto de entrada (`index.php`) y archivos estáticos (CSS, JS).
- `templates/`: Archivos HTML organizados por módulos.
- `storage/`: Archivo de la base de datos SQLite.
- `docs/`: Documentación técnica y esquema SQL original.
