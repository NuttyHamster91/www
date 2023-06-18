<?php
session_start();
include_once("includes/config.php");

// Connect to the database
//$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['username'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
    echo header("Location: index.php?id=1");
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $mysqli->prepare('SELECT id, password, activation_code FROM users WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $activation_code);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if (password_verify($_POST['password'], $password)) {
            if ($activation_code == "activated") {
                // Verification success! User has logged-in!
                // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['id'] = $id;


                $stmt = $mysqli->prepare('SELECT name, username, email, is_admin, activation_code, date_format(last_login, "%d/%m/%Y") as last_login, avatar FROM users WHERE id = ?');
                // In this case we can use the account ID to get the account info.
                $stmt->bind_param('i', $_SESSION['id']);
                $stmt->execute();
                $stmt->bind_result($name, $username, $email, $is_admin, $activation_code, $last_login, $avatar);
                $stmt->fetch();
                $_SESSION['name'] = $name;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['admin'] = $is_admin;
                $_SESSION['last_login'] = $last_login;
                $_SESSION['activated'] = $activation_code;
                if ($is_admin == yes){
                    $_SESSION['avatar'] = "default/admin-icon.png";
                } else {
                    $_SESSION['avatar'] = $avatar;
                }
                $stmt->close();



                if ($stmt = $mysqli->prepare('SELECT * FROM user_details WHERE user_id = ?')) {
                    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
                    $stmt->bind_param('s', $_SESSION['id']);
                    $stmt->execute();
                    // Store the result so we can check if the account exists in the database.
                    $stmt->store_result();
                
                    if ($stmt->num_rows == 0) {
                        $null = null;
                        $user_id = $_SESSION['id'];
                        $stmt = $mysqli->prepare("INSERT INTO user_details (user_id, dob, addressl1, addressl2, addressl3, postcode, mobile, ni_no, utr_no, cis_rate, vat_reg_no, vat_rate, pay_rate, salary, bank,
                        srt, acct, k1, em_name, em_mobile, ins_company, ins_exp_date, ins_policy_no) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param('isssssssssssissssssssss', $user_id, $null, $null, $null, $null, $null, $null, $null, $null, $null, $null, $null, 
                        $null, $null, $null, $null, $null, $null, $null, $null, $null, $null, $null);
                        $stmt->execute();
                        $stmt->close();
                    } else {}
                }



                //last login
                $sql = "UPDATE users SET last_login = NOW() WHERE id = '" . $_SESSION['id'] . "'";

                if ($mysqli->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $mysqli->error;
                }
                $stmt->close();

                //if ($is_admin == "yes") { 
                    //admin                   
                    header('Location: dashboard.php?id=10');
                //} else {
                    //client
                //    echo header('Location: client/dashboard.php?id=10');
                //}
            } else {
                // Incorrect password
                echo header("Location: index.php?id=7");
            }

        } else {
            // Incorrect username
            echo header("Location: index.php?id=1");
        }

    } else {
        // Incorrect username
        echo header("Location: index.php?id=1");
    }

    $stmt->close();
}
?>