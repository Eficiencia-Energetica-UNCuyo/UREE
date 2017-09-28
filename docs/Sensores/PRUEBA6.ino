// Programa: Lectura de corriente y temperatura por MQTT.
// Programador: Moyano Jonathan.
// Versión: 0.1

// Características:
// Configuración de SSID,Password,MQTT SERVER,MQTT PORT y MQTT USERNAME vía AP.
// Lectura del sensor de temperatura cada 10 segundos.
// Lectura del sensor de corriente cada 30 segundos.

// Incluye librería para manejar el conversor AD.
#include <MCP3008.h>
// Incluye librería para manejar las comunicaciones por SPI.
#include <SPI.h>

// Configuramos los pines SPI.
MCP3008 adc(D5,D7,D6,D8);

void setup() {

  // Configuramos el puerto serial.
  Serial.begin(115200);
  
}

void loop()
{

  delay(200);
  Serial.print("Corriente en A: ");  
  Serial.print(doubleToStr(readACCurrent(), 2));  
  Serial.print(", Potencia en Watt: ");  
  Serial.println(doubleToStr(currentToPower(readACCurrent()), 2)); 

  }


 // Retorna el valor de corriente alterna medido.
 double readACCurrent()  
 {  
      int analogReadAmplitude = 0, min = 520, max = 0, filter = 10;  
      unsigned long start = millis();  
      do {  
           int val = 0;  
           for (int i = 0; i < filter; i++)  
                val += adc.readADC(0);
           val = (val / filter);       
           if (max < val) max = val;  
           if (val < min) min = val;  
      } while (millis() - start <= 1100/50);     
      analogReadAmplitude = (max - min) / 2;                  
      double sensedVoltage = (analogReadAmplitude * 5000) / 1024;     
      double sensedCurrent = (sensedVoltage /66)-0.5;     
      return sensedCurrent;  
 }


 
 // Función que retorna el valor de la potencia en Watt.
 double currentToPower(double current){  
      return current * 220;  
 }  
 
 // Función que convierte del tipo double a string.
 String doubleToStr(double val, byte precision)  
 {  
      String out = String(int(val));  
      if( precision > 0) {                     
           out += ".";  
           unsigned long frac, mult = 1;  
           byte padding = precision -1;  
           while(precision--) mult *=10;  
           if(val >= 0) frac = (val - int(val)) * mult; else frac = (int(val) - val) * mult;  
           unsigned long frac1 = frac;  
           while(frac1 /= 10) padding--;  
           while(padding--) out += "0";  
           out += String(frac,DEC) ;  
      }  
      return out;  
 }  


