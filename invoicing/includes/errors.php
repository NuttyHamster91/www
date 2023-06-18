<?php 

if(isset($_GET['id'])){

    $pVar = $_GET['id'];
    if ($pVar =='1'){
        $pVar = "Login Details Are Incorrect.";
    } elseif ($pVar =='2'){
        $pVar = "Connection To DB Could Not Be Made " . $mysqli->connect_error;
    } elseif ($pVar =='3'){
        $pVar = "Please Check Your Emails for your Activation Link.";
    } elseif ($pVar =='4'){
        $pVar = "Looks Like Something Went Wrong.";
    } elseif ($pVar =='5'){
        $pVar = "Account Activated - You can now login.";
    } elseif ($pVar =='6'){
        $pVar = "The account is already activated or doesn\'t exist!";
    } elseif ($pVar =='7'){
        $pVar = "Your Account is not Activated.";
    } elseif ($pVar =='8'){
        $pVar = "Please Login.";
    } elseif ($pVar =='9'){
        $pVar = "Username Already Exists.";
    } elseif ($pVar =='10'){
        $pVar = "Welcome Back"  . $_SESSION['name'];
    } elseif ($pVar =='11'){
        $pVar = "Your New Logo Was Uploaded Successfully.";
    } elseif ($pVar =='12'){
        $pVar = "Sorry. Your File Was Not Uploaded.";
    } elseif ($pVar =='13'){
        $pVar = "Settings Have Been Saved !";
    } elseif ($pVar =='14'){
        $pVar = "Your New Favicon Was Uploaded Successfully.";
    } elseif ($pVar =='15'){
        $pVar = "Sorry, that file type isn't allowed, or is too large.";
    } elseif ($pVar =='16'){
        $pVar = "Sorry - Mail not sent.";
    } elseif ($pVar =='17'){
        $pVar = "Sent Successfully.";
    } elseif ($pVar =='18'){
        $pVar = "Profile Updated Successfully for "  . $_SESSION['name'];
    } elseif ($pVar =='19'){
        $pVar = "Sorry. Passwords did not match and were not updated.";
    } elseif ($pVar =='20'){
        $pVar = "File not Uploaded. Only jp(e)g & png and under 500KB are accepted.";
    } elseif ($pVar =='21'){
        $pVar = "Timesheet Submitted Successfully.";
    } elseif ($pVar =='22'){
        $pVar = "Customer Updated Successfully.";
    } elseif ($pVar =='23'){
        $pVar = "Customer Created Successfully.";
    } elseif ($pVar =='24'){
        $pVar = "Product Updated Successfully.";
    } elseif ($pVar =='25'){
        $pVar = "Product Created Successfully.";
    } elseif ($pVar =='26'){
        $pVar = "Record Created & Saved Successfully.";
    } elseif ($pVar =='27'){
        $pVar = "Record Produced But Not Sent.";
    } elseif ($pVar =='28'){
        $pVar = "Site Created Successfully.";
    } elseif ($pVar =='29'){
        $pVar = "Site Updated Successfully.";
    } elseif ($pVar =='30'){
        $pVar = "Record Updated Successfully.";
    } elseif ($pVar =='31'){
        $pVar = "Record Removed Successfully.";
    } elseif ($pVar =='32'){
        $pVar = "Record Marked As Paid.";
    } elseif ($pVar =='33'){
        $pVar = "Record Marked As Open.";
    } elseif ($pVar =='34'){
        $pVar = "Preferences Updated.";
    } else {
        $pVar = "";
    }
}
else {
    $pVar="";
}
?>