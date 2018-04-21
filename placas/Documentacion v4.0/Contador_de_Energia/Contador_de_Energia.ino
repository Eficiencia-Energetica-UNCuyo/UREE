// Firmware, versión final que envía el valor de energía consumida, cada 30 segundos al servidor.
// Programador: Instituto de Energia.
// Versión: v0.9 - beta.

// Librería para manejar las comunicaciones WIFI. 
#include <ESP8266WiFi.h>          
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>  
// Incluye librería para manejar protocolo OneWire.
#include <OneWire.h>
// Incluye librería para manejar el sensor de temperatura.
#include <DallasTemperature.h>
// Incluye librería para manejar el conversor AD.
#include <MCP3008.h>
// Incluye librería para manejar las comunicaciones por SPI.
#include <SPI.h>

///PARAMETROS A MODIFICAR///
String Nombre="Gonzalo_Romero";   //Importante ponerle el _
String Oficina="1";
String Equipo="Televisor";
//String IP="34.196.152.80"; // IP PRUEBAS.
String IP="179.0.132.135";    // IP UNC.
String User="Usuario";
String Password="Contrasena";
///////////////////////////

// Configuramos los pines SPI.
MCP3008 adc(D5,D7,D6,D8);

ESP8266WiFiMulti WiFiMulti;
HTTPClient http;

// Pin donde está conectado el sensor de temperatura.
#define ONE_WIRE_BUS 2

// Configuramos una instancia para comunicarnos con cualquier dispositivo I2C en el bus.
OneWire oneWire(ONE_WIRE_BUS);

DallasTemperature sensors(&oneWire);

// Variables globales.
float U = 0.0;
float I = 0.0;
float energy=0.0; 
float EnergyCounter=0.0;
String temperatura = "";
unsigned long previousMillis = 0;
const long interval = 60000;  // Intervalo modificable por el usuario.
unsigned long tiempo=0;
unsigned long currentMillis=0;
int i = 0;
int valor = 0;

void setup() {
      
  Serial.begin(9600);
  
  WiFi.begin(User.c_str(), Password.c_str());

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi conectado.");  
  Serial.println("IP: ");
  Serial.println(WiFi.localIP());
  
  // Inicializa el sensor DS18B20.
  sensors.begin();

  valor = ACS712_calibrate();
  Serial.println(valor);
  

  // Resetea las variables globales.
  U = 0.0;
  I = 0.0;
  energy = 0.0;
  EnergyCounter=0.0;

}

void loop() {
 
 currentMillis = millis();  // Obtiene el tiempo transcurrido en ms.
 tiempo=currentMillis /1000;  // Lo convierte a segundos.
 
  Serial.print("Adquiriendo temperaturas...");
  sensors.requestTemperatures(); // Enviamos el comando para adquirir la temperatura.
  Serial.println("Conversion lista...");
  Serial.print("Temperatura interna: ");
  // Obtenemos el valor de la temperatura.
  temperatura = String(sensors.getTempCByIndex(0));
  Serial.println(temperatura);
 
  // El valor medio medido era fluctuante, se utiliza un valor estático para mayor precisión.
  float U = 230; 
  // Lee la corriente que fluye por el sensor.
  I = ACS712_CurrentSense(valor);
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

 Serial.println(String("T = ") + tiempo + " sec");
 Serial.println(String("I = ") + I + " A");
 Serial.println(String("P = ") + P + " Kw");
 Serial.println(String("Kw/h = ") + EnergyCounter);
 delay(1000);


 // Cada 30 segundos, enviamos los datos al servidor.
  if(currentMillis - previousMillis >= interval) {
    previousMillis = currentMillis;   

 // Inicia la transmisión de datos.
 // http.begin("http://"+IP+"/php/Ranking.php?nombre="+Nombre+"&oficina="+Oficina+"&equipo="+Equipo+"&TemperaturaINT="+temperatura+"&energia=" + EnergyCounter);

  String  energia = String(EnergyCounter);
  Serial.println(energia);
 
  http.begin("http://"+IP+"/php/Ranking.php?nombre="+Nombre+"&oficina="+Oficina+"&equipo="+Equipo+"&energia=" + energia);
    
  int httpCode = http.GET();
    if(httpCode > 0) {
      Serial.println("Enviado: OK !!");      
        if(httpCode == HTTP_CODE_OK) {
            String payload = http.getString();  
             Serial.print("Respuesta del server:");
              Serial.println(payload);
        }
    } else { Serial.println("Enviado: ERROR !!");
    }
    
      http.end();
   }
}

int ACS712_calibrate() {

  // Variables locales.
  uint32_t acc = 0;
  uint16_t zero = 0;

  // Espera 1ms antes de empezar la muestra.
  delay(1);
  
  // Toma 250 muestras del cero.
  for (int i = 0; i < 250; i++) {
    acc += adc.readADC(0);
  }
    // Obtiene el valor de calibración.
    zero = acc / 250;
  return zero;
}

/*
float ACS712_noiseCancel(int calibrationValue) { // No está terminada.

  // Variables locales.
  float noise= 0;
  float zero_noise= 0;

  // Espera 1ms antes de empezar la muestra.
  delay(1);
  
  // Toma 50 muestras del ruido.
  for (int i = 0; i < 50; i++) {
    noise += ACS712_CurrentSense(calibrationValue);
  }
    // Obtiene el valor de calibración.
    zero_noise = noise / 50;
  return zero_noise;
}

*/

float ACS712_CurrentSense(int zeroCalibrate)
{

 const unsigned long sampleTime = 100000UL;                  // Tiempo discreto de sampleo.                       
 const unsigned long numSamples = 250UL;                     // Total de muestras.                 
 const unsigned long sampleInterval = sampleTime/numSamples; // Intervalo de muestreo.
 unsigned long currentAcc = 0;                               // Variable que contiene las muestras de corriente.
 unsigned int count = 0;                                     // Contador auxiliar.
 unsigned long prevMicros = micros() - sampleInterval ;
 
 while (count < numSamples)
 {
   if (micros() - prevMicros >= sampleInterval)
   {
     int adc_raw = adc.readADC(0) - zeroCalibrate;      // Toma el valor de corriente y le resta el offset.
     currentAcc += (unsigned long)(adc_raw * adc_raw);  // Guarda las muestras de corriente.
     ++count; prevMicros += sampleInterval;             // Aumenta el contador de muestreo.   
   }
 }
 
 // Calcula el valor RMS de corriente.
 float rms = sqrt((float)currentAcc/(float)numSamples) * (75 / 1024.0); 
 if (rms<0.05){rms=0;} // No lee valores de corriente menores a 100mA. 
 
return rms;

}


