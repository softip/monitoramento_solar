import serial
import time
from enum import Enum

####################################################################################
##   Class Raduino: Realiza a transmissão e recepção dos dados                     #
####################################################################################
class Raduino:

    def __init__(self, porta, id_sensor = 1, id_base = 0):
        self._serial = serial.Serial(porta, 9600, timeout=0.5,parity=serial.PARITY_NONE) # seta valores da serial
        self._id_base = id_base
        self._id_sensor = id_sensor
        self._pacoteTX = {i:0 for i in range(52)}
        self._pacoteRX = {i:0 for i in range(52)}
        self._contadorTX = 0
        self._contadorRX = 0   

    def _clear(self):
        self._pacoteTX = {i:0 for i in range(52)}
        self._pacoteRX = {i:0 for i in range(52)}

    def _put(self, byte, valor):
        self._pacoteTX[byte] = valor
    
    def _put_preambulo(self):
        self._pacoteTX[8] = self._id_sensor
        self._pacoteTX[10] = self._id_base
        self._pacoteTX[13] = self._contadorTX

    def _send(self):
        self._put_preambulo()
        self._serial.flushInput()
        for i in range(0, 52): 
            byteTX = str.encode(chr(self._pacoteTX[i]))
            self._serial.write(byteTX)                  # transmite pacote
        self._contadorTX = self._contadorTX + 1
        time.sleep(1)
        self._clear()

    def request(self):
        self._send()                                   #faz o pedido
        self._pacoteRX = self._serial.read(52)          #le a resposta
        if (len(self._pacoteRX ) == 52):            
            self._contadorRX = self._pacoteRX[12]
            res = Response(self._pacoteRX)                           #cria um objeto para retornar para o usuario
            return res
        else:
            print("Perda de pacote")
            self._serial.flushInput()
            time.sleep(1)
            return None
    
    def close(self):
        if (self._serial.isOpen()):
            self._serial.close()


####################################################################################
##   Class Response: Encapsula a recepção realizada pelo Raduino                   #
####################################################################################
class Response:

    def __init__(self, pacoteRX):
        self.rssid = 0
        self.rssiu = 0
        self._pacoteRX = pacoteRX
        self._calcula_potencia()

    def _calcula_potencia(self):
        rssid = self._pacoteRX[0] # RSSI_DownLink
        rssiu = self._pacoteRX[2] # RSSI_UpLink
        if rssid > 128:
            self.rssid = ((rssid-256)/2.0)-74         
        else:
            self.rssid = (rssid/2.0)-74
        
        if rssiu > 128:
            self.rssiu = ((rssiu-256)/2.0)-74         
        else:
            self.rssiu = (rssiu/2.0)-74
    
    def get(self, sensores):
        adh = self._pacoteRX[sensores.value[1]] # alto
        adl = self._pacoteRX[sensores.value[2]] # baixo
        return ((adh * 256 + adl)/100.0)

    def isError(self, sensores):
        return self._pacoteRX[sensores.value[0]]


####################################################################################
##   Enum Sensores: Simplifica a enumeração das posições do pacoteRX               #
####################################################################################        
class Sensores(Enum):
    TENSAO = (16, 17, 18) #tipo sensor, high e low
    CORRENTE = (19, 20, 21)
    TEMPERATURA = (22, 23, 24)
    LUMINOSIDADE = (25, 26, 27)