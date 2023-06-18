<?php
include_once("includes/functions.php");
verifyAdmin();
include_once("includes/header.php");
include_once("includes/navbar.php");

$getID = $_GET['id'];

if (!$getID) {
    $getID = "Please Go To View Customers and Select A Customer To Edit.";
} else {
    $getID = $getID;
}

// the query
$query = "SELECT * FROM store_customers WHERE id = '" . $mysqli->real_escape_string($getID) . "'";

$result = mysqli_query($mysqli, $query);

// mysqli select query
if($result) {
	while ($row = mysqli_fetch_assoc($result)) {

		$customer_id = $row['id']; // customer name
		$customer_name = $row['name']; // customer name
		$customer_name_2 = $row['name_2']; // customer name
		$customer_email = $row['email']; // customer email
		$customer_email_2 = $row['email_2']; // customer email 2
		$customer_address_1 = $row['address_1']; // customer address
		$customer_address_2 = $row['address_2']; // customer address
		$customer_town = $row['town']; // customer town
		$customer_county = $row['county']; // customer county
		$customer_postcode = $row['postcode']; // customer postcode
		$customer_phone = $row['phone']; // customer phone number
		
		//shipping
		$customer_name_ship = $row['name_ship']; // customer name (shipping)
		$customer_address_1_ship = $row['address_1_ship']; // customer address (shipping)
		$customer_address_2_ship = $row['address_2_ship']; // customer address (shipping)
		$customer_town_ship = $row['town_ship']; // customer town (shipping)
		$customer_county_ship = $row['county_ship']; // customer county (shipping)
		$customer_postcode_ship = $row['postcode_ship']; // customer postcode (shipping)

        //More Info
		$customer_website = $row['website']; // customer website
		$customer_vat = $row['vat_number']; // customer VAT number
		$customer_cis = $row['cis_number']; // customer CIS Number
		$customer_utr = $row['utr_number']; // customer UTR Number
		$customer_active = $row['active']; // customer active ?
	}
}

// the query
$query2 = "SELECT * FROM sites WHERE customer = '" . $mysqli->real_escape_string($customer_name) . "'";

$result2 = mysqli_query($mysqli, $query2);

// mysqli select query
if($result2) {
	while ($row = mysqli_fetch_assoc($result2)) {
        $siteid = $row['id']; // ID
		$in_sites = $row['active']; // Active?
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


<div class="content-body">
    <form action="includes/functions.php?action=ecd" method="post" enctype="multipart/form-data">
    <div class="row match-height">
        <div class="col-xl-6 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Edit Customer (<?php echo $getID; ?>) </h4>
                        Account <?php if ($customer_active == '1'){ echo "IS Active - Uncheck to de-activate";} else { echo "NOT Active - Check to activate";}; ?>
                        <input type="checkbox" name="customer_active" value="1"<?php if ($customer_active == '1') echo "checked='checked'"; ?>>
                        <br>Active In Sites List - Appears on timesheets and dashboard with maps link. (Recommended): 
                                <input type="checkbox" name="add_to_sites" value="1" <?php if ($in_sites == '1') echo "checked='checked'"; ?>> 
                        <hr>
                            <p class="card-text">Company Name: *<input type="text" name="customer_name" value="<?php echo $customer_name; ?>" required></p>
                            <p class="card-text">Contact Name: *<input type="text" name="customer_name_2" value="<?php echo $customer_name_2; ?>" required></p>
                            <p class="card-text">Email 1: *<input type="email" name="customer_email" value="<?php echo $customer_email; ?>" required></p>
                            <p class="card-text">Email 2: <input type="email" name="customer_email_2" value="<?php echo $customer_email_2; ?>"></p>
                            <p class="card-text">Phone Number: *<input type="text" name="customer_phone" value="<?php echo $customer_phone; ?>" required></p>
                            <p class="card-text">Website: <input type="text" name="customer_website" value="<?php echo $customer_website; ?>"></p>
                            <p class="card-text">VAT Number: <input type="text" name="vat_number" value="<?php echo $customer_vat; ?>"></p>
                            <p class="card-text">CIS Number: <input type="text" name="cis_number" value="<?php echo $customer_cis; ?>"></p>
                            <p class="card-text">UTR Number: <input type="text" name="utr_number" value="<?php echo $customer_utr; ?>"></p>
                            <p class="card-text">Customer ID: <input type="text" name="cust_id" value="<?php echo $customer_id; ?>" readonly></p>

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
                            <p class="card-text">Address Line 1: *<input type="text" name="customer_address_1" value="<?php echo $customer_address_1; ?>" required></p>
                            <p class="card-text">Address Line 2: *<input type="text" name="customer_address_2" value="<?php echo $customer_address_2; ?>" required></p>
                            <p class="card-text">Town: *<input type="text" name="customer_town" value="<?php echo $customer_town; ?>" required></p>
                            <p class="card-text">County: *<input type="text" name="customer_county" value="<?php echo $customer_county; ?>" required></p>
                            <p class="card-text">Postcode: *<input type="text" name="customer_postcode" value="<?php echo $customer_postcode; ?>" required></p>  
                            <input type="text" name="site_id" value="<?php echo $siteid; ?>">

                        <h4 class="card-title">Shipping Address</h4>
                        <hr>
                            <p class="card-text">Shipping Name: *<input type="text" name="customer_name_ship" value="<?php echo $customer_name_ship; ?>" required></p>
                            <p class="card-text">Address Line 1: *<input type="text" name="customer_address_1_ship" value="<?php echo $customer_address_1_ship; ?>" required></p>
                            <p class="card-text">Address Line 2: <input type="text" name="customer_address_2_ship" value="<?php echo $customer_address_2_ship; ?>"></p>
                            <p class="card-text">Town: *<input type="text" name="customer_town_ship" value="<?php echo $customer_town_ship; ?>" required></p>
                            <p class="card-text">County: *<input type="text" name="customer_county_ship" value="<?php echo $customer_county_ship; ?>" required></p>
                            <p class="card-text">Postcode: *<input type="text" name="customer_postcode_ship" value="<?php echo $customer_postcode_ship; ?>" required></p>  

                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="row">
		<div class="col-sm-12 margin-top btn-group">
			<input type="submit" id="action_update_customer" class="btn btn-success float-right" value="Update Customer" data-loading-text="Updating..."
            <?if (!$_GET['id']) echo 'disabled'?>>
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