void setup() {
  // put your setup code here, to run once:
  pinMode(A0, INPUT);
  Serial.begin(9600);
}

void loop() {
  float v = analogRead(A0);
  float tensao = 0;
  
  for(int i= 0; i < 300; i++){
     tensao = tensao + (v * 0.0048828125)* 2.5 ;
     delayMicroseconds(600);
  }  
  tensao = tensao / 300;
    
  Serial.print(tensao);
  Serial.println("v");
  delay(1000);

}
