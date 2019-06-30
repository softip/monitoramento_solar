from model import Medicao
import conexao


class MedicaoDAO:

    def __init__(self):
        self.cursor = conexao.banco.cursor()
    
    def inserir(self, medicao):
        query = "INSERT INTO `medicao` (`potencia`, `corrente`, `tensao`,`temperatura`, `luminosidade`, `planta_idplanta`, `timestamp`) VALUES (%s, %s, %s, %s, %s, %s, %s);" 
        valores = (medicao.potencia, medicao.corrente, medicao.tensao, medicao.temperatura, medicao.luminosidade, medicao.instalacao, medicao.tempo.strftime("%Y-%m-%d %H:%M:%S"))
        self.cursor.execute(query, valores)
        conexao.banco.commit()

    def atualizar(self, medicao, instalacao):
        print("Executando o atualizar")
        ultimaMedicao = self.buscaId(instalacao)
        energia = medicao.calcular_energia(ultimaMedicao)
        query = "UPDATE `medicao_realtime` SET `potencia` = %s, `corrente` =%s, `tensao`=%s,`temperatura`=%s, `luminosidade`=%s, `timestamp`=%s, `energia`= %s, `rssii`=%s, `rssiu`=%s where `planta_idplanta`= %s" 
        valores = (medicao.potencia, medicao.corrente, medicao.tensao, medicao.temperatura, medicao.luminosidade, medicao.tempo.strftime("%Y-%m-%d %H:%M:%S"), energia, medicao.rssii, medicao.rssiu, instalacao)
        self.cursor.execute(query, valores)
        conexao.banco.commit()

    def buscaId(self, instalacao):
        query = "SELECT potencia, energia, `timestamp` FROM medicao_realtime  WHERE planta_idplanta = %s" 
        self.cursor.execute(query, (instalacao, ))
        resultado = self.cursor.fetchall()
        return resultado[0] if len(resultado) > 0 else None



class FalhaDAO:

    def __init__(self):
        self.cursor = conexao.banco.cursor()

    def inserir(self, falha):
        query = "INSERT INTO `falhas` (`mensagem`, `planta_idplanta`, `timestamp`, `categoria`) VALUES (%s, %s, %s, %s);" 
        valores = (falha.mensagem, falha.instalacao, falha.tempo.strftime("%Y-%m-%d %H:%M:%S"), falha.categoria)
        self.cursor.execute(query, valores)
        conexao.banco.commit()

    def get_potenciaMinima(self, instalacao):
        query = "SELECT sum(potencia_minima) AS potencia_minima  FROM placas WHERE planta_idplanta = %s GROUP BY planta_idplanta" 
        self.cursor.execute(query, (instalacao, ))
        resultado = self.cursor.fetchone()
        return round(resultado[0],1) if len(resultado) > 0 else None
        

class ClienteDAO:

    def __init__(self):
        self.cursor = conexao.banco.cursor()


    def get_contato(self, instalacao):
        query = "SELECT email, whatsapp FROM cliente INNER JOIN planta ON cliente.idcliente = planta.cliente_idcliente WHERE planta.idplanta = %s" 
        self.cursor.execute(query, (instalacao, ))
        resultado = self.cursor.fetchone()
        return resultado if len(resultado) > 0 else None