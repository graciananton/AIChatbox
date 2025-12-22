from langgraph.checkpoint.memory import MemorySaver
from langgraph.graph import START, MessagesState, StateGraph
from langchain_core.messages import HumanMessage, AIMessage
from langchain_google_genai import ChatGoogleGenerativeAI
from pprint import pprint
from dotenv import load_dotenv
from pathlib import Path
import os
import DatabaseManager, QueryBuilder
import sys
from Config import Config
class AIResponseGenerator:
    def __init__(self, message, chatId, uid):
        # Database setup
        self.db = DatabaseManager.DatabaseManager()
        self.qb = QueryBuilder.QueryBuilder()
        self.message = message
        self.chatId = chatId
        self.uid = uid
        os.environ["GRPC_VERBOSITY"] = "NONE"
        os.environ["GRPC_CPP_LOG_LEVEL"] = "NONE"
        sys.stdout.reconfigure(encoding='utf-8')
    def create_memory(self):
        self.memory = MemorySaver()
        self.app = self.workflow.compile(checkpointer=self.memory)
        
    def generateTitle(self):
        response = self.model.invoke([
            {"role":"system","content":"Generate a 3-6 word title for the message I give you"},
            {"role":"user","content": self.message}
        ])
        return response.content

    def initialize(self):
        self.thread_id = f"chat{self.chatId}"

        load_dotenv(Path(Config.env_file_path()))
        os.getenv("GOOGLE_API_KEY")

        self.model = ChatGoogleGenerativeAI(model="gemini-2.5-flash")
    
    def create_workflow(self):
        # Build LangGraph workflow
        self.workflow = StateGraph(state_schema=MessagesState)
        self.workflow.add_node("model", self.call_model)
        self.workflow.add_edge(START, "model")

    def call_model(self, state: MessagesState):
        response = self.model.invoke(state["messages"])
        return {"messages": response}

    def loadMessages(self):
        sql = self.qb.loadMessages()
        messages = self.db.fetchAll(sql, (self.chatId,self.uid))
        return messages or []

    def generateResponse(self):
        previous_messages = self.loadMessages() # loads all previous messages and responses
 
        # appends all previous messages and responses
        formatted_messages = []
        for message in previous_messages:
            formatted_messages.append(HumanMessage(content=message["msg"]))
            if message.get("response"):
                formatted_messages.append(AIMessage(content=message["response"]))

        # adds the most recent HumanMessage to the formatted_messages list
        formatted_messages.append(HumanMessage(content=self.message))

        response = self.app.invoke(
            {"messages": formatted_messages},
            config={"configurable": {"thread_id": self.thread_id}}, # adds a thread_id for the messages
        )

        ai_reply = response['messages'][-1].content # extracts most recent response from the AI
        return ai_reply
    
        