// Prueba del módulo de sensores ambientales.
// El sistema cuenta con sensor de temperatura externa, 
// interna, movimiento y 2 sensores de contacto seco.
// Programador: Moyano Jonathan.
// Versión: 0.1

// Librería para manejar las comunicaciones WIFI. 
#include <ESP8266WiFi.h>          
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>  

ESP8266WiFiMulti WiFiMulti;
HTTPClient http;

///PARAMETROS A MODIFICAR///
String Oficina="3";
String IP="179.0.132.135";
String User="IMD-AP4";
String Password="imdwifi4";
///////////////////////////

// Definimos los pines utilizados.
#define SENSOR_TEMP_EXT  2
#define SENSOR_TEMP_INT  0
#define SENSOR_PIR      16
#define SENSOR_AUX1     14
#define SENSOR_AUX2     12
#define ERROR_LED       15
#define OK_LED          13

// Variables globales.
unsigned long previousMillis = 0;
const long interval = 30000;   // Intervalo modificable por el usuario.
unsigned long currentMillis=0;

// Incluye librería para manejar protocolo OneWire.
#include <OneWire.h>
// Incluye librería para manejar el sensor de temperatura.
#include <DallasTemperature.h>
// Incluimos la librería button para el manejo del sensor PIR y los
// sensores de puerta y ventana.
#include <Button.h>

// Pin donde está conectado el sensor de temperatura.
#define ONE_WIRE_BUS SENSOR_TEMP_EXT

// Configuramos una instancia para comunicarnos con cualquier dispositivo I2C en el bus.
OneWire oneWire(ONE_WIRE_BUS);

DallasTemperature sensors(&oneWire);

// Configuramos las entradas auxiliares.
Button AUX1(SENSOR_AUX1);
Button AUX2(SENSOR_AUX2);


void setup() {

 // Configuramos el puerto serial.
  Serial.begin(115200); 
 // Configuramos los pines utilizados.
 pinMode(SENSOR_PIR,INPUT);
 pinMode(ERROR_LED,OUTPUT);
 pinMode(OK_LED,OUTPUT);
 AUX1.begin();
 AUX2.begin();
 
 // Inicializa el sensor DS18B20.
  sensors.begin();

  // Inicializa el módulo wifi.
  // WiFi.begin("IMD-AP4", "imdwifi4");
 Wifi.begin(User,Password);
  
}


void loop()
{  

  currentMillis = millis();  // Obtiene el tiempo transcurrido en ms.
  
  Serial.print("Adquiriendo temperaturas...");
  sensors.requestTemperatures(); // Enviamos el comando para adquirir la temperatura.
  Serial.println("Conversion lista...");
  Serial.print("Temperatura externa: ");
  // Obtenemos el valor de la temperatura.
  Serial.println(sensors.getTempCByIndex(0)); 

   if (AUX1.pressed())
   Serial.println("VENTANA ABIERTA !!");
  
  if (AUX2.released())
    Serial.println("PUERTA ABIERTA !!");

 // Cada 30 segundos, enviamos los datos al servidor.
  if(currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis;   

   //Inicia la transmision de datos
  //http.begin("http://172.23.200.108/corriente.php?ipsrc=Oficina_1&corriente="); // HTTP.
  http.begin("http://"+IP+"/php/Ranking.php?nombre="+Nombre+"&oficina="+Oficina+"&equipo="+Equipo+"&energia=" + corr);
  int httpCode = http.GET();
  
    if(httpCode > 0) {
        if(httpCode == HTTP_CODE_OK) {
            String payload = http.getString();
        }
    } else {
    }
 
    http.end();
   
  }
}
  

