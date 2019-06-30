from twilio.rest import Client

class Whatsapp:

    def __init__(self):        
        account_sid = '' #utilize os dados de sua conta no twilio
        auth_token = ''  #utilize os dados de sua conta no twilio
        self.client = Client(account_sid, auth_token)
        self.de = 'whatsapp:+14' #informe o número criado pelo twilio para sua conta

    def send(self, para, msg):   
        self.para = "whatsapp:+55" +para #ddd-numero
        message = self.client.messages.create(from_= self.de, body = msg, to = self.para)
        return message.sid