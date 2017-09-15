//Librerias a utilizar
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>
#include <DHT.h>;

//Parametros del sensor DTH
#define DHTPIN D2     // Pin a conectar
#define DHTTYPE DHT22   // DHT 22  (AM2302)
#define MOVPIN D0

ESP8266WiFiMulti WiFiMulti;

//Variables 
float Temperatura;
float Humedad;
float Ventana_1;
float Ventana_2;
float PIR;

//Inicializacion del DHT
DHT dht(DHTPIN, DHTTYPE); 

void setup() {
  
  //Serial.begin(115200); 
  dht.begin();          
 
  for(uint8_t t = 8; t > 0; t--) {  
      delay(1000);
  }
 //Comienza la conexión("ssid","password)")
  WiFi.begin("IMD-AP4", "imdwifi4"); 
} 
void loop() 
{
  //Adquisicion de las variables
  Temperatura= dht.readTemperature();
  Humedad = dht.readHumidity();
  PIR  = digitalRead(MOVPIN); //read state of the PIR
  Ventana_1  = digitalRead(MOVPIN);
  Ventana_2  = digitalRead(MOVPIN);
  
  delay(2000);
  
  //TEMPERATURA 
  String temp;
  temp = String(Temperatura);
  
  //HUMEDAD
  String hum; 
  hum = String(Humedad);

  //MOVIMIENTO
  String pir;
  pir= String(PIR);
  
  //VENTANA 1
  String vent_1;
  vent_1= String(Ventana_1);
  
  //VENTANA 2
  String vent_2;
  vent_2= String(Ventana_2);
    
  HTTPClient http;
  //Serial.println(temp);
  //Serial.println(hum)
  //Serial.println(pir);
  //Serial.println(vent_1);
  //Serial.println(vent_2);
  delay(200);

  //Inicia la transmision de datos
  http.begin("http://172.23.201.87/test4.php?ipsrc=Oficina_1&Temperatura="+ temp + "&Humedad="+ hum + "&PIR="+ pir +"&Ventana_1="+ vent_1 +"&Ventana_2="+ vent_2); //HTTP

  int httpCode = http.GET();
  
    if(httpCode > 0) {
        if(httpCode == HTTP_CODE_OK) {
            String payload = http.getString();
        }
    } else {
    }
 
    http.end();
    delay(1000);
}
