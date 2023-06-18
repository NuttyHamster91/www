<?php
include_once("includes/header.php");
include_once("includes/navbar.php");
include_once("includes/functions.php");
?>

<!-- DASHBOARD ONLY SCRIPTS -->
<style>
input[type=text], input[type=password], input[type=date], input[type=radio], textarea, #projects, #contact {
    border: 1px solid #ccc; 
    border-radius: 5px;
    padding: 1px 5px;
    min-width: 50%;
    max-width: 65%;
    float: right;
}
.sitesDiv {
    overflow-x: hidden;
    overflow-y: auto; 
    max-height: 35em;
    }
</style>
<!-- DASHBOARD ONLY SCRIPTS -->

<div class="content-body">
            
<!-- Statistics -->

<?
$id = $_SESSION['id'];
$sql = "SELECT users.*, user_details.* FROM users JOIN user_details WHERE users.id = user_details.user_id AND users.id = $id;";
$result = $mysqli->query($sql);
$data = $result->fetch_all(MYSQLI_ASSOC); 
foreach($data as $row): 
$A1 = $row['dob'];
$A2 = (openssl_decrypt ($row['addressl1'], $cipher, $row['k1'], $options, $encryption_iv));
$A3 = (openssl_decrypt ($row['addressl2'], $cipher, $row['k1'], $options, $encryption_iv));
$A4 = $row['postcode'];
$A5 = $row['mobile'];
$A6 = (openssl_decrypt ($row['ni_no'], $cipher, $row['k1'], $options, $encryption_iv));
$A7 = (openssl_decrypt ($row['bank'], $cipher, $row['k1'], $options, $encryption_iv));
$A8 = (openssl_decrypt ($row['srt'], $cipher, $row['k1'], $options, $encryption_iv));
$A9 = (openssl_decrypt ($row['acct'], $cipher, $row['k1'], $options, $encryption_iv));
$A10 = $row['em_name'];
$A11 = $row['em_mobile'];
$A12 = $row['name'];
endforeach;
$data=array($A1,$A2,$A3,$A4,$A5,$A6,$A7,$A8,$A9,$A10,$A11,$A12,);
$field_cnt = count(array_filter($data));
$FC = $field_cnt;
$NF = '12';
$PC = round(($FC * 100) / $NF);
$current_day = date("D");

// Select User Profile & Rates Etc
$date = Date('Y-m-d');
$t1 = new FiscalYear('2023-04-11','04-06');
$YearStart = $t1->Start()->Format('Y-m-d');
$YearEnd = $t1->End()->Format('Y-m-d');
$YearStart1 = $t1->Start()->Format('d-m-Y');
$YearEnd1 = $t1->End()->Format('d-m-Y');
$sql = "SELECT pay_rate, salary
FROM user_details
INNER JOIN timesheet_details
ON user_details.user_id = timesheet_details.user_id
WHERE user_details.user_id = timesheet_details.user_id AND user_details.user_id = $id";
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
$user = $result->fetch_assoc(); // fetch data

$sql2 = "SELECT SUM(sum_hours) as hours, SUM(pay_total) as pay, SUM(over_time) as overtime
FROM user_details
INNER JOIN timesheet_details
ON user_details.user_id = timesheet_details.user_id
WHERE timesheet_details.wk_start BETWEEN '$YearStart' AND '$YearEnd' AND user_details.user_id = timesheet_details.user_id AND user_details.user_id = $id";
$stmt = $mysqli->prepare($sql2); 
$stmt->bind_param("i", $id);
$stmt->execute();
$result2 = $stmt->get_result(); // get the mysqli result
$user2 = $result2->fetch_assoc(); // fetch data

$query = "SELECT wk_end FROM timesheets WHERE user_id = $id AND wk_start >= DATE(NOW() - INTERVAL 6 DAY)";
$results = $mysqli->query($query);
if(mysqli_num_rows($results) > 0) {
    $last_timesheet = 1; //"You've Completed A Timesheet Within The Last Week";
} else {
    $last_timesheet = 0; //"You Haven't Completed A Timesheet This Week";
}

