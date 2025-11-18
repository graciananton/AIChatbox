class QueryBuilder:
    def loadMessages(self):
        sql = "SELECT * FROM messages WHERE chatId = %s AND uid = %s"
        return sql
