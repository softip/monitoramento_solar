// APP : classe da camada de Aplica��o

// Mais informacoes em www.radiuino.cc
// Copyright (c) 2015
// Author: Pedro Henrique Gomes, Omar C. Branquinho, Tiago T. Ganselli e Debora M Ferreira 
// Versao 2.2: 20/01/2015

// Este arquivo e parte da plataforma Radiuino
// Este programa e um software livre; voce pode redistribui-lo e/ou modifica-lo dentro dos termos da Licenca Publica Geral Menor GNU 
// como publicada pela Fundacao do Software Livre (FSF); na versao 2 da Licenca, ou (na sua opniao) qualquer futura versao.
// Este programa e distribuido na esperanca que possa ser  util, mas SEM NENHUMA GARANTIA; sem uma garantia implicita 
// de ADEQUACAO a qualquer MERCADO ou APLICACAO EM PARTICULAR. Veja a Licenca Publica Geral Menor GNU para maiores detalhes.
// Voce deve ter recebido uma copia da Licenca Publica Geral Menor GNU junto com este programa, se nao, escreva para a Fundacao 
// do Software Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    
// This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License 
// as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version. This library 
// is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
// or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License for more details. You should have received a copy 
// of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 51 Franklin St, 
// Fifth Floor, Boston, MA  02110-1301  USA

#include "Headers.h"

/**
 * Construtor da camada de Aplica��o.
 */
APP::APP()
{
}

/**
 * Inicializa a camada de Aplica��o.
 */
void APP::initialize(void) 
{  
  // Faz com que todos os pinos de IO sejam sa�da
  pinMode (IO0_PIN, OUTPUT); 
  pinMode (IO1_PIN, OUTPUT); 
  pinMode (IO2_PIN, OUTPUT); 
  pinMode (IO3_PIN, OUTPUT); 
  pinMode (IO4_PIN, OUTPUT); 
  pinMode (IO5_PIN, OUTPUT);
  
  digitalWrite (IO1_PIN, HIGH);
}

/**
 * Envia o pacote para a camada inferior
 */
inline void APP::send(packet * pkt) 
{    
  return;  
}

/**
 * Recebe o pacote da camada inferior
 */
inline void APP::receive(packet * pkt) 
{
  int AD0, AD1, AD2, AD3, AD4, AD5;
  
  // IO0 - pino 4 do BE900 - no DK101 comanda o led vermelho
  if (pkt->IO0[0] == 1)  // Checa se a vari�vel IO0[0] � igual a 1 para ligar o led no DK101. Este � o byte 34 do pacote
  {
    digitalWrite (IO0_PIN, HIGH); // Liga led vermelho no DK101
  }
  else 
  {
    digitalWrite (IO0_PIN, LOW); // Desliga led vermelhor no DK101
  }
   
  // IO1 - pino 17 para ligar LDR para realizar medida. Portanto para medir a luminosidade no programa do computador o byte 37 deve ser 1.
//  if (pkt->IO1[0] == 1)  // Este � o byte 37
//  {
//    digitalWrite (IO1_PIN, HIGH);
//  }
//  else 
//  {
//    digitalWrite (IO1_PIN, LOW);
//  }

  // IO2 - pino 18 do BE900
  if (pkt->IO2[0] == 1)  // Este � o byte 40
  {
    digitalWrite (IO2_PIN, HIGH);
  }
  else 
  {
    digitalWrite (IO2_PIN, LOW);
  }
 
  // IO3 - No DK101 este IO liga o rel� que est� no pino 8 do BE900
  if (pkt->IO3[0] == 1)  // Este � o byte 43
  {
    digitalWrite (IO3_PIN, HIGH);
  }
  else 
  {
    digitalWrite (IO3_PIN, LOW);
  }

  // IO4 - pino 7 do BE900
  if (pkt->IO4[0] == 1)  // Este � o byte 46
  {
    digitalWrite (IO4_PIN, HIGH);
  }
  else 
  {
    digitalWrite (IO4_PIN, LOW);
  }

  // IO5 - pino 6 do BE900
  if (pkt->IO5[0] == 1)  // Este � o byte 49
  {
    digitalWrite (IO5_PIN, HIGH);
  }
  else 
  {
    digitalWrite (IO5_PIN, LOW);
  }

  // AD0 - pino 15 do BE900
  long somador=0;
  for (int contadorsoma=0; contadorsoma < 10; contadorsoma ++)
  {
    somador=somador + analogRead(AD0_PIN);
  }
  AD0 = int(somador/10); // Valor de 0 a 1023 e ser� necess�rio dois bytes para representar
  pkt->AD0[0] = 0; // Pode ser utilizado para indicar o tipo de sensor no byte 16
  pkt->AD0[1] = (byte) (AD0/256); // Valor inteiro no byte 17
  pkt->AD0[2] = (byte) (AD0%256); // Resto da divis�o noo byte 18
  // No computador para voltar no valor de 0 a 1023 deve ser feita a conta Valor=Inteiro*256+Resto
  
  // AD1 - pino 13 do BE900
  somador=0;
  for (int contadorsoma=0; contadorsoma < 10; contadorsoma ++)
  {
    somador=somador + analogRead(AD1_PIN);
  }
  AD1 = int(somador/10);
  pkt->AD1[0] = 1; // Pode ser utilizado para indicar o tipo de sensor o byte 19
  pkt->AD1[1] = (byte) (AD1/256); // Valor inteiro no byte 20
  pkt->AD1[2] = (byte) (AD1%256); // Resto da divis�o noo byte 21

  // AD2 - pino 12 do BE900
  somador=0;
  for (int contadorsoma=0; contadorsoma < 10; contadorsoma ++)
  {
    somador=somador + analogRead(AD2_PIN);
  }
  AD2 = int(somador/10);
  pkt->AD2[0] = 2; // Pode ser utilizado para indicar o tipo de sensor o byte 22
  pkt->AD2[1] = (byte) (AD2/256); // Valor inteiro no byte 23
  pkt->AD2[2] = (byte) (AD2%256); // Resto da divis�o noo byte 24

  // AD3 - pino 11 do BE900
  somador=0;
  for (int contadorsoma=0; contadorsoma < 10; contadorsoma ++)
  {
    somador=somador + analogRead(AD3_PIN);
  }
  AD3 = int(somador/10);
  pkt->AD3[0] = 3; // Pode ser utilizado para indicar o tipo de sensor o byte 25
  pkt->AD3[1] = (byte) (AD3/256); // Valor inteiro no byte 26
  pkt->AD3[2] = (byte) (AD3%256); // Resto da divis�o noo byte 27

  // AD4 - pino 20 do BE900
  somador=0;
  for (int contadorsoma=0; contadorsoma < 10; contadorsoma ++)
  {
    somador=somador + analogRead(AD4_PIN);
  }
  AD4 = int(somador/10);
  pkt->AD4[0] = 0; // Pode ser utilizado para indicar o tipo de sensor o byte 28
  pkt->AD4[1] = (byte) (AD4/256); // Valor inteiro no byte 29
  pkt->AD4[2] = (byte) (AD4%256); // Resto da divis�o noo byte 30

  // AD5 - pino 19 do BE900
  somador=0;
  for (int contadorsoma=0; contadorsoma < 10; contadorsoma ++)
  {
    somador=somador + analogRead(AD5_PIN);
  }
  AD5 = int(somador/10);
  pkt->AD5[0] = 0; // Pode ser utilizado para indicar o tipo de sensor o byte 31
  pkt->AD5[1] = (byte) (AD5/256); // Valor inteiro no byte 32
  pkt->AD5[2] = (byte) (AD5%256); // Resto da divis�o noo byte 33
  
  // TRANSMITE PACOTE
  Transp.send(pkt);
  
  return;  
}
 
/* Instancia��o do objeto de acesso � classe da camada de Aplica��o */
APP App = APP();
