<?php
include_once("includes/header.php");
include_once("includes/navbar.php");
include_once("includes/functions.php");

?>

<style>
    th, tr {
    padding-left: 10px;
    padding-right: 10px;
    height: 30px;
    }
    table {
        width:95%;
    }

input[type=text], input[type=password], input[type=date], select, textarea {
    border: 1px solid #ccc; 
    border-radius: 5px;
    padding: 3px 5px;
    margin: 3px;
    min-width: 60%;
    max-width: 90%;
    float: right;
}

.table input {
    border: 1px solid #ccc; 
    border-radius: 5px;
    padding: 1px;
    margin: 1px;
    min-width: 100%;
}
</style>

<script>
$(function () {
    $("#customer_name").change(function() {
        var details = $(this).val().split(',');
  $("#customer_email_1").val(details[0]);
  $("#customer_email_2").val(details[1]);
  $("#customer_name_2").val(details[2]);
  $("#customer_address_1").val(details[3]);
  $("#customer_address_2").val(details[4]);
  $("#customer_town").val(details[5]);
  $("#customer_county").val(details[6]);
  $("#customer_postcode").val(details[7]);
  $("#customer_phone").val(details[8]);
  $("#customer_ship_name").val(details[9]);
  $("#customer_ship_address_1").val(details[10]);
  $("#customer_ship_address_2").val(details[11]);
  $("#customer_ship_town").val(details[12]);
  $("#customer_ship_county").val(details[13]);
  $("#customer_ship_postcode").val(details[14]);
  $("#customer_ship_phone").val(details[8]);
})
   $("#customer_name").trigger("change");
})


</script>

<div class="content-body">

