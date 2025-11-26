
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
    if musicas == 'guitarra': 
        val1 = '1' 
    elif musicas == 'bateria': 
        val1 = '2' 
    elif musicas == 'saxofone':
        val1 = '3'
    elif musicas == 'piano':
        val1 = '4'
    elif musicas == 'violao':
        val1 = '5'
    elif musicas == 'clarinete':
        val1 = '6' 
    elif musicas == 'violino':
        val1 = '7'  
    elif musicas == 'baixo':
        val1 = '8'
  
        
    arduino.write(val1.encode())


if __name__ == "__main__":
    while True:
        main()
