<?php
include_once("includes/header.php");
include_once("includes/navbar.php");
include_once("includes/functions.php");

?>




<div class="content-body">

<!--/ Template Customization -->
<form action="includes/functions.php?action=createinvoice" method="post" enctype="multipart/form-data">
    <div class="row match-height">
        <div class="col-xl-12 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body" style="padding-top:20px">
                    <table class="table table-bordered table-hover">
    <thead>
        <tr>
        <th width="2%"><input id="check_all" type="checkbox"/></th>
        <th width="10%">Credit Type</th>
        <th width="20%">Credit Account</th>
        <th width="15%">Fund</th>
        <th width="15%">Amount</th>
        <th><input type="button" class="btn btn-primary addmore" value="+"></th>
        </tr>
        </thead>
        <tbody>
         <tr>
            <td><input class="case" type="checkbox"/></td>
           <td>
             <select name="fund_id" class="form control" id="type_1">
             <option></option>
             <option value="23">Expense</option>
             <option value="3">Fixed Asset</option>
             <option value="8">Current Asset</option>
             <option value="5">Current Liability</option>
            <option value="4">Non-Current Liability</option>                                    
            </select>
          </td>
          <td>
            <select id="credit_1" name="cr_ac" class="form-control" >
             <option></option>
            </select>
         </td>
         <td> <input type="text" name="fund[]" id="fund_1" ></td>
         <td><input type="text"  name="amount[]" id="amount_1"></td>
         <td><input type="text"  name="total[]" id="total_1"></td>
      </tr>
     </tbody>
    </table>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>

                    <script>
    var i=$('table tr').length;
    $(".addmore").on('click',function(){
        html = '<tr>';
        html += '<td><input class="case" type="checkbox"/></td>';
        html += '<td><select class="form-control select-product" id="type_'+i+'"><option></option><option value="23">Expense</option>';
        html += '<td><select id="credit_'+i+'" name="cr_ac" class="form-control" ><option></option></select></td>';
        html += '<td><input type="text" name="fund[]" id="fund_'+i+'"></td>';
        html += '<td><input type="text" name="amount[]" id="amount_'+i+'"></td>';
       html += '</tr>';
        $('table').append(html);
        i++;
    });
</script>


<script>
$(document).delegate( ".select-product", "change", function() {
      $(this).change(function(){
        var id=$(this).val();
        var dataString = 'id='+ id;
        $.ajax({
               type: "GET",
               url: "ttx.php",
               data: dataString,
               cache: false,
               success: function(html){
            _crac.html(html);
        } 
   });

});

});
</script>
        
<? include ('includes/footer.php')?>