<?php
session_start();
//include('functions.php');
include_once("includes/header.php");
include_once("includes/navbar.php");

$sql = "SELECT users.*, user_details.* FROM users JOIN user_details WHERE users.id = user_details.user_id AND users.id = ?"; // SQL with parameters
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC); 
foreach($data as $row): 

?>

<style>
input[type=text], input[type=password], input[type=date] {
    border: 1px solid #ccc; 
    border-radius: 5px;
    padding: 1px 5px;
    min-width: 60%;
    max-width: 70%;
    float: right;
}
</style>

<script>
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#ImdID').attr('src', e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
  }
}
</script>

<div class="content-body">
    <form action="includes/functions.php?action=spc" method="post" enctype="multipart/form-data">
    <div class="row match-height">
        <div class="col-xl-4 col-lg-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Your Profile.</h4>
                        <p class="card-text">This is all of the information we hold about you.</p>
                        <p class="card-text">Please fill in all blanks marked * as this information is needed by us to ensure you're correctly insured at work, to make payments to you and contact the correct person in case of emergency.</p>
                        <p class="card-text">Please let us know if you need any other information changing.</p>
                        <p class="card-text">You can E-mail us at: <? echo COMPANY_EMAIL ?> or use the contact form on the Dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">                
                        <h4 class="card-title">About You:</h4>
                            <input type="hidden" name="user_id" value="<? echo $row['user_id']?>">
                            <p class="card-text"><b>Full Name <br>/ Company: </b><input style="background-color: lightgrey;" type="text" name="name" value="<? echo $row['name']?>" readonly></p>
                            <p class="card-text"><b>Date of Birth *: </b><input type="date" name="dob" value="<?=$row['dob']?>"></p>
                            <p class="card-text"><b>Nat. Ins. No. *: </b><input type="text" name="ni_no" value="<? echo (openssl_decrypt ($row['ni_no'], $cipher, $row['k1'], $options, $encryption_iv));?>"></p>
                            <p class="card-text"><b>UTR No.: </b><input type="text" name="utr_no" value="<? echo $row['utr_no']?>"></p>
                            <p class="card-text"><b>CIS Rate.: </b><input type="text" name="cis_rate" value="<? echo $row['cis_rate']?>" placeholder="E.G. Enter 0.20 for 20%" pattern="[^%()/><\][\\\x22,;|]+"></p>
                            <p class="card-text"><b>Username: </b><input style="background-color: lightgrey;" type="text" name="username" value="<? echo $row['username']?>" readonly></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">                
                        <h4 class="card-title">Your Contact Details:</h4>
                            <p class="card-text"><b>E-Mail *: </b><input type="text" name="email" value="<? echo $row['email']?>"></p>
                            <p class="card-text"><b>Mobile *: </b><input type="text" name="mobile" value="<? echo $row['mobile']?>"></p>
                            <p class="card-text"><b>Address Line 1 *: </b><input type="text" name="addressl1" value="<?echo (openssl_decrypt ($row['addressl1'], $cipher, $row['k1'], $options, $encryption_iv));?>"></p>
                            <p class="card-text"><b>Address Line 2 *: </b><input type="text" name="addressl2" value="<? echo (openssl_decrypt ($row['addressl2'], $cipher, $row['k1'], $options, $encryption_iv));?>"></p>
                            <p class="card-text"><b>Address Line 3: </b><input type="text" name="addressl3" value="<? echo (openssl_decrypt ($row['addressl3'], $cipher, $row['k1'], $options, $encryption_iv));?>"></p>
                            <p class="card-text"><b>Post Code *: </b><input type="text" name="postcode" value="<? echo $row['postcode']?>"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body"> 
                        <h4 class="card-title">Emergency Contact:</h4>
                            <p class="card-text"><b>Name *: </b><input type="text" name="em_name" value="<? echo $row['em_name']?>"></p>
                            <p class="card-text"><b>Number *: </b><input type="text" name="em_mobile" value="<? echo $row['em_mobile']?>"></p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="card-body"> 
                        <h4 class="card-title">Payment Details:</h4>
                            <p class="card-text"><b>Bank *: </b><input type="text" name="bank" value="<? echo (openssl_decrypt ($row['bank'], $cipher, $row['k1'], $options, $encryption_iv));?>"></p>
                            <p class="card-text"><b>Sort Code *: </b><input type="text" name="srt" value="<? echo (openssl_decrypt ($row['srt'], $cipher, $row['k1'], $options, $encryption_iv));?>"></p>
                            <p class="card-text"><b>Account No. *: </b><input type="text" name="acct" value="<? echo (openssl_decrypt ($row['acct'], $cipher, $row['k1'], $options, $encryption_iv));?>"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">                
                        <h4 class="card-title">Your Pay (As Applicable):</h4>
                            <p class="card-text"><b>Your Salary: </b><input style="background-color: lightgrey;" type="text" name="salary" value="<? echo $row['salary']?>" readonly></p>
                            <p class="card-text"><b>Hourly Rate: </b><input style="background-color: lightgrey;" type="text" name="pay_rate" value="<?=$row['pay_rate']?>" readonly></p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="card-body">                
                        <h4 class="card-title">Your Insurance (If Applicable):</h4>
                            <p class="card-text"><b>Ins. Company: </b><input type="text" name="ins_company" value="<? echo $row['ins_company']?>"></p>
                            <p class="card-text"><b>Ins. Policy No.: </b><input type="text" name="ins_policy_no" value="<? echo (openssl_decrypt ($row['ins_policy_no'], $cipher, $row['k1'], $options, $encryption_iv));?>"></p>
                            <p class="card-text"><b>Ins. Exp. Date: </b><input type="date" name="ins_exp_date" value="<? echo $row['ins_exp_date']?>"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">                
                        <h4 class="card-title">VAT Information (If Applicable):</h4>
                            <p class="card-text"><b>Vat Reg. No.: </b><input type="text" name="vat_reg_no" value="<? echo $row['vat_reg_no']?>"></p>
                            <p class="card-text"><b>Vat Rate: </b><input type="text" name="vat_rate" value="<? echo $row['vat_rate']?>" placeholder="E.G. Enter 0.20 for 20%" pattern="[^%()/><\][\\\x22,;|]+"></p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="card-body">                
                        <h4 class="card-title">Password Change:</h4>
                            <p class="card-text"><b>New Password: </b><input type="password" name="new_pass"></p>
                            <p class="card-text"><b>Repeat: </b><input type="password" name="new_pass1"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">                
                        <h4 class="card-title">Upload your Avatar / Profile Picture:</h4>
                            <p class="card-text"><b>Upload your Avatar / Picture of you here. File must be - Jpg,Jpeg or png and under 500kb.</b>
                            <a href="https://www.simpleimageresizer.com/resize-image-to-250-kb">Resize your image here if needed.</a></p>
                        <p class="card-text"><input type="file" name="upload_avatar" id="upload_avatar" onchange="readURL(this);">
                        <? if (!empty($row['avatar'])){
                            echo '<img style="max-width:80px" id="ImdID" src="theme-assets/images/portrait/'.$row['avatar'].'" alt="Image" /></p>';
                        } else {
                            echo '<img style="max-width:80px" id="ImdID" src="theme-assets/images/portrait/default/add-avatar.png" alt="Image" /></p>';
                        }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input style="width: 100%; margin-bottom: 15px;" type="submit" class="btn btn-success w92" name="sendprofile" id="sendprofile" value="Save Changes">
    </form>
</div>
<!--/ Statistics -->
<!-- ////////////////////////////////////////////////////////////////////////////-->
<?php endforeach ?>
<? include ('includes/footer.php')?>