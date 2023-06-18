<?php
include_once("includes/functions.php");
verifyAdmin();
include_once("includes/header.php");
include_once("includes/navbar.php");
include ('includes/invoice-edit.php');

// Get works ID
$getID = $_GET['inv'];
$getPRE = $_GET['pre'];

if (!$getID) {
    $getID = "Please Go To View Invoice / Quote and Select To Edit.";
} else {
    $getID = $getID;
}

// Convert to invoice ?
$convert = $_GET['t'];

// Connect to the database
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// output any connection error
if ($mysqli->connect_error) {
	die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
}

// the query
$query = "SELECT p.*, i.*, c.*
			FROM invoice_items p 
			JOIN invoices i ON i.invoice_no = p.invoice_no
			JOIN customer c ON c.invoice_no = i.invoice_no
			WHERE i.invoice_no = '" . $mysqli->real_escape_string($getID) . "'
            AND i.invoice_pre = '" . $mysqli->real_escape_string($getPRE) . "'";

$result = mysqli_query($mysqli, $query);

// mysqli select query
if($result) {
	while ($row = mysqli_fetch_assoc($result)) {
		$customer_name = $row['company']; // company name
		$contact_name = $row['name']; // contact name
		$customer_email_1 = $row['email_1']; // customer email
		$customer_email_2 = $row['email_2']; // customer email
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

		// invoice details
        $rowID = $row['id']; // id
        $custID = $row['inv_id'];
		$invoice_pre = $row['invoice_pre']; // invoice prefix
        $invoice_number = $row['invoice_no']; // invoice number
		$invoice_reference = $row['invoice_reference']; // invoice reference
		$custom_email = $row['custom_email']; // invoice custom email body
		$invoice_date = $row['invoice_date']; // invoice date
		$invoice_due_date = $row['invoice_due_date']; // invoice due date
		$invoice_subtotal = $row['subtotal']; // invoice sub-total
		$invoice_shipping = $row['shipping']; // invoice shipping amount
		$invoice_discount = $row['discount']; // invoice discount
		$invoice_vat = $row['vat']; // invoice vat
		$invoice_total = $row['total']; // invoice total
		$invoice_notes = $row['notes']; // Invoice notes
		if ($convert == "cti") {
            $invoice_type = "Invoice";
            $invoice_status = "Draft";
        } else { 
            $invoice_type = $row['invoice_type'];
            $invoice_status = $row['status'];
        } // Invoice type & status
		$invoice_tax = $row['invoice_tax']; // Invoice status
		$line_taxes = $row['line_taxes']; // Invoice status

	} 
}

?>

<script type="text/javascript">

    $(document).ready(function () {
        sumLine();
        getdate();
    });
</script>

<style>
    input:read-only {
    background-color: #f9f9f9;
}
</style>

<div class="content-body">