?>

<div class="row match-height">
    <div class="col-xl-4 col-lg-6 col-md-12">
        <div class="card pull-up ecom-card-1 bg-white">
            <div class="card-content ecom-card2">
                <a href="user_details.php">
                <div>
                    <i class="la la-user-secret success font-large-1 float-right p-1"></i></a>
                </div>
                <div class="card-body">
                    <h4 class="card-title success">Personal Profile</h4>
                    <h6 class="card-text">Complete Your Profile.</h6>
                    <a href="user_details.php">
                    <div class="progress" style="height: 3em; background-color: #cbf0c5">
                        <div class="progress-bar" role="progressbar" aria-valuenow="<? echo $PC ?>" aria-valuemin="0" aria-valuemax="100"
                            style="width: <? echo $PC ?>%; background-color: #5cb85c; font-size: 2em"><? echo $PC ?>%
                        </div>
                    </div>
                    <button type="button" class="btn mt-2 mb-1 btn-success btn-block">Edit Profile</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 col-md-12">
        <div class="card pull-up ecom-card-1 bg-white">
            <div class="card-content ecom-card2">
                <a href="timesheet.php">
                <div>
                    <i class="la la-calendar info font-large-1 float-right p-1"></i></a>
                </div>
                <div class="card-body">
                    <h4 class="card-title info">Timesheets</h4>
                    <h6 class="card-text">To be completed by Sunday each week.</h6>
                    <a href="timesheet.php">
                    <button type="button" class="btn mt-2 mb-1 <? if($last_timesheet==0) { echo 'btn-danger';} else { echo 'btn-info';};?> btn-lg btn-block">
                        <? if($last_timesheet==0) { echo 'It doesn\'t look like you\'ve completed you\'re timesheet yet - Please Click Here';
                        } else { echo 'Looks like you\'ve done you\'re timesheet for last week - Thanks :)';} ;?></button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12">
        <div class="card pull-up ecom-card-1 bg-white">
            <div class="card-content ecom-card2">
                <div>
                    <i class="la la-area-chart primary font-large-1 float-right p-1"></i>
                </div>
                <div class="card-body">
                    <h4 class="card-title primary">Work Profile </h4>
                    <h6 class="card-text mb-1">(<? Echo "Tax Year: " . $YearStart1 . " to " . $YearEnd1;?>)<br></h6>
                    <? if(($user['salary'] == NULL) && ($user['pay_rate'] > 0)) {
                            echo '
                            <p class="card-text">Hourly Rate: '. CURRENCY .' '.$user['pay_rate'].'</p>
                            <p class="card-text">Total Hours Worked: '.$user2['hours'].'</p>
                            <p class="card-text">Total Pay (after taxes): '.CURRENCY.' '.$user2['pay'].'</p>
                        ';}
                        else if(($user['pay_rate'] == NULL) && ($user['salary'] > 0)) {
                            echo '
                            <p class="card-text">Salary: '. CURRENCY .' '.$user['salary'].'</p>
                            <p class="card-text">Total Hours Worked: '.$user2['hours'].'</p>
                            <p class="card-text">Total Over-Time: '.$user2['overtime'].'</p>
                        ';}
                        else if (($user['pay_rate'] == NULL) && ($user['salary'] == NULL)) {
                            echo '
                            <p class="card-text">Your Account has not been reviewed by an Admin yet - This information will appear soon. Thanks.</p>
                        ';}
                        ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ eCommerce statistic -->

<!-- Statistics -->
<div class="row match-height">
    <div class="col-xl-4 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title bg-white" id="heading-multiple-thumbnails">Users & Contact</h4>
                    <a class="heading-elements-toggle">
                        <i class="la la-ellipsis-v font-medium-3"></i>
                    </a>
                    <div class="heading-elements">
                        <? $sql = mysqli_query($mysqli, "SELECT avatar FROM users");
                            while ($row = $sql->fetch_assoc()) {
                                if ($row['avatar'] == NULL) { $row['avatar'] = "default/add-avatar.png"; }
                                echo '<span class="avatar avatar-online">
                                <img src="theme-assets/images/portrait/'.$row['avatar'].'" alt="avatar" title="'.$row['name'].'">
                                </span>';
                            } ?>
                    </div>
                </div>
                <div class="card-content">
                <form action="includes/functions.php?action=sdf" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <h4 class="card-title">Send a message...</h4>
                            <p class="card-text"><b>Message To: </b><select class="card-text" name="contact" id="contact">
                            <option style="color: #666">Please Select:</option>
                                <? $sql = mysqli_query($mysqli, "SELECT * FROM users");
                                while ($row = $sql->fetch_assoc()) {
                                    echo '<option style="color: #666" value="'.$row['name'].','.$row['email'].'">'.$row['name'].'</option>';
                                    } ?>
                            </select></p>
                            <input type="hidden" name="contact_name" id="contact_name">
                            <input type="hidden" name="contact_email" id="contact_email">
                            <p class="card-text"><b>Subject: </b><input type="text" name="message_subject" id="message_subject"></p>
                            <p class="card-text"><b>Message: </b><textarea name="message" cols="35" rows="5"></textarea></p>
                            <p class="card-text"><b><br><br><br><br><br>Is A Follow Up / Reply Needed ? :</b><br>
                            <input type="radio" id="yes" name="follow" value="A Follow Up Is Required By The User. Please Respond !">
                            <label for="yes">Yes</label><br>
                            <input type="radio" id="no" name="follow" value="No Follow Up / Response Is Required.">
                            <label for="no">No</label><br></p>
                            <input type="submit" class="btn btn-success btn-block" name="sendmessage" id="sendmessage" value="Send Your Message">
                    </div>
                </form>
                </div>
            </div>
    </div>
    <div class="col-xl-4 col-lg-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <h4 class="card-title">Recent Jobs</h4>
                    <h6 class="card-subtitle text-muted">Some Recent Jobs - Uploaded Yours Yet?</h6>
                </div>
                <div id="carousel-area" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-area" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-area" data-slide-to="1"></li>
                        <li data-target="#carousel-area" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img src="theme-assets/images/carousel/08.jpg" class="d-block w-100" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img src="theme-assets/images/carousel/03.jpg" class="d-block w-100" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img src="theme-assets/images/carousel/01.jpg" class="d-block w-100" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carousel-area" role="button" data-slide="prev">
                            <span class="la la-angle-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                    <a class="carousel-control-next" href="#carousel-area" role="button" data-slide="next">
                            <span class="la la-angle-right icon-next" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                </div>
                <!--div class="card-body">
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div-->
            </div>
            <div class="card-footer border-top-blue-grey border-top-lighten-5 text-muted">
                <span class="float-left">2 days ago</span>
                <span class="tags float-right">
                    <span class="badge badge-pill badge-primary">Install</span>
                    <span class="badge badge-pill badge-danger">Showcase</span>
                </span>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Most Used Sites</h4>
                <a class="heading-elements-toggle">
                    <i class="fa fa-ellipsis-v font-medium-3"></i>
                </a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body sitesDiv">
                    <? $sql = mysqli_query($mysqli, "SELECT * FROM sites WHERE active = 1 AND id > 1 ORDER BY clicks DESC LIMIT 12");
                    while ($row = $sql->fetch_assoc()) {
                        echo '<p class="card-text">'.$row['customer'] . ", " . $row['site'].'
                        <a href="includes/functions.php?action=maps_link&maps_id='.$row['id'].'" target="_blank"><i class="la la-map-pin" title="Maps Link"></i></a></p>';
                    }?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Statistics -->
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<script>
$(function () {
    $("#contact").change(function() {
        var details = $(this).val().split(',');
  $("#contact_name").val(details[0]);
  $("#contact_email").val(details[1]);
})
   $("#contact").trigger("change");
})
</script>

<? include ('includes/footer.php')?>