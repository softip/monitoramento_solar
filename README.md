# Monitoramento Solar

Matéria: IE309X 

Nome                       |RA	 
---------------------------|------
Eloísa A. N. Matthiesen	   |208929
Rafael Augusto Pedriali    |190742
Dimas Augusto Mendes Lemes |163660 
Ivan Paulino Pereira       |262125	


## Introdução 
Diante das novas formas de se usarem os dispositivos eletrônicos, novas tecnologias foram sendo desenvolvidas e adaptadas para as novas funcionalidades. A busca por maiores taxas de transmissão de dados, visando formas de conexão que minimizem custos de projeto, que diminuam a necessidade de alta potência na transmissão e aumentem as áreas de cobertura sendo confiáveis vêm produzindo resultados nos meios industrial e acadêmico. Estas tecnologias estão relacionadas ao conceito de Internet das Coisas. 

A Internet das Coisas, representada pela sigla IoT (Internet of Things), é definida de acordo com a União Internacional das Telecomunicações como uma infraestrutura global que habilita serviços avançados por meio da interconexão entre coisas, ditas físicas ou virtuais, com base nas tecnologias de informação e comunicação. Ou seja, a ideia é conectar coisas, objetos do dia-a-dia, dotando-os de capacidade de processar dados. Dessa forma, uma solução em IoT deve atender a três pré-requisitos. São eles: Reconhecimento de dados, Conexão a uma rede e a Capacidade de processar os dados sem que haja interferência humana. 
A aplicação de IoT pode trazer benefícios aos cidadãos, à gestão pública, como questões envolvendo segurança, transporte e eficiência energética, que também é benéfica ao meio ambiente. A questão ambiental também é um fator relevante devido às fontes de energia renováveis, dentre elas a energia solar. 
A energia solar pode ser usada como fonte de energia elétrica e tem a vantagem de ser uma das mais limpas formas de geração de energia existentes no mundo. É utilizada em tecnologias como arquitetura solar, fotossíntese artificial, aquecimento solar, energia heliotérmica e energia solar fotovoltaica. Especificamente no caso da energia solar fotovoltaica, a luz do sol é captada por meio de painéis solares que tem por finalidade realizar a conversão da energia luminosa em energia elétrica. Nesse processo é possível criar uma rede IoT em que os painéis solares estejam conectados a dispositivos de comunicação que traduzam, por exemplo, ao consumidor a capacidade de geração de energia elétrica do sistema, buscando minimizar custos. 

## Objetivo 
Desenvolver uma Rede de Sensor Sem Fio (RSSF) para monitoramento da geração de energia em painéis solares. Serão coletados os valores da tensão e corrente, enviando-os para um banco de dados, sendo possível ter o completo gerenciamento dos dados coletados. A comunicação será realizada por meio de módulos de comunicação BE900.

## Material 

Item |Uni |Quant |Descrição                          |Unitário   |Total
:---:|:--:|:----:|-----------------------------------|----------:|--------:
1    |UN  |2     |Módulos de comunicação BE900       |R$   180,00|R$ 360,00
2    |UN  |1     |UARTsBee                           |R$   127,00|R$ 127,00
3    |UN  |2     |Antenas omnidireccional de 2,15 dBi|R$    29,00|R$  58,00
4    |UN  |1     |Placa de desenvolvimento DK 107    |R$   165,00|R$ 165,00
5    |UN  |1     |Raspberry Pi                       |R$   290,00|R$ 290,00
6    |UN  |1     |Sensor Allegro ACS712              |R$    26,90|R$  26,90
7    |UN  |1     |Amplificador LM324                 |R$    12,00|R$  12,00
### Total                              R$ 1.038,90 

## Cronograma
Ativid. \ Mês                      |Março |Abril |Maio  |Junho
-----------------------------------|:----:|:----:|:----:|:----:
Estudo do Tema                     |X     |      |      |
Elaboração do Projeto              |X     |      |      |
Seleção e Obtenção dos Componentes |X     |      |      |
Montagem                           |X     |X     |X     |  
Desenvolvimento do Software        |X     |X     |X     |
Testes                             |      |      |X     |
Elaboração do Relatório Final      |      |      |      |X
Apresentação Final                 |      |      |      |X


## Questão a)

