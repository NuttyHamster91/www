<script>
function invType(element) {
    if (element == "Quote") {
        document.getElementById("invNo").value = "QT-<?php getQuoteId(); ?>";
        document.getElementById("invoice_pre").value = "QT-";
        document.getElementById("invoice_id").value = "<?php getQuoteId(); ?>";
    } else if (element == "Invoice") {
        document.getElementById("invNo").value = "<?php echo INVOICE_PREFIX ?><?php getInvoiceId(); ?>";
        document.getElementById("invoice_pre").value = "<?php echo INVOICE_PREFIX ?>";
        document.getElementById("invoice_id").value = "<?php getInvoiceId(); ?>";
    }
}

// LINE TOTALs
function sumLine(){
    
  document.querySelectorAll('#select-items td').forEach(cell => {
  var value1 = parseFloat(document.getElementById("item_unit_cost" + cell.closest('tr').rowIndex).value);
  var value2 = parseFloat(document.getElementById("item_quantity" + cell.closest('tr').rowIndex).value);
  var sum1 = value1 * value2;
  var sum = parseFloat(sum1).toFixed(2);
  document.getElementById("item_line_total" + cell.closest('tr').rowIndex).value = sum;

// LINE TAXES 
  if (document.getElementById("item_tax" + cell.closest('tr').rowIndex).value == "") {
  var sum = "0";
  } else {
  var value3 = parseFloat(document.getElementById("item_tax" + cell.closest('tr').rowIndex).value);
  var value4 = parseFloat(document.getElementById("item_line_total" + cell.closest('tr').rowIndex).value);
  var sum1 = value3 / "100" * value4;
  var sum = parseFloat(sum1).toFixed(2);
  }
  document.getElementById("line_tax_amt" + cell.closest('tr').rowIndex).value = sum;
});


// SUB TOTAL CALCULATION
var total=0;
    $(".line_total").each(function(){
        if(!isNaN(parseFloat($(this).val())))
        {
          total+=parseFloat($(this).val());  
        }
    });
    total1 = parseFloat(total).toFixed(2);
    $(".sub_total").val(total1);  

// LINE TAX TOTAL CALCULATION
var total=0;
    $(".line_tax_amt").each(function(){
        if(!isNaN(parseFloat($(this).val())))
        {
          total+=parseFloat($(this).val());  
        }
    });
    total1 = parseFloat(total).toFixed(2);
    $(".total_line_tax").val(total1);    

// Totals Taxes
  if (document.getElementById("invoice_tax").value == "") {
  var sum = "0";
  } else {
  var value5 = parseFloat(document.getElementById("invoice_tax").value);
  var value6 = parseFloat(document.getElementById("total_subtotal").value);
  var sum1 = value6 / "100" * value5;
  var sum = sum1.toFixed(2);
  }
  document.getElementById("subtotal_tax").value = sum;  

// TOTAL DUE
  var value7 = parseFloat(document.getElementById("total_subtotal").value);
  var value8 = parseFloat(document.getElementById("total_line_tax").value);
  var value9 = parseFloat(document.getElementById("subtotal_tax").value);
  var sum1 = value7 + value8 + value9;
  var sum = sum1.toFixed(2);
  document.getElementById("total_balance_due").value = sum; 

}



function myFunction() {
    document.querySelectorAll('#select-items td').forEach(cell => {
  var table = document.getElementById("items_table");
  var tbodyRowCount = table.tBodies[0].rows.length;
  var x = document.getElementById("item_select" + cell.closest('tr').rowIndex).value;
  var details = x.split(',');
  document.getElementById("item_unit_description" + cell.closest('tr').rowIndex).value = (details[1]);
  document.getElementById("item_unit_cost" + cell.closest('tr').rowIndex).value = (details[2]);
  document.getElementById("item_tax" + cell.closest('tr').rowIndex).value = (details[3]);
    })
}

function addRows() {
  var table = document.getElementById('items_table');
  var rowCount = table.rows.length;
  var iteration = rowCount - 1;
  var numbers = iteration + 1;
  var row = table.insertRow(rowCount);
  var colCount = table.rows[0].cells.length;

  // Cell for number
  var cell = row.insertCell(0);
  var label = document.createElement('p');
  label.textContent = numbers;
  cell.appendChild(label);

  for (var i = 1; i < colCount; i++) {

    var newcell = row.insertCell(i);
    newcell.innerHTML = table.rows[1].cells[i].innerHTML.replace(/id="(.+)1"/, 'id="$1' + rowCount + '"');
  }
}

// Date Picker
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

// Script to List File Uploads
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


function uploadanother(elem)
{
var document    = $(elem).parent().prev().find('input[type="file"]').val();
if(document!='')
{
var clonewrap   = $(elem).parent().parent().clone();                
clonewrap.find('button').removeAttr('onclick');
clonewrap.find('button').attr('onclick','removeupload(this)');
clonewrap.find('button').html('X');
$(elem).parent().parent().before(clonewrap);
$(elem).parent().prev().find('input[type="file"]').val('');
}
}

function removeupload(elem)
{
$(elem).parent().parent().remove();
}


</script>


<style>
table {
    width: 100%;
    table-layout: fixed;
}
.zero {
    width: 5%;
}
.ten {
    width: 10%;
}
.twenty {
    width: 20%;
}
.thirty {
    width: 35%;
}
th, tr, td{
    padding-left: 1px;
    padding-right: 1px;
    height: 30px;
}
.tis {
    border: 1px solid #ccc; 
    border-radius: 5px;
    padding: 2px 2px;
    margin: 1px;
    min-width: 60%;
    max-width: 90%;
    float: right;
}
.ois {
    border: 1px solid #ccc; 
    border-radius: 5px;
    padding: 2px 2px;
    margin: 1px;
    width: 100%;
    float: right;
}
.rois {
    border: 1px solid #ccc; 
    border-radius: 5px;
    padding: 2px 2px;
    margin: 1px;
    min-width: 60%;
    max-width: 90%;
    float: right;
}
.fois {
    border: 1px dashed #ccc; 
    border-radius: 5px;
    padding: 2px 2px;
    width: 100%;
    float: left;
}
</style>