<!--/ Template Customization -->
<form method="post" enctype="multipart/form-data">
    <div class="row">
        <input id="pay_term" type="hidden" name="pay_term" value="<? echo str_replace("'","",INVOICE_PAYMENT_TERM)?>"></p>
        <div class="col-xl-12 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Order Information - Edit Order <?php echo $getPRE . ' ' . $getID; ?></h4>
                        <input class="tis" type="hidden" name="rowID" value="<?php echo $rowID; ?>" readonly required></p>
                        <input class="tis" type="hidden" name="custID" value="<?php echo $custID; ?>" readonly required></p>
                        <input class="tis" type="hidden" name="convert" value="<?php echo $convert; ?>" readonly required></p>
                        <input class="tis" type="hidden" name="qtpre" value="<?php echo $getPRE; ?>" readonly required></p>
                        <input class="tis" type="hidden" name="qtno" value="<?php echo $getID; ?>" readonly required></p>
                        <hr>
                        <div class="row">
                            <div class="col-xl-4">
                                <p class="card-text">Select Type: *
                                <select class="tis" name="invoice_type" id="invoice_type" onkeyup="sync()" onchange="invType(this.value);" required>
                                    <option value="<?php echo $invoice_type; ?>" Selected><?php echo $invoice_type; ?></option>
                                    <option value="Invoice">Invoice</option>
                                    <option value="Quote">Quote</option>
                                </select></p>
                            </div>
                            <div class="col-xl-4">
                                <p class="card-text">Status: *
                                <select class="tis" name="invoice_status" id="invoice_status" onkeyup="sync()" required>
                                    <option value="<?php echo $invoice_status; ?>" Selected><?php echo $invoice_status; ?></option>
                                    <option value="Draft">Draft</option>
                                    <option value="Paid">Paid</option>
                                </select></p>
                            </div>
                            <div class="col-xl-4">
                                <p class="card-text">Reference: *
                                    <input class="tis" type="text" name="invoice_reference" value="<?php echo $invoice_reference; ?>" maxlength="35" required></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3">
                                <p class="card-text">Original Date: *
                                <input class="tis" id="invoice_date_original" type="text" name="invoice_date" onchange="getdate()" value="<?php echo $invoice_date ?>" readonly></p>
                            </div>
                            <div class="col-xl-3">
                                <p class="card-text">New Invoice Date: 
                                <input class="tis" id="invoice_date" type="date" name="invoice_date" onchange="getdate()" value="<?php echo date("Y-m-d");?>"></p>
                            </div>
                            <div class="col-xl-3">
                                <p class="card-text">Due Date: *
                                <input class="tis" id="invoice_due_date" type="text" name="invoice_due_date" value="<?php echo $invoice_due_date; ?>"></p>
                            </div>
                            <div class="col-xl-3">
                                <p class="card-text">Invoice Number: #
                                <input class="tis" type="text" name="#" id="#" value="<?php if ($convert == "cti") { echo 'Generated On Save'; } else { echo $invoice_pre . $invoice_number; }?>" readonly/>
                                <input class="tis" type="hidden" name="invoice_pre" id="invoice_pre" value="<?php if ($convert == "cti") { echo INVOICE_PREFIX; } else { echo $invoice_pre; }?>"/>
                                <input class="tis" type="hidden" name="invoice_id" id="invoice_id" value="<?php if ($convert == "cti") { getInvoiceId(); } else { echo $invoice_number; }?>"/></p>
                            </div>
                        </div>
                        <hr>
                        <h4 class="card-title">Customer</h4>
                        <div class="row">
                            <div class="col-xl-4">
                                <p class="card-text">Customer: *
                                    <select class="select-product tis" id="customer_name" name="customer_name" readonly>
                                        <option selected style="color: #666" value="<?php echo $customer_name; ?>"><?php echo $customer_name; ?> </option>
                                    </select></p>
                            </div>
                            <input class="tis" type="hidden" name="customer" id="customer" value="<?php echo $customer_name; ?>" required/></p>
                            <div class="col-xl-4">
                                <p class="card-text">Email 1: 
                                <input class="tis" type="text" name="customer_email_1" id="customer_email_1" required value="<?php echo $customer_email_1; ?>"/></p>
                            </div>
                            <div class="col-xl-4">
                                <p class="card-text">Email 2: 
                                <input class="tis" type="text" name="customer_email_2" id="customer_email_2" value="<?php echo $customer_email_2; ?>"/></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Billing Information</h4>
                        <hr>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Contact Name: 
                                <input class="tis" type="text" name="customer_name_2" id="customer_name_2" required value="<?php echo $contact_name; ?>" readonly/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Address Line 1: 
                                <input class="tis" type="text" name="customer_address_1" id="customer_address_1" value="<?php echo $customer_address_1; ?>" readonly/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">Address Line 2: 
                                <input class="tis" type="text" name="customer_address_2" id="customer_address_2" value="<?php echo $customer_address_2; ?>" readonly/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Town: 
                                <input class="tis" type="text" name="customer_town" id="customer_town" value="<?php echo $customer_town; ?>" readonly/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">County: 
                                <input class="tis" type="text" name="customer_county" id="customer_county" value="<?php echo $customer_county; ?>" readonly/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Post Code: 
                                <input class="tis" type="text" name="customer_postcode" id="customer_postcode" value="<?php echo $customer_postcode; ?>" readonly/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">Phone:
                                <input class="tis" type="text" name="customer_phone" id="customer_phone" value="<?php echo $customer_phone; ?>" readonly/></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Shipping Information</h4>
                        <hr>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Shipping Name: 
                                <input class="tis" type="text" name="customer_ship_name" id="customer_ship_name" value="<?php echo $customer_name_ship; ?>"/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Address Line 1: 
                                <input class="tis" type="text" name="customer_ship_address_1" id="customer_ship_address_1" value="<?php echo $customer_address_1_ship; ?>"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">Address Line 2: 
                                <input class="tis" type="text" name="customer_ship_address_2" id="customer_ship_address_2" value="<?php echo $customer_address_2_ship; ?>"/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Town: 
                                <input class="tis" type="text" name="customer_ship_town" id="customer_ship_town" value="<?php echo $customer_town_ship; ?>"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">County: 
                                <input class="tis" type="text" name="customer_ship_county" id="customer_ship_county" value="<?php echo $customer_county_ship; ?>"/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Post Code: 
                                <input class="tis" type="text" name="customer_ship_postcode" id="customer_ship_postcode" value="<?php echo $customer_postcode_ship; ?>"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">Phone:
                                <input class="tis" type="text" name="customer_ship_phone" id="customer_ship_phone" value="<?php echo $customer_phone; ?>"/></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row match-height">
        <div class="col-xl-12 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body" style="padding-top:20px">
                        <table class="table table-hover table-responsive" id="items_table">
                            <thead>
                                <tr>
                                    <th class="zero">
                                        <p class="card-text">#</p>
                                    </th>
                                    <th class="twenty">
                                        <p class="card-text">Item <a onclick="confirm('Are You sure? \n Any Unsaved Data will be lost!') || event.preventDefault()"
                                            href="product-add.php"><i title="Add Product" class="la la-plus"></i></a></p>
                                    </th>
                                    <th class="thirty">
                                        <p class="card-text">Description</p>
                                    </th>
                                    <th class="ten">
                                        <p class="card-text">Unit Cost (<? echo CURRENCY ?>)</p>
                                    </th>
                                    <th class="ten">
                                        <p class="card-text">Qty</p>
                                    </th>
                                    <th class="ten">
                                        <p class="card-text">Line Tax (%)</p>
                                    </th>
                                    <th>
                                        <!--p class="card-text">Line Tax (<?// echo CURRENCY ?>)</p-->
                                    </th>
                                    <th class="twenty">
                                        <p class="card-text">Line Total (<? echo CURRENCY ?>)</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="select-items">
                            <?
                            // the query
                            $query = "SELECT p.*, i.*, c.*
                                        FROM invoice_items p 
                                        JOIN invoices i ON i.invoice_no = p.invoice_no
                                        JOIN customer c ON c.invoice_no = i.invoice_no
                                        WHERE p.invoice_no = '" . $mysqli->real_escape_string($getID) . "'";

                            $result = mysqli_query($mysqli, $query);

                            // mysqli select query
                            if($result) {
                                $count = mysqli_num_rows($result);
                                $i = 1;
                                while ($res = mysqli_fetch_assoc($result)) {?>
                                    <tr id="row<?echo $i?>">
                                        <td class="zero">
                                            <p class="card-text"><?echo $i?></p>
                                        </td>
                                        <td class="twenty">
                                                <select class="ois" style="width: 100%" name="item[]" id="item_select<?echo $i?>"  onchange="myFunction()" required>
                                                    <option selected ><? echo $res['product'] ?></option>
                                                    <? $sql = mysqli_query($mysqli, "SELECT * FROM products WHERE product_active = 1");
                                                    $first = TRUE;
                                                    while ($row1 = mysqli_fetch_object($sql)) {
                                                        echo '<option value="'.$row1->product_name.",".$row1->product_desc.",".$row1->product_price.",".$row1->product_tax.'">'.$row1->product_name." - ".$row1->product_desc.'</option>';
                                                    } ?>
                                                </select>
                                        </td>
                                        <td class="thirty">
                                                <input class="ois" onchange="" id="item_unit_description<?echo $i?>" type="text" name="item_unit_description[]" value="<? echo $res['product_desc'] ?>" >
                                        </td>
                                        <td class="ten">
                                                <input class="ois" onchange="sumLine()" id="item_unit_cost<?echo $i?>" type="number" name="item_unit_cost[]" value="<? echo $res['unit_price'] ?>" >
                                        </td>
                                        <td class="ten">
                                                <input class="qty ois" onkeyup="sumLine()" onclick="sumLine()" step="0.25" id="item_quantity<?echo $i?>" type="number" name="item_quantity[]"  style="max-width: 80px;" value="<? echo $res['qty'] ?>" >
                                        </td>
                                        <td class="ten">
                                            <select class="item_tax ois" onchange="sumLine()" name="item_tax[]" id="item_tax<?echo $i?>">
                                            <option value="<? echo $res['line_tax'] ?>"><? echo $res['line_tax'] ?></option>
                                                <? $sql = mysqli_query($mysqli, "SELECT * FROM taxes");
                                                $first = TRUE;
                                                while ($row2 = mysqli_fetch_object($sql)) {
                                                    echo '<option value="'.$row2->tax_amount.'">'.$row2->tax_name.",  ".$row2->tax_amount.'%</option>';
                                                 } ?>
                                            </select>                                                
                                        </td>
                                        <td>
                                                <input class="line_tax_amt ois" onchange="" id="line_tax_amt<?echo $i?>" type="hidden" name="line_tax_amt[]" value="<? echo $res['line_tax_amt'] ?>" >
                                        </td>
                                        <td class="twenty">
                                                <input class="line_total ois" onchange="" id="item_line_total<?echo $i?>" type="text" name="item_line_total[]" readonly value="<? echo $res['line_subtotal'] ?>" >
                                        </td>
                                    </tr><? $i++?>
                                <?}
                            }?>
                            </tbody>
                        </table>
                        <!--button type="button" class="btn btn-success mr-1 mb-1" onclick="addRows();"><i class="la la-plus"></i></button-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row match-height">
        <div class="col-xl-4 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Notes (Shown on paperwork)</h4>
                        <hr>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text"> 
                                <textarea class="ois" id="notes" name="notes" rows="5" cols="90"><?php echo $invoice_notes ?></textarea></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12">
            <div class="card bg-white overflow-auto">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Documents</h4>
                        <hr>
                        <div class="row">
                            <div class="col-xl-10">
                                    <p class="card-text"> 
                                        <? 
                                        // the query
                                        $query = "SELECT i.*, d.*
                                        FROM invoices i
                                        JOIN invoice_docs d ON d.invoice_id = i.invoice_no
                                        WHERE i.invoice_no = $getID 
                                        AND d.status = '1'";

                                        $results = $mysqli->query($query);

                                        if($results) {
                                            echo 'Current Documents:<br>';
                                        while($row3 = $results->fetch_assoc()) {
                                        print '<a href="'.dirname($_SERVER['PHP_SELF']).$row3["folder"].$row3["pass"].'-'.$row3["filename"].'" target="_blank"> ~ '.$row3["filename"].' ~ </a><br>';
                                        } 
                                        } else {
                                        print 'No Docs Currently Attached.';
                                        
                                        }?>
                                        <p><br></p>
                                    <input type="file" class="fois" id="upload_document[]" name="upload_document[]" accept="application/pdf" multiple>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Totals (<? echo CURRENCY ?>)</h4>
                        <hr>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Sub-Total: 
                                <input type="text" name="total_subtotal" id="total_subtotal" class="sub_total rois" value="<?php echo $invoice_subtotal ?>" readonly required/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Line Taxes: 
                                <input type="text" name="total_line_tax" id="total_line_tax" class="total_line_tax rois" value="<?php echo $line_taxes ?>" readonly required/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Taxes: 
                                <select class="card-text rois" onchange="sumLine()" name="invoice_tax" id="invoice_tax">
                                    <option selected value="<?php echo $invoice_tax ?>"><?php echo $invoice_tax ?></option>
                                    <option value="">N/A</option>
                                    <? $sql = mysqli_query($mysqli, "SELECT * FROM taxes");
                                    $first = TRUE;
                                    while ($row4 = mysqli_fetch_object($sql)) {
                                        echo '<option value="'.$row4->tax_amount.'">'.$row4->tax_name.",  ".$row4->tax_amount.'%</option>';
                                        } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Tax (<? echo CURRENCY ?>): 
                                <input type="text" name="subtotal_tax" id="subtotal_tax" class="subtotal_tax rois" readonly/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Balance Due: 
                                <input type="text" name="total_balance_due" id="total_balance_due" class="total_due rois" value="<?php echo $invoice_total ?>" readonly required/></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-group btn-block" role="group" aria-label="">
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmModal">Cancel / Back to Dashboard</button>
    <button type="submit" formaction="includes/functions.php?action=editsio" class="btn btn-info">Save Only</button>
    <button type="submit" formaction="includes/functions.php?action=editeio" class="btn btn-warning">Email to Customer</button>
    </div>
</form>

<!-- END OF SITE NAVIGATION TOP RIGHT AND PAGE ------------------------------------------->
<? $mysqli->close();?>
</div>
<!-- SCRIPTS //////////////////////////////////////////////////////////////////////////////-->

<? include ('includes/footer.php')?>

<script type="text/javascript">

    // Get Sent Documents
    function getInvDocs() {
        // the query
        $query = "SELECT i.*, d.*
        FROM invoices i
        JOIN invoice_docs d ON d.invoice_id = i.invoice_no
        WHERE i.invoice_no = '" . $mysqli->real_escape_string($id) . "'";

        $results = $mysqli->query($query);

        if($results) {
        while($row = $results->fetch_assoc()) {
        print '<p>File: '.$row["filename"].'<br></p>';
        }
        }

// close connection 
$mysqli->close();
}

</script>

<!-- MODALS --------------------------->
<!-- Trigger the modal with a button -->

<!-- Modal -->
<div id="confirmModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Are You Sure ?</h4>
      </div>
      <div class="modal-body">
        <p>Any unsaved data will be lost.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a href="dashboard.php"><button type="button" class="btn btn-success">Confirm</button></a>
      </div>
    </div>

  </div>
</div>