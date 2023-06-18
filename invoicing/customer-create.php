<?php
include_once("includes/functions.php");
verifyAdmin();
include_once("includes/header.php");
include_once("includes/navbar.php");

// the query
$query = "SELECT `auto_increment` FROM INFORMATION_SCHEMA.TABLES
WHERE table_name = 'store_customers'";
$result = mysqli_query($mysqli, $query);
// mysqli select query
if($result) {
	while ($row = mysqli_fetch_assoc($result)) {
		$nextid = $row['AUTO_INCREMENT']; // customer name
	}
}
/* close connection */
$mysqli->close();
?>

<style>
input[type=text], input[type=password], input[type=date], input[type=email] {
    border: 1px solid #ccc; 
    border-radius: 5px;
    padding: 1px 5px;
    min-width: 50%;
    max-width: 70%;
    float: right;
}
</style>

<script>
function sync(){
  var n1 = document.getElementById('customer_name');
  var n2 = document.getElementById('customer_address_1');
  var n3 = document.getElementById('customer_address_1_ship');
  n2.value = n1.value;
  n3.value = n1.value;
  var n4 = document.getElementById('n4');
  var n8 = document.getElementById('n8');
  n8.value = n4.value;
  var n5 = document.getElementById('n5');
  var n9 = document.getElementById('n9');
  n9.value = n5.value;
  var n6 = document.getElementById('n6');
  var n10 = document.getElementById('n10');
  n10.value = n6.value;
  var n7 = document.getElementById('n7');
  var n11 = document.getElementById('n11');
  n11.value = n7.value;
  var n12 = document.getElementById('n12');
  var n13 = document.getElementById('n13');
  n13.value = n12.value;
}
</script>


<div class="content-body">
    <form action="includes/functions.php?action=cnc" method="post" enctype="multipart/form-data">
    <div class="row match-height">
        <div class="col-xl-6 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Create Customer </h4>
                        Activate Account
                        <input type="checkbox" name="customer_active" value="1" checked>
                        <hr>
                            <p class="card-text">Company Name: *<input type="text" name="customer_name" id="customer_name" onkeyup="sync()" required></p>
                            <p class="card-text">Contact Name: *<input type="text" name="customer_name_2" id="n12" onkeyup="sync()" required></p>
                            <p class="card-text">Email 1: *<input type="email" name="customer_email" required></p>
                            <p class="card-text">Email 2: <input type="email" name="customer_email_2"></p>
                            <p class="card-text">Phone Number: *<input type="text" name="customer_phone" required></p>
                            <p class="card-text">Website: <input type="text" name="customer_website"></p>
                            <p class="card-text">VAT Number: <input type="text" name="vat_number"></p>
                            <p class="card-text">CIS Number: <input type="text" name="cis_number"></p>
                            <p class="card-text">UTR Number: <input type="text" name="utr_number"></p>
                            <p class="card-text">Customer ID: <input type="text" name="cust_id" value="<? echo $nextid; ?>" readonly></p>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Invoice Address</h4>
                        <hr>
                            <p class="card-text">Address Line 1: *<input type="text" name="customer_address_1" id="customer_address_1" value="<?php echo $customer_address_1; ?>" required></p>
                            <p class="card-text">Address Line 2: *<input type="text" name="customer_address_2" id="n4" value="<?php echo $customer_address_2; ?>" onkeyup="sync()" required></p>
                            <p class="card-text">Town: *<input type="text" name="customer_town" id="n5" value="<?php echo $customer_town; ?>" onkeyup="sync()" required></p>
                            <p class="card-text">County: *<input type="text" name="customer_county" id="n6" value="<?php echo $customer_county; ?>" onkeyup="sync()" required></p>
                            <p class="card-text">Postcode: *<input type="text" name="customer_postcode" id="n7" value="<?php echo $customer_postcode; ?>" onkeyup="sync()" required></p>  
                            <p class="card-text">Add To Sites List - Appears on timesheets and dashboard with maps link. (Recommended): <input type="checkbox" name="add_to_sites" value="1" checked></p>     

                        <h4 class="card-title">Shipping Address</h4>
                        <hr>
                            <p class="card-text">Shipping Name: *<input type="text" name="customer_name_ship" id="n13" required></p>
                            <p class="card-text">Address Line 1: *<input type="text" name="customer_address_1_ship" id="customer_address_1_ship" required></p>
                            <p class="card-text">Address Line 2: <input type="text" name="customer_address_2_ship" id="n8"></p>
                            <p class="card-text">Town: *<input type="text" name="customer_town_ship" id="n9" required></p>
                            <p class="card-text">County: *<input type="text" name="customer_county_ship" id="n10" required></p>
                            <p class="card-text">Postcode: *<input type="text" name="customer_postcode_ship" id="n11" required></p>  

                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="row">
		<div class="col-sm-12 margin-top btn-group">
			<input type="submit" id="action_create_customer" class="btn btn-success float-right" value="Create Customer" data-loading-text="Updating...">
		</div>
	</div>
</form>


</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Statistics -->
<!-- ////////////////////////////////////////////////////////////////////////////-->

<? include ('includes/footer.php')?>