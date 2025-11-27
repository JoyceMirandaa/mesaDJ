
from banco_dados import Banco
import serial
import time

porta ="COM5"
baudrate = 115200
arduino = serial.Serial(porta,baudrate,timeout=1)


def main():
    musica_atual =""
    banco = Banco()
    banco.conectar()
    banco.sons()

   
    while True:
        musicas = banco.sons()
        time.sleep(1)
        if musica_atual != musicas: 
            arduino.write(musicas.encode())
            time.sleep(1)
        musica_atual = musicas
            
            
    #     flag = "musica_1"
    #     nova_musica = "musica_1"
    #     if(flag != nova_musica):
    #          
    # elif musicas == 'musica_2': 
    #     flag = "musica_1"
    #     val1 = "2" 
    # elif musicas == 'musica_3':
    #     flag = "musica_1"
    #     val1 = "3"
    # elif musicas == 'musica_4':
    #     flag = "musica_1"
    #     val1 = "4"
    # elif musicas == 'musica_5':
    #     flag = "musica_1"
    #     val1 = "5"
    # elif musicas == 'musica_6':
    #     flag = "musica_1"
    #     val1 = "6" 
    # elif musicas == 'musica_7':
    #     flag = "musica_1"
    #     val1 = "7"  
    # elif musicas == 'musica_8':
    #     flag = "musica_1"
    #     val1 = "8" 
        print(musicas)
        


if __name__ == "__main__":
    while True:
        main()
