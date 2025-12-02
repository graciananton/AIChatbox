import sys
import AIResponseGenerator
from pprint import pprint
import DatabaseManager 
import QueryBuilder 
message = sys.argv[1]
chatId = sys.argv[2]
uid = sys.argv[3]
req = sys.argv[4]

db = DatabaseManager.DatabaseManager()
qb =QueryBuilder.QueryBuilder()
if req == "reply":

    ai = AIResponseGenerator.AIResponseGenerator(message, chatId, uid)
    ai.initialize() # sets chatId and intializes chat model
    ai.create_workflow() # STARTS workflow
    ai.create_memory() # creates memory checkpoint system to track messages

    reply = ai.generateResponse()

    print(reply)

elif req == "title":
    ai = AIResponseGenerator.AIResponseGenerator(message,chatId,uid)
    ai.initialize()
    title = ai.generateTitle()
    print(title)
