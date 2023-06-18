<?php
$file = ('includes/config.php'); 
if (!file_exists($file) && (filesize($file)) <= 5) {   
    header('Location: setup/firstrun.php');
    } else {
        include('includes/header.php');
    }


session_start();
if(isset($_SESSION['id'])&&!empty($_SESSION['id'])&&($_SESSION['activated'] == 'activated')){
    header("Location: dashboard.php");
    exit();
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

#username, #password {
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


<div class="container">
    <div class="body d-md-flex align-items-center justify-content-between">
		<div class="box-1 mt-md-0 mr-2">
			<img src="https://picsum.photos/500/1200" class="" alt="Random Image Generated">
		</div>
            <div class="box-2 d-flex flex-column">
                <div class="mt-0 center_div">
                    <p class="mb-0 h-1">Login.</p>
                    <div class="d-flex flex-column center_div">
                        <p class="text-muted mb-1"><? echo '<br>' . $pVar?></p>
                        <form name="contactForm" id="contactForm" method="post" action="session.php">
							<div class="form-group">
								<label>User Name<br></label><br>
								<input class="form-control" type="text"  id="username" name="username" placeholder="Username" required>
							</div>
							<div class="form-group">
								<label>Password<br></label><br>
								<input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
							</div>
							<div class="myform-button">
								<button class="btn btn-success w92">Login</button>
							</div>
						</form>
                        <div class="mt-2">
                            <p class="mb-0 text-muted">Don't have an account?</p>
                            <div class="btn btn-primary"><a href="register.php">Register Here</a></div>
                        </div>
                    </div>
                </div>
                <div class="mt-1">
                    <p class="footer text-muted mb-0 mt-md-0 mt-3">By registering you agree with our 
                        <a href="../uploads/<?php echo TCDP ?>" target="_blank"><span class="p-color me-1">terms and conditions and </span>
                        <span class="p-color ms-1">relevant policies.</span></a>
                    </p>
                </div>
            </div>
        </div>
    </div>