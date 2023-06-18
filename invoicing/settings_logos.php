<?php
include_once("includes/functions.php");
verifyAdmin();
include_once("includes/header.php");
include_once("includes/navbar.php");

/////// SET PAGE TITLE ////////
$PT = "Logo's Settings";

?>

<style>
    th, tr {
    padding: 3px;
    width: 14%;
    height: 35px;
    }
    table {
        width:90%;
    }
</style>

<!-- RIGHT HAND CARD - PAGE NAVIGATION ------------------------------------------->
<div class="app-content content">
    <div class="sidebar-right sidebar-sticky">
    </div>

<!-- END OF RIGHT HAND CARD - PAGE NAVIGATION ------------------------------------------->

<!-- SITE NAVIGATION TOP RIGHT ------------------------------------------->

            </div>

<!-- BODY CONTENT  -------------------------------------------------------------------->

            <div class="content-body">


                <section id="section1" class="card">
                    <div class="card-header">
                        <h4 id="template-customization" class="card-title">Logo & Favicon Upload</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show" aria-expanded="true">
                        <div class="card-body">
                            <p>Use this page to alter your logo & favicon.</p>
                            <p>Once uploaded your new logo will appear on all future documents.</p>
                            <p>Logo & Favicon will be uploaded to the server location set in the settings page. </p>
                            <p>Logo & Favicon will only display if the correct file name is input in the general settings page. </p>
                            <p>Note: Uploads will delete old icons & logos with the same name. </p>
                            <p>Note: You may need to close your browser and/or clear the cache to display new images. </p>
                        </div>
                    </div>
                </section>
                <!--/ Template Customization -->
                <div style="overflow-x:auto;">
                <form action="includes/functions.php?action=savelogo" method="post" enctype="multipart/form-data">
			        
                <section id="section2" class="card">
                    <div class="card-header">
                        <h4 id="template-customization" class="card-title">Upload Your Company Logo</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show" aria-expanded="true">
                        <div class="card-body">
                        <table>
                            <div>
                                <tr><th><label for="logo">Main Logo:</label></th><th></th>
                                <td><input type="file" name="companylogo" id="companylogo" accept="image/jpg, image/jpeg, image/png, image/ico"></td>
                                <th>Current Logo:</th><td><img style="max-height:80px" src="<? echo COMPANY_LOGO . COMPANY_LOGO_NAME?>" alt="Logo" height="auto"></td></tr>
                            </div>
                        </table>
                        <br>
                        <input type="submit" class="btn btn-success w92" name="sendlogo" id="sendlogo" value="Upload">
                        </div>
                    </div>
                </section>
                    
                </form>

                <br>

                
                
                <form action="includes/functions.php?action=savefavicon" method="post" enctype="multipart/form-data">
			        
                <section id="section3" class="card">
                    <div class="card-header">
                        <h4 id="template-customization" class="card-title">Upload Your Company Icon / Favicon</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show" aria-expanded="true">
                        <div class="card-body">
                        <table>
                            <div>
                                <tr><th><label for="logo">Favicon:</label></th><th></th>
                                <td><input type="file" name="cfavicon" id="cfavicon" accept="image/png, image/ico"></td>
                                <th>Current Favicon:</th><td><img style="max-height:80px" src="<? echo COMPANY_FAVICON . COMPANY_FAVICON_NAME?>" alt="Logo" height="auto"></td></tr>
                            </div>
                        </table>
                        <br>
                        <input type="submit" class="btn btn-success w92" name="savefavicon" id="savefavicon" value="Upload">
                        </div>
                    </div>
                </section>
                    
                </form>
</div>


<!-- SUBMIT FORM SECTION ------------------------------>


<!-- END OF SITE NAVIGATION TOP RIGHT AND PAGE ------------------------------------------->
</div>
        </div>
    </div>
</div>


<? include ('includes/footer.php')?>