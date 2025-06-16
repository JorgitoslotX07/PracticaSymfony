# PracticaSymfony

Este repositorio contiene un proyecto Symfony 4 configurado con Docker y Tailwind CSS.

## Requisitos previos

* Docker y Docker Compose instalados en tu sistema.
* Node.js y npm instalados en la máquina host.
* Acceso a Internet para descargar dependencias.

## Instalación de dependencias

1. Sitúate en la raíz del proyecto:

   ```bash
   cd PracticaSymfony
   ```

2. Instala las dependencias de Node.js y compila los assets de Tailwind:

   ```bash
   npm install
   npm run dev
   ```

3. Instala las dependencias de PHP usando Composer **en tu máquina host** (no dentro del contenedor):

   ```bash
   composer install
   ```

## Levantando el entorno con Docker

Levanta los contenedores de Docker (PHP, Nginx, base de datos, etc.) y construye la imagen:

```bash
docker compose up -d --build
```



## Parada y limpieza de contenedores

Para detener los servicios y eliminar volúmenes asociados:

```bash
docker compose down -v
```

## Acceso a la aplicación

Una vez que los contenedores estén en marcha, abre tu navegador y visita:

```
http://localhost:8080
```

Para acceder al panel de administración utiliza las siguientes credenciales por defecto:

* **Usuario:** [admin1@example.com](mailto:admin1@example.com)
* **Contraseña:** admin123
