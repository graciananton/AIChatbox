<?php
require_once "View.php";
class UserView extends View{
    public function __construct(array $request){
        parent::__construct($request);
    }
    public function process():void{
        if($this->req == "login"){
            ?>
            <link rel='stylesheet' href='../css/login.css'/>
            <div id='main'>
                <div style='width:25%;' ></div>
                <div id='form' style='display:flex;justify-content:center;'>
                    <form action='login.php' method='POST'>
                        <?php
                        if(array_key_exists("error",$this->request) && $this->request['error'] == true){
                            echo "<span style='color:red;'>Username and/or password invalid</span>";
                        }
                        ?>
                        <div class='form-group'>
                            <label for='emailAddress' >Email Address:</label>
                            <input type='email' name='emailaddress' value='' class='form-control' id='emailAddress' placeholder='Enter email'>
                        </div>

                        <div class='form-group'>
                            <label for='password'>Password:</label>
                            <input type='password'  name='password_hash' value='' class='form-control' id='password' placeholder='Enter password'>
                        </div>

                        <input type='submit' class='btn btn-primary w-100' value='Sign In' style='margin-top:15px;'/>
                        <input type='hidden' name='req' value='submit_login'/>
                    </form>
                </div>
                <div style='width:25%;'></div>
            </div>
            <?php
        }
        else if($this->req == "signup"){
            ?>
            <link rel='stylesheet' href='../css/signup.css'/>
            <div id='main'>
                <div style='width:25%;' ></div>
                <div id='form' style='display:flex;justify-content:center;'>
                    <form action='signup.php' method='GET'>
                        <?php
                        if(array_key_exists("error",$this->request) && $this->request['error'] == true){
                            echo "<span style='color:red;text-align:center;'>This username is already registered</span>";
                        }
                        ?>

                        <div class='form-group'>
                            <label for='emailAddress' >Email Address:</label>
                            <input type='email' name='emailaddress' value='' class='form-control' id='emailAddress' placeholder='Enter email'>
                        </div>

                        <div class='form-group'>
                            <label for='password'>Password:</label>
                            <input type='password'  name='password_hash' value='' class='form-control' id='password' placeholder='Enter password'>
                        </div>

                        <input type='submit' class='btn btn-primary w-100' value='Sign Up' style='margin-top:15px;'/>
                        <input type='hidden' name='req' value='submit_signup'/>
                    </form>
                </div>
                <div style='width:25%;'></div>
            </div>

            <?php
        }
        else if($this->req == "verification_code_signup"){
            ?>
            <link rel='stylesheet' href='../css/verification_code_signup.css'/>
            <div id='main'>
                <div style='width:25%;'></div>
                <div id='form' class='container-fluid'>
                    <div class='row'>
                        <div class='col-md-3 col-sm-3 col-lg-3'></div>
                        <div id='title' class='col-md-6 col-sm-6 col-lg-6' style='text-align:center;'>Verify Your Email</div>
                        <div class='col-md-3 col-sm-3 col-lg-3'></div>
                    </div>
                    <div class='row'>
                        <div class='col-md-3 col-sm-3 col-lg-3'></div>
                        <div id='message' class='col-md-6 col-sm-6 col-lg-6' style='text-align:center;'>Please Enter The 6-digit Verification Code We Just Sent To <b><?php echo $this->request['emailaddress']; ?></b></div>
                        <div class='col-md-3 col-sm-3 col-lg-3'></div>
                    </div>
                    <br/>
                    <div class='row'>
                        <div class='col-md-12 col-sm-12 col-lg-12'>
                            <form action='signup.php' method='POST' enctype='multipart/form-data'>
                                <div class='d-flex justify-content-center gap-3 mb-3'>
                                    <?php for($i=1; $i<7; $i++){ 
                                        $name = "verification_code{$i}";
                                    ?>
                                    <input type='text' name='<?php echo $name; ?>' value=''
                                            style='width:8%;height:50px;border-radius:10px;border:1px solid black;'>
                                    <?php } ?>
                                </div>
                                <div class='d-flex justify-content-center'>
                                    <input type='submit' value='Submit Verification Code' name='button' class='btn btn-primary'>
                                    <input type='hidden' name='req' value='verification_code_submit'>
                                    <input type='hidden' name='emailaddress' value="<?php echo $this->request['emailaddress']; ?>"/>
                                    <input type='hidden' name='password_hash' value='<?php echo $this->request['password_hash'];?>'/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div style='width:25%;'></div>
            </div>
            <?php 
        }
        else if($this->req == "verification_code_success"){
            ?>
            <link rel='stylesheet' href='../css/verification_code_success.css'/>
            <div id='main'>
                <div style='width:25%;'></div>
                <div id='content' class='container-fluid'>
                    <div class='row' style='display:flex;height:100vh;align-items:center;'>
                        <div class='col-md-4 col-sm-4 col-lg-4'></div>
                        <div class='col-md-4 col-sm-4 col-lg-4' style='font-size:1.2rem;text-align:center;'>
                            <b>Successfully Verified Verification Code.</b><br/> <a href='login.php'>Re-login</a> to the system using your username and password.   
                        </div>
                        <div class='col-md-4 col-sm-4 col-lg-4'></div>
                    </div>
                </div>
                <div style='width:25%;'></div>
            </div>

            <?php
        }
        else if($this->req == "verification_code_error"){
            ?>
            <link rel='stylesheet' href='../css/verification_code_success.css'/>
            <div id='main'>
                <div style='width:25%;'></div>
                <div id='content' class='container-fluid'>
                    <div class='row' style='display:flex;height:100vh;align-items:center;'>
                        <div class='col-md-4 col-sm-4 col-lg-4'></div>
                        <div class='col-md-4 col-sm-4 col-lg-4' style='font-size:1.2rem;text-align:center;'>
                            <b>Incorrect Verification Code.</b><br/> <a href='signup.php'>Re-SignUp</a> to the system.   
                        </div>
                        <div class='col-md-4 col-sm-4 col-lg-4'></div>
                    </div>
                </div>
                <div style='width:25%;'></div>
            </div>


            <?php
        }
    }

}