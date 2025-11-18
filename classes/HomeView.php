<?php
require_once "View.php";
class HomeView extends View{
    public function __construct(array $request){
        parent::__construct($request);
    }
    public function process():void{
        if($this->req == "home"){
            print_r($this->request);
            ?>
            <link rel="stylesheet" href="css/home.css">
            <script src="https://www.google.com/recaptcha/api.js"></script>
            <div class="graph">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg" id='navbar'>
                        <div class="container">
                            <a class="navbar-brand" href="index.php">DocuMind</a>

                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#navbarNav" aria-controls="navbarNav"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav me-auto mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#home" style='color:black;'>Home</a>
                                    </li>
                                </ul>
                                <ul class='navbar-nav ms-auto mb-lg-0'>
                                    <li class="nav-item">
                                        <a class='nav-link ' href='admin/login.php' target='_blank' style='color:black;'>Login</a>
                                    </li>
                                    <li class='nav-item'>
                                        <a class='nav-link ' href='admin/signup.php' target='_blank' style='color:black;'>Sign Up</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div class='row'>
                        <div class='col-md-1 col-sm-1 col-lg-1'></div>
                        <div class='col-md-5 col-sm-5 col-lg-5'>
                            <img src='images/home.png' alt=''/>
                        </div>
                        <div class='col-md-1 col-sm-1 col-lg-1'></div>
                        <div class='col-md-3 col-sm-3 col-lg-3' style='flex-direction:column;'>
                                 <div id='image'>
                                    <img src='images/checkmark.png' alt=''/>
                                </div>
                                <?php if($this->request['success'] == true){ ?>
                                    <div id='text' style='text-align:center;'>
                                        <b>Submission Successfull! </b><br/>
                                        Thank you for your submission. We have received your information and will process it shortly. You will receive a confirmation email within the next few minutes. 
                                    </div>
                                    }
                                      else
                                        {
                                        echo ErrorFormatter::toHTmL($this->request['errors']); ?>
                                <?php } 
                                ?>
                                <form action='index.php' enctype='multipart/form-data' method='POST' id='contact'>
                                    <script>
                                    function onSubmit(token) {
                                        document.getElementById("contact").submit();
                                    }
                                    </script>
                                    <div class='form-group'>
                                        <label for='emailaddress'>Email Address:</label>
                                        <input type='email' class='form-control' name='emailaddress' id='emailaddress' value='basil_anton@yahoo.ca'/>
                                    </div>
                                    <div class='form-group'>
                                        <label for='fullname'>Full Name:</label>
                                        <input type='text' class='form-control' name='fullname' id='fullname' value='Gracian Anton'/>
                                    </div>
                                    <div class='form-group'>
                                        <label for='message'>Message:</label>
                                        <textarea class='form-control' id='message' name='message' rows='3'>Message</textarea>
                                    </div>
                                    <div class='form-group'>
                                        <div class="g-recaptcha" data-sitekey="6Lf0-pUrAAAAALToG7Pss0k1liYphAH4trea6rvB"></div>
                                    </div>
                                    <div class='form-group'>
                                        <input type="submit" id="submit" class="form-control" name="submit" value="Send Message"/>
                                        <input type='hidden' value='submit' name='req'/>
                                    </div>
                                </form>
                            <?php } ?>
                        </div>
                        <div class='col-md-2 col-sm-2 col-lg-2'></div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}