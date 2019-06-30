import os

class PrintResult:

    def __init__(self):
        self.__f = open("relatorio.html","w+")        

    def set_campi(self, value):
        self.campi = value
    
    def render(self):        
        for campus in self.campi:
            self.create_dir(campus)
            for curso in campus.cursos:
                self.gerar_arquivo_curso(campus, curso)
                self.print_preambulo()
                self.gravar("<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><img class='mx-auto d-block' src='../../logo.jpg'/><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>")
                self.gravar("<h1 class='text-center'>{}</h1><h2 class='text-center'>{}</h2><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>".format(curso.nome, campus.nome))
                self.gravar("<h5 class='text-center'>INCONFIDENTES</h5>")
                self.gravar("<h5 class='text-center'>2019</h5><p>&nbsp;</p><p>&nbsp;</p>")
                self.print_participantes(curso)
                for dimensao in curso.dimensoes:                    
                    self.gravar("\n\t\t\t<strong><h1 class='h4'>{}</h1></strong><hr/>".format(dimensao.nome))
                    self.print_indicadores(dimensao)
                self.print_fragilidades(curso)
                self.print_proposicoes(curso)
                self.print_fecho()

    def create_dir(self, campus):
        if not os.path.exists('./campi/'+campus.nome):
                os.mkdir('./campi/'+campus.nome)


    def gerar_arquivo_curso(self, campus, curso):
        #if not os.path.exists('./campi/'+campus.nome+"/"+curso.nome):
        self.__f = open('./campi/'+campus.nome+"/"+curso.nome+".html","w+")   

    def print_indicadores(self, dimensao):
        for indicador in dimensao.indicadores:
            if (indicador.has_perguntas()):
                self.gravar("\n\t\t\t\t<h2 class='h5'>{}</h2>".format(indicador.nome.rstrip()))
                self.print_perguntas(indicador)

    def print_perguntas(self, indicador):
        if indicador.has_perguntas_tipo(0):
            for pergunta in indicador.perguntas:
                if pergunta.linkert == 0:
                    self.imprimir_tabela2(pergunta)                 

        if indicador.has_perguntas_tipo(1):
            self.gravar("<table class='table table-bordered'><thead><tr><th class='col-lg-9'>Pergunta</th><th class='col-lg-3 text-center'>Rank Médio</th></tr></thead><tbody>")
            for pergunta in indicador.perguntas:
                if pergunta.linkert == 1:
                    self.imprimir_tabela(pergunta)                
            self.gravar("</tbody></table><p>&nbsp;</p>")    


    def imprimir_tabela(self, pergunta):                                                      
        css_class = self.get_classe_css(pergunta) 
        tabela = "<tr><td class='col-lg-9'>{}</td><td class='{} col-lg-3 text-center'>{}</td></tr>".format(pergunta.pergunta, css_class, pergunta.media_linkert)                  
        self.gravar(tabela)   

    def get_classe_css(self, pergunta):
        if(pergunta.media_linkert < 3):
            return "red"
        elif pergunta.media_linkert <= 3.8:
            return "yellow"
        else:
            return "green"
        return ".nada"

    def print_participantes(self, curso):
        self.gravar("<table class='table table-bordered'><thead><tr><th class='col-lg-6'>Curso</th><th class='col-lg-2 text-center'>Aptos</th><th class='col-lg-2 text-center'>Participantes</th><th class='col-lg-2 text-center'>%</th></tr></thead><tbody>")             
        porcentagem = round(curso.entrevistados.participantes / curso.entrevistados.aptos, 2)
        tabela = "<tr><td>{}</td><td>{}</td><td>{}</td><td class='text-center'>{}</td></tr>".format(curso.nome, curso.entrevistados.aptos, curso.entrevistados.participantes, porcentagem)                              
        self.gravar(tabela)
        self.gravar("</tbody></table><p>&nbsp;</p>")

    def print_fragilidades(self, curso):
        if curso.has_fragilidades:
            self.gravar("<strong><h2 class='h4'>4. FRAGILIDADES</h2></strong><hr/><p>&nbsp;</p>")
            self.gravar("<table class='table table-bordered'><thead><tr><th>Dimensao</th><th>Indicador</th><th>Pergunta</th><th>Media</th></tr></thead><tbody>")             
            for fragilidade in curso.fragilidades:
                tabela = "<tr><td>{}</td><td>{}</td><td>{}</td><td>{}</td></tr>".format(fragilidade.dimensao, fragilidade.indicador, fragilidade.pergunta.pergunta, fragilidade.pergunta.media_linkert)                              
                self.gravar(tabela)
            self.gravar("</tbody></table><p>&nbsp;</p>")


    def print_proposicoes(self, curso):
        if curso.has_acoes:
            self.gravar("<strong><h2 class='h4'>5. AÇÕES PROPOSTAS</h2></strong><hr/><p>&nbsp;</p>")

            for acao in curso.acoes:
                self.gravar("<table class='table table-bordered'><tr><th class='col-lg-12 verde'>Ação</th></tr>") 
                self.gravar("<tr><td>{}</td></tr>".format(acao.acao))
                self.gravar("<tr><th class='col-lg-12 verde'>Objetivo</th></tr>")   
                self.gravar("<tr><td>{}</td></tr>".format(acao.objetivo))
                self.gravar("<tr><th class='col-lg-12 verde'>Responsável</th></tr>")
                self.gravar("<tr><td>{}</td></tr>".format(acao.resposavel))   
                self.gravar("<tr><th class='col-lg-12 verde'>Prazo</th></tr>")      
                self.gravar("<tr><td>{}</td></tr>".format(acao.prazo)) 
                self.gravar("</table><p>&nbsp;</p>")


    def imprimir_tabela2(self, pergunta):       
        self.gravar("{}<table class='table table-bordered'><thead><tr><th class='col-lg-10'>Pergunta</th><th class='col-lg-2 text-center'>Total de Discentes</th></tr></thead><tbody>".format(pergunta.pergunta))             
        for reposta in pergunta.respostas: 
            tabela = "<tr><td>{}</td><td class='text-center'>{}</td></tr>".format(reposta.alternativa.rstrip(), reposta.total)                              
            self.gravar(tabela)
        self.gravar("</tbody></table><p>&nbsp;</p>")

    def gravar(self, v):
        self.__f.write(v)

    def print_preambulo(self):
        str = "<html>\n\t<head>\n\t\t<style type='text/css' media='all'>  .verde{background-color:#d9ffb3; -webkit-print-color-adjust: exact !important; color-adjust: exact;} .red{background-color: red !important; -webkit-print-color-adjust: exact !important; color-adjust: exact;} .yellow{background-color: yellow !important; -webkit-print-color-adjust: exact !important; color-adjust: exact;} .green{background-color: green !important; -webkit-print-color-adjust: exact !important; color-adjust: exact;} </style><link rel='stylesheet' href='../../bootstrap.css'  media='all'/><title></title>\n\t\t<meta charset='utf-8'/>\n\t</head>\n\t<body><div class='container'>"
        self.gravar(str)

    def print_fecho(self):
        str = """\n\t</div></body>
        \n</html>
        """
        self.gravar(str)

    def __del__(self):
        self.__f.close()    