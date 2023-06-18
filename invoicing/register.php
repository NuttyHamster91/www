<?php
$file = ('includes/config.php'); 
if (!file_exists($file) && (filesize($file)) <= 5) {   
    header('Location: setup/firstrun.php');
    } else {
        include('includes/header.php');
    }
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif
}

.container {
    margin: 50px auto;
}

.body {
    position: center;
    width: 820px;
    height: 660px;
    margin: 20px auto;
    border: 1px solid #dddd;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}

.box-1 img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.box-2 {
    padding: 10px;
}

.box-1,
.box-2 {
    width: 50%;
}

.h-1 {
    font-size: 24px;
    font-weight: 700;
}

.text-muted {
    font-size: 14px;
}

.container .box {
    width: 100px;
    height: 100px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border: 2px solid transparent;
    text-decoration: none;
    color: #615f5fdd;
}

.box:active,
.box:visited {
    border: 2px solid #858585;
}

.box:hover {
    border: 2px solid #858585;
}

.btn.btn-primary {
    background-color: transparent;
    color: #858585;
    border: 0px;
    padding: 0;
    font-size: 14px;
}

.btn.btn-primary .fas.fa-chevron-right {
    font-size: 12px;
}

.footer .p-color {
    color: #858585;
}

.footer.text-muted {
    font-size: 10px;
}

.fas.fa-times {
    position: absolute;
    top: 20px;
    right: 20px;
    height: 20px;
    width: 20px;
    background-color: #f3cff379;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.fas.fa-times:hover {
    color: #ff0000;
}

#username, #password, #email, #name {
	width: 92%;
}

.w92 {
	width: 92%;
}

.center_div{
    margin: 0 auto;
    width:100% /* value of your choice which suits your alignment */
}

@media (max-width:767px) {
    body {
        padding: 5px;
    }

    .body {
        width: 100%;
        height: 100%;
    }

    .box-1 {
        width: 100%;
    }

    .box-2 {
        width: 100%;
        height: 440px;
    }
}
</style>


<?php
if (isset($_POST['sendit'])) {
session_start();
include('includes/config.php');

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
    echo header("Location: register.php?id=1");
}

    $name = $_POST['name'];
    $UN = $_POST['username'];
    $EM = $_POST['email'];
    $ll = "2000-01-01T00:00:00";
    $i1="N/A";
    $i2="no";
            
    if ($stmt = $mysqli->prepare('SELECT id, password FROM users WHERE username = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();
        // Store the result so we can check if the account exists in the database.
        if ($stmt->num_rows > 0) {
            // Username already exists
            echo header("Location: register.php?id=9");
        } else {
            // Insert new account
            // Username doesnt exists, insert new account
    if ($stmt = $mysqli->prepare('INSERT INTO users (name, username, email, phone, password, is_admin, activation_code, last_login, avatar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
        // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $uniqid = uniqid();
        $avatar = "default/admin-icon.png";



        //Email to client
        $ipa = getenv("REMOTE_ADDR");
        if ($ipa = '::1'){
        $ipaddress = "localhost";
        } else {
        $ipaddress = $ipa;
        }
        $from = EMAIL_FROM;
        $subject = COMPANY_NAME . ' - Account Activation';
        $headers = 'From: ' . EMAIL_NAME . ' <' . $from . '>' . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        // Update the activation variable below
        $emailusername = $_POST['username'];
        $emailpass = $_POST['password'];
        $activate_link = '' . $ipaddress . '/setup/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
        $message = '<p>Please click or copy the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a> <br><br>
        Please Complete Your Profile once logged in. <br><br> Regards, ' . COMPANY_NAME . '</p>';


        $stmt->bind_param('ssssssss', $_POST['name'], $_POST['username'], $_POST['email'], $i1, $password, $i2, $uniqid, $ll, $avatar);
        $stmt->execute();
        $stmt->close();
    
    // (C) SEND!
    
    //PHP mailer function
     
    $result3 = mail($EM, $subject, $message, $headers);
     
    //Checking if Mails sent successfully
     
    if ($result3) {
    
    echo header("Location: /index.php?id=3");
    } else {
        // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
        echo header("Location: register.php?id=4");
    }
        }
        $stmt->close();
    $mysqli->close();
    }


    




}
}
?>


<div class="container">
    <div class="body d-md-flex align-items-center justify-content-between">
		<div class="box-1 mt-md-0 mr-2">
			<img src="https://picsum.photos/500/1200" class="" alt="Random Image Generated">
		</div>
            <div class="box-2 d-flex flex-column">
                <div class="mt-0 center_div">
                    <p class="mb-0 h-1">Create Account.</p>
                    <div class="d-flex flex-column center_div">
                        <p class="text-muted mb-1"><? echo '<br>' . $pVar?></p>
                        <form method="post" action=""><!--action="setup/register.php"-->
							<div class="form-group">
								<label>Full Name (incl. Any Middle Name(s))<br></label><br>
								<input class="form-control" type="text"  id="name" name="name" placeholder="Your Full Name" required>
							</div>
							<div class="form-group">
								<label>User Name<br></label><br>
								<input class="form-control" type="text"  id="username" name="username" placeholder="Username" required>
							</div>
							<div class="form-group">
								<label>Password<br></label><br>
								<input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
							</div>
                            <div class="form-group">
								<label>Email Address<br></label><br>
								<input class="form-control" type="email"  id="email" name="email" placeholder="Email" required>
							</div>
							<div class="myform-button">
								<button class="btn btn-success w92" name="sendit" id="sendit">Create Account</button>
							</div>
						</form>
                        <div class="mt-2">
                            <p class="mb-0 text-muted">Already have an account?</p>
                            <div class="btn btn-primary"><a href="index.php">Login</a></div>
                        </div>
                    </div>
                </div>
                <div class="mt-1">
                    <p class="footer text-muted mb-0 mt-md-0 mt-3">By registering you agree with our 
                        <span class="p-color me-1">terms and conditions </span>and 
                        <span class="p-color ms-1">privacy policy</span>
                    </p>
                </div>
            </div>
        </div>
    </div>