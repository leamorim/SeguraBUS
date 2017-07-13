///bibliotecas do GPS
#include <SoftwareSerial.h>
#include <TinyGPS.h>
#include <SPI.h>
#include <Ethernet.h>

//informações do ônibus
char linha[] = "303";
char onibus[] = "7007";

///informações para conexão com o servidor
byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
byte ip[] = { 10, 0, 0 , 104 };
byte servidor[] = { 10, 0, 0, 101};

EthernetClient cliente;

//GPS
SoftwareSerial serial1(8, 9); // RX, TX
TinyGPS gps1;

const int buttonPin1 = 6;     // Pino Botao de ativacao
const int ledPin =  7;      // Pino LED branco
const int ledPin2 = 3;      // Pino LED vermelho

byte desativador = 1; // variavel de controle do alerta
bool conexao = TRUE;

void setup() {

  Serial.begin(9600);//serial pra printar
  serial1.begin(9600);//comunicacao serial do GPS
  Ethernet.begin(mac, ip);

  // initialize the LED pin as an output:
  pinMode(ledPin, OUTPUT);//LED branco
  pinMode(ledPin2, OUTPUT);//LED vermelho
  pinMode(buttonPin1, INPUT);//botao para ativação do alarme
}


void loop() {
  
  long latitude, longitude;//variáveis do GPS
  String DatEth;//variável para interpretação da string

  /// Espera o botao ser apertado
  Serial.println("Esperando apertar o botao");
  while (digitalRead(buttonPin1) == LOW) {//Estado de esperar apertar o botão

  }

  Serial.print("Botao apertado");
  delay(200);
  Serial.print(".");
  delay(200);
  Serial.print(".");
  delay(200);
  Serial.println(".");
  delay(200);
  Serial.println("Conectando..");
  
  if (cliente.connect(servidor, 80)) { //estado de teste de conexão
    cliente.println("GET segurabus/PHP/wfile.php?msg=ledon");
    Serial.println("Conectado");
    Serial.println("Alarme Ativado com Sucesso!");
    digitalWrite(ledPin, HIGH);   // acende o LED para indicar que a informação está sendo enviada
    conexao = TRUE;
  }
  else {
    Serial.println("Sem conexao!");
    
    for (int i = 0; i < 19; i++) {
      Serial.println("Tentando conectar !");
      if (cliente.connect(servidor, 80)) {
        cliente.println("GET segurabus/PHP/wfile.php?msg=ledon");
        Serial.println("Alarme Ativado com Sucesso!");
        digitalWrite(ledPin, HIGH);
        digitalWrite(ledPin2, LOW);
        conexao = TRUE;
        break;
      }
      else{
        for(int i = 0; i < 8;i++){//loop apenas para passar o tempo de tentar enviar novamente
            digitalWrite(ledPin2, HIGH);
            delay(2000);
            digitalWrite(ledPin2, LOW);
            delay(2000);
        }
      }
    }
    conexao = FALSE;
  }

  cliente.stop();

  if(conexao){

  Serial.println("Enviando a informacao");
  //Aqui seria onde esperaríamos o sinal vindo do monitoramento para desativar o alerta
  while (!desativador == 0) {
    //Aqui deveria enviar a informação e esperar o sinal para desativar o alarme
    if (cliente.connect(servidor, 80)) {//talvez n precise
      Serial.println("conectado");

      // Make a HTTP request:
      cliente.println("GET segurabus/PHP/volta.php");
      delay(600);
      while (cliente.available()) {
        // Serial.println("WHILE");
        char c = cliente.read();
        Serial.print(c);
        DatEth.concat(c);
        if (DatEth.endsWith("/ledon")) {
          desativador = 1;
          break;
        }
        if (DatEth.endsWith("/ledof")) {
          desativador = 0;
          break;
        }
      }
      cliente.stop();
    }
    else {
      Serial.println("Não conectou !");
      cliente.stop();
    }


    bool recebido = false;
    while (serial1.available()) {
      char cIn = serial1.read();
      recebido = gps1.encode(cIn);
      recebido = true;

    }

    if (recebido) {
      Serial.println("----------------------------------------");

      //Latitude e Longitude
      unsigned long idadeInfo;
      gps1.get_position(&latitude, &longitude, &idadeInfo);

      if (latitude != TinyGPS::GPS_INVALID_F_ANGLE) {
        Serial.print("Latitude: ");
        Serial.println(float(latitude) / 100000, 6);
      }

      if (longitude != TinyGPS::GPS_INVALID_F_ANGLE) {
        Serial.print("Longitude: ");
        Serial.println(float(longitude) / 100000, 6);
      }

      if (idadeInfo != TinyGPS::GPS_INVALID_AGE) {
        Serial.print("Idade da Informacao (ms): ");
        Serial.println(idadeInfo);
      }
    }
    else{//caso o GPS não esteja funcionando
      latitude = 0.0000000;
      longitude = 0.0000000;
    }
    
      if (cliente.connect(servidor, 80)) {
        // Make a HTTP request:
        cliente.print("GET segurabus/PHP/salvardados.php?");
        cliente.print("latitude=");
        cliente.print(float(latitude) / 100000, 6);
        cliente.print("&longitude=");
        cliente.print(float(longitude) / 100000, 6);
        cliente.print("&linha=");
        cliente.print(linha);
        cliente.print("&onibus=");
        cliente.print(onibus);
        cliente.print("&status=");
        cliente.println(desativador);

        Serial.print("linha=");
        Serial.println(linha);
        Serial.print("onibus=");
        Serial.println(onibus);
        Serial.print("status=");
        Serial.println(desativador);
        

        cliente.stop();
      }
      else {
        cliente.stop();
      }
      
    delay(5000);//tempo de enviar outro dado
  }
  desativador = 1;//variável de controle do loop
  /////Chega nessa parte quando o alarme for desativado

  digitalWrite(ledPin, LOW);
  delay(100);
  Serial.println("Alarme Desativado !");
  }

  //delay(1000);

}