<!--/ Template Customization -->
<form action="includes/functions.php?action=createinvoice" method="post" enctype="multipart/form-data">
    <div class="row">
        <input id="pay_term" type="hidden" name="pay_term" value="<? echo str_replace("'","",INVOICE_PAYMENT_TERM)?>"></p>
        <div class="col-xl-12 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Order Information</h4>
                        <hr>
                        <div class="row">
                            <div class="col-xl-4">
                                <p class="card-text">Select Type: *
                                <select name="invoice_type" id="invoice_type" onkeyup="sync()" required>>
                                    <option value="invoice" selected>Invoice</option>
                                    <option value="quote">Quote</option>
                                </select></p>
                            </div>
                            <div class="col-xl-4">
                                <p class="card-text">Status: *
                                <select name="invoice_type" id="invoice_type" onkeyup="sync()" required>>
                                    <option value="open" selected>Open</option>
                                    <option value="paid">Paid</option>
                                </select></p>
                            </div>
                            <div class="col-xl-4">
                                <p class="card-text">Reference: *
                                    <input type="text" name="invoice_reference" placeholder="Enter Job Reference / PO / Order Number" required></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4">
                                <p class="card-text">Invoice Date: *
                                <input id="invoice_date" type="date" name="invoice_date" onchange="getdate()" required></p>
                            </div>
                            <div class="col-xl-4">
                                <p class="card-text">Due Date: *
                                <input id="invoice_due_date" type="text" name="invoice_due_date"></p>
                            </div>
                            <div class="col-xl-4">
                                <p class="card-text">Invoice Number: #
                                <input type="text" name="invoice_id" id="invoice_id" placeholder="Invoice Number" value="<?php echo INVOICE_PREFIX ?><?php getInvoiceId(); ?>"/></p>
                            </div>
                        </div>
                        <hr>
                        <h4 class="card-title">Customer</h4>
                        <div class="row">
                            <div class="col-xl-4">
                                <p class="card-text">Customer: *
                                    <select class="card-text select-product" id="customer_name" name="customer_name">
                                        <option style="color: #666">Select a Customer:</option>
                                        <? $sql = mysqli_query($mysqli, "SELECT * FROM store_customers WHERE active = 1");
                                        $first = TRUE;
                                        while ($row = mysqli_fetch_object($sql)) {
                                            echo "<option style='color: #666' value='".$row->email.",".$row->email_2.",".$row->name_2.",".$row->address_1.","
                                            .$row->address_2.",".$row->town.",".$row->county.",".$row->postcode.",".$row->phone.",".$row->name_ship.
                                            ",".$row->address_1_ship.",".$row->address_2_ship.",".$row->town_ship.",".$row->county_ship.",".$row->postcode_ship."'>
                                            ".$row->name.' - '.$row->name_2."</option>";
                                            } ?>
                                    </select></p>
                            </div>
                            <div class="col-xl-4">
                                <p class="card-text">Email 1: 
                                <input type="text" name="customer_email_1" id="customer_email_1" required/></p>
                            </div>
                            <div class="col-xl-4">
                                <p class="card-text">Email 2: 
                                <input type="text" name="customer_email_2" id="customer_email_2"/></p>
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
                                <input type="text" name="customer_name_2" id="customer_name_2" required/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Address Line 1: 
                                <input type="text" name="customer_address_1" id="customer_address_1"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">Address Line 2: 
                                <input type="text" name="customer_address_2" id="customer_address_2"/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Town: 
                                <input type="text" name="customer_town" id="customer_town"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">County: 
                                <input type="text" name="customer_county" id="customer_county"/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Post Code: 
                                <input type="text" name="customer_postcode" id="customer_postcode"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">Phone:
                                <input type="text" name="customer_phone" id="customer_phone"/></p>
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
                                <input type="text" name="customer_ship_name" id="customer_ship_name" required/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Address Line 1: 
                                <input type="text" name="customer_ship_address_1" id="customer_ship_address_1"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">Address Line 2: 
                                <input type="text" name="customer_ship_address_2" id="customer_ship_address_2"/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Town: 
                                <input type="text" name="customer_ship_town" id="customer_ship_town"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">County: 
                                <input type="text" name="customer_ship_county" id="customer_ship_county"/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Post Code: 
                                <input type="text" name="customer_ship_postcode" id="customer_ship_postcode"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">Phone:
                                <input type="text" name="customer_ship_phone" id="customer_ship_phone"/></p>
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
                                    <th width="5%">
                                        <p class="card-text">#</p>
                                    </th>
                                    <th max-width="10%">
                                        <p class="card-text">Item <a href="product-add.php"><i title="Add Product" class="la la-plus"></i></a></p>
                                    </th>
                                    <th width="30%">
                                        <p class="card-text">Description</p>
                                    </th>
                                    <th width="5%">
                                        <p class="card-text">Unit Cost</p>
                                    </th>
                                    <th width="5%">
                                        <p class="card-text">Qty</p>
                                    </th>
                                    <th width="5%">
                                        <p class="card-text">Tax</p>
                                    </th>
                                    <th width="5%">
                                        <p class="card-text">Line Total</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="select-items">

                            

                                <tr>
                                    
                                    
                                    
                                    <td>
                                        <p class="card-text">1</p>
                                    </td>
                                    <td>
                                            <select class="card-text" style="max-width: 80px;" name="item[]" id="item_select"  onchange="myFunction()" required>
                                                <option selected disabled>Item:</option>
                                                <? $sql = mysqli_query($mysqli, "SELECT * FROM products WHERE product_active = 1");
                                                $first = TRUE;
                                                while ($row = mysqli_fetch_object($sql)) {
                                                    echo '<option value="'.$row->product_name.",".$row->product_desc.",".$row->product_price.'">'.$row->product_name." - ".$row->product_desc.'</option>';
                                                 } ?>
                                            </select>
                                            <?php //popProductsList(); ?>
                                    </td>
                                    <td>
                                            <input class="card-text" id="item_unit_description" type="text" name="item_unit_description[]" >
                                    </td>
                                    <td>
                                            <input class="card-text" id="item_unit_cost" type="number" name="item_unit_cost[]" >
                                    </td>
                                    <td>
                                            <input class="card-text" id="item_quantity[]" type="text" name="item_quantity[]"  style="max-width: 80px;">
                                    </td>
                                    <td>
                                            <input class="card-text" id="item_tax[]" type="text" name="item_tax[]" >
                                    </td>
                                    <td>
                                            <input class="card-text" id="item_line_total[]" type="text" name="item_line_total[]">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success mr-1 mb-1" onclick="addRows();"><i class="la la-plus"></i></button>
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
                        <h4 class="card-title">Notes</h4>
                        <hr>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text"> 
                                <textarea id="notes" name="notes" rows="4" cols="90"></textarea></p>
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
                        <h4 class="card-title">Documents</h4>
                        <hr>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text"> 
                                <input type="file" name="files" id="files" multiple></p>
                                <div id="selectedFiles"></div>
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
                        <h4 class="card-title">Totals</h4>
                        <hr>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Sub-Total: 
                                <input type="text" name="total_subtotal" id="total_subtotal" required/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Tax: 
                                <input type="text" name="total_tax" id="total_tax" required/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Balance Due: 
                                <input type="text" name="total_balance_due" id="total_balance_due" required/></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-group btn-block" role="group" aria-label="">
    <button type="button" onclick="confirmFunction()" class="btn btn-danger">Cancel / Back to Dashboard</button>
    <button type="button" onclick="location.href='includes/functions.php?action=sio';" class="btn btn-info">Save Only</button>
    <button type="button" onclick="location.href='includes/functions.php?action=eio';" class="btn btn-warning">Email to Customer</button>
    </div>
