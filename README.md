Para ejecutar el proyecto debe dirigirse a la carpeta del proyecto y ejecutar el siguiente comando
docker build -t webapp-immaga .

Para posteriormente ejecutar este comando
docker run -p 8080:80 webapp-immaga

Y verificar en el local host el analizador
http://localhost:8080/
