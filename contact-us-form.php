<?php
    
    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $txtmessage = $_POST['message'];
    $whoyour    = $_POST['whoyour'];
    $mobile     = intval($_POST['mobile']);
    $from       = 'admin@getsethome.com'; 

    $rexMobile  = "/^[789][0-9]{9}$/";
    

    $message = "From: $name\n E-Mail: $email\n Mobile: $mobile \n Who You Are?: $whoyour \n Message:\n $txtmessage";

    // Check if name has been entered`
    if (!$_POST['name']) {
        $errName = 'Please enter your name';
    }
    
    // Check if email has been entered and is valid
    if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errEmail = 'Please enter a valid email address';
    }
    
    //Check if message has been entered
    if (!$_POST['message']) {
        $errMessage = 'Please enter your message';
    }
    //Check if simple anti-bot test is correct
    if(!preg_match($rexMobile, $mobile)) { 
        $errMobile = 'check your Mobile number';
    }

    ini_set("SMTP","mail.getsethome.com" ); 
    ini_set("sendmail_from", "admin@getsethome.com");
    
    $to             =   "contact.us@getsethome.com, junaid.shaikh@flipside.co.in";
    $subject        =   "Contact us GetSetHome";
    $headers        =   "MIME-Version: 1.0" . "\r\n";
    $headers        .=  "Content-Type: text/html; charset=iso-8859-1\r\n";
    $headers        .=  "From: <admin@getsethome.com>";


    //error_reporting(E_ALL);
    //ini_set('display_errors', 1); 
    
    /*require "config/global.php";        
    require "comlib/clsMyDBEngine.php"; 
    
    //Sanity for your paramters
    if(!isset($email)) die("Parameter - email not specified in url!!");
    
    //Insert query
    $strQuery = "INSERT INTO tblenquiry VALUES ('".$name."','".$email."','".$mobile."','".$whoyour."','".$txtmessage."');";
    

    $objDB = new clsMyDBEngine();

    if(!$objDB->blnExecute($strQuery)) {                    
        echo 'Query failed';
        exit();             
    }*/

   /* CREATE TABLE tblContactUs
    (
        Sub_strName VarChar(100),
        Sub_strEmail VarChar(100),
        Sub_strPhoneNo VarChar(20),
        Sub_strWhoYouAre VarChar(100),
        Sub_strMessage VarChar(400),
        Sub_strType VarChar(10), -- Type is used to indentify news letters or some other page etc
        PRIMARY KEY(Sub_strEmail, Sub_strType) 
    )*/
    
    $username = "getset";
    $password = "homeemail";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://smcbazaar.com/email.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array("name"=> $name, "email"=> $email, "message"=> $txtmessage, "whoyour"=> $whoyour, "mobile"=> $mobile, "str_Type"=>"enquiry", "Command" => "contact"));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    $result = curl_exec($ch);
    
    if($result == 1) {

        if(mail($to, $subject, $message, $headers)) {
            
            header('Location: /thank-you?&id=2');
        
        } else {
            
            echo "fail";
        }

    } else {

            echo "fail";        
    }    
?>