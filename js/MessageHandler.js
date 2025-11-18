class MessageHandler{
    constructor(message,AIReply,chatId,chat_title){
        this.message = message;
        this.AIReply = AIReply;
        this.chatId = chatId;
        this.chat_title = chat_title
    }
    displayMessage(){
        document.getElementById('message').value = "";

        const chatbox = document.getElementById("chatbox");
        const message = document.createElement("div");
        message.classList.add("chat-msg");
        message.textContent = this.message;

        chatbox.appendChild(message);


        chatbox.scrollTop = chatbox.scrollHeight; 
    }
    displayChatTitle(){
        document.getElementById('chats').innerHTML +=     "<li class='nav-item'>" +
                                                                "<a class='nav-link' href='?chatId=" + this.chatId + "'>" + this.chat_title + "</a>" +
                                                            "</li>";

    }
    displayAIReply(){
        const chatbox = document.getElementById("chatbox");
        const AIReply = document.createElement("div");
        AIReply.classList.add("ai-reply");
        AIReply.textContent = this.AIReply
        chatbox.appendChild(AIReply)
        chatbox.scrollTop = chatbox.scrollHeight;
    }
    /* add more functionality */
}