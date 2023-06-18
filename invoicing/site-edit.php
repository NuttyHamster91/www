<?php
include_once("includes/functions.php");
verifyAdmin();
include_once("includes/header.php");
include_once("includes/navbar.php");

$getID = $_GET['edit'];

if (!$getID) {
    $getID = "Please Go To Sites and Select A Site To Edit.";
} else {
    $getID = $getID;
}

// the query
$query = "SELECT * FROM sites WHERE id = '" . $mysqli->real_escape_string($getID) . "'";

$result = mysqli_query($mysqli, $query);

// mysqli select query
if($result) {
	while ($row = mysqli_fetch_assoc($result)) {

		$customer = $row['customer']; // customer name
		$site = $row['site']; // customer name
		$address = $row['address']; // customer name
		$maps_link = $row['maps_link']; // customer email
	}
}

/* close connection */
$mysqli->close();

// Example 2
$data = "foo:*:1023:1000::/home/foo:/bin/sh";
list($user, $pass, $uid, $gid, $gecos, $home, $shell) = explode(":", $data);

// Example 2
$data = $address;
list($AD1, $AD2, $AD3, $ADCounty, $ADPC) = explode(", ", $data);

?>

<style>
    th, tr {
    padding: 3px;
    width: 14%;
    height: 35px;
    }
    table {
        width:90%;
    }

    p .btn-group { display: inline-block; }
</style>

<!-- BODY CONTENT  -------------------------------------------------------------------->
<div class="content-body">
<!--/ Template Customization -->
    <form action="includes/functions.php?action=update_site" method="post" enctype="multipart/form-data">
        <div class="row match-height">
            <div class="col-xl-6 col-lg-12">
                <div class="card bg-white">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">Edit A Site:</h4>
                            <hr>
                            <div class="row">
                                <div class="col-xl-12">
                                    <p class="card-text">Site Owner / Customer: 
                                        <input type="text" name="site_owner" id="site_owner" class="form-control" value="<? echo $customer ?>"></p>
                                </div>
                            </div>
                            <hr>
                            <h4 class="card-title">Address</h4>
                            <div class="row">
                                <div class="col-xl-6">
                                    <p class="card-text">Building / Property / Site Name: *
                                        <input type="text" name="AD" id="AD" class="form-control sis" value="<? echo $site ?>" required></p>
                                </div>
                                <div class="col-xl-6">
                                    <p class="card-text">Address Line 1: *
                                        <input type="text" name="AD1" id="AD1" class="form-control sis" value="<? echo $AD1 ?>" required></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <p class="card-text">Address Line 2: 
                                        <input type="text" name="AD2" id="AD2" class="form-control sis" value="<? echo $AD2 ?>"></p>
                                </div>
                                <div class="col-xl-6">
                                    <p class="card-text">Address Line 3: 
                                        <input type="text" name="AD3" id="AD3" class="form-control sis" value="<? echo $AD3 ?>"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <p class="card-text">County: 
                                        <input type="text" name="ADCounty" id="ADCounty" class="form-control sis" value="<? echo $ADCounty ?>"></p>
                                </div>
                                <div class="col-xl-6">
                                    <p class="card-text">Post Code: *
                                        <input type="text" name="ADPC" id="ADPC" class="form-control sis" value="<? echo $ADPC ?>"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <p class="card-text"><br>Google Maps Link (Preferred Option) (On Maps -> Drop Pin -> Share -> Copy Link): 
                                        <input type="text" placeholder="E.G. https://goo.gl/maps/XG9Yy2GeNgPeXxmu7" name="ADMapLink" id="ADMapLink" class="form-control"
                                        value="<? echo $maps_link ?>"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <p class="card-text"> 
                                        <input type="hidden" name="site" id="site" class="form-control"></p>
                                </div>
                                <div class="col-xl-6">
                                    <p class="card-text">
                                        <input type="hidden" name="sid" id="sid" class="form-control" value="<? echo $getID ?>"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <br>
                                    <button class="btn btn-success btn-block w92" name="sendit" id="sendit">Update Site</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
    <script>
        $(".sis").change(function(){
        $("#site").val($("#AD").val());
        $("#fullAD").val($("#AD1").val() + ", " + $("#AD2").val() + ", " + $("#AD3").val() + ", " + $("#ADCounty").val() + ", " + $("#ADPC").val());

        
        var values = "";
        });
       </script> 
<!-- END OF SITE NAVIGATION TOP RIGHT AND PAGE ------------------------------------------->            
</div>
</div>
</div>
</div>
</div>
<? include ('includes/footer.php')?>