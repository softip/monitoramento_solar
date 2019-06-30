import smtplib, ssl
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

class SendMail:

    def __init__(self, user = '', password = ''): #defina um endereço do gmail e sua senha
        self._user = user
        self._password = password

        
    def send(self, to = '', assunto = "assunto", mensagem = "ocorreu um erro"):
        message = MIMEMultipart("alternative")
        message["Subject"] = assunto
        message["From"] = self._user
        message["To"] = to

        # Create the plain-text and HTML version of your message
        text = """\
        {}
        """.format(mensagem)
        html = """\
        <html>
        <body>
            <p>Prezado usuário,<br>
            O sistema de monitoramento está apresentando a seguinte falha: <br />
            {}
            </p>
        </body>
        </html>
        """.format(mensagem)

        # Turn these into plain/html MIMEText objects
        part1 = MIMEText(text, "plain")
        part2 = MIMEText(html, "html")

        # Add HTML/plain-text parts to MIMEMultipart message
        # The email client will try to render the last part first
        message.attach(part1)
        message.attach(part2)

        # Create secure connection with server and send email
        try:
            context = ssl.create_default_context()
            with smtplib.SMTP_SSL("smtp.gmail.com", 465, context=context) as server:
                server.login(self._user, self._password)
                server.sendmail(self._user, to, message.as_string())
        except Exception as e:  
            print ('Falha ao enviar o email',str(e))