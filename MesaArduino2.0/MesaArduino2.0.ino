#include <Arduino.h>
#include <SPI.h>
#include <SD.h>
#include "BluetoothA2DPSource.h"

// Objeto responsável por enviar áudio via Bluetooth A2DP
BluetoothA2DPSource a2dp_source;

const int SD_CS_PIN = 5;   // Pino CS do cartão SD
const int botao0 = 15;
const int botao1 = 34;
const int botao2 = 35;
const int botao3 = 32;
const int botao4 = 33;
const int botao5 = 25;
const int botao6 = 26;
const int botao7 = 27;
const int botao8 = 14;
File currentFile;          // Arquivo WAV atualmente aberto

// Lista de arquivos que correspondem aos comandos 1 a 8
const char* musicFiles[] = {
  "",        // índice 0 não usado
  "/1.wav",  // comando '1'
  "/2.wav",  // comando '2'
  "/3.wav",  // comando '3'
  "/4.wav",
  "/5.wav",
  "/6.wav",
  "/7.wav",
  "/8.wav"
};

volatile bool playing = false;        // Indica se um arquivo está sendo reproduzido
const uint32_t WAV_HEADER_SIZE = 44;  // Tamanho padrão do cabeçalho WAV (44 bytes)

// ---------------------------------------------------------------------
// CALLBACK A2DP - enviado pelo Bluetooth quando precisa de mais áudio
// ---------------------------------------------------------------------
int32_t get_sound_data(uint8_t *data, int32_t byteCount) {

  // Se não está tocando ou arquivo não está aberto → manda silêncio
  if (!playing || !currentFile) {
    memset(data, 0, byteCount); // Preenche com zeros (silêncio)
    return byteCount;
  }

  // Lê o próximo bloco do arquivo WAV
  int32_t readBytes = currentFile.read(data, byteCount);

  // Se chegou ao final do arquivo, completa com silêncio e volta para o início
  if (readBytes < byteCount) {
    memset(data + readBytes, 0, byteCount - readBytes); // preenche o restante com silêncio
    currentFile.seek(WAV_HEADER_SIZE); // volta para depois do cabeçalho → LOOP NA MÚSICA
  }

  // Retorna o tamanho solicitado (o Bluetooth espera exatamente byteCount)
  return byteCount;
}

// ---------------------------------------------------------------------
// FUNÇÃO: TOCAR UM ARQUIVO WAV
// ---------------------------------------------------------------------
void playFile(const char* filename) {
  
  // Se já tinha um arquivo aberto, fecha antes
  if (currentFile) currentFile.close();

  // Abre o novo arquivo do cartão SD
  currentFile = SD.open(filename, FILE_READ);

  // Se não conseguiu abrir → erro
  if (!currentFile) {
    Serial.print("Erro ao abrir: ");
    Serial.println(filename);
    playing = false;
    return;
  }

  // Pula o cabeçalho WAV (os primeiros 44 bytes)
  currentFile.seek(WAV_HEADER_SIZE);

  Serial.print("Tocando: ");
  Serial.println(filename);

  playing = true; // habilita reprodução
}

// ---------------------------------------------------------------------
// FUNÇÃO: PARAR TUDO / SILENCIAR (COMANDO 0)
// ---------------------------------------------------------------------
void stopAll() {
  if (currentFile) currentFile.close(); // fecha o arquivo se aberto
  playing = false;                     // desabilita reprodução
  Serial.println("Silenciado (stop).");
}

// ---------------------------------------------------------------------
// SETUP — configura SD, Bluetooth e começa A2DP
// ---------------------------------------------------------------------
void setup() {
  Serial.begin(115200);
  delay(1000);

  // Inicializa o cartão SD
  Serial.println("Inicializando SD...");
  pinMode(botao0, INPUT);
  pinMode(botao1, INPUT);
  pinMode(botao2, INPUT);
  pinMode(botao3, INPUT);
  pinMode(botao4, INPUT);
  pinMode(botao5, INPUT);
  pinMode(botao6, INPUT);
  pinMode(botao7, INPUT);
  pinMode(botao8, INPUT);
  if (!SD.begin(SD_CS_PIN)) {
    Serial.println("Falha SD!");
    while (true) delay(1000); // trava se SD falhar
  }
  Serial.println("SD OK.");

  // Registra a função de callback que envia dados de áudio
  a2dp_source.set_data_callback(get_sound_data);

  // Inicia transmissão Bluetooth para o dispositivo indicado
  a2dp_source.start("APORO T18");
  Serial.println("Bluetooth iniciado.");
}

// ---------------------------------------------------------------------
// LOOP — aguarda comandos 0 a 8 pela porta serial
// ---------------------------------------------------------------------
void loop() {
  int estado0 = digitalRead(botao0);
  int estado1 = digitalRead(botao1);
  int estado2 = digitalRead(botao2);
  int estado3 = digitalRead(botao3);
  int estado4 = digitalRead(botao4);
  int estado5 = digitalRead(botao5);
  int estado6 = digitalRead(botao6);
  int estado7 = digitalRead(botao7);
  int estado8 = digitalRead(botao8);

	if(estado1 == HIGH){
		int idx = 1;
    playFile(musicFiles[idx]);
	}
  else if(estado2 == HIGH){
		int idx = 2;
    playFile(musicFiles[idx]);
	}
  else	if(estado3 == HIGH){
		int idx = 3;
    playFile(musicFiles[idx]);
	}
  else	if(estado4 == HIGH){
		int idx = 4;
    playFile(musicFiles[idx]);
	}
  else	if(estado5 == HIGH){
		int idx = 5;
    playFile(musicFiles[idx]);
	}
  else	if(estado6 == HIGH){
		int idx = 6;
    playFile(musicFiles[idx]);
	}
  else	if(estado7 == HIGH){
		int idx = 7;
    playFile(musicFiles[idx]);
	}
  else	if(estado8 == HIGH){
		int idx = 8;
    playFile(musicFiles[idx]);
	}
  if (estado0 == HIGH) {
      stopAll();
      return;
    }
  // Se chegou algum caractere serial...
  if (Serial.available()) {
    char c = Serial.read(); // lê o comando

    // ---------- COMANDO '0' = PARAR/SILÊNCIO ----------
    if (c == '0') {
      stopAll();
      return;
    }

    // ---------- COMANDOS '1' A '8' → TOCAR ARQUIVO ----------
    if (c >= '1' && c <= '8') {
      int idx = c - '0';  // converte caractere em número

      Serial.print("Comando recebido: ");
      Serial.println(idx);

      // Toca o arquivo correspondente à posição no array musicFiles
      playFile(musicFiles[idx]);
    }
  }
}
