import mysql.connector
import platform

class DatabaseManager:
    def __init__(self):
        if platform.system() == "Windows":
            host="localhost"
            user="root"
            password=""
            database="documind"
        else:
            host="db5018917755.hosting-data.io"
            user="dbu3738302"
            password="78Agracian#J(L"
            database="dbs14916465"

        self.conn =mysql.connector.connect(
            host = host,
            user = user,
            password = password,
            database = database
        )
        self.cursor = self.conn.cursor(dictionary = True) # returns rows as dictionary

    def execute(self,sql,params=()):
        self.cursor.execute(sql,params)
        self.conn.commit()

    def fetchAll(self,sql,params=()):
        self.cursor.execute(sql, params)
        return self.cursor.fetchall()

    def fetch(self,sql):
        self.cursor.execute(sql)
        return self.cursor.fetchone()
    
    def fetchOne(self,sql,params=()):
        self.cursor.execute(sql,params)
        return self.cursor.fetchone()
    
    def close(self):
        self.cursor.close()
        self.conn.close()