
import mysql.connector

class Banco:
    def conectar(self):
        return mysql.connector.connect(
            host='paparella.com.br',
            user='paparell_deejay',
            password='@Senai2025',
            database='sons'
        )

    def sons(self):
        conexao = self.conectar()
        cursor = conexao.cursor()

        cursor.execute("select * from sons")
        valor = cursor.fetchall()

        musicas = valor[0]

        conexao.commit()
        cursor.close()
        conexao.close()
        print(musicas[2])
        return musicas[2]


