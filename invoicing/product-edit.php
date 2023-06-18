<?php
include_once("includes/functions.php");
verifyAdmin();
include_once("includes/header.php");
include_once("includes/navbar.php");

$getID = $_GET['id'];

if (!$getID) {
    $getID = "Please Go To View Products and Select A Product To Edit.";
} else {
    $getID = $getID;
}

// the query
$query = "SELECT * FROM products WHERE product_id = '" . $mysqli->real_escape_string($getID) . "'";

$result = mysqli_query($mysqli, $query);

// mysqli select query
if($result) {
	while ($row = mysqli_fetch_assoc($result)) {
		$product_id = $row['product_id']; // product name
		$product_name = $row['product_name']; // product name
		$product_desc = $row['product_desc']; // product description
		$product_price = $row['product_price']; // product price
		$product_tax = $row['product_tax']; // product price
		$product_active = $row['product_active']; // product active
	}
}

?>

<style>
input[type=text], input[type=number], .item_tax {
    border: 1px solid #ccc; 
    border-radius: 5px;
    padding: 3px 5px;
    margin: 3px;
    min-width: 60%;
    max-width: 90%;
    float: right;
    color: #808080;
}
</style>


<div class="content-body">
<form action="includes/functions.php?action=epd" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Edit Product (<?php echo $getID; ?>) </h4>
                        Product <?php if ($product_active == '1'){ echo "IS Active - Uncheck to de-activate";} else { echo "NOT Active - Check to activate";}; ?>
                        <input type="checkbox" name="product_active" value="1"<?php if ($product_active == '1') echo "checked='checked'"; ?>>
                        <hr>
                        <div class="row">
                            <div class="col-xl-6">
                            <p class="card-text">Product ID: 
                                <input type="text" name="product_id" value="<?php echo $product_id; ?>" readonly></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Product Name: *
                                <input type="text" name="product_name" value="<?php echo $product_name; ?>" required></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Product Description: *
								<input type="text"name="product_desc" value="<?php echo $product_desc; ?>" required></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Product Price Per Unit (in <?php echo CURRENCY ?>): *
                                	<input type="number" name="product_price" min="0" step="0.01" value="<?php echo $product_price; ?>"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Line Item Tax: (%)
                                <select class="card-text item_tax" onchange="sumLine()" name="item_tax" id="item_tax">
                                    <option value="<?php echo $product_tax; ?>"><?php echo $product_tax; ?></option>
                                    <option value="0">N/A</option>
                                    <? $sql = mysqli_query($mysqli, "SELECT * FROM taxes");
                                    $first = TRUE;
                                    while ($row = mysqli_fetch_object($sql)) {
                                        echo '<option value="'.$row->tax_amount.'">'.$row->tax_name.",  ".$row->tax_amount.'%</option>';
                                        } ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <input type="submit" id="action_update_product" class="btn btn-success" value="Update Product" data-loading-text="Updating..."
						<?if (!$_GET['id']) echo 'disabled'?>>
                    </div>
                </div>
            </div>
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

<? include ('includes/footer.php');
/* close connection */
$mysqli->close();?>