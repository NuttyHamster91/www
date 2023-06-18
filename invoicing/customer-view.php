<?php
include_once("includes/functions.php");
verifyAdmin();
include_once("includes/header.php");
include_once("includes/navbar.php");

?>

<style>

td {
  vertical-align: middle;
}
</style>

<div class="content-body">
    <div class="row match-height">
        <div class="col-xl-12 col-lg-12">
            <div class="card bg-white">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">All Customers.</h4>
                        <?php getCustomers(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Statistics -->
<!-- ////////////////////////////////////////////////////////////////////////////-->

<? include ('includes/footer.php')?>