<?php 
error_reporting(E_ERROR | E_PARSE);
include("../includes/header.php");
include("../includes/config.php");

?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

* {
    margin-left: 5px;
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
    height: 540px;
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
    margin-top: 10px;
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

#username, #password, #email, #db_name, #db_user, #db_pass, #comp_name, #name, #TIMEZONE, #web_add {
	width: 90%;
}

.w92 {
    margin-top: 10px;
	width: 85%;
}

.center_div{
    margin: 0 auto;
    width:100% /* value of your choice which suits your alignment */
}

@media (max-width:767px) {
    body {
    margin-left: 10px;
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


<div class="container">
    <div class="body d-md-flex align-items-center justify-content-between">
        <div class="box-1 d-flex flex-column">
            <div class="ml-1 mt-0 center_div">
                <p class="mb-0 h-1">First Run - Settings - 1</p>
                <div class="d-flex flex-column center_div">
                    <p class="text-muted mb-1">All Fields are Required !<? echo '<br>' . $pVar?></p>
                    <form method="POST" action="initsetup1.php">
                        <div class="form-group">
                            <label>Database Name<br></label><br>
                            <input class="form-control" type="text"  id="db_name" name="db_name" placeholder="Database Name" value="<? echo DATABASE_NAME ?>" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Database Username<br></label><br>
                            <input class="form-control" type="text" id="db_user" name="db_user" placeholder="Database Username" value="<? echo DATABASE_USER ?>" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Database Password<br></label><br>
                            <input class="form-control" type="password" id="db_pass" name="db_pass" placeholder="Database Password" value="<? echo DATABASE_PASS ?>" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Your Company Name<br></label><br>
                            <input class="form-control" type="text" id="comp_name" name="comp_name" placeholder="Company Name " value="<? echo COMPANY_NAME ?>" readonly required>
                        </div>
                        <div class="form-group">
                            <label>Default Time Zone<br></label><br>
                            <?php $Zone = TIMEZONE;
                                            if(!empty($Zone)){
                                                $curentZone = '<option selected value>' . TIMEZONE . '</option>';
                                            } else{
                                                $curentZone = '<option disabled selected value> -- Select an option -- </option>';
                                            }
        
                                        // Create a timezone identifiers
                                        $timezone_identifiers = 
                                            DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                                        
                                        echo "<select class='form-control' name='TIMEZONE' id='TIMEZONE' required disabled>";
                                        
                                        echo $curentZone;
                                        
                                        $n = 425;
                                        for($i = 0; $i < $n; $i++) {
                                            
                                            // Print the timezone identifiers
                                            echo "<option value='" . $timezone_identifiers[$i] . 
                                                "'>" . $timezone_identifiers[$i] . "</option>";
                                        }
                                        
                                        echo "</select>";
                                        
                                        ?>
                        </div>
                        <div class="form-group">
                            <label>Website Address:<br></label><br>
                            <input class="form-control" type="text" id="web_add" name="web_add" placeholder="E.G. Localhost or microsoft.com " value="<? echo COMPANY_WEBSITE ?>" readonly required>
                        </div>
                </div>
            </div>
        </div>
        <div class="box-2 d-flex flex-column">
            <div class="mt-0 center_div">
                <p class="mb-0 h-1">Create Admin User</p>
                <div class="d-flex flex-column center_div">
                    <p class="text-muted mb-1">Note: You can add more admin users later.</p>
                        <div class="form-group">
                            <label>Your Full Name<br></label><br>
                            <input class="form-control" type="text"  id="name" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <label>Admin Username<br></label><br>
                            <input class="form-control" type="text"  id="username" name="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <label>Admin Password<br></label><br>
                            <input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label>Admin Email<br></label><br>
                            <input class="form-control" type="email" id="email" name="email" placeholder="Your Email" required>
                        </div>
                        <p class="text-muted mb-1"></p>
                        <div class="myform-button">
                            <button type="submit" class="btn btn-success w92" name="sendIt" value="Submit">Submit</button>
                        </div>
                        <br>
                        <div class="myform-button">
                            <INPUT class="btn btn-success w92" type="reset">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>