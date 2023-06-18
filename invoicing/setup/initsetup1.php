<?php

//if(isset($_POST['sendIt'])) { 

    // See if sql connection can be made
    $mysqli = new mysqli(getenv('IP'), $_POST['db_user'], $_POST['db_pass'], $_POST['db_name']);

    // Check connection
    if ($mysqli->connect_error) {
        header('Location: ../setup/firstrun1.php?id=2');
    } else {

        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $uniqid = uniqid();
        $name = $_POST['name'];
        $UN = $_POST['username'];
        $EM = $_POST['email'];
        $ll = "2000-01-01T00:00:00";
        $i1="N/A";
        $i2="yes";
        $ava="default/admin-icon.png";
        $sql = "INSERT INTO `users` (`name`, `username`, `email`, `phone`, `password`, `is_admin`, `activation_code`, `last_login`, `avatar`) VALUES 
                ('" . $name . "', '" . $UN . "', '" . $EM . "', '" . $i1 . "', '" . $password . "', '" . $i2 . "', '" . $uniqid . "', '" . $ll . "', '" . $ava . "')";
                
                    if ($mysqli->query($sql)) {
                    printf("Record inserted successfully.<br />");
                    }
                    if ($mysqli->errno) {
                    printf("Could not insert record into table: %s<br />", $mysqli->error);
                    header('Location: ../setup/firstrun1.php?id=2');
                    }
                    $mysqli->close();

        //Email to client
        //$ipa = $_SERVER['SERVER_NAME'];
        //if ($ipa = '::1'){
        //  $ipaddress = "localhost";
        //} else {
        //  $ipaddress = $ipa;
        //}
        
        $ipaddress = $_POST['web_add'];
        $from    = $_POST['email'];
        $subject = 'Admin Account Activation';
        $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        // Update the activation variable below
        $activate_link = '' . $ipaddress . '/setup/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
        $message = '<p>Please click or copy the following link to activate your account: <br><br> <a href="' . $activate_link . '">' . $activate_link . '</a> <br><br> Regards, ' . $_POST['comp_name'];
        $sent = mail($from, $subject, $message, $headers);
        
        //Checking if Mails sent successfully
        
        if ($sent) {            

        // WRITE BASIC CONFIG FILE

        $newsettings = fopen("../includes/config.php", "w") or die("Unable to open file!");

        //Write Database Connections

        $txt = "<?php\n// Debugging\nini_set('error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE);\n\n// DATABASE INFORMATION\ndefine('DATABASE_HOST', getenv('IP'));\n";
        fwrite($newsettings, $txt);
        $txt = "define('DATABASE_NAME', '".$_POST['db_name']."');\n";
        fwrite($newsettings, $txt);
        $txt = "define('DATABASE_USER', '".$_POST['db_user']."');\n";
        fwrite($newsettings, $txt);
        $txt = "define('DATABASE_PASS', '".$_POST['db_pass']."');\n";
        fwrite($newsettings, $txt);

        // Write Default Logo details  
        
        $txt = "define('COMPANY_FAVICON_NAME', 'favicon.png');\n";
        fwrite($newsettings, $txt);
        $txt = "define('COMPANY_LOGO_NAME', 'logo.png');\n";
        fwrite($newsettings, $txt);
        $txt = "define('COMPANY_FAVICON', 'theme-assets/images/ico/');\n";
        fwrite($newsettings, $txt);
        $txt = "define('COMPANY_LOGO', 'theme-assets/images/logo/');\n";
        fwrite($newsettings, $txt);
        $txt = "define('COMPANY_LOGO_WIDTH', '300');\n";
        fwrite($newsettings, $txt);
        $txt = "define('COMPANY_LOGO_HEIGHT', '90');\n";
        fwrite($newsettings, $txt);

        // Write Company Name

        $txt = "define('COMPANY_NAME', '".$_POST['comp_name']."');\n";
        fwrite($newsettings, $txt);
        $txt = "define('TIMEZONE', '".$_POST['TIMEZONE']."');\n";
        fwrite($newsettings, $txt);
        $txt = "define('COMPANY_WEBSITE', '".$_POST['web_add']."');\n";
        fwrite($newsettings, $txt);

        //Write Email Details

        $txt = "define('EMAIL_FROM', '".$_POST['email']."'); // Email address invoice emails will be sent from\n";
        fwrite($newsettings, $txt);

        // Write Connect to DB

        $txt = "\n// CONNECT TO THE DATABASE\n$";
        fwrite($newsettings, $txt);
        $txt = "mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);\n\n";
        fwrite($newsettings, $txt);

        // Encrypt

        $txt = "\n//Define cipher\n$";
        fwrite($newsettings, $txt);
        $txt = "cipher = 'aes-256-cbc';\n";
        fwrite($newsettings, $txt);
        $txt = "// Use OpenSSl Encryption method\n$";
        fwrite($newsettings, $txt);
        $txt = "iv_length = openssl_cipher_iv_length($";
        fwrite($newsettings, $txt);
        $txt = "cipher);\n$";
        fwrite($newsettings, $txt);
        $txt = "options = 0;\n";
        fwrite($newsettings, $txt);
        $txt = "//Non-NULL Initialization Vector for encryption\n$";
        fwrite($newsettings, $txt);
        $txt = "encryption_iv = '1234567891011121';\n";
        fwrite($newsettings, $txt);
        $txt = "\n\n?>";
        fwrite($newsettings, $txt);
        fclose($newsettings);

        echo header("Location: ../index.php?id=3");

        } else {

            // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
            
            $mysqli = new mysqli(getenv('IP'), $_POST['db_user'], $_POST['db_pass'], $_POST['db_name']);
            $UN1 = $_POST['username'];

            $sqlquery = "DELETE FROM users WHERE username='{$UN1}'";
            echo "<pre>$sqlquery</pre>";
            mysqli_query($mysqli,$sqlquery);
            $mysqli->close();
            echo header("Location: ../setup/firstrun1.php?id=4");
        }
            
            //header("Location: ../index.php");
        exit();
}	    
?>