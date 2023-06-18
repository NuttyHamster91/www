<?php
include_once("includes/functions.php");
verifyAdmin();
include_once("includes/header.php");
include_once("includes/navbar.php");

?>

<style>
    .affix {
    position: fixed;
    margin: 0 1.5rem 0 0;
    width: 300px;
    }
    th {
    padding: 3px;
    width: 25%;
}
tr {
    height: 35px;
}
table {
    width:90%;
}    
#DATE_FORMAT, #CURRENCY, #TIMEZONE, #ENABLE_VAT, #VAT_INCLUDED, #SMTP_USE_AUTH, #SMTP_SECURE{
    width:80%; 
    height: 27px;  
} 
input[type=text], input[type=password] {
    width: 80%;
}

.shell {
  position: relative;
  line-height: 0; }
  .shell span {
    position: absolute;
    pointer-events: none;
    z-index: -1; }
    .shell span i {
      font-style: normal;
      /* any of these 3 will work */
      color: transparent;
      opacity: 0;
      visibility: hidden; }

input.masked,
.shell span {
  font-size: 16px;
  font-family: monospace;
  padding-right: 10px;
  background-color: transparent;
  text-transform: uppercase; }

</style>

<!-- RIGHT HAND CARD - PAGE NAVIGATION ------------------------------------------->
<div class="app-content content">
    <div class="sidebar-right sidebar-sticky">
        <div class="sidebar"><div class="pt-2 pr-2">
            <div class="sidebar-content p-1" data-spy="affix" data-offset-top="-77">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Page Navigation</h6>
                    </div>
                    <div class="card-content" aria-expanded="true">
                        <div class="card-body">
                            <nav id="sidebar-page-navigation">
                                <ul id="page-navigation-list" class="nav">
                                    <li class="nav-item"><a class="nav-link" href="#section1"><? echo $PT ?></a>
                                        <ul class="nav">
                                            <li class="nav-item"><a class="nav-link" href="#section2">Database Settings</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#section3">Company Settings</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#section4">Invoice, Quote & Payment Settings</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#section5">Email Settings</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#section6">Company Logo Settings</a></li>
                                        </ul>
                                    </li>                            
                                </ul>
                            </nav>
                        </div>
                        <h6 class="border-top-grey border-top-lighten-2 p-1 mt-1 mb-0">
                            <a class="nav-link display-block text-muted" href="#top">Back to top
                                <i class="float-right la la-arrow-circle-o-up font-medium-3"></i>
                            </a>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END OF RIGHT HAND CARD - PAGE NAVIGATION ------------------------------------------->

<!-- SITE NAVIGATION TOP RIGHT ------------------------------------------->
                
            </div>