</form>

<!-- END OF SITE NAVIGATION TOP RIGHT AND PAGE ------------------------------------------->
<? $mysqli->close();?>
</div>

<!-- SCRIPTS //////////////////////////////////////////////////////////////////////////////-->



    <script>
    // FUNCTION TO INSERT ITEM DETAILS //
        function myFunction() {
        var x = document.getElementById("item_select").value;
        var details = x.split(',');
        document.getElementById("item_unit_description").value = (details[1]);
        document.getElementById("item_unit_cost").value = (details[2]);
        }
    // END OF - FUNCTION TO INSERT ITEM DETAILS // WORKS ON FIRST LINE ONLY
    </script>



    <!-- DATE PICKER -->
    <script>
        $(document).ready(function () {
        $('#invoice_date').datepicker();
    });
    function getdate() {
        var tt = document.getElementById('invoice_date').value;
        var nod = document.getElementById('pay_term').value;

        var date = new Date(tt);
        var newdate = new Date(date);

        newdate.setDate(newdate.getDate() + parseInt(nod));

        var dd = ('0' + newdate.getDate()).slice(-2);
        var mm = ('0' + (newdate.getMonth()+1)).slice(-2);
        var y = newdate.getFullYear();

        var someFormattedDate = dd + '/' + mm + '/' + y;
        document.getElementById('invoice_due_date').value = someFormattedDate;
    }
    </script>

    <!-- Add Row To Item Table -->
    <script>  
    function addRows () {
    var table = document.getElementById('items_table');
    var rowCount = table.rows.length;
    var iteration = rowCount -1;
    var numbers = iteration +1;
    var row = table.insertRow(rowCount);
    var colCount = table.rows[0].cells.length;

    // Cell for number
    var cell = row.insertCell(0);
    var label = document.createElement('p');
    label.textContent = numbers;
    cell.appendChild(label);

    for(var i=1; i<colCount; i++) {

        var newcell = row.insertCell(i);
        newcell.innerHTML = table.rows[1].cells[i].innerHTML.replace(/name="(.+)1"/, 'name="$1' + rowCount + '"');
    }
    }
    </script>

    <!-- Script to List File Uploads -->
    <script>
	var selDiv = "";
		
	document.addEventListener("DOMContentLoaded", init, false);
	
	function init() {
		document.querySelector('#files').addEventListener('change', handleFileSelect, false);
		selDiv = document.querySelector("#selectedFiles");
	}
		
	function handleFileSelect(e) {
		
		if(!e.target.files) return;
		
		selDiv.innerHTML = "";
		
		var files = e.target.files;
		for(var i=0; i<files.length; i++) {
			var f = files[i];
			
			selDiv.innerHTML += f.name + "<br/>";

		}
		
	}
	</script>

    <!-- Script for cancel confirmation -->
    <script>
    function confirmFunction() {
        if (confirm("Are You sure? \n Any Unsaved Data will be lost!") == true) {
            location.href='dashboard.php';
        } else {
            
        }
    }
    </script>

<? include ('includes/footer.php')?>