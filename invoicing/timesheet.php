<?php
//include('functions.php');
include_once("includes/header.php");
include_once("includes/navbar.php");
include_once("includes/functions.php");

$id = $_SESSION['id'];
$sql = "SELECT users.*, user_details.* FROM users JOIN user_details WHERE users.id = user_details.user_id AND users.id = $id;";
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
$user = $result->fetch_assoc(); // fetch data   

?>

<style>
input[type=text], input[type=password], input[type=date]{
    border: 1px solid #ccc; 
    border-radius: 5px;
    padding: 1px 5px;
    min-width: 40%;
    max-width: 70%;
    float: right;
}

#projects {
    border: 1px solid #ccc; 
    border-radius: 5px;
    padding: 1px;
    min-width: 100%;
    background: transparent;
    border-top-style: hidden;
    border-right-style: hidden;
    border-left-style: hidden;
    border-bottom-style: groove;
}

#sums {
    border: 0px solid #ccc; 
    border-radius: 5px;
    padding: 1px;
    min-width: 40%;
    display: inline;
    /* color: #666; */
    background: transparent;
}

table tr td:nth-child(n+6){
    display: none;
}
</style>

<div class="content-body">
    <form action="includes/functions.php?action=sts" method="POST" enctype="multipart/form-data">
    <div class="row match-height">
        <div class="col-xl-4 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Timesheet.</h4>
                        <p class="card-text">Please complete this timesheet weekly.</p>
                        <p class="card-text">Use One section per job - If you conduct multiple jobs at the same site please use multiple sections.</p>
                        <p class="card-text">E.g. Site "A" you conduct 5 jobs over 8 hours - Use 5 sections. If you visit 2 sites in one day but conduct one job per site, 
                            this is only 2 sections.</p>
                        <p class="card-text"><br></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">                
                    <h4 class="card-title">Check Your Details:</h4>
                            <p class="card-text">Please update your profile if these details have changed.</p>
                            <p class="card-text"><b>Full Name: </b><? echo $_SESSION['name'];?></p>
                            <p class="card-text"><b>Email: </b><? echo $user['email'];?></p>
                            <input type="hidden" name="user_email" value="<? echo $user['email'];?>">
                            <p class="card-text"><b>Sort Code: </b><? echo (openssl_decrypt ($user['srt'], $cipher, $user['k1'], $options, $encryption_iv));?></p>
                            <p class="card-text"><b>Acct. No.: </b><? echo (openssl_decrypt ($user['acct'], $cipher, $user['k1'], $options, $encryption_iv));?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">                
                    <h4 class="card-title">Select Week:</h4>
                            <p class="card-text">Week Beginning: (Mon) <input id="wk_start" type="date" name="wk_start" onchange="getdate()" required></p>
                            <p class="card-text">Week Ending: (Sun) <input id="wk_end" type="text" name="wk_end" readonly></p>
                    <h4 class="card-title">If Applicable:</h4>
                            <p class="card-text">PO Number: <input type="text" name="po_number"></p>
                            <p class="card-text">Unique Ref. No.: <input type="text" name="ref_number"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="tsDetails">
        <div class="row match-height">
            <div class="col-xl-12 col-lg-12">
                <div class="card bg-white">
                    <div class="card-content">
                        <div class="card-body" style="padding-top:20px">
                        <div class="sections">
                        <div class="template">
                            <div class="row match-height">
                                <div class="col-xl-2 col-lg-2">
                                    <h4 id="h4" class="card-title">Project No. 1</h4>
                                </div>
                                <div class="col-xl-3 col-lg-3">
                                    <div class="form-group form-group-sm mb-3">
                                        <p class="card-text">Date
                                        <input class="projects text-black" id="projects" type="date" name="pd[]" required></p>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-5">
                                    <div class="form-group form-group-sm no-margin-bottom">
                                        <p class="card-text projects text-black">Location / Site
                                        <select class="card-text projects text-black" name="site[]" id="projects" required>
                                            <option>Select a site:</option>
                                            <? $sql = mysqli_query($mysqli, "SELECT * FROM sites WHERE active = 1");
                                            while ($row = $sql->fetch_assoc()) {
                                                echo '<option style="color: #666" value="'.$row['site'].'">'.$row['customer']. ' - ' .$row['site'].'</option>';
                                                } ?>
                                        </select></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row match-height">
                                <div class="col-xl-2 col-lg-2">
                                    <div class="form-group form-group-sm no-margin-bottom mr-1">
                                        <p class="card-text projects text-black">Hours
                                        <input class="card-text projects text-black hours" id="projects" type="number" name="hours[]" step=".25" required></p>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-8">
                                    <div class="form-group form-group-sm no-margin-bottom ml-1">
                                        <p class="card-text projects text-black">Details Of Work Carried Out
                                        <input class="card-text projects text-black" id="projects" type="text" name="details[]" required></p>
                                        <p><br></p>
                                    </div>
                                </div>
                            </div> 
                            <hr>  
                            </div>    
                            </div> 
                            <button id='btn1' type="button" class="btn btn-success mr-1 mb-1 add"><i class="la la-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>     
    <div class="row match-height">
        <div class="col-xl-4 col-lg-4">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Summary.</h4>
                        <p class="card-text">Total Hours Worked: <input class="card-text projects text-black" type="number" name="sum" id="sums" readonly></p>
                        <? if(($user['salary'] == NULL) && ($user['pay_rate'] > 0)) {
                            echo '
                            <p class="card-text">Hourly Rate: '. CURRENCY .'<input class="card-text" type="number" name="rate" id="sums" value="'.$user['pay_rate'].'" readonly></p>
                            <p class="card-text"><input type="hidden" name="cis_rate" value="'.$user['cis_rate'].'"></p>
                            <p class="card-text">CIS Deduction: '.CURRENCY.'<input class="card-text" type="number" name="cis_total" id="sums" readonly></p>
                            <p class="card-text"><input type="hidden" name="vat_rate" value="'.$user['vat_rate'].'"></p>
                            <p class="card-text">VAT: '.CURRENCY.'<input class="card-text" type="number" name="vat_total" id="sums" readonly></p>
                            <p class="card-text"><b>Total Pay: '.CURRENCY.'<input class="card-text" type="number" name="pay_total" id="sums" readonly></b></p>
                            <input type="hidden" name="wk_hours" readonly>
                            <input type="hidden" name="over_time" readonly>
                        ';}
                        else if(($user['pay_rate'] == NULL) && ($user['salary'] > 0)) {
                            echo '
                            <p class="card-text">Your Salary: '. CURRENCY .'<input class="card-text" type="number" name="salary" id="sums" value="'.$user['salary'].'" readonly></p>
                            <p class="card-text">Contracted Hours: <input class="card-text" type="number" name="wk_hours" id="sums" value="'.$user['contracted_hours'].'" readonly></p>
                            <p class="card-text">Over-Time (hours): <input class="card-text" type="number" name="over_time" id="sums" readonly></p>
                            <input type="hidden" name="rate" id="sums" readonly>
                            <input type="hidden" name="cis_rate" readonly>
                            <input type="hidden" name="cis_total" readonly>
                            <input type="hidden" name="vat_rate" readonly>
                            <input type="hidden" name="vat_total" readonly>
                            <input type="hidden" name="pay_total" readonly>
                        ';}
                        else if (($user['pay_rate'] == NULL) && ($user['salary'] == NULL)) {
                            echo '
                            <p class="card-text">Your Account has not been completed by an Admin yet - Please submit your timesheet still. Thanks.</p>
                        ';}
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-8">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">How We Use This Information.</h4>
                        <p class="card-text">We simply use this to track the progress of our jobs & staff.</p>
                        <p class="card-text">Without this information we can't bill accurately for work carried out.</p>
                        <p class="card-text">It also makes sure you're paid correctly for what you do.</p>
                        <p class="card-text">All information you've entered here is sent and stored securely.</p>
                        <p class="card-text">By clicking submit you agree to this information being used, and our T&C's & Data Policy.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-xl-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <input type="submit" class="btn btn-success btn-block" name="sendtimesheet" id="sendtimesheet" value="Submit Your Timesheet">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<!--/ Statistics -->
<!-- ////////////////////////////////////////////////////////////////////////////-->

    <!--Script to get date 6 days (week begin & end dates)-->
   <script>
        $(document).ready(function () {
        $('#wk_start').datepicker();
        $('#wk_end').datepicker();
    });
    function getdate() {
        var tt = document.getElementById('wk_start').value;

        var date = new Date(tt);
        var newdate = new Date(date);

        newdate.setDate(newdate.getDate() + 6);

        var dd = ('0' + newdate.getDate()).slice(-2);
        var mm = ('0' + (newdate.getMonth()+1)).slice(-2);
        var y = newdate.getFullYear();

        var someFormattedDate = dd + '/' + mm + '/' + y;
        document.getElementById('wk_end').value = someFormattedDate;
    }
    </script>
    


    <script>
    // Clone Timesheet Details Section
    $(document).ready(function() {        
        var count = 1;
        $('.add').on('click', function() {
            count++;
            var clone = $('.template').clone('true').removeClass('template');
            clone.find('h4').attr('id', 'Project No.' + count);
            clone.find('h4').html('' + clone.find('h4').attr('id'));
            clone.find("input[type=text]").val("");
            clone.find("input[type=number]").val("");
            clone.find("input[type=date]").val("");
            clone.appendTo('.sections');
        });
    });

    var sum = 0;
    $('.hours').each(function(){
        sum += parseFloat(this.value);
    });
    </script>

    <!-- Script to add hours -->
    <script>
    addEventListener("input", function(e) {
    var sum = 0;
    $('.hours').each(function(){
        sum += parseFloat(this.value);
    });
    document.getElementsByName("sum")[0].value = sum.toFixed(2);


    // CIS TAX DEDUCTION //
    let num1 = document.getElementsByName("sum")[0].value || 0;
    let num2 = document.getElementsByName("rate")[0].value || 0;
    let num3 = document.getElementsByName("cis_rate")[0].value || 0;

    let sum3 = (Number(num1) * Number(num2)) * Number(num3);
    document.getElementsByName("cis_total")[0].value = sum3.toFixed(2);

    // VAT CALCULATION //
    let num4 = document.getElementsByName("vat_rate")[0].value || 0;
    
    let sum7 = ((Number(num1) * Number(num2))) * Number(num4);
    document.getElementsByName("vat_total")[0].value = sum7.toFixed(2);

    //Total Pay Calculation
    let sum5 = (Number(num1) * Number(num2)) - ((Number(num1) * Number(num2)) * Number(num3)) + ((Number(num1) * Number(num2)) * Number(num4));
    document.getElementsByName("pay_total")[0].value = sum5.toFixed(2);

    // Over-time Calculator
    let num5 = document.getElementsByName("sum")[0].value || 0;
    let num6 = document.getElementsByName("wk_hours")[0].value || 0;

    let value = 0
    value = (Number(num5) - Number(num6));
    //if (value < 0) {
    //    value = Math.max(0,value)
    //}
    //else if (value > 0) {
    //    value = value
    //}
    document.getElementsByName("over_time")[0].value = value;
    
  })
    </script>


<? include ('includes/footer.php')?>