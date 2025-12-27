# Proyecto: Monitoreo WebApp

Este proyecto es una aplicación web diseñada para el monitoreo en tiempo real de vehículos (trufis) y el seguimiento de encomiendas durante viajes.

## Características Principales

- **Gestión de Entidades**: Control completo sobre usuarios, clientes, conductores y vehículos (móviles).
- **Control de Viajes**: Registro detallado de viajes, incluyendo origen, destino, horarios de salida/llegada y vehículo asignado.
- **Monitoreo en Tiempo Real**: Seguimiento de coordenadas GPS (latitud/longitud) vinculadas a un viaje específico.
- **Seguimiento de Encomiendas**: Localización de paquetes mediante un código único asociado a un viaje monitoreado.
- **API de Seguimiento**: Endpoint dedicado (`/api/monitoreo`) para la actualización de posición desde dispositivos externos.

## Stack Tecnológico

- **Lenguaje**: PHP 7.4 / 8.3
- **Base de Datos**: SQLite 3
- **Enrutamiento**: Bramus Router
- **Arquitectura**: MVC (Modelo-Vista-Controlador)
- **Gestión de Dependencias**: Composer
- **Frontend**: Plantillas HTML con layouts base

## Estructura del Proyecto

- `src/`: Lógica de la aplicación (Controllers, Models, Views, Core, Utils).
- `templates/`: Archivos de vista (HTML) organizados por módulo.
- `public/`: Punto de entrada (`index.php`) y activos estáticos.
- `docs/`: Documentación y scripts de base de datos (`database.sql`).
- `storage/`: Almacenamiento de base de datos SQLite y otros archivos persistentes.

## Base de Datos (Tablas)

1.  **oficina**: Sedes o sucursales.
2.  **usuario**: Credenciales y roles (admin/operador).
3.  **cliente**: Información de los clientes vinculada a un usuario.
4.  **conductor**: Datos personales de los choferes.
5.  **movil**: Vehículos registrados con su placa e interno.
6.  **viaje**: Información logística del trayecto y encomiendas.
7.  **monitoreo**: Última posición conocida de un viaje.
