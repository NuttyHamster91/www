<?php
include_once("includes/functions.php");
verifyAdmin();
include_once("includes/header.php");
include_once("includes/navbar.php");
include ('includes/invoice-create.php');

// Create Quote ?
$create_type = $_GET['IQ'];
?>

<script type="text/javascript">

    $(document).ready(function () {
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
                        <h4 class="card-title">Order Information</h4>
                        <hr>
                        <div class="row">
                            <div class="col-xl-4">
                                <p class="card-text">Select Type: *
                                <select class="tis" name="invoice_type" id="invoice_type" onkeyup="sync()" onchange="invType(this.value);" required>
                                <? if ($create_type == 'I') {?>
                                    <option value="Invoice" selected>Invoice</option>
                                    <option value="Quote">Quote</option>
                                <?} else if ($create_type == 'Q') {?>
                                    <option value="Quote" selected>Quote</option>
                                    <option value="Invoice">Invoice</option>
                                <?} else {?>
                                    <option value="Invoice" selected>Invoice</option>
                                    <option value="Quote">Quote</option>
                                <?}?>
                                </select></p>
                            </div>
                            <div class="col-xl-4">
                                <p class="card-text">Status: *
                                <select class="tis" name="invoice_status" id="invoice_status" onkeyup="sync()" required>>
                                    <option value="Draft" selected>Draft</option>
                                    <option value="Paid">Paid</option>
                                </select></p>
                            </div>
                            <div class="col-xl-4">
                                <p class="card-text">Reference: *
                                    <input class="tis" type="text" name="invoice_reference" placeholder="Enter Job Reference / PO / Order Number" 
                                    onchange="getdate()" maxlength="35" required></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4">
                                <p class="card-text">Invoice Date: *
                                <input class="tis" id="invoice_date" type="date" name="invoice_date" onchange="getdate()" value="<?php echo date("Y-m-d");?>" required></p>
                            </div>
                            <div class="col-xl-4">
                                <p class="card-text">Due Date: *
                                <input class="tis" id="invoice_due_date" type="text" name="invoice_due_date" readonly></p>
                            </div>
                            <div class="col-xl-4">
                                <p class="card-text">Invoice Number: #
                                <input class="tis" type="text" name="invNo" id="invNo" placeholder="Invoice Number" value="" readonly/>
                                <input class="tis" type="hidden" name="invoice_pre" id="invoice_pre" placeholder="Invoice Number" value=""/>
                                <input class="tis" type="hidden" name="invoice_id" id="invoice_id" placeholder="Invoice Number" value=""/></p>
                            </div>
                        </div>
                        <hr>
                        <h4 class="card-title">Customer</h4>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Select A Customer: *
                                    <select class="card-text select-product rois mb-2" id="customer_name" name="customer_name" onchange="invType();">
                                        <option selected style="color: #666">Select a Customer:</option>
                                        <? $sql = mysqli_query($mysqli, "SELECT * FROM store_customers WHERE active = 1");
                                        $first = TRUE;
                                        while ($row = mysqli_fetch_object($sql)) {
                                            echo "<option style='color: #666' value='".$row->name.",".$row->email.",".$row->email_2.",".$row->name_2.",".$row->address_1.","
                                            .$row->address_2.",".$row->town.",".$row->county.",".$row->postcode.",".$row->phone.",".$row->name_ship.
                                            ",".$row->address_1_ship.",".$row->address_2_ship.",".$row->town_ship.",".$row->county_ship.",".$row->postcode_ship."'>
                                            ".$row->name.' - '.$row->name_2."</option>";
                                            } ?>
                                    </select></p>
                            </div>
                        </div>
                        <div class="row">
                            <input class="tis" type="hidden" name="customer" id="customer" required/></p>
                            <div class="col-xl-6">
                                <p class="card-text">Email 1: 
                                <input class="rois" type="text" name="customer_email_1" id="customer_email_1" required/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">Email 2: 
                                <input class="rois" type="text" name="customer_email_2" id="customer_email_2"/></p>
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
                                <input class="tis" type="text" name="customer_name_2" id="customer_name_2" required/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Address Line 1: 
                                <input class="tis" type="text" name="customer_address_1" id="customer_address_1"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">Address Line 2: 
                                <input class="tis" type="text" name="customer_address_2" id="customer_address_2"/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Town: 
                                <input class="tis" type="text" name="customer_town" id="customer_town"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">County: 
                                <input class="tis" type="text" name="customer_county" id="customer_county"/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Post Code: 
                                <input class="tis" type="text" name="customer_postcode" id="customer_postcode"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">Phone:
                                <input class="tis" type="text" name="customer_phone" id="customer_phone"/></p>
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
                                <input class="tis" type="text" name="customer_ship_name" id="customer_ship_name" required/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Address Line 1: 
                                <input class="tis" type="text" name="customer_ship_address_1" id="customer_ship_address_1"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">Address Line 2: 
                                <input class="tis" type="text" name="customer_ship_address_2" id="customer_ship_address_2"/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Town: 
                                <input class="tis" type="text" name="customer_ship_town" id="customer_ship_town"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">County: 
                                <input class="tis" type="text" name="customer_ship_county" id="customer_ship_county"/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <p class="card-text">Post Code: 
                                <input class="tis" type="text" name="customer_ship_postcode" id="customer_ship_postcode"/></p>
                            </div>
                            <div class="col-xl-6">
                                <p class="card-text">Phone:
                                <input class="tis" type="text" name="customer_ship_phone" id="customer_ship_phone"/></p>
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
                        <table class="table  table-hover table-responsive" id="items_table">
                            <thead>
                                <tr>
                                    <th class="zero">
                                        <p class="card-text text-black">#</p>
                                    </th>
                                    <th class="twenty">
                                        <p class="card-text projects text-black" id="projects">Item 
                                            <a onclick="confirm('Are You sure? \n Any Unsaved Data will be lost!') || event.preventDefault()"
                                            href="product-add.php"><i title="Add Product" class="la la-plus"></i></a></p>
                                    </th>
                                    <th class="thirty">
                                        <p class="card-text text-black">Description</p>
                                    </th>
                                    <th class="ten">
                                        <p class="card-text text-black">Unit Cost (<? echo CURRENCY ?>)</p>
                                    </th>
                                    <th class="ten">
                                        <p class="card-text text-black">Qty</p>
                                    </th>
                                    <th class="ten">
                                        <p class="card-text text-black">Line Tax (%)</p>
                                    </th>
                                    <th>
                                        <!--p class="card-text">Line Tax (<?// echo CURRENCY ?>)</p-->
                                    </th>
                                    <th class="twenty">
                                        <p class="card-text text-black">Line Total (<? echo CURRENCY ?>)</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="select-items">
                                <tr>
                                    <td class="zero">
                                        <p class="card-text text-black">1</p>
                                    </td>
                                    <td class="twenty">
                                            <select class="card-text ois" style="width: 100%" name="item[]" id="item_select1"  onchange="myFunction()" required>
                                                <option selected >Item:</option>
                                                <? $sql = mysqli_query($mysqli, "SELECT * FROM products WHERE product_active = 1");
                                                $first = TRUE;
                                                while ($row = mysqli_fetch_object($sql)) {
                                                    echo '<option value="'.$row->product_name.",".$row->product_desc.",".$row->product_price.",".$row->product_tax.'">'.$row->product_name." - ".$row->product_desc.'</option>';
                                                 } ?>
                                            </select>
                                            <?php //popProductsList(); ?>
                                    </td>
                                    <td class="thirty">
                                            <input class="card-text ois" onchange="" id="item_unit_description1" type="text" name="item_unit_description[]" >
                                    </td>
                                    <td class="ten">
                                            <input class="ois" onchange="sumLine()" id="item_unit_cost1" type="number" name="item_unit_cost[]" >
                                    </td>
                                    <td class="ten">
                                            <input class="qty ois" onkeyup="sumLine()" onclick="sumLine()" step="0.25" id="item_quantity1" type="number" name="item_quantity[]"  style="max-width: 80px;" value="">
                                    </td>
                                    <td class="ten">
                                            <select class="card-text item_tax ois" onchange="sumLine()" name="item_tax[]" id="item_tax1">
                                                <option value="">N/A</option>
                                                <? $sql = mysqli_query($mysqli, "SELECT * FROM taxes");
                                                $first = TRUE;
                                                while ($row = mysqli_fetch_object($sql)) {
                                                    echo '<option value="'.$row->tax_amount.'">'.$row->tax_name.",  ".$row->tax_amount.'%</option>';
                                                 } ?>
                                            </select>
                                            
                                    </td>
                                    <td>
                                            <input class="line_tax_amt ois" onchange="" id="line_tax_amt1" type="hidden" name="line_tax_amt[]">
                                    </td>
                                    <td class="twenty">
                                            <input class="line_total ois" onchange="" id="item_line_total1" type="text" name="item_line_total[]" readonly>
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
                        <h4 class="card-title">Notes (Shown on paperwork)</h4>
                        <hr>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text"> 
                                <textarea class="ois" id="notes" name="notes" rows="5" cols="90"></textarea></p>
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
                                    <!--input class="ois" type="file" name="files" id="files" multiple></p>
                                    <div id="selectedFiles"></div-->
                                    <input type="file" class="fois" id="upload_document[]" name="upload_document[]" accept="application/pdf" multiple>
                                <!--/div>
                                <div class="col-xl">
                                    <button type="button" class="btn btn-sm btn-success mb-1" onclick="uploadanother(this)">+</button>
                                </div-->
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
                                <input type="text" name="total_subtotal" id="total_subtotal" class="sub_total tis" readonly required/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Line Taxes: 
                                <input type="text" name="total_line_tax" id="total_line_tax" class="total_line_tax tis" readonly/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Tax (%):
                                <select class="card-text tis" onchange="sumLine()" name="invoice_tax" id="invoice_tax">
                                    <? if(ENABLE_VAT =='true') {
                                        echo '<option selected value="' . VAT_RATE . '">' . VAT_RATE . '</option>';
                                    } else {
                                        echo '<option selected value="">N/A</option>';
                                    }
                                    $sql = mysqli_query($mysqli, "SELECT * FROM taxes");
                                    $first = TRUE;
                                    while ($row = mysqli_fetch_object($sql)) {
                                        echo '<option value="'.$row->tax_amount.'">'.$row->tax_name.",  ".$row->tax_amount.'%</option>';
                                        } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Tax (<? echo CURRENCY ?>): 
                                <input type="text" name="subtotal_tax" id="subtotal_tax" class="subtotal_tax tis" readonly/></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <p class="card-text">Balance Due: 
                                <input type="text" name="total_balance_due" id="total_balance_due" class="total_due tis" readonly required/></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-group btn-block" role="group" aria-label="">
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmModal">Cancel / Back to Dashboard</button>
    <button type="submit" formaction="includes/functions.php?action=sio" class="btn btn-info">Save Only</button>
    <button type="submit" formaction="includes/functions.php?action=eio" class="btn btn-warning">Email to Customer</button>
    </div>
</form>

<!-- END OF SITE NAVIGATION TOP RIGHT AND PAGE ------------------------------------------->
<? $mysqli->close();?>
</div>
<!-- SCRIPTS //////////////////////////////////////////////////////////////////////////////-->

<? include ('includes/footer.php')?>

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