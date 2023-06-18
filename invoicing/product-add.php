<?php
include_once("includes/functions.php");
verifyAdmin();
include_once("includes/header.php");
include_once("includes/navbar.php");

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

<!--/ Template Customization -->
<form action="includes/functions.php?action=cnp" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Create A Product / Service</h4>
                        Activate Product
                        <input type="checkbox" name="product_active" value="1" checked>
                        <hr>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Product Name: *
                                <input type="text"name="product_name" placeholder="Enter Product Name" required></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Product Description: *
								<input type="text"name="product_desc" placeholder="Enter Product Description" required></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Product Price Per Unit (in <?php echo CURRENCY ?>): *
                                	<input type="number" name="product_price" placeholder="0.00" aria-describedby="sizing-addon1" step="0.01"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Line Item Tax: (%)
                                <select class="card-text item_tax" onchange="sumLine()" name="item_tax" id="item_tax">
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
                        <input type="submit" id="action_create_product" class="btn btn-success" value="Create Product" data-loading-text="Updating...">
                    </div>
                </div>
            </div>
        </div>
        </div>
	</form>
</div>


<!-- SUBMIT FORM SECTION ------------------------------>


<!-- END OF SITE NAVIGATION TOP RIGHT AND PAGE ------------------------------------------->
</div>


<? include ('includes/footer.php')?>