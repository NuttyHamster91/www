<?php
include_once("includes/header.php");
include_once("includes/navbar.php");
include_once("includes/functions.php");
?>

<style>
    th, tr {
    padding: 3px;
    width: 14%;
    height: 35px;
   position: sticky;
   top: 0;
   background: white;
    }
    table {
        width:90%;
    }

    p .btn-group { display: inline-block; }

    .tableContainerDiv {
   overflow: auto;
   max-height: 47em;
    }
</style>

<!-- BODY CONTENT  -------------------------------------------------------------------->
<div class="content-body">
<!--/ Template Customization -->
    <form action="includes/functions.php?action=add_site" method="post" enctype="multipart/form-data">
        <div class="row match-height max-height:200px">
            <div class="col-xl-6 col-lg-12">
                <div class="card bg-white">
                    <div class="card-content">
                        <div class="card-body">
                            <h4 class="card-title">Add a New Site:</h4>
                            <hr>
                            <div class="row">
                                <div class="col-xl-12">
                                    <p class="card-text">Existing Customer or New Customer is required.</p>
                                    <p class="card-text">Select Site Owner / Customer:
                                        <select class="card-text select-product form-control" id="customer_name" name="customer_name">
                                            <option style="color: #666" value="">Select:</option>
                                            <? $sql = mysqli_query($mysqli, "SELECT * FROM store_customers WHERE active = 1");
                                            $first = TRUE;
                                            while ($row = mysqli_fetch_object($sql)) {
                                                echo "<option style='color: #666' value='".$row->name."'>".$row->name."</option>";
                                                } ?>
                                        </select>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <p class="card-text">Or Create New Site Owner / Customer: 
                                        <input type="text" name="site_owner" id="site_owner" class="form-control"></p>
                                </div>
                            </div>
                            <hr>
                            <h4 class="card-title">Address</h4>
                            <div class="row">
                                <div class="col-xl-6">
                                    <p class="card-text">Building / Property / Site Name: *
                                        <input type="text" name="AD" id="AD" class="form-control sis" required></p>
                                </div>
                                <div class="col-xl-6">
                                    <p class="card-text">Address Line 1: *
                                        <input type="text" name="AD1" id="AD1" class="form-control sis" required></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <p class="card-text">Address Line 2: 
                                        <input type="text" name="AD2" id="AD2" class="form-control sis"></p>
                                </div>
                                <div class="col-xl-6">
                                    <p class="card-text">Address Line 3: 
                                        <input type="text" name="AD3" id="AD3" class="form-control sis"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <p class="card-text">County: 
                                        <input type="text" name="ADCounty" id="ADCounty" class="form-control sis"></p>
                                </div>
                                <div class="col-xl-6">
                                    <p class="card-text">Post Code: *
                                        <input type="text" name="ADPC" id="ADPC" class="form-control sis"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <p class="card-text"><br>Google Maps Link (Preferred Option) (On Maps -> Drop Pin -> Share -> Copy Link): 
                                        <input type="text" placeholder="E.G. https://goo.gl/maps/XG9Yy2GeNgPeXxmu7" name="ADMapLink" id="ADMapLink" class="form-control"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <p class="card-text"> 
                                        <input type="hidden" name="site" id="site" class="form-control"></p>
                                </div>
                                <div class="col-xl-6">
                                    <p class="card-text">
                                        <input type="hidden" name="fullAD" id="fullAD" class="form-control"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <br>
                                    <button class="btn btn-success btn-block w92" name="sendit" id="sendit">Create Site</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
            <div class="col-xl-6 col-lg-12">
                <div class="card bg-white">
                    <div class="card-content">
                        <div class="card-body tableContainerDiv" >
                            <h4 class="card-title">All Sites:</h4>
                            <hr>
                            <? getSites() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                
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