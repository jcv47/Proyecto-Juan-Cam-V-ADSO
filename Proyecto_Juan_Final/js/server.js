// Este es un archivo de servidor Node.js que crea un servidor HTTP simple
// que responde con un mensaje de texto cuando se accede a él.
const http = require('http');
 
const hostname = '127.0.0.1';
const port = 3002;
 
const server = http.createServer((req, res) => {
  res.statusCode = 200;
  res.setHeader('Content-Type', 'text/plain');
  res.end('¡Hola, Mundo!');
});
 
server.listen(port, hostname, () => {
  console.log(`Servidor corriendo en http://${hostname}:${port}/`);
});