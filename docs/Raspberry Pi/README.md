# Configuracion Raspberry Pi
contamos con el modelo 3-b y el sistema operativo [Raspian](http://www.raspbian.org/) o [Ubuntu Mate](https://ubuntu-mate.org/raspberry-pi/) a elección del usuario.
En los links anteriores estan las correspondientes instrucciones para sus respectivas instalaciones, de lo contrario o en caso de duda se puede consultar facilmente a las mismas [aquí](https://www.raspberrypi.org/downloads/).

[Acceso Remoto](https://www.raspberrypi.org/documentation/remote-access/)

## Login via ssh on Raspi

Más instrucciones pueden ser encontradas [aquí](https://www.raspberrypi.org/help/)

### Consiguiendo la dirección de IP 

ejecuatando el siguiente comando e nuestro interprete de bash: hostname -I
en caso de no poder acceder al interprete local de la raspi es posible obtener su ip con alguna utilidad de terceros como 
arpscan y buscarla con lso primeros digitos de la direccion mac allende a todas las raspberrys.

### Login with ssh
en la computadora remota deberemos poner 

ssh user@<IP>   Donde: user es el nombre de usuario que tengamos en la Raspi y la ip es el prompt que obtuvimos antes

si quisiesemos pipear la sesion grafica debermos meter el argumento -Y antes del nombre de usuario

lo que nos permitira abrir aplicaciones con interfaz grafica instaladas en al raspi en nuestra plataforma.

en caso de querer trasnmitir la sesión de escritorio deberemos haber habilitado previamente vnc en la raspi, en caso de usar algun sistema basado en debian es recomendable ejecutar "sudo raspi-config"

esto abrira en el puerto 5800 la interfaz de vnc viewer, para poder utilizarlo deberemos usar un navegador con soporte para java, el plugin iced-tea y algun visor de vnc como vinagre.

## Setear un servidor PHP en la raspi 
Montamos un servidor LAMP con mariaDB y PHP7.

## Definir IP estática 
Instrucciones [aquí](https://www.modmypi.com/blog/how-to-give-your-raspberry-pi-a-static-ip-address-update)

`Nota: Este paso es mejor realizarlo desde el router local al que se conectará la Raspi mediante el reservado de una direccion de ip.`
