<?php
require_once "View.php";
class DashboardView extends View{
    private string $chatId;
    private string $uid;
    public function __construct(array $request){
        $this->chatId = $request['chatId'] ?? "";
        $this->uid = $request['uid'] ?? "";
        parent::__construct($request);
    }
    public function setNavBar():void{
    ?>
        <link rel='stylesheet' href='../css/navbar.css'/>

        <nav class='navbar navbar-expand-lg' style='background-image:linear-gradient(to right,#F0FFFF,#0096FF) !important'>
            <div class='container-fluid'>
                <a class="navbar-brand">Chatbot</a>

                <button class="navbar-toggler" type="button" 
                        data-bs-toggle="collapse" data-bs-target="#navbar" 
                        aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class='collapse navbar-collapse' id="navbar">
                    <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                        <li class='nav-item'>
                            <a class='nav-link' href='?req=basic'>Basic Chatbox</a>
                        </li>
                        <li class='nav-item'>
                            <button id='deleteAccount' style='background-image:linear-gradient(to right,#F0FFFF,#F0FFFF) !important;'>Delete Account</button>
                        </li>
                    </ul>

                    <ul class="navbar-nav mb-5 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
            <link rel='stylesheet' href='../css/deleteMessage.css'/>
            <div class='container-fluid' id='deleteMessage' >
            </div>
            <script>
                const emailaddress = <?php echo json_encode($_SESSION['emailaddress'] ?? ''); ?>;

                function displayDeleteMessage() {
                const container = document.getElementById('deleteMessage');
                
                // Show the overlay
                container.style.visibility = 'visible';
                container.innerHTML = `
                    <div class='row' id='message'>
                
                        <p>Hello, ${emailaddress || 'Guest'}! By deleting this account, you agree to:</p>

                        <ul>
                            <li>Delete all chats under this account</li>
                            <li>Delete all messages under this account</li>
                            <li>Delete this account from the DocuMindsystem</li>
                        </ul>
                        
                        <button style='margin-bottom:10px;background-image:linear-gradient(to right,#0096FF,#0096FF);' id='deleteAccountButton'>Delete Account</button>
                        <button onclick="closeDeleteMessage()" style='background-image:linear-gradient(to left,#0096FF,#0096FF);'>Close</button>
                    </div>
                `;
        }

        function closeDeleteMessage(){
        document.getElementById('deleteMessage').style.visibility = 'hidden';
        }

        document.getElementById("deleteAccount").addEventListener("click", displayDeleteMessage);

        $(document).on("click", "#deleteAccountButton", function(event){
            console.log("deleting account button");
            event.preventDefault();

            $.ajax({
                url: "ajax.php",
                method: "POST",
                data: { emailaddress: emailaddress },
                success: function(response){
                    response = JSON.parse(response);
                    if(response){
                        window.location.href='logout.php';
                    }
                },
            });
        });

        </script>    
    <?php
    }
    public function process():void{
        if($this->req == "basic"){
        ?>
            <link rel='stylesheet' href='../css/dashboard.css'>
            <div class='container-fluid' id='main'>
                <div class='row' style='height:80vh;'>
                    <div class='col-md-2 col-lg-2 col-sm-2' style='overflow-y:auto;height:100%;margin-top:15px;border-top-left-radius:15px;border-top-right-radius:15px;' id='chatbox-options'>
                        <ul class='nav flex-column' id='chats'>
                            <li class='nav-item'>
                                <a class='nav-link' href="?chatId=<?= urlencode($this->request['newChatId']['chatId']) ?> ">
                                    New Chat
                                </a>
                            </li>
                            <?php foreach (array_reverse($this->request['chats'],true) as $chat): ?>
                                <li class="nav-item">
                                    <?php if($this->request['chatId'] == $chat['chatId']){ ?>
                                    <a class="nav-link" id='<?php echo $chat['chatId']; ?>' style='background-image:linear-gradient(to right,#F0FFFF,#0096FF) !important; color: #222;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);' href="?chatId=<?= urlencode($chat['chatId']) ?>">
                                        <?= htmlspecialchars($chat['title']) ?>
                                    </a>
                                    <?php } 
                                    else{
                                    ?>
                                    <a class="nav-link" id='<?php echo $chat['chatId']; ?>' href="?chatId=<?= urlencode($chat['chatId']) ?>">
                                        <?= htmlspecialchars($chat['title']) ?>
                                    </a>
                                    <?php } ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        
                    </div>
                    <div class='col-md-10 col-lg-10 col-sm-10' id='chatbox'>
                        <!-- chatbox screen -->
                        <?php foreach($this->request['msgs'] as $msg): ?>
                            <div class='chat-msg'>
                                <?= htmlspecialchars($msg['msg']) ?>
                            </div>
                            <div class='ai-reply'>
                                <?= htmlspecialchars($msg['response']) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class='row' style='height:10vh;'>
                    <div class='col-md-2 col-sm-2 col-lg-2' style='margin-bottom:40px;border-bottom-left-radius:15px;border-bottom-right-radius:15px;height:100%;' ></div>
                    <div class="col-md-10 col-sm-10 col-lg-10" style='height:100%;'>
                        <input type="text" id="message" class="form-control"
                            placeholder="Ask anything"
                            style="width:100%;margin-top:20px;padding:10px;padding-left:10px;border-radius:15px;box-shadow: 0 0 10px rgba(128, 128, 128, 0.4);" />
                    </div>
                </div>
                <script src='../js/MessageHandler.js'></script>
                <script>
                    const chatId = <?php echo json_encode($this->chatId); ?>;
                    const uid = <?php echo json_encode($this->uid); ?>;
                    $(document).ready(function(){
                        $("#message").on("keydown",function(event){
                            if(event.key == "Enter"){
                                event.preventDefault();
                                                   
                                let message = $(this).val().trim();
                                
                                const mh = new MessageHandler(message,"",chatId);
                                mh.displayMessage();

                                if(message == ''){return}
                                $.ajax({
                                    url:"ajax.php",
                                    method:"POST",
                                    data:{
                                        message:message,
                                        chatId:chatId,
                                        uid:uid
                                    },
                                    success: function(response) {
                                        console.log(response); 

                                        const data = JSON.parse(response); 
                                        var chat_title = data[0];
                                        var AIReply = data[1];


                                        const mh = new MessageHandler("", AIReply, chatId,chat_title);
                                        mh.displayAIReply();
                                        mh.displayChatTitle();
                                    }
                                })
                            }
                        })
                    })
                </script>
            </div>
        <?php
        }
      
    }
}