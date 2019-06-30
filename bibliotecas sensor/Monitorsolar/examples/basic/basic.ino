#include <Monitorsolar.h>

Monitorsolar monitor(A0, A1, A2, A4, A5, 50);

void setup() {
  Serial.begin(9600);
}

void loop() {
  float tensao = monitor.readTensao();
  Serial.print("Tensao ");
  Serial.println(tensao);

  float corrente = monitor.readCorrente();
  Serial.print("Corrente ");
  Serial.println(corrente);

   float temperatura = monitor.readTemperatura();
  Serial.print("Temperatura ");
  Serial.println(temperatura);

  delay(800);

}
