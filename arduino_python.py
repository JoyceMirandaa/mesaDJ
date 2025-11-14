
from banco_dados import Banco
import serial

porta ="COM3"
baudrate = 9600
arduino = serial.Serial(porta,baudrate,timeout=1)


def main():
    nome_aluno = 'Joyce'
    banco = Banco()
    banco.conectar()
    banco.sons()

    musicas = banco.sons()
    if musicas == 'kick': 
        val1 = '1' 
    elif musicas == 'snare': 
        val1 = '2' 
    elif musicas > 'hihat':
        val1 = '3'
    elif musicas > 'clap':
        val1 = '4'
    elif musicas > 'bass':
        val1 = '5'
    elif musicas > 'synth':
        val1 = '6' 
    elif musicas > 'lead':
        val1 = '7'  
    elif musicas > 'chord':
        val1 = '8'
  
        
    arduino.write(val1.encode())


if __name__ == "__main__":
    while True:
        main()
