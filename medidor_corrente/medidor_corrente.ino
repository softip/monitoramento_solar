#define ADC 0.0048828125 

float mv_sem_corrente = 0;

void setup()
{
  Serial.begin(9600);
  pinMode(A0, INPUT);
  mv_sem_corrente = calibra_sensor();
}

float calibra_sensor(){
  Serial.println("Calibrando o sensor - Desligue a corrente");
  delay(1000);

  float valor_medio =0;
  for (int i = 0; i < 300; i++){    
     int byte_lido = analogRead(A0);
     float mv_lido = byte_lido * ADC ;//byte_lido * (5v / 1024 ou 10bits adc) 
     valor_medio = valor_medio + mv_lido;
     delayMicroseconds(600);
  }

  valor_medio = valor_medio / 300;
  return valor_medio;  
}

float get_amperes(){
   int byte_lido = analogRead(A0);
   float mv_lido = byte_lido * 0.0048828125 ;//byte_lido * (5v / 1024 ou 10bits adc) 
   float amp = (mv_lido - 2.5) / 10;
   //amp = amp * 1000; //convertendo para milivolt
   //amp = amp /100; //sensibilidade do sensor
   return amp;
}
 
void loop()
{
   float amp = 0;
   
   for (int i = 0; i<300; i++){
      amp = amp + get_amperes();
      delayMicroseconds(600);
   }
   amp =amp / 300;
   
   Serial.print("Valor: ");
   Serial.println(amp);
   delay(500);
}
