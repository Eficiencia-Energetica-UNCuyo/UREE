int pirPin = 8;
int val;

void setup() {
  Serial.begin(9600);
}

void loop() {
  val = digitalRead(pirPin); //read state of the PIR
  
  if (val == LOW) {
    Serial.println("No motion"); //if the value read is low, there was no motion
  }
  else {
    Serial.println("Motion!"); //if the value read was high, there was motion
  }
  
  delay(1000);
}
