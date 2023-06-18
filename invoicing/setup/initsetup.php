<?php

//if(isset($_POST['sendIt'])) { 

    // See if sql connection can be made
    $mysqli = new mysqli(getenv('IP'), $_POST['db_user'], $_POST['db_pass'], $_POST['db_name']);

    // Check connection
    if ($mysqli->connect_error) {
        header('Location: ../setup/firstrun.php?id=2');
    } else {

	// database connection string  
	mysqli_set_charset($mysqli,"utf8");
	
	if(!$mysqli) {
		die('Unable to connect to database'.mysqli_connect_error());
        header('Location: ../setup/firstrun.php?id=2');
	}

	// get data from the SQL file
	$query = file_get_contents("invoicing.sql");    

	// execute the SQL
	if (mysqli_multi_query($mysqli, $query)){
		echo "Success";
        $mysqli->close();
	  

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

        // Write Company Name

        $txt = "define('COMPANY_NAME', '".$_POST['comp_name']."');\n";
        fwrite($newsettings, $txt);
        $txt = "define('TIMEZONE', '".$_POST['TIMEZONE']."');\n";
        fwrite($newsettings, $txt);
        $txt = "define('COMPANY_WEBSITE', '".$_POST['web_add']."');\n";
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

        header('Location: ../setup/firstrun1.php?id=13');

        } else {
            
		echo "Fail";
        header('Location: ../setup/firstrun.php?id=2');
        $mysqli->close();

            // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
            
            $mysqli = new mysqli(getenv('IP'), $_POST['db_user'], $_POST['db_pass'], $_POST['db_name']);
            $UN1 = $_POST['username'];

            $sqlquery = "DELETE FROM users WHERE username='{$UN1}'";
            echo "<pre>$sqlquery</pre>";
            mysqli_query($mysqli,$sqlquery);
            $mysqli->close();
            echo header("Location: ../setup/firstrun.php?id=4");
        }
            
            //header("Location: ../index.php");
        exit();
}	    
?>