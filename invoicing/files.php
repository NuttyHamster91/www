<?php
/////// INCLUDES ///////////////////

include_once("includes/header.php");
include_once("includes/navbar.php");
include_once("includes/functions.php");

/////// MYSQLI Query ///////////////

//$id = $_SESSION['id'];
//$sql = "SELECT users.*, uploads.* FROM users JOIN uploads WHERE users.id = uploads.user_id AND users.id = $id;";
//$stmt = $mysqli->prepare($sql); 
//$stmt->bind_param("i", $id);
//$stmt->execute();
//$result = $stmt->get_result(); // get the mysqli result
//$user = $result->fetch_assoc(); // fetch data
?>

<style>
input[type=text], input[type=date], select {
    border: 1px solid #ccc; 
    border-radius: 5px;
    padding: 1px 5px;
    min-width: 60%;
    max-width: 70%;
    float: right;
}
</style>

<div class="content-body">
<!--/ PAGE CONTENT -->

<div class="row match-height">
    <div class="col-xl-12 col-lg-12">
        <div class="card text-dark bg-white">
            <div class="card-content">
                <div class="card-body" style="padding-top:20px">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- UPLOAD SECTION -->
<div class="row match-height">
    <div class="col-xl-12 col-lg-12">
        <div class="card text-dark bg-white">
            <div class="card-content">
                <div class="card-body">                
                    <h4 class="card-title">Upload A File:</h4>
                    <p class="card-text"><b>*</b> - Required Field for every upload</p>
                    <div class="row">
                        <div class="col-xl-6 col-lg-12">
                            <form action="includes/functions.php?action=ulf" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="user_id" value="<? echo $_SESSION['id']?>">
                                    <input type="hidden" name="user_name" value="<? echo $_SESSION['name']?>">
                                    <p class="card-text"><input type="file" name="upload_file" id="upload_file">
                                    <p class="card-text"><b>Description*: </b><input type="text" name="description"></p>
                        </div>
                        <div class="col-xl-6 col-lg-12">
                            <p class="card-text"><b>File Valid Till: </b><input type="date" name="valid_till"></p>
                            <? if($_SESSION['admin'] == "yes") {
                                echo '<p class="card-text"><b>File Valid Till: </b><input type="date" name="valid_till"></p>';
                            }?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<p class="card-text"><b>Upload to Area of Site: </b><select class="card-text" name="site[]" id="projects">
                                <option style="color: #666">Select area of site:</option>';
                                $sql = mysqli_query($mysqli, "SELECT * FROM sites");
                                while ($row = $sql->fetch_assoc()){;
                                '<option style="color: #666" value="'. $row['site'].'">'. $row['site'].'</option>';
                                };
                                '</select></p>

<!--/ END OF PAGE -->
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->

<? include ('includes/footer.php')?>