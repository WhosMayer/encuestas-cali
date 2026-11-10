Encuestas Cali — primera entrega

Requisitos: PHP 8.0+ con pdo_mysql y mbstring, y MySQL o MariaDB.
1. Inicia MySQL e importa sql/schema.sql desde phpMyAdmin.
2. Desde PowerShell en esta carpeta, define una clave de demostración:
   $env:ENCUESTAS_DEMO_PASSWORD = Read-Host 'Clave de prueba (10 caracteres o más)'
   & C:/xampp/php/php.exe scripts/crear-usuarios.php
3. Arranca la aplicación desde esta carpeta:
   & C:/xampp/php/php.exe -S 127.0.0.1:8092 -t public
4. Abre http://127.0.0.1:8092/ y entra con la clave elegida.

Cuentas: administrador, ventanilla, encuestador, calidad, enrutador.
Ventanilla usa la oficina principal. También hay cuentas ventanilla1,
ventanilla6, ventanilla7, ventanilla13, ventanilla14, ventanilla20 y ventanilla21.
El mapa usa Leaflet y OpenStreetMap y necesita internet. También puedes escribir
las coordenadas. El catálogo territorial incluye 339 barrios y sectores de 22
comunas y 15 corregimientos. El servidor verifica que el barrio corresponda
a la comuna seleccionada. El mapa guarda la posición marcada por ventanilla.
Fuente: Departamento Administrativo de Planeación – Alcaldía Distrital de
Santiago de Cali. Se extrajeron nombres y comunas de las capas de la
geodatabase DIVIPOLA, sin geometrías. El catálogo derivado en app/territorio.json
se distribuye bajo CC BY-SA 4.0: https://creativecommons.org/licenses/by-sa/4.0/
Descarga: https://idesc.cali.gov.co/download/divipola/divipola.rar

Para otra instalación configura ENCUESTAS_DSN, ENCUESTAS_DB_USER y
ENCUESTAS_DB_PASSWORD. Usa public como raíz del servidor web.

Pruebas: C:/xampp/php/php.exe ci/check.php
Jenkins: crea una tarea Pipeline desde SCM para este repositorio y selecciona
Jenkinsfile. El agente necesita Git y PHP con mbstring. El pipeline comprueba
sintaxis y reglas de validación sin necesitar una base de datos.
