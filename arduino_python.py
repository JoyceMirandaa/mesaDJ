
import serial

porta ="COM3"
baudrate = 9600
arduino = serial.Serial(porta,baudrate,timeout=1)

def main():
    resposta = arduino.readline().decode().strip()
    print(f"ESTADO LED => {resposta}")

if __name__ == "__main__":
    while True:
        main()