### Nível 7 – Negócio
O negócio contemplado nesse projeto foi a geração fotovoltaica construída na Unicamp, um subprojeto do Campus Sustentável. Ao todo será instalado 573 kWp de geração no campus, focaremos na microgeração instalada na FEEC - Faculdade de Engenharia Elétrica e de Computação, com 97 kWp.
### Nível 6 – Exibição
Nesse nível irá apresentar gráficos para os estudantes e funcionários da Unicamp, mostrando o nível de geração da FEEC e o quanto isso significa no uso total da energia do campus. Nesse nível é necessário definir quais são as regras do negócio, quais os alarmes e alertas que serão criados durante o projeto.
### Nível 5 – Abstração
A abstração é feita com a ajuda de um especialista, qual a tensão nominal da placa fotovoltaica, qual a eficiência da mesma? Essas questões são resolvidas utilizando um especialista. No caso do projeto, o especialista pode ser algum professor com conhecimento na área que pode ajudar o grupo.
### Nível 4 – Storage
O armazenamento dos dados, no primeiro momento, será feito localmente, mas tendo a possibilidade de enviar os dados para a nuvem. É preciso definir a quantidade de dados que será armazenada e com qual frequência.
### Nível 3 – Borda
O elemento de borda é responsável pela conexão da RSSF à Internet. Ele será realizado através de uma Raspberry Pi 3.
### Nível 2 – Conectividade
A conectividade será feita por meio de uma RSSF, com módulos de comunicação compostos por um microcontrolador Atmega328 e um transceptor CC1101. Uma placa de desenvolvimento DK107 no Nó Sensor e um programador UARTsBee para a Estação Rádio Base (ERB).
### Nível 1 – Nó Local Sensor/Atuador
Utilizaremos a plataforma Radiuino para criar os firmwares dos Nós. Para medir a tensão da placa será usado o DK107, em conjunto com um divisor de tensão, e a corrente será medida através de um sensor de efeito hall, Allegro ACS712.
Nível 0 – Coisas
A coisa desse projeto é a placa fotovoltaica, utilizada na microgeração da FEEC.


## Questão b)

### b.1) 
As variáveis da "coisa" que devem ser medidas são a corrente e a tensão do painel fotovoltaico durante o tempo, para assim poder calcular a energia produzida pela mesma.

### b.2) 
Primeiramente, são analisadas as especificações dos painéis solares, pois é necessário saber a faixa de operação do equipamento para a adequada elaboração e desenvolvimento do projeto.

Painel                              |Potência (W)|Tensão (V)|Corrente (A)
------------------------------------|:----------:|:--------:|:----
Yingli JS150                        |150         |18.5      |8.12
Kyocera KD140SX                     |140         |17.7      |7.91
Komaes KMP150                       |150         |18.28     |8.21
Canadian Solar CS6K 260P            |260         |30.40     |8.56
Canadian Solar CS6K 275P            |275         |31        |8.88
UPSolar M150P                       |150         |18.06     |8.07
UPSolar M315P                       |315         |36.5      |8.63
 
 
Com esta tabela é possível dimensionar um array  de placas que pode para ser projetado seguindo as especificações do sensor Allegro ACS712, o qual é apresentado no próximo item.
 
### b.3) 
Após realizar uma pesquisa de mercado foi observado que a melhor opção para poder realizar as medidas da corrente é com o sensor Allegro ACS712, o qual pode ser visto na figura a seguir.

![alt text](https://intranet.ifs.ifsuldeminas.edu.br/ivan.pereira/.icones/alegro_sensor.jpg)
 
Este sensor é classificado como invasivo, ou seja, é necessário abrir o circuito para fazer a medição.  Além disso, ao adicioná-lo ao circuito provoca uma baixa queda de tensão durante a medição, devido a sua resistência interna ser de apenas 1,2 mOhm. Possui fundo de escala de -30 A até 30 A tanto para corrente contínua como para alternada, com uma sensibilidade de aproximadamente 0,066 mV/A. A medição ocorre por meio do efeito hall para detectar o campo magnético gerado pela corrente.
 
A de tensão a ser medida será realizada diretamente, mas como a entrada pino de medição não deve possuir uma tensão maior do que 5V. Então será realizado um divisor de tensão para abaixar a tensão gerada. Este circuito é isulatrado a fingura a seguir.

![alt text](https://intranet.ifs.ifsuldeminas.edu.br/ivan.pereira/.icones/divisor_resistivo.jpg)

O capacitor tem o objetivo de eliminar possíveis ruídos na medição.

Outra medida a ser informada é a temperatura, pois apesar do aumento na irradiação solar sobre a placa fotovoltaica fornecer mais energia, o aumento da temperatura da placa danifica-a. O sensor utilizado para a medição é o LM35DZ encapsulado (proteção contra fatores adversos, como a chuva).

### b.4) 
O circuito esquemático do sensor é apresentado na figura a seguir

![alt text](https://intranet.ifs.ifsuldeminas.edu.br/ivan.pereira/.icones/esquema_logico.jpg)

Onde,
Vcc, é o pino de alimentação do circuito, em que será utilizado uma bateria para poder alimentá-lo.
Viout é o pino que informa os dados da corrente e tensão medidos
GND é o pino terra
Os pinos IP+ e IP-  conectam-se em série ao circuito que deverá ser medido.

### b.5) 
No site da Allegro, empresa responsável pela fabricação do sensor, há uma página de FAQ. Perguntaram qual a menor corrente que pode ser medida pelo ACS712, foi respondido que a sua resolução é determinada pelo nível de ruído, mostrando assim uma tabela das características de filtros que podem ser aplicadas.

![alt text](https://intranet.ifs.ifsuldeminas.edu.br/ivan.pereira/.icones/tabela.jpg)




Dependendo do valor da corrente que será necessário medir, é necessário alterar o capacitor utilizado.






