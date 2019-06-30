#ifndef Monitorsolar_h
#define Monitorsolar_h

#include "Arduino.h"
#include "math.h"


class Monitorsolar {
  public:
    Monitorsolar(int pinTensao, int pinCorrente, int pinTemperatura, int num_medidas);
    float readTensao();
    float readCorrente();
    float readTemperatura();
    float readLuminosidade(float v[]);
  private:
    int _pinT;
    int _pinC;
    int _pinTemp; 
      
    int _num_medidas;
    float _vTensoes[]; 
    float _vCorrentes[]; 
    float _vTemperaturas[]; 

    
    float mim_max(float valor, float minimum, float maximum);
    float media(float v[]);
    void devio_padrao(float v[], float *media, float *desvio_padrao);
    float media_zscore(float v[], float media, float std);
};

#endif