<!-- BODY CONTENT  -------------------------------------------------------------------->

            <div class="content-body">


                <section id="section1" class="card">
                    <div class="card-header">
                        <h4 id="template-customization" class="card-title">Main Settings Page</h4>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show" aria-expanded="true">
                        <div class="card-body">
                            <p>Use this page to alter your settings.</p>
                            <p>Some settings will already be filled out from initial setup.</p>
                            <p>Please fill in every setting to avoid any issues within the app. </p>
                        </div>
                    </div>
                </section>
                <!--/ Template Customization -->
                
                <form action="includes/functions.php?action=mss" method="post" enctype="multipart/form-data">
			        
                <section id="section2" class="card">
                    <div class="card-header">
                        <h4 id="template-customization" class="card-title">Database Settings</h4>
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
                                <tr><th><label for="logo">Database Name:</label></th>
                                <td><input type="text" id="DATABASE_NAME" name="DATABASE_NAME" value="<?php echo DATABASE_NAME ?>"/></td></tr>
                            </div>
                            <div>
                                <tr><th><label for="logo">Database Username:</label></th>
                                <td><input type="text" id="DATABASE_USER" name="DATABASE_USER" value="<?php echo DATABASE_USER ?>"/></td></tr>
                            </div>
                            <div>
                                <tr><th><label for="logo">Database Password:</label></th>
                                <td><input type="password" id="DATABASE_PASS" name="DATABASE_PASS" value="<?php echo DATABASE_PASS ?>"/></td></tr>
                            </div>
                        </table>
                        </div>
                    </div>
                </section>
                    
                    <br>
			        
                    <section id="section3" class="card">
                        <div class="card-header">
                            <h4 id="template-customization" class="card-title">Company Settings</h4>
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
                                    <tr><th><label for="logo">Company Name:</label></th>
                                    <td><input type="text" id="COMPANY_NAME" name="COMPANY_NAME" value="<?php if(COMPANY_NAME == 'COMPANY_NAME') { echo '' ;} else {echo COMPANY_NAME;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Company Address Line 1:</label></th>
                                    <td><input type="text" id="COMPANY_ADDRESS_1" name="COMPANY_ADDRESS_1" value="<?php if(COMPANY_ADDRESS_1 == 'COMPANY_ADDRESS_1') { echo '' ;} else {echo COMPANY_ADDRESS_1;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Company Address Line 2:</label></th>
                                    <td><input type="text" id="COMPANY_ADDRESS_2" name="COMPANY_ADDRESS_2" value="<?php if(COMPANY_ADDRESS_2 == 'COMPANY_ADDRESS_2') { echo '' ;} else {echo COMPANY_ADDRESS_2 ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Company Address Line 3:</label></th>
                                    <td><input type="text" id="COMPANY_ADDRESS_3" name="COMPANY_ADDRESS_3" value="<?php if(COMPANY_ADDRESS_3 == 'COMPANY_ADDRESS_3') { echo '' ;} else {echo COMPANY_ADDRESS_3 ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">County:</label></th>
                                    <td><input type="text" id="COMPANY_COUNTY" name="COMPANY_COUNTY" value="<?php if(COMPANY_COUNTY == 'COMPANY_COUNTY') { echo '' ;} else {echo COMPANY_COUNTY ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Postcode:</label></th>
                                    <td><input type="text" id="COMPANY_POSTCODE" name="COMPANY_POSTCODE" value="<?php if(COMPANY_POSTCODE == 'COMPANY_POSTCODE') { echo '' ;} else {echo COMPANY_POSTCODE ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Company Registration Number:</label></th>
                                    <td><input type="text" id="COMPANY_NUMBER" name="COMPANY_NUMBER" value="<?php if(COMPANY_NUMBER == 'COMPANY_NUMBER') { echo '' ;} else {echo COMPANY_NUMBER ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Company VAT Registration Number:</label></th>
                                    <td><input type="text" id="COMPANY_VAT" name="COMPANY_VAT" value="<?php if(COMPANY_VAT == 'COMPANY_VAT') { echo '' ;} else {echo COMPANY_VAT ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Company Unique Tax Reference (UTR) Number:</label></th>
                                    <td><input type="text" id="COMPANY_UTR" name="COMPANY_UTR" value="<?php if(COMPANY_UTR == 'COMPANY_UTR') { echo '' ;} else {echo COMPANY_UTR ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Company Contact Number 1:</label></th>
                                    <td><input type="text" id="COMPANY_CONTACT_1" name="COMPANY_CONTACT_1" value="<?php if(COMPANY_CONTACT_1 == 'COMPANY_CONTACT_1') { echo '' ;} else {echo COMPANY_CONTACT_1 ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Company Contact Number 2:</label></th>
                                    <td><input type="text" id="COMPANY_CONTACT_2" name="COMPANY_CONTACT_2" value="<?php if(COMPANY_CONTACT_2 == 'COMPANY_CONTACT_2') { echo '' ;} else {echo COMPANY_CONTACT_2 ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Company Email Address:</label></th>
                                    <td><input type="text" id="COMPANY_EMAIL" name="COMPANY_EMAIL" value="<?php if(COMPANY_EMAIL == 'COMPANY_EMAIL') { echo '' ;} else {echo COMPANY_EMAIL ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Company Website:</label></th>
                                    <td><input type="text" id="COMPANY_WEBSITE" name="COMPANY_WEBSITE" value="<?php if(COMPANY_WEBSITE == 'COMPANY_WEBSITE') { echo '' ;} else {echo COMPANY_WEBSITE ;} ?>"/></td></tr>
                                </div>
                            </table>
                            </div>
                        </div>
                    </section>
                    
                    <br>
                    
                    <section id="section4" class="card">
                        <div class="card-header">
                            <h4 id="template-customization" class="card-title">Invoice, Quote & Payment Settings</h4>
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
                                    <tr><th><label for="logo">Invoice Prefix:</label></th>
                                    <td><input type="text" id="INVOICE_PREFIX" name="INVOICE_PREFIX" value="<?php if(INVOICE_PREFIX == 'INVOICE_PREFIX') { echo '' ;} else {echo INVOICE_PREFIX ;} ?>" Placeholder="E.g. ABC- or Leave empty for no prefix"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Initial Invoice Order Number:</label></th>
                                    <td><input type="text" id="INVOICE_INITIAL_VALUE" name="INVOICE_INITIAL_VALUE" value="<?php if(INVOICE_INITIAL_VALUE == 'INVOICE_INITIAL_VALUE') { echo '' ;} else {echo INVOICE_INITIAL_VALUE ;} ?>" Placeholder=""/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Initial Quote Number:</label></th>
                                    <td><input type="text" id="QUOTE_INITIAL_VALUE" name="QUOTE_INITIAL_VALUE" value="<?php if(QUOTE_INITIAL_VALUE == 'QUOTE_INITIAL_VALUE') { echo '' ;} else {echo QUOTE_INITIAL_VALUE ;} ?>" Placeholder=""/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Invoice Payment Term (Days):</label></th>
                                    <td><input type="text" id="INVOICE_PAYMENT_TERM" name="INVOICE_PAYMENT_TERM" value="<?php if(INVOICE_PAYMENT_TERM == 'INVOICE_PAYMENT_TERM') { echo '' ;} else {echo INVOICE_PAYMENT_TERM ;} ?>" Placeholder="E.G. 30"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Invoice Body Colour (Hex Code):
                                        <i class="la la-question-circle" data-toggle="tooltip" data-placement="top" title="Hex Code Must Start With A # - E.G. #ffffff"></label></th>
                                    <td><input type="text" id="INVOICE_THEME" name="INVOICE_THEME" value="<?php if(INVOICE_THEME == 'INVOICE_THEME') { echo '' ;} else {echo INVOICE_THEME ;} ?>" Placeholder="E.g. #001122"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Invoice Header & Footer Colour (Hex Code):
                                        <i class="la la-question-circle" data-toggle="tooltip" data-placement="top" title="Hex Code Must Start With A # - E.G. #ffffff"></label></th>
                                    <td><input type="text" id="INVOICE_THEME_HF" name="INVOICE_THEME_HF" value="<?php if(INVOICE_THEME_HF == 'INVOICE_THEME_HF') { echo '' ;} else {echo INVOICE_THEME_HF ;} ?>" Placeholder="E.g. #001122"/></td></tr>
                                </div>
                            </table>
                            <table>
                                <div>
                                    <tr><th><label for="logo">Timezone:</label></th>
                                    <!--td><input style="width:90%" type="text" value="<?php if(TIMEZONE == 'TIMEZONE') { echo '' ;} else {echo TIMEZONE ;} ?>"/-->
                                    <td><?php $Zone = TIMEZONE;
                                            if(!empty($Zone)){
                                                $curentZone = '<option selected value>' . TIMEZONE . '</option>';
                                            } else{
                                                $curentZone = '<option disabled selected value> -- Select an option -- </option>';
                                            }
        
                                        // Create a timezone identifiers
                                        $timezone_identifiers = 
                                            DateTimeZone::listIdentifiers(DateTimeZone::ALL);
                                        
                                        echo "<select style='width:80%' name='TIMEZONE' id='TIMEZONE'>";
                                        
                                        echo $curentZone;
                                        
                                        $n = 425;
                                        for($i = 0; $i < $n; $i++) {
                                            
                                            // Print the timezone identifiers
                                            echo "<option value='" . $timezone_identifiers[$i] . 
                                                "'>" . $timezone_identifiers[$i] . "</option>";
                                        }
                                        
                                        echo "</select>";
                                        
                                        ?>
                                    </td></tr>
                                </div>
                            </table>
                            <table>
                                <div>
                                    <tr><th><label for="logo">Date Format:</label></th>
                                    <? $selected_value = DATE_FORMAT;?>
                                    <td><select id="DATE_FORMAT" name="DATE_FORMAT"><option <?php if($selected_value == 'DD/MM/YYYY') echo 'selected' ?> value="DD/MM/YYYY">DD/MM/YYYY</option><option <?php if($selected_value == 'MM/DD/YYYY') echo 'selected' ?> value="MM/DD/YYYY">MM/DD/YYYY</option></select></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Currency:</label></th>
                                    <? $selected_value1 = CURRENCY;?>
                                    <td><select id="CURRENCY" name="CURRENCY"><option <?php if($selected_value1 == '£') echo 'selected' ?> value="£">£</option><option <?php if($selected_value1 == '€') echo 'selected' ?> value="€">€</option><option <?php if($selected_value2 == '$') echo 'selected' ?> value="$">$</option></select></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Enable VAT:</label></th>
                                    <? $selected_value2 = ENABLE_VAT;?>
                                    <td><select id="ENABLE_VAT" name="ENABLE_VAT"><option <?php if($selected_value2 == 'false') echo 'selected' ?> value="false">No</option><option <?php if($selected_value2 == 'true') echo 'selected' ?> value="true">Yes</option></select></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Is VAT included in prices / costs?:</label></th>
                                    <? $selected_value3 = VAT_INCLUDED;?>
                                    <td><select id="VAT_INCLUDED" name="VAT_INCLUDED"><option <?php if($selected_value3 == 'false') echo 'selected' ?> value="false">No</option><option <?php if($selected_value3 == 'true') echo 'selected' ?> value="true">Yes</option></select></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">VAT Rate:</label></th>
                                    <td><input type="text" id="VAT_RATE" name="VAT_RATE" value="<?php if(VAT_RATE == 'VAT_RATE') { echo '' ;} else {echo VAT_RATE ;} ?>" Placeholder="E.g. 20 for 20%"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Payment Bank:</label></th>
                                    <td><input type="text" id="PAYMENT_BANK" name="PAYMENT_BANK" value="<?php if(PAYMENT_BANK == 'PAYMENT_BANK') { echo '' ;} else {echo PAYMENT_BANK ;} ?>" Placeholder="E.g. Banklays, Santander etc"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Payment Sort Code:</label></th>
                                    <td><input type="text" id="PAYMENT_SORT" name="PAYMENT_SORT" placeholder="XX-XX-XX" pattern="\d\d-\d\d-\d\d" class="masked" data-charset="XX-XX-XX" title="6-character sort code in the format of 11-11-11" value="<?php if(PAYMENT_SORT == 'PAYMENT_SORT') { echo '' ;} else {echo PAYMENT_SORT ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Payment Account Number:</label></th>
                                    <td><input type="text" id="PAYMENT_ACCTNO" name="PAYMENT_ACCTNO" value="<?php if(PAYMENT_ACCTNO == 'PAYMENT_ACCTNO') { echo '' ;} else {echo PAYMENT_ACCTNO ;} ?>" Placeholder=""/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Footer Note On Paperwork:</label></th>
                                    <td><input type="text" id="FOOTER_NOTE" name="FOOTER_NOTE" value="<?php if(FOOTER_NOTE  == 'FOOTER_NOTE') { echo '' ;} else {echo FOOTER_NOTE ;} ?>" Placeholder=""/></td></tr>
                                </div>
                            </table>
                            </div>
                        </div>
                    </section>
                    
                    <br>
                    
                    <section id="section5" class="card">
                        <div class="card-header">
                            <h4 id="template-customization" class="card-title">Email Settings</h4>
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
                                    <tr><th><label for="logo">Emails Send From Address:</label></th>
                                    <td><input type="text" id="EMAIL_FROM" name="EMAIL_FROM" value="<?php if(EMAIL_FROM == 'EMAIL_FROM') { echo '' ;} else {echo EMAIL_FROM ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Email From Name:</label></th>
                                    <td><input type="text" id="EMAIL_NAME" name="EMAIL_NAME" value="<?php if(EMAIL_NAME == 'EMAIL_NAME') { echo '' ;} else {echo EMAIL_NAME ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Default Email Subject:</label></th>
                                    <td><input type="text" id="EMAIL_SUBJECT" name="EMAIL_SUBJECT" value="<?php if(EMAIL_SUBJECT == 'EMAIL_SUBJECT') { echo '' ;} else {echo EMAIL_SUBJECT ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Invoice Email Body:</label></th>
                                    <td><input type="text" id="EMAIL_BODY_INVOICE" name="EMAIL_BODY_INVOICE" value="<?php if(EMAIL_BODY_INVOICE == 'EMAIL_BODY_INVOICE') { echo '' ;} else {echo EMAIL_BODY_INVOICE ;} ?>" Placeholder="E.g. Please Find Invoice attached from *Company Name*"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Quote Email Body:</label></th>
                                    <td><input type="text" id="EMAIL_BODY_QUOTE" name="EMAIL_BODY_QUOTE" value="<?php if(EMAIL_BODY_QUOTE == 'EMAIL_BODY_QUOTE') { echo '' ;} else {echo EMAIL_BODY_QUOTE ;} ?>" Placeholder="E.g. Please Find Quotation attached from *Company Name*"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Receipt  Email Body:</label></th>
                                    <td><input type="text" id="EMAIL_BODY_RECEIPT" name="EMAIL_BODY_RECEIPT" value="<?php if(EMAIL_BODY_RECEIPT == 'EMAIL_BODY_RECEIPT') { echo '' ;} else {echo EMAIL_BODY_RECEIPT ;} ?>" Placeholder="E.g. Payment Receipt from *Company Name*"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">SMTP Server Address:</label></th>
                                    <td><input type="text" id="SMTP_SERVER" name="SMTP_SERVER" value="<?php if(SMTP_SERVER == 'SMTP_SERVER') { echo '' ;} else {echo SMTP_SERVER ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">SMTP Username:</label></th>
                                    <td><input type="text" id="SMTP_USERNAME" name="SMTP_USERNAME" value="<?php if(SMTP_USERNAME == 'SMTP_USERNAME') { echo '' ;} else {echo SMTP_USERNAME ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">SMTP Password:</label></th>
                                    <td><input type="password" id="SMTP_PASSWORD" name="SMTP_PASSWORD" value="<?php if(SMTP_PASSWORD == 'SMTP_PASSWORD') { echo '' ;} else {echo SMTP_PASSWORD ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">SMTP Port:</label></th>
                                    <td><input type="text" id="SMTP_PORT" name="SMTP_PORT" value="<?php if(SMTP_PORT == 'SMTP_PORT') { echo '' ;} else {echo SMTP_PORT ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">SMTP Use Authentication ? :</label></th>
                                    <? $selected_value4 = SMTP_USE_AUTH;?>
                                    <td><select id="SMTP_USE_AUTH" name="SMTP_USE_AUTH"><option <?php if($selected_value4 == '') echo 'selected' ?> value="">None</option><option <?php if($selected_value4 == 'ssl') echo 'selected' ?> value="ssl">SSL</option><option <?php if($selected_value4 == 'tls') echo 'selected' ?> value="tls">TLS</option></select></td></tr>
                                </div>
                            </table>
                            </div>
                        </div>
                    </section>
                    
                    <br>
                    
                    <section id="section6" class="card">
                        <div class="card-header">
                            <h4 id="template-customization" class="card-title">Company Logo Settings</h4>
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
                                    <tr><th><label for="logo">Favicon File Name (Including Extension):</label></th>
                                    <td><input type="text" id="COMPANY_FAVICON_NAME" name="COMPANY_FAVICON_NAME" value="<?php if(COMPANY_FAVICON_NAME == 'COMPANY_FAVICON_NAME') { echo '' ;} else {echo COMPANY_FAVICON_NAME ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Logo File Name (Including Extension):</label></th>
                                    <td><input type="text" id="COMPANY_LOGO_NAME" name="COMPANY_LOGO_NAME" value="<?php if(COMPANY_LOGO_NAME == 'COMPANY_LOGO_NAME') { echo '' ;} else {echo COMPANY_LOGO_NAME ;} ?>"/></td></tr>
                                </div>
                            </table>
                                <p>It is advised not to change these values - They should be set after initial setup.</p>
                            <table>
                                <div>
                                    <tr><th><label for="logo">Favicon File Path on Server:</label></th>
                                    <td><input type="text" id="COMPANY_FAVICON" name="COMPANY_FAVICON" value="<?php if(COMPANY_FAVICON == 'COMPANY_FAVICON') { echo '' ;} else {echo COMPANY_FAVICON ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Logo File Path on Server:</label></th>
                                    <td><input type="text" id="COMPANY_LOGO" name="COMPANY_LOGO" value="<?php if(COMPANY_LOGO == 'COMPANY_LOGO') { echo '' ;} else {echo COMPANY_LOGO ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Company Logo Width (px):</label></th>
                                    <td><input type="text" id="COMPANY_LOGO_WIDTH" name="COMPANY_LOGO_WIDTH" value="<?php if(COMPANY_LOGO_WIDTH == 'COMPANY_LOGO_WIDTH') { echo '' ;} else {echo COMPANY_LOGO_WIDTH ;} ?>"/></td></tr>
                                </div>
                                <div>
                                    <tr><th><label for="logo">Company Logo Height (px):</label></th>
                                    <td><input type="text" id="COMPANY_LOGO_HEIGHT" name="COMPANY_LOGO_HEIGHT" value="<?php if(COMPANY_LOGO_HEIGHT == 'COMPANY_LOGO_HEIGHT') { echo '' ;} else {echo COMPANY_LOGO_HEIGHT ;} ?>"/></td></tr>
                                </div>
                            </table>
                            </div>
                        </div>
                    </section>
                    
                    <br>
                    
                    <section id="section6" class="card">
                        <div class="card-header">
                            <h4 id="template-customization" class="card-title">Terms, Conditions & Data Policies</h4>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show" aria-expanded="true">
                            <div class="card-body">
                                <p>Upload all policies in one document.</p>
                                <p>Upload must be in PDF format.</p>
                            </div>
                        </div>
                        <div class="card-content collapse show" aria-expanded="true">
                            <div class="card-body">
                            <div>
                                <p>Current File: <?php if(TCDP == 'TCDP') { echo 'No File Uploaded Yet.' ;} else {echo TCDP ;} ?></p>
                                <input type="file" name="upload" id="upload" accept="application/pdf">
                            </div>
                            </div>
                        </div>
                    </section>
                    
                    <br>
                    
                    <input type="submit" class="btn btn-success w92" name="sendsettings" id="sendsettings" value="Save All Settings">
                </form>



<!-- SUBMIT FORM SECTION ------------------------------>

<script>
    document.getElementById('FOOTER_NOTE').onkeypress = function () {
    console.log(event.keyCode);
    
    if (event.keyCode === 39) { // apostrophe
        // prevent the keypress
        return false;
    }
};
</script>

<!-- END OF SITE NAVIGATION TOP RIGHT AND PAGE ------------------------------------------->
</div>
        </div>
    </div>
</div>


<? include ('includes/footer.php')?>