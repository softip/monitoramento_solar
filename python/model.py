from decimal import Decimal
from datetime import datetime

#MEDICAO ######################################
class Medicao:
    
    def __init__(self, instalacao, tensao, corrente, temperatura = 0, luminosidade = 0, tempo = 0, rssii = 0, rssiu = 0):
        self.instalacao = instalacao
        self.tensao = tensao
        self.corrente = corrente
        self.potencia = tensao * corrente
        self.temperatura = temperatura
        self.luminosidade = luminosidade
        self.rssii = rssii
        self.rssiu = rssiu
        self.tempo = tempo

    def calcular_energia(self, last):
        if (last):
            last_potencia = last[0]
            last_energia = last[1]
            last_time = last[2]            
            tempo = self.tempo - last_time               
            energia = (self.potencia + last_potencia) * tempo.total_seconds() / 2               
            return (last_energia + energia)             
        else:
            return 0

    def __eq__(self, other):
        return  (round(other.potencia,1) == round(self.potencia,1))           

#FALHAS ######################################
class Falha:
    
    def __init__(self, instalacao, mensagem, tempo, categoria):
        self.instalacao = instalacao
        self.mensagem = mensagem
        self.tempo = tempo                            
        self.categoria = categoria