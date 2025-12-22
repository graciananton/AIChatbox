import mysql.connector
from Config import Config
class DatabaseManager:
    def __init__(self):
        dbConnection = Config.connection_info()

        host = dbConnection['host']
        user = dbConnection['user']
        password = dbConnection['password']
        database = dbConnection['database']

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