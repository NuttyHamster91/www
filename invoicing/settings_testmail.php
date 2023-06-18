<?php
include_once("includes/functions.php");
verifyAdmin();
include_once("includes/header.php");
include_once("includes/navbar.php");

/////// SET PAGE TITLE ////////
$PT = "Test Email";

?>

<style>
    th, tr {
    padding: 3px;
    width: 22%;
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
                        <h4 id="template-customization" class="card-title">Test Your Email Settings</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show" aria-expanded="true">
                        <div class="card-body">
                            <p>Send a test email to check your settings.</p>
                            <p>Use this function to test if your email settings and server are sending mail correctly.</p>
                            <p>You cannot edit values on this page - Please refer to settings page to edit.</p>
                            <p>Note: You can edit the send to address.</p>
                            <p>Note: If any boxes below are empty please go to settings and fill them in - all boxes are required to send emails.</p>
                        </div>
                    </div>
                </section>
                <!--/ Template Customization -->
                
                <form action="includes/functions.php?action=testemail" method="post" enctype="multipart/form-data">
			        
                <section id="section2" class="card">
                    <div class="card-header">
                        <h4 id="template-customization" class="card-title">Email Settings & Test</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show" aria-expanded="true">
                        <div class="card-body" style="overflow-x:auto;">
                            <table>
                                <div>
                                    <tr style="width:100%"><th><label for="logo">Send Test Email To:</label></th>
                                    <td><input type="text" id="COMPANY_EMAIL" name="COMPANY_EMAIL" value="<? echo COMPANY_EMAIL ?>" required/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Emails Send From Address:</label></th>
                                    <td><input type="text" id="EMAIL_FROM" name="EMAIL_FROM" value="<? echo EMAIL_FROM ?>" readonly="readonly" required/></td>
                                </div>
                                <div>
                                    <th><label for="logo">Email From Name:</label></th>
                                    <td><input type="text" id="EMAIL_NAME" name="EMAIL_NAME" value="<?php echo EMAIL_NAME ?>" readonly="readonly" required/></td></tr>
                                </div>
                                <div>
                                <tr><th><label for="logo">Email Subject:</label></th>
                                    <td><input type="text" id="EMAIL_SUBJECT" name="EMAIL_SUBJECT" value="<?php echo EMAIL_SUBJECT ?>" readonly="readonly" required/></td>
                                </div>
                                <div>
                                    <th><label for="logo">SMTP Server Address:</label></th>
                                    <td><input type="text" id="SMTP_SERVER" name="SMTP_SERVER" value="<?php echo SMTP_SERVER ?>" readonly="readonly" required/></td></tr>
                                </div>
                                <div>
                                <tr><th><label for="logo">SMTP Username:</label></th>
                                    <td><input type="text" id="SMTP_USERNAME" name="SMTP_USERNAME" value="<?php echo SMTP_USERNAME ?>" readonly="readonly" required/></td>
                                </div>
                                <div>
                                    <th><label for="logo">SMTP Password:</label></th>
                                    <td><input type="password" id="SMTP_PASSWORD" name="SMTP_PASSWORD" value="<?php echo SMTP_PASSWORD ?>" readonly="readonly" required/></td></tr>
                                </div>
                                <div>
                                <tr><th><label for="logo">SMTP Port:</label></th>
                                    <td><input type="text" id="SMTP_PORT" name="SMTP_PORT" value="<?php echo SMTP_PORT ?>" readonly="readonly" required/></td>
                                </div>
                                <div>
                                    <th><label for="logo">SMTP Use Authentication:</label></th>
                                    <td><input type="text" id="SMTP_PORT" name="SMTP_PORT" value="<?php echo SMTP_USE_AUTH ?>" readonly="readonly" required/></td></tr>
                                </div>
                            </table>
                        <br>
                        <input type="submit" class="btn btn-warning w92" name="testemail" id="testemail" value="Send Test Email.">
                        </div>
                    </div>
                </section>
                    
                </form>


<!-- SUBMIT FORM SECTION ------------------------------>


<!-- END OF SITE NAVIGATION TOP RIGHT AND PAGE ------------------------------------------->
</div>
        </div>
    </div>
</div>


<? include ('includes/footer.php')?>

