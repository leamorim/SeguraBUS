///bibliotecas do GPS
#include <SoftwareSerial.h>
#include <TinyGPS.h>
#include <SPI.h>
#include <Ethernet.h>

char linha[] = "303";
char onibus[] = "7007";



byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };
byte ip[] = { 10, 0, 0 , 104 };
byte servidor[] = { 10, 0, 0, 103};

EthernetClient cliente;

//GPS
SoftwareSerial serial1(8, 9); // RX, TX
TinyGPS gps1;

const int buttonPin1 = 6;     // the number of the pushbutton1 pin
const int buttonPin2 = 5;     // the number of the pushbutton2 pin
const int ledPin =  7;      // the number of the LED pin
const int ledPin2 = 3;      // the number of the LED pin
byte desativador = 1;

void setup() {

  Serial.begin(9600);//serial pra printar
  serial1.begin(9600);//comunicacao serial do GPS
  Ethernet.begin(mac, ip);

  // initialize the LED pin as an output:
  pinMode(ledPin, OUTPUT);
  pinMode(ledPin2, OUTPUT);
  // initialize the pushbutton pin as an input:
  pinMode(buttonPin1, INPUT);
  pinMode(buttonPin2, INPUT);
}

void loop() {
  String DatEth;

  /// Espera o botao ser apertado
  Serial.println("Esperando apertar o botao");
  while (digitalRead(buttonPin1) == LOW) {

  }

  if (cliente.connect(servidor, 80)) { //fazer a lógica de teste da conexão aqui
    cliente.println("GET /PHP/wfile.php?msg=ledon");
    Serial.println("Alarme Ativado com Sucesso!");
  }
  else {
    Serial.println("Nao conectou!");
    for (int i = 0; i < 19; i++) {
      if (cliente.connect(servidor, 80)) {
        cliente.println("GET /PHP/wfile.php?msg=ledon");
        Serial.println("Alarme Ativado com Sucesso!");
        digitalWrite(ledPin2, HIGH);
        break;

      }
      digitalWrite(ledPin2, HIGH);
      delay(1000);
    }
  }

  cliente.stop();

  digitalWrite(ledPin2, LOW);

  Serial.print("Botao apertado");
  delay(200);
  Serial.print(".");
  delay(200);
  Serial.print(".");
  delay(200);
  Serial.println(".");
  delay(200);
  // acende o LED para indicar que a informação está sendo enviada
  digitalWrite(ledPin, HIGH);

  Serial.println("Enviando a informacao");
  //Aqui seria onde esperaríamos o sinal vindo do monitoramento para desativar o alerta
  while (!desativador == 0) {
    //Aqui deveria enviar a informação e esperar o sinal para desativar o alarme
    if (cliente.connect(servidor, 80)) {//talvez n precise
      Serial.println("conectado");

      // Make a HTTP request:
      cliente.println("GET /PHP/volta.php");
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
    
    if(!serial1.available){
    
      
    }



    if (recebido) {
      Serial.println("----------------------------------------");

      //Latitude e Longitude
      long latitude, longitude;
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

      if (cliente.connect(servidor, 80)) {
        // Make a HTTP request:
        cliente.print("GET /arduino/segurabus/salvardados.php?");
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

    }
    delay(2000);
  }
  desativador = 1;//variável de controle do loop
  /////Chega nessa parte quando o alarme for desativado

  digitalWrite(ledPin, LOW);
  delay(100);
  Serial.println("Alarme Desativado !");


  //delay(1000);

}


