
import mysql.connector

class Banco:
    def conectar(self):
        return mysql.connector.connect(
            host='paparella.com.br',
            user='paparell_deejay',
            password='@Senai2025',
            database='paparell_deejay'
        )

    def sons(self):
        conexao = self.conectar()
        cursor = conexao.cursor()
        # id = 89
        # query = "SELECT nome_som FROM sons where id_som = %s"
        # cursor.execute(query, (id,))
        # valor = cursor.fetchone() # Trazer em formato de lista um dado só
        # # print(valor)

        # musicas = valor
        # # print(musicas)
        
        query = "SELECT * from sons"
        cursor.execute(query)
        valor = cursor.fetchone()
        musicas = valor[1]

        conexao.commit()
        cursor.close()
        conexao.close()
        return musicas


