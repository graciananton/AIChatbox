from langgraph.checkpoint.memory import MemorySaver
from langgraph.graph import START, MessagesState, StateGraph
from langchain_core.messages import HumanMessage, AIMessage
from langchain.chat_models import init_chat_model
from pprint import pprint
import os
import DatabaseManager, QueryBuilder
import sys


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

    def generateTitle(self):
        response = self.model.invoke([
            {"role":"system","content":"Generate a 3-6 word title for the message I give you"},
            {"role":"user","content": self.message}
        ])
        return response.content

    def initialize(self):
        self.thread_id = f"chat{self.chatId}"

        # Model initialization
        os.environ["GOOGLE_API_KEY"] = "AIzaSyA26EG1w4Ac-CAQautdio8h-D8iv7m4RqQ"
        self.model = init_chat_model("gemini-2.5-flash", model_provider="google_genai")
    
    def create_workflow(self):
        # Build LangGraph workflow
        self.workflow = StateGraph(state_schema=MessagesState)
        self.workflow.add_node("model", self.call_model)
        self.workflow.add_edge(START, "model")

    def create_memory(self):
        # Memory checkpoint system
        self.memory = MemorySaver()
        self.app = self.workflow.compile(checkpointer=self.memory)

    def call_model(self, state: MessagesState):
        response = self.model.invoke(state["messages"])
        return {"messages": response}

    def loadMessages(self):
        sql = self.qb.loadMessages()
        messages = self.db.fetchAll(sql, (self.chatId,self.uid))
        return messages or []

    def generateResponse(self):
        previous_messages = self.loadMessages()

        formatted_messages = []
        for message in previous_messages:
            formatted_messages.append(HumanMessage(content=message["msg"]))
            if message.get("response"):
                formatted_messages.append(AIMessage(content=message["response"]))

        formatted_messages.append(HumanMessage(content=self.message))

        response = self.app.invoke(
            {"messages": formatted_messages},
            config={"configurable": {"thread_id": self.thread_id}},
        )

        ai_reply = response['messages'][-1].content
        return ai_reply
    
        