Proyecto Grúas Andalucía
Este proyecto es una aplicación web desarrollada con Laravel en el backend y Vue.js en el frontend, destinada a la gestión de la retirada de vehículos mal estacionados y el control de un depósito municipal.

Requisitos Previos
Antes de ejecutar el proyecto en tu entorno local, asegúrate de tener instalados los siguientes programas:

Software necesario:
PHP 8.x o superior
Composer (para gestionar las dependencias de Laravel)
Node.js 16.x o superior
npm (para instalar las dependencias del frontend de Vue.js)
XAMPP (para ejecutar Apache y MySQL localmente)
Requisitos de hardware:
Procesador: CPU moderna con 2 o más núcleos (ej. Intel Core i5).
Memoria RAM: Al menos 8 GB.
Espacio en disco: 200 GB libres (al menos).
Instalación y Configuración
Sigue estos pasos para configurar y ejecutar la aplicación localmente:

1. Configurar el Entorno
Clona o descarga el proyecto.
Copia el archivo .env.example y renómbralo a .env.
Edita el archivo .env con la siguiente configuración (deberás modificar solo la parte de Base de datos y Correo electrónico):
dotenv
Copiar código
APP_NAME="Gruas Andalucia"
APP_ENV=local
APP_KEY=base64:5nFP18RboijNlJDP8rH76V5DTmEQV0o+pgScHlk79zo=
APP_DEBUG=true
APP_TIMEZONE=Europe/Madrid
APP_URL=http://gruasandalucia.local

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crudlaravel
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=dmoreno@logic10.net  # Cambia con tu correo si es necesario
MAIL_PASSWORD=xkvyatmfwrvfyjoy    # Cambia con tu contraseña si es necesario
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="dmoreno@logic10.net"
MAIL_FROM_NAME="${APP_NAME}"
2. Instalar Dependencias
Instala las dependencias de PHP utilizando Composer:
bash
Copiar código
composer install
Instala las dependencias de Node.js para el frontend:
bash
Copiar código
npm install
3. Configuración de XAMPP
Asegúrate de tener XAMPP instalado. Si no lo tienes, puedes descargarlo aquí.
Abre XAMPP y enciende los servicios de Apache y MySQL.
4. Ubicación del Proyecto en XAMPP
El proyecto debe ser colocado en la carpeta htdocs de tu instalación de XAMPP. Esta carpeta es donde XAMPP busca los archivos para ser ejecutados por Apache.

En Windows, la ruta será algo como:
C:\xampp\htdocs\gruasandalucia

En Linux o macOS, la ruta será algo como:
/opt/lampp/htdocs/gruasandalucia

5. Configurar Apache para Laravel
En el archivo C:\xampp\apache\conf\extra\httpd-vhosts.conf, añade la siguiente configuración:
apache
Copiar código
<VirtualHost *:80>
    ServerAdmin webmaster@dummy-host2.example.com
    DocumentRoot "C:\xampp\htdocs\gruas_andalucia\public"
    ServerName gruasandalucia.local
    ErrorLog "logs/dummy-host2.example.com-error.log"
    CustomLog "logs/dummy-host2.example.com-access.log" common
</VirtualHost>
Luego, abre el archivo C:\Windows\System32\drivers\etc\hosts y añade la siguiente línea al final del archivo:
plaintext
Copiar código
127.0.0.1   gruasandalucia.local
6. Crear la Base de Datos
Accede a phpMyAdmin desde el panel de control de XAMPP (http://localhost/phpmyadmin).
Crea una base de datos con el nombre crudlaravel (o el nombre que hayas configurado en el archivo .env).
Importa la base de datos que te he proporcionado, asegurándote de que esté configurada con el conjunto de caracteres utf8mb4_unicode_ci.
7. Compilar el Frontend
En el directorio del proyecto, ejecuta el siguiente comando para compilar los archivos de Vue.js:

bash
Copiar código
npm run dev
8. Acceso a la Aplicación
Una vez que todo esté configurado y compilado, podrás acceder a la aplicación en tu navegador utilizando la siguiente URL:

http://gruasandalucia.local
Si no funciona, asegúrate de que la dirección gruasandalucia.local esté configurada en tu archivo de hosts de tu sistema operativo. Añade la siguiente línea al archivo C:\Windows\System32\drivers\etc\hosts (en Windows) o /etc/hosts (en Linux/macOS):

plaintext
Copiar código
127.0.0.1   gruasandalucia.local
9. Acceso Inicial
Para acceder a la aplicación, puedes iniciar sesión con el siguiente usuario de prueba:

Correo electrónico: test@gmail.com
Contraseña: 123456789
El usuario Test tiene los permisos administrativos, por lo que podrás acceder a todas las opciones de la aplicación. Cualquier otro usuario que se registre inicialmente tendrá el rol de cliente.

