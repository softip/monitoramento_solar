import serial
from raduino import Raduino, Response, Sensores
from dao import MedicaoDAO, FalhaDAO, ClienteDAO
from model import Medicao, Falha
from whatsapp import Whatsapp
from myemail import SendMail
import zope.event
import time
from datetime import datetime
import termios

ID_SENSOR = 1               #armazena o ID da planta
medicoes = []               #medicoes realizadas, antes de inserir no banco
num_leituras = 3            #número de leituras a ser realizadas
totalPacotesPerdidos = 0    #numero máximo de pacotes perdidos para relatar uma falha
tempo_maximo_para_atualizar = num_leituras * 2
contador_medicoes = 0

#loop principal      
def conectar():
    perda_pacotes = 0
    global totalPacotesPerdidos
    try:
        raduino = Raduino("/dev/ttyUSB0", ID_SENSOR)  #cria um objeto raduino que recebe dados do sensor
        while True:
            res = raduino.request()                   #faz um request solicitando dados do sensor
            if (res):
                zope.event.notify(res)                #informa aos inscritos que os dados do sensor chegaram
                time.sleep(1)                         
                perda_pacotes = 0
                totalPacotesPerdidos = 0
            else:
                totalPacotesPerdidos = totalPacotesPerdidos + 1
                perda_pacotes = perda_pacotes + 1
                if (perda_pacotes > 5):
                    enviar_notificacao(ID_SENSOR, "Muitos pacotes estao sendo perdidos", 'Problemas na comunicação')
                    raduino.close()                   #fecha raduino
                    conectar()                        #(recuperacao de falha) reconecta caso tenha varias perdas de pacotes                    
                if (totalPacotesPerdidos > 10):       #após 10 pacotes perdidos envia notificacao por email
                    enviar_notificacao(ID_SENSOR, "A base nao consegue se conectar com os sensores", 'Falha de comunicação')
                    exit()
    except KeyboardInterrupt:        
        raduino.close()
    except termios.error:
        enviar_notificacao(ID_SENSOR, "A base nao consegue se conectar com os sensores", 'Falha de comunicação')
    except serial.SerialException as e:
        enviar_notificacao(ID_SENSOR, "A base nao consegue se conectar com os sensores", 'Falha de comunicação')


#adiciona inscritos - funcões que esperam a resposta 
#do nó sensor para realizar processamento
def add_subscribes():
    zope.event.subscribers.append(log)
    zope.event.subscribers.append(registra_medicao)

##leitura de dados do raduino
def log(res):
    tensao = res.get(Sensores.TENSAO)
    corrente = res.get(Sensores.CORRENTE)
    temperatura = res.get(Sensores.TEMPERATURA)
    print("Tensao ", tensao, " Corrente ", corrente, "Temperatura", temperatura, "RSSIu", res.rssiu, "RSSIi", res.rssid)

#faz media dos valores lido
def registra_medicao(res):
    global medicoes
    global contador_medicoes
    contador_medicoes = contador_medicoes + 1
    tensao = res.get(Sensores.TENSAO)
    #corrente = 1
    corrente = res.get(Sensores.CORRENTE)    
    temperatura = res.get(Sensores.TEMPERATURA)
    luminosidade = 0
    tempo = datetime.now()
    medicao = Medicao(ID_SENSOR, tensao, corrente, temperatura, luminosidade, tempo, res.rssid, res.rssiu)
    
    if (len(medicoes) == 0 or medicao != medicoes[-1]):
        medicoes.append(medicao)
        dao = MedicaoDAO()
        dao.atualizar(medicao, ID_SENSOR)          # atualiza a medica
    
    ##se o vetor de medicoes foi preenchido ou se apos o tempo determinado não foi possivel preencher o vetor
    #atualiza a informação no banco de dados
    if(len(medicoes) == num_leituras or contador_medicoes == tempo_maximo_para_atualizar): 
        contador_medicoes = 0
        media_medicao = calcula_media_medicoes()
        save(media_medicao)                                   #registra a medicao no banco
        verificar_falhas(media_medicao)                       #verifica se houve falha 

def calcula_media_medicoes():
    global medicoes 
    saveMedicao = medicoes.pop(0)
    for potencia in medicoes:
        #somatorio das medidas
        saveMedicao.tensao = saveMedicao.tensao + potencia.tensao
        saveMedicao.corrente = saveMedicao.corrente + potencia.corrente
        saveMedicao.potencia = saveMedicao.potencia + potencia.potencia
        saveMedicao.temperatura = saveMedicao.temperatura + potencia.temperatura
        saveMedicao.luminosidade = saveMedicao.luminosidade + potencia.luminosidade
    #faz a media    
    #n_medidas = len(medicoes) if len(medicoes) != 0 else 1
    saveMedicao.tensao = saveMedicao.tensao / num_leituras 
    saveMedicao.corrente = saveMedicao.corrente / num_leituras
    saveMedicao.potencia = saveMedicao.potencia / num_leituras
    saveMedicao.temperatura = saveMedicao.temperatura / num_leituras 
    saveMedicao.luminosidade = saveMedicao.luminosidade / num_leituras
    medicoes.clear()
    return saveMedicao


#salva no banco de dados
def save(medicao):    
    dao = MedicaoDAO()
    dao.inserir(medicao)

#verifica se houve falhas
def verificar_falhas(medicao):    
    dao = FalhaDAO()   
    potencia_minima =  dao.get_potenciaMinima(ID_SENSOR)
    print("Potencia minima", potencia_minima)
    if (medicao.potencia <= potencia_minima):
        print("Ocorreu uma falha", potencia_minima)
        msg = "A potência dos paineis esta abaixo do mínimo."
        enviar_notificacao(ID_SENSOR, msg, 'Falha na usina solar',medicao) 
           

#envia notificacoes de falha pelo whatsapp, email e registra no banco
def enviar_notificacao(sensor, msg, categoria, medicao = None):
    clienteDao = ClienteDAO()
    contato = clienteDao.get_contato(sensor)
    toemail = contato[0]
    fone = contato[1]

    if(fone):
        print('mensagem enviada whatsapp')
        #whats = Whatsapp()
        #whats.send(str(fone), msg)

    if(toemail):
        print('email enviado')
        semail = SendMail()
        semail.send( toemail, "Falha sistema monitoramento solar", msg)

    dao = FalhaDAO()
    falha = Falha(ID_SENSOR, msg, datetime.now(), categoria)
    dao.inserir(falha)

    #faz a medicao ser 0 houver erro
    if(medicao is None):
        tempo = datetime.now()
        medicao = Medicao(ID_SENSOR, 0, 0, 0, 0, tempo, 0, 0)  
    
    dao = MedicaoDAO()
    dao.atualizar(medicao, ID_SENSOR)  

#inicio
add_subscribes()
conectar()
