#include <RunningStatistics.h>
#include <FilterDerivative.h>
#include <Filters.h>
#include <FilterTwoPole.h>
#include <FloatDefine.h>
#include <FilterOnePole.h>

// Firmaware final del sensor Ambiental.
// Programador: Moyano Jonathan.
// Versión: 0.1 beta.

// Librería para manejar las comunicaciones WIFI. 
#include <ESP8266WiFi.h>          
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>
// Incluye librería para manejar protocolo OneWire.
#include <OneWire.h>
// Incluye librería para manejar el sensor de temperatura.
#include <DallasTemperature.h>
// Incluimos la librería button para el manejo del sensor PIR y los
// sensores de puerta y ventana.
#include <Button.h>

// Incluye la librería del sensor de humedad y temperatura.
#include "DHT.h"

ESP8266WiFiMulti WiFiMulti;
HTTPClient http;

///PARAMETROS A MODIFICAR///
String Oficina="4";
String IP="179.0.132.135";
String User="Usuario";
String Password="contrasena";
///////////////////////////

// Definimos los pines utilizados.
#define SENSOR_TEMP_EXT   2
#define SENSOR_TEMP_INT   0
#define SENSOR_PIR        16
#define SENSOR_VENTANA    14
#define SENSOR_PUERTA     12
#define ERROR_LED         15
#define OK_LED            13

// Variables globales.
unsigned long previousMillis = 0;
const long interval = 60000;      // Intervalo modificable por el usuario.
unsigned long currentMillis=0;

// Algunas variables de estado.
byte estado_ventana = 0x00;     // 0x00 significa que la ventana está cerrada.
byte estado_puerta = 0x00;
byte estado_movimiento = 0x00;

// Pin donde está conectado el sensor de temperatura interno.
#define DHTPIN SENSOR_TEMP_INT
// Defino el tipo de sensor que está conectado a la placa.
#define DHTTYPE DHT22 

DHT dht(DHTPIN, DHTTYPE);

// Pin donde está conectado el sensor de temperatura.
#define ONE_WIRE_BUS SENSOR_TEMP_EXT
// Configuramos una instancia para comunicarnos con cualquier dispositivo OneWire en el bus.
OneWire oneWire(ONE_WIRE_BUS);

DallasTemperature sensors(&oneWire);

// Configuramos las entradas auxiliares.
Button sensor_ventana(SENSOR_VENTANA,false,false,40);
Button sensor_puerta(SENSOR_PUERTA,false,false,40);
Button sensor_PIR(SENSOR_PIR,false,false,40);

void setup() {

 // Configuramos el puerto serial.
  Serial.begin(9600); 
 // Configuramos los pines utilizados.
 pinMode(ERROR_LED,OUTPUT);
 pinMode(OK_LED,OUTPUT);
 
 // Inicializa el sensor DS18B20.
  sensors.begin();
  // Inicializa el sensor DHT22.
  dht.begin();

 // Inicializa las comunicaciones.
  WiFi.begin(User.c_str(), Password.c_str());

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
    digitalWrite(ERROR_LED,HIGH);
    digitalWrite(OK_LED,LOW);
  }digitalWrite(ERROR_LED,LOW);
    digitalWrite(OK_LED,HIGH);

  Serial.println("");
  Serial.println("WiFi conectado.");  
  Serial.println("IP: ");
  Serial.println(WiFi.localIP());
  Serial.println("");
  
}


void loop()
{  

  // Lee los sensores auxiliares.
  sensor_ventana.read(); 
  sensor_puerta.read(); 
  sensor_PIR.read();
  
  currentMillis = millis();  // Obtiene el tiempo transcurrido en ms.
  
  Serial.print("Adquiriendo temperaturas...");
  sensors.requestTemperatures(); // Enviamos el comando para adquirir la temperatura.
  Serial.println("Conversion lista...");
  Serial.print("Temperatura externa: ");
  // Obtenemos el valor de la temperatura.
  String temperatura = String(sensors.getTempCByIndex(0));
  Serial.println(temperatura); 

  // Obtiene el valor de la humedad.
   float h = dht.readHumidity();
    String humedad = String(h);
  // Obtiene la temperatura interna.
   float t = dht.readTemperature();
    String Tinterna = String(t);

   // Verifica que no haya ningún error de lectura del sensor de temperatura interno.
    if (isnan(h) || isnan(t)) {
    Serial.println("Falla al leer el sensor !");
    return;
  }

   if (sensor_ventana.isReleased()){
   Serial.println("VENTANA ABIERTA !!");
    estado_ventana = 0x01;
    } else {estado_ventana = 0x00;}
  if (sensor_puerta.isReleased()){
    Serial.println("PUERTA ABIERTA !!");
     estado_puerta = 0x01;
     } else {estado_puerta = 0x00;}
      if (sensor_PIR.isPressed()){
    Serial.println("MOVIMIENTO!!");
     estado_movimiento = 0x01;
     } else {estado_movimiento = 0x00;}

  // Imprime los valores de temperatura y humedad.
  Serial.println("");
  Serial.print("Humedad interna: ");
  Serial.print(h);
  Serial.print(" %\t");
  Serial.print("Temperatura interna: ");
  Serial.print(t);
  Serial.print(" *C ");
  Serial.println("");

  // Cada 30 segundos, enviamos los datos al servidor.
  if(currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis;

  //Inicia la transmision de datos
  //http.begin("http://"+IP+"/receptor.php?ipsrc=Oficina_"+Oficina+"&Temperatura="+Tinterna+ "&Humedad="+ humedad + "&PIR=" + estado_movimiento + "&Ventana=" + estado_ventana + "&Puerta=" + estado_puerta);
  http.begin("http://"+IP+"/php/receptor.php?ipsrc=Oficina_"+Oficina+"&Temperatura="+Tinterna+ "&Humedad="+ humedad + "&PIR=" + estado_movimiento + "&Ventana_1=" + estado_ventana + "&Ventana_2=" + estado_puerta);
   int httpCode = http.GET();
    if(httpCode > 0) {
      Serial.println("Enviado: OK !!");
        if(httpCode == HTTP_CODE_OK) {
            String payload = http.getString();  
             Serial.print("Respuesta del server:");
              Serial.println(payload);
        }
    } else {

      // Muestra una secuencia de error en el led WIFI/ERR.
      digitalWrite(OK_LED,LOW);
      digitalWrite(ERROR_LED,HIGH);
      delay(100);
      digitalWrite(ERROR_LED,LOW);
      delay(100);
      
      Serial.println("Enviado: ERROR !!");
    }

    http.end();

  }

}
  

