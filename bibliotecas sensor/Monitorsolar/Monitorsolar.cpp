#include "Arduino.h"
#include "Monitorsolar.h"

//Construtor --------------------------
Monitorsolar::Monitorsolar(int pinTensao, int pinCorrente, int pinTemperatura, int num_medidas) {
  _pinT = pinTensao;
  _pinC = pinCorrente;
  _pinTemp = pinTemperatura;

  _num_medidas = num_medidas;
  _vTensoes[_num_medidas];
  _vCorrentes[_num_medidas];
  _vTemperaturas[_num_medidas]; 

  for(int i = 0 ; i < _num_medidas; i++){
      _vTensoes[i] = 0;
      _vCorrentes[i] = 0;
      _vCorrentes[i] = 0;
      _vTemperaturas[i] = 0; 
  } 
  
}


float Monitorsolar::readTensao() {
  analogRead(_pinT); //Descarte - Evita bug do uno em leitura de multiplos pinos analogicos
  int rawADC = analogRead(_pinT);
  for (int i = 0; i < _num_medidas; i++) {    
        _vTensoes[i] = (float) rawADC / 1023.0 * 5.0  * 10.1;  
        delayMicroseconds(500);
  }
  return mim_max(media(_vTensoes), 0.0, 50.5);
}

float Monitorsolar::readCorrente() {
  analogRead(_pinC); //Descarte - Evita bug do uno em leitura de multiplos pinos analogicos
  int rawADC = analogRead(_pinC);
  for (int i = 0; i < _num_medidas; i++) { 
       _vCorrentes[i] = (((float)rawADC / 1023.0 * 5.0) - 2.5) * 10.0;   
       delayMicroseconds(500);
   }
   return mim_max(media(_vCorrentes), 0, 20);
}


float Monitorsolar::readTemperatura() {
  analogRead(_pinTemp); //Descarte - Evita bug do uno em leitura de multiplos pinos analogicos
  int rawADC = analogRead(_pinTemp);
  for (int i = 0; i < _num_medidas; i++) {    
        _vTemperaturas[i] = ((float)rawADC / 1023.0 * 5.0) / 0.01;  
        delayMicroseconds(500);
  }
  return mim_max(media(_vTemperaturas), 0, 60);
}

float Monitorsolar::readLuminosidade(float v[]) {
   return mim_max(media(v), 0.0, 65000);
}

float Monitorsolar::mim_max(float valor, float minimum, float maximum){
   if (valor < minimum){
       return minimum;
   }else if(valor > maximum){
       return maximum;
   }else{
       return valor;
   }
}

float Monitorsolar::media(float v[]){
  float media = 0.0;
  float std = 0.0;
  devio_padrao(v, &media, &std);
  if (std == 0){
    return media;
  }else{
    return media_zscore(v, media, std);
  }
}

void  Monitorsolar::devio_padrao(float v[], float *media, float *desvio_padrao){
  float somatorio = 0.0;
   for(int i =0; i < _num_medidas; i++){     
      *media = *media + v[i];
   }
   *media = *media / _num_medidas;
   for(int i=0; i < _num_medidas; i++){
     somatorio = somatorio + pow((v[i] - *media), 2);
   }   
   *desvio_padrao = sqrt((somatorio / _num_medidas));
}

float Monitorsolar::media_zscore(float v[], float media, float std){
  float count = 0.0;
    float somatorio = 0.0;
    for(int i =0; i< _num_medidas; i++){
      float score = ((v[i] - media) / std);
      
      if (score <= 3 && score >= -3){
         somatorio = somatorio + v[i];
         count++;
      }
    }
  return somatorio / count;
}
