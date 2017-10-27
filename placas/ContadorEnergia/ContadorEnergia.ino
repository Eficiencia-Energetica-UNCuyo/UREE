// Firmware, versión final que envía el valor de energía consumida, cada 30 segundos al servidor.
// Programador: Moyano Jonathan.
// Versión: v0.1 - beta.

// Librería para manejar las comunicaciones WIFI. 
#include <ESP8266WiFi.h>          
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>  
// Incluye librería para manejar el ACS712.
#include "ACS712.h"

///PARAMETROS A MODIFICAR///
String Nombre="Valentina_Rodriguez";   //Importante ponerle el _
String Oficina="3";
String Equipo="Computadora";
String IP="179.0.132.135";
String User="IMD-AP4";
String Password="imdwifi4";
///////////////////////////


ACS712 sensor(ACS712_30A,0);
ESP8266WiFiMulti WiFiMulti;
HTTPClient http;

// Variables globales.
float U = 0.0;
float I = 0.0;
float energy=0.0; 
float EnergyCounter=0.0;
unsigned long previousMillis = 0;
const long interval = 30000;  // Intervalo modificable por el usuario.
unsigned long tiempo=0;
unsigned long currentMillis=0;
int i = 0;

void setup() {
  
  Serial.begin(9600);
  //configura el pin del relé como salida.
  pinMode(0,OUTPUT);
  // Enciende el relé.
  digitalWrite(1,HIGH);
  // Espera para antirrebotes.
   delay(400);
   
  Serial.println("Calibrando...desconectar carga !");
  // Calibra la lectura del sensor.
  sensor.calibrate();
  Serial.println("Sensor calibrado !!");

  //WiFi.begin("IMD-AP4", "imdwifi4");
  WiFi.begin(User, Password);

  // Resetea las variables globales.
  U = 0.0;
  I = 0.0;
  energy = 0.0;
  EnergyCounter=0.0;
}

void loop() {
  
 currentMillis = millis();  // Obtiene el tiempo transcurrido en ms.
 tiempo=currentMillis /1000;  // Lo convierte a segundos.
 
  // El valor medio medido era fluctuante, se utiliza un valor estático para mayor precisión.
  float U = 230; 
  // Lee la corriente que fluye por el sensor.
  float I = sensor.getCurrentAC();
  // Obtiene la potencia en Kilowatt.
  float P = (U * I)/1000;
  // Obtiene el valor de la energía.
  energy=(P*tiempo)/3600;      
  // Almacenamos el valor de la energía. Este valor nos indica el consumo del artefacto.
  EnergyCounter += energy;
  // Convierte el valor de la energía en un entero.
   i = (int)EnergyCounter;
   // Si el contador de energía llega a los 10Kw/h, resetea el contador.
    if(i==10000){EnergyCounter=0.0; i=0;}

// Sacar el comentario, si necesitamos debug.

/*
 Serial.println(String("T = ") + time + " sec");
 Serial.println(String("I = ") + I + " A");
 Serial.println(String("P = ") + P + " Kw");
 Serial.println(String("Kw/h = ") + EnergyCounter);
 delay(1000);
*/

 // Cada 30 segundos, enviamos los datos al servidor.
  if(currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis;   

  // Envía los datos cada 30 segundos.
  Serial.println(String("Kw/h - millis = ") + EnergyCounter);

   //Inicia la transmision de datos
  //http.begin("http://172.23.200.108/corriente.php?ipsrc=Oficina_1&corriente="); // HTTP.
  http.begin("http://"+IP+"/php/Ranking.php?nombre="+Nombre+"&oficina="+Oficina+"&equipo="+Equipo+"&energia=" + EnergyCounter);
    
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


