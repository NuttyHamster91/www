<?php

include('config.php');

// get invoice list
function getInvoices() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
		die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
    $query = "SELECT * 
		FROM invoices i
		JOIN customer c
		ON c.invoice_no = i.invoice_no
		WHERE i.invoice_no = c.invoice_no
		AND i.invoice_type = 'Invoice'
		ORDER BY i.invoice_no DESC";

	// mysqli select query
	$results = $mysqli->query($query);	
	
	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table" cellspacing="0"><thead><tr>

				<th>Invoice</th>
				<th>Customer</th>
	            <th>Reference</th>
				<th>Issue Date</th>
				<th>Due Date</th>
				<th>Amount Due</th>
				<th>Status</th>
				<th>Actions</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

			// Generate encryption key
			include('config.php');
			$encryption_key = generateRandomString();
			$pw = openssl_encrypt('PassWordForDeletingItem', $cipher, $encryption_key, $options, $encryption_iv);

			print '
				<tr>
					<td>'.$row["invoice_no"].'</td>
					<td>'.$row["company"].'</td>
	                <td>'.$row["invoice_reference"].'</td>
				    <td>'.$row["invoice_date"].'</td>
				    <td>'.$row["invoice_due_date"].'</td>
				    <td> '.CURRENCY.$row["total"].'</td>
				';

				if($row['status'] == "Open"){
					print '<td><span class="label label-primary">'.$row['status'].'</span></td>';

			print '
				    <td>
					<a href="includes/functions.php?action=paid&pre='.$row["invoice_pre"].'&no='.$row["invoice_no"].'" class="btn btn-success btn-sm py-0" style="font-size: 0.8em;">
						<span class="la la-check" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Mark Paid"></span></a>

					<a href="invoice-edit.php?inv='.$row["invoice_no"].'" class="btn btn-primary btn-sm py-0" style="font-size: 0.8em;">
						<span class="la la-edit" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Edit Invoice"></span></a> 

				    <a href="includes/functions.php?action=sendinqt&pre='.$row["invoice_pre"].'&no='.$row["invoice_no"].'&e1='.$row["custom_email"].'&e2='.$row["custom_email_1"].
					'&bal='.$row["total"].'&dd='.$row["invoice_due_date"].'&ir='.$row["invoice_reference"].'&co='.$row["company"].'&p=1"
					class="btn btn-warning btn-sm py-0" style="font-size: 0.8em; email-invoice">
						<span class="la la-envelope" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Email Invoice"></span></a> 

				    <a href="qtinvdcs/Invoice-'.$row["invoice_pre"].$row["invoice_no"].'.pdf" class="btn btn-info btn-sm py-0" style="font-size: 0.8em;" target="_blank">
						<span class="la la-download" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Download Invoice"></span></a> 

				    <a href="includes/functions.php?action=deliq&pre='.$row["invoice_pre"].'&iq='.$encryption_key.'&no='.$row["invoice_no"].'&en='.$pw.'&p=1" 
					class="btn btn-danger btn-sm py-0" style="font-size: 0.8em; delete-invoice">
						<span class="la la-trash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Delete Invoice"></span></a></td>
			    </tr>
			';
			
			} elseif ($row['status'] == "Paid"){
				print '<td><span class="label label-success">'.$row['status'].'</span></td>';

				print '
						<td>
						<a href="includes/functions.php?action=open&pre='.$row["invoice_pre"].'&no='.$row["invoice_no"].'" class="btn btn-danger btn-sm py-0" style="font-size: 0.8em;">
							<span class="la la-undo" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Mark Open"></span></a>

							<a href="includes/functions.php?action=paidinqt&pre='.$row["invoice_pre"].'&no='.$row["invoice_no"].'&e1='.$row["custom_email"].'&e2='.$row["custom_email_1"].
							'&bal='.$row["total"].'&dd='.$row["invoice_due_date"].'&ir='.$row["invoice_reference"].'&co='.$row["company"].'&p=1"
							class="btn btn-warning btn-sm py-0" style="font-size: 0.8em; email-invoice">
								<span class="la la-envelope" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Send Receipt"></span></a> 
					</tr>
				';
			}

		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no invoices to display.</p>";

	}

	// Frees the memory associated with a result
	mysqli_free_result($result);

	// close connection 
	$mysqli->close();

}

// get Quote list
function getQuotes() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
		die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
    $query = "SELECT * 
		FROM invoices i
		JOIN customer c
		ON c.invoice_no = i.invoice_no
		WHERE i.invoice_no = c.invoice_no
		AND i.invoice_type = 'Quote'
		ORDER BY i.invoice_no DESC";

	// mysqli select query
	$results = $mysqli->query($query);
	
	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table" cellspacing="0"><thead><tr>

				<th>Invoice</th>
				<th>Customer</th>
	            <th>Reference</th>
				<th>Issue Date</th>
				<th>Due Date</th>
				<th>Amount</th>
				<th>Status</th>
				<th>Actions</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

			// Generate encryption key
			include('config.php');
			$encryption_key = generateRandomString();
			$pw = openssl_encrypt('PassWordForDeletingItem', $cipher, $encryption_key, $options, $encryption_iv);

			print '
				<tr>
					<td>'.$row["invoice_no"].'</td>
					<td>'.$row["company"].'</td>
	                <td>'.$row["invoice_reference"].'</td>
				    <td>'.$row["invoice_date"].'</td>
				    <td>'.$row["invoice_due_date"].'</td>
				    <td>£ '.$row["total"].'</td>
				';

				if($row['status'] == "Open"){
					print '<td><span class="label label-primary">'.$row['status'].'</span></td>';
				} elseif ($row['status'] == "Paid"){
					print '<td><span class="label label-success">'.$row['status'].'</span></td>';
				}

			print '
				    <td>
					<a href="invoice-edit.php?inv='.$row["invoice_no"].'" class="btn btn-primary btn-sm py-0" style="font-size: 0.8em;">
						<span class="la la-edit" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Edit Quote"></span></a> 

					<a href="includes/functions.php?action=sendinqt&pre='.$row["invoice_pre"].'&no='.$row["invoice_no"].'&e1='.$row["custom_email"].'&e2='.$row["custom_email_1"].
					'&bal='.$row["total"].'&dd='.$row["invoice_due_date"].'&ir='.$row["invoice_reference"].'&co='.$row["company"].'&p=2"
					class="btn btn-success btn-sm py-0" style="font-size: 0.8em; email-invoice">
						<span class="la la-envelope" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Email Quote"></span></a> 

				    <a href="qtinvdcs/Quote-'.$row["invoice_pre"].$row["invoice_no"].'.pdf" class="btn btn-info btn-sm py-0" style="font-size: 0.8em;" target="_blank">
					<span class="la la-download" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Download Quote"></span></a> 

				    <a href="includes/functions.php?action=deliq&pre='.$row["invoice_pre"].'&iq='.$encryption_key.'&no='.$row["invoice_no"].'&en='.$pw.'&p=2"
					class="btn btn-danger btn-sm py-0" style="font-size: 0.8em; delete-invoice">
					<span class="la la-trash" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Delete Quote"></span></a></td>
			    </tr>
			';

		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no invoices to display.</p>";

	}

	// Frees the memory associated with a result
	mysqli_free_result($result);

	// close connection 
	$mysqli->close();

}

// Initial invoice number
function getInvoiceId() {

	include('config.php');	

	$query = "SELECT id,invoice_pre,invoice_no FROM invoices WHERE invoice_pre = '".INVOICE_PREFIX."' ORDER BY id DESC LIMIT 1";

	if ($result = $mysqli->query($query)) {

		$row_cnt = $result->num_rows;

	    $row = mysqli_fetch_assoc($result);

	    //var_dump($row);

		if (INVOICE_INITIAL_VALUE > $row['invoice_no'] + 1) {
			echo INVOICE_INITIAL_VALUE;
		} elseif($row_cnt == 0){
			echo INVOICE_INITIAL_VALUE;
		} else {
			echo $row['invoice_no'] + 1; 
		}

	    // Frees the memory associated with a result
		$result->free();

		// close connection 
		$mysqli->close();
	}
	
}

// Initial invoice number
function getQuoteId() {

	include('config.php');	

	$query = "SELECT id,invoice_pre,invoice_no FROM invoices WHERE invoice_pre = 'QT-' ORDER BY id DESC LIMIT 1";

	if ($result = $mysqli->query($query)) {

		$row_cnt = $result->num_rows;

	    $row = mysqli_fetch_assoc($result);

	    //var_dump($row);

		if (QUOTE_INITIAL_VALUE > $row['invoice_no'] + 1) {
			echo QUOTE_INITIAL_VALUE;
		} elseif($row_cnt == 0){
			echo QUOTE_INITIAL_VALUE;
		} else {
			echo $row['invoice_no'] + 1; 
		}

	    // Frees the memory associated with a result
		$result->free();

		// close connection 
		$mysqli->close();
	}
	
}

// populate product dropdown for invoice creation
function popProductsList() {

	include('config.php');	

	// the query
	$query = "SELECT * FROM products WHERE product_active = 1 ORDER BY product_name ASC";

	// mysqli select query
	$results = $mysqli->query($query);
	if($results) {

		echo '<select class="card-text" name="item[]" id="item_select">';
		echo '<option selected disabled>Select an item:</option>';
		
		while($row = $results->fetch_assoc()) {

		    print '<option value="'.$row['product_price'].'">'.$row["product_name"].' - '.$row["product_desc"].'</option>';
		}
		echo '</select>';

	} else {

		echo "<p>There are no products, please add a product.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();

}

// populate product dropdown for invoice creation
function popCustomersList() {

	include('config.php');	

	// the query
	$query = "SELECT * FROM store_customers ORDER BY name ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>

				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Action</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		    print '
			    <tr>
					<td>'.$row["name"].'</td>
				    <td>'.$row["email"].'</td>
				    <td>'.$row["phone"].'</td>
				    <td><a href="#" class="btn btn-primary btn-xs customer-select" data-customer-name="'.$row['name'].'" data-customer-email="'.$row['email'].'" data-customer-phone="'.$row['phone'].'" data-customer-address-1="'.$row['address_1'].'" data-customer-address_2="'.$row['address_2'].'" data-customer-town="'.$row['town'].'" data-customer-county="'.$row['county'].'" data-customer-postcode="'.$row['postcode'].'" data-customer-name-ship="'.$row['name_ship'].'" data-customer-address-1-ship="'.$row['address_1_ship'].'" data-customer-address-2-ship="'.$row['address_2_ship'].'" data-customer-town-ship="'.$row['town_ship'].'" data-customer-county-ship="'.$row['county_ship'].'" data-customer-postcode-ship="'.$row['postcode_ship'].'">Select</a></td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no customers to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();

}

// get products list
function getProducts() {

	include('config.php');	

	// the query
	$query = "SELECT * FROM products ORDER BY product_active DESC, product_name ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {

		print '<table class="table table-striped table-hover table-bordered align-middle" id="data-table"><thead><tr>

				<th>Product</th>
				<th>Description</th>
				<th>Price</th>
				<th>Tax (%)</th>
				<th>Action</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		    print '
			    <tr>
					<td>'.$row["product_name"].'</td>
				    <td>'.$row["product_desc"].'</td>
				    <td>'. CURRENCY . $row["product_price"].'</td>
				    <td>'.$row["product_tax"].'</td>
				    <td class="align-middle"><a href="product-edit.php?id='.$row["product_id"].'" class="btn btn-primary btn-sm mr-1"><span class="la la-edit" aria-hidden="true"></span></a>';
					if ($row["product_active"] == 1) {
						echo '<a href="product-edit.php?id='.$row["product_id"].'" class="btn btn-success btn-sm"><span class=" la la-check" aria-hidden="true"></span></a>';
					} else {
						echo '<a href="product-edit.php?id='.$row["product_id"].'" class="btn btn-danger btn-sm"><span class=" la la-close" aria-hidden="true"></span></a>';
					}
					'</td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no products to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();
}

// get user list
function getUsers() {

	include('config.php');	

	// the query
	$query = "SELECT * FROM users ORDER BY username ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>

				<th>Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Action</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		    print '
			    <tr>
			    	<td>'.$row['name'].'</td>
					<td>'.$row["username"].'</td>
				    <td>'.$row["email"].'</td>
				    <td>'.$row["phone"].'</td>
				    <td><a href="user-edit.php?id='.$row["id"].'" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> <a data-user-id="'.$row['id'].'" class="btn btn-danger btn-xs delete-user"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no users to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();
}

// get user list
function getCustomers() {

	include('config.php');	

	// the query
	$query = "SELECT * FROM store_customers ORDER BY active DESC, name ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {

		print '<table class="table table-striped table-hover table-bordered align-middle" id="data-table"><thead><tr>

				<th>Customer</th>
				<th>Contact</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Edit / Active</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		    print '
			    <tr>
					<td class="align-middle">'.$row["name"].'</td>
					<td class="align-middle">'.$row["name_2"].'</td>
				    <td class="align-middle"><a href="mailto:'.$row["email"].'">'.$row["email"].'</a></td>
				    <td class="align-middle"><a href="tel:'.$row["phone"].'">'.$row["phone"].'</a></td>
				    <td class="align-middle"><a href="customer-edit.php?id='.$row["id"].'" class="btn btn-primary btn-sm mr-1"><span class="la la-edit" aria-hidden="true"></span></a>';
					if ($row["active"] == 1) {
						echo '<a href="customer-edit.php?id='.$row["id"].'" class="btn btn-success btn-sm"><span class=" la la-check" aria-hidden="true"></span></a>';
					} else {
						echo '<a href="customer-edit.php?id='.$row["id"].'" class="btn btn-danger btn-sm"><span class=" la la-close" aria-hidden="true"></span></a>';
					}
					'</td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no customers to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();

}


// get user list
function getSites() {

	include('config.php');	

	// the query
	$query = "SELECT * FROM sites WHERE active = 1 AND id > 1 ORDER BY clicks DESC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {

		print '<table class="table table-striped table-hover table-bordered align-middle" id="data-table"><thead><tr>

				<th>Customer</th>
				<th>Site</th>
				<th>Directions / Edit</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		    print '
			    <tr>
					<td class="align-middle">'.$row["customer"].'</td>
					<td class="align-middle">'.$row["site"].'</td>
				    <td class="align-middle"><a href="includes/functions.php?action=maps_link&maps_id='.$row['id'].'" target="_blank" class="btn btn-info btn-sm mr-.5">
					<span class="la la-map-pin" aria-hidden="true"></span></a>
					<a href="site-edit.php?edit='.$row["id"].'" class="btn btn-warning btn-sm"><span class=" la la-edit" aria-hidden="true"></span></a>';
					'</td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no sites to display.</p>";

	}

	while ($row = $results->fetch_assoc()) {
		echo '<p class="card-text"><b>'.$row['customer'] . ", " . $row['site'].'</b>
		<a href="includes/functions.php?action=maps_link&maps_id='.$row['id'].'" target="_blank"><i class="la la-map-pin" title="Maps Link"></i></a></p>';
	}

	// close connection 
	$mysqli->close();

}

// GET CURRENT FINANCIAL YEAR //

class FiscalYear extends DateTime {

    // the start and end of the fiscal year
    private $start;
    private $end;

    /**
     * 
     * Create a fiscal year object
     * 
     * @param type $time date you wish to determine the fiscal year in 'yyyy-mm-dd' format
     * @param type $fiscalstart optional fiscal year start month and day in 'mm-dd' format
     */
    public function __construct($time = null, $fiscalstart = '07-01') {
        parent::__construct($time,null);
        list($m, $d) = explode('-', $fiscalstart);
        $this->start = new DateTime();
        $this->start->setTime(0, 0, 0);
        $this->end = new DateTime();
        $this->end->setTime(23, 59, 59);
        $year = $this->format('Y');
        $this->start->setDate($year, $m, $d);
        $this->end = clone $this->start;
        if ($this->start <= $this) {
            $this->end->add(new DateInterval('P1Y'));
            $this->end->sub(new DateInterval('P1D'));
        } else {
            $this->start->sub(new DateInterval('P1Y'));
            $this->end->sub(new DateInterval('P1D'));
        }
    }

    /**
     * return the start of the fiscal year
     * @return type DateTime
     */
    public function Start() {
        return $this->start;
    }

    /**
     * return the end of the fiscal year
     * @return type DateTime
     */
    public function End() {
        return $this->end;
    }

}


// Dark Mode

function getDark() {
$cookie_name='dark';
if ($_COOKIE[$cookie_name]='on'){
	darkON();
} elseif ($_COOKIE[$cookie_name]='off'){
	darOFF();
}
}


// Verify Admin

function verifyAdmin() {
    if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 'yes'){
         header("Location: dashboard.php");
     }
 }


///////////////////////// SUBMITS //////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		// Import PHPMailer classes into the global namespace
		// These must be at the top of your script, not inside a function
		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\Exception;
		use Dompdf\Dompdf; 
		use Dompdf\Options;

		session_start();

/// SAVE SETTINGS /// (action=mss)
if ($_GET['action'] == 'mss') {
	
	include_once('config.php');

	// Upload Terms conditions etc
	if ($_FILES['upload']['tmp_name']!='') {
		$target_dir = "../uploads/";
		$target_file = $target_dir . basename($_FILES["upload"]["name"]);
		// Check if file is a DOC or PDF file
		$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		if ($fileType != "PDF" && $fileType != "pdf") {
		echo "Sorry, only pdf and PDF files are allowed.";
		//header("Location: ../settings.php?id=4");
		exit();
		}
		if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
			$fileUp = $_FILES["upload"]["name"];
			echo "The file " . basename($_FILES["upload"]["name"]) . " has been uploaded.";
		} else {
			echo "Sorry, there was an error uploading your file.";
		//header("Location: ../settings.php?id=4");
		exit();
		}
	} else {
		$fileUp = TCDP;
	}

	//Copy config file for backup
	date_default_timezone_set(TIMEZONE);
	$date = date("d-m-Y_h-i-s");
	$file = '../includes/config.php';
	$newfile = '../includes/config_bkup_' . $date . '.php';
	if(!copy($file,$newfile)){
		echo "<br>failed to copy $file<br>";
		//header("Location: ../settings.php?id=4");
		exit();
	}
	else{
		echo "<br>copied $file into $newfile<br>";
	}
	
	$newsettings = fopen("config.php", "w") or die("Unable to open file!");
	
	//Write Database Connections
	
	$txt = "<?php\n// Debugging\nini_set('error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE);\n\n// DATABASE INFORMATION\ndefine('DATABASE_HOST', getenv('IP'));\n";
	fwrite($newsettings, $txt);
	$txt = "define('DATABASE_NAME', '".$_POST['DATABASE_NAME']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('DATABASE_USER', '".$_POST['DATABASE_USER']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('DATABASE_PASS', '".$_POST['DATABASE_PASS']."');\n";
	fwrite($newsettings, $txt);
	
	//Write Company Profile
	
	$txt = "\n// COMPANY INFORMATION\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_FAVICON_NAME', '".$_POST['COMPANY_FAVICON_NAME']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_LOGO_NAME', '".$_POST['COMPANY_LOGO_NAME']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_FAVICON', '".$_POST['COMPANY_FAVICON']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_LOGO', '".$_POST['COMPANY_LOGO']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_LOGO_WIDTH', '".$_POST['COMPANY_LOGO_WIDTH']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_LOGO_HEIGHT', '".$_POST['COMPANY_LOGO_HEIGHT']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_NAME', '".$_POST['COMPANY_NAME']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_ADDRESS_1', '".$_POST['COMPANY_ADDRESS_1']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_ADDRESS_2', '".$_POST['COMPANY_ADDRESS_2']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_ADDRESS_3', '".$_POST['COMPANY_ADDRESS_3']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_COUNTY', '".$_POST['COMPANY_COUNTY']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_POSTCODE', '".$_POST['COMPANY_POSTCODE']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_CONTACT_1', '".$_POST['COMPANY_CONTACT_1']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_CONTACT_2', '".$_POST['COMPANY_CONTACT_2']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_EMAIL', '".$_POST['COMPANY_EMAIL']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_WEBSITE', '".$_POST['COMPANY_WEBSITE']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_NUMBER', '".$_POST['COMPANY_NUMBER']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_VAT', '".$_POST['COMPANY_VAT']."');\n";
	fwrite($newsettings, $txt);
	$txt = "define('COMPANY_UTR', '".$_POST['COMPANY_UTR']."');\n";
	fwrite($newsettings, $txt);
	
	//Write Email Details 
	
	$txt = "\n// EMAIL DETAILS\n";
	fwrite($newsettings, $txt);
	$txt = "define('EMAIL_FROM', '".$_POST['EMAIL_FROM']."'); // Email address invoice emails will be sent from\n";
	fwrite($newsettings, $txt);
	$txt = "define('SMTP_SERVER', '".$_POST['SMTP_SERVER']."'); // Email SMTP Server address\n";
	fwrite($newsettings, $txt);
	$txt = "define('SMTP_USERNAME', '".$_POST['SMTP_USERNAME']."'); // Email SMTP Username\n";
	fwrite($newsettings, $txt);
	$txt = "define('SMTP_PASSWORD', '".$_POST['SMTP_PASSWORD']."'); // Email SMTP Password\n";
	fwrite($newsettings, $txt);
	$txt = "define('SMTP_PORT', '".$_POST['SMTP_PORT']."'); // Email SMTP Port\n";
	fwrite($newsettings, $txt);
	$txt = "define('SMTP_USE_AUTH', '".$_POST['SMTP_USE_AUTH']."'); // Email SMTP Use Authorisation\n";
	fwrite($newsettings, $txt);
	$txt = "define('EMAIL_NAME', '".$_POST['EMAIL_NAME']."'); // Email from\n";
	fwrite($newsettings, $txt);
	$txt = "define('EMAIL_SUBJECT', '".$_POST['EMAIL_SUBJECT']."'); // Invoice email subject\n";
	fwrite($newsettings, $txt);
	$txt = "define('EMAIL_BODY_INVOICE', '".$_POST['EMAIL_BODY_INVOICE']."'); // Invoice email body\n";
	fwrite($newsettings, $txt);
	$txt = "define('EMAIL_BODY_QUOTE', '".$_POST['EMAIL_BODY_QUOTE']."'); // Quote email body\n";
	fwrite($newsettings, $txt);
	$txt = "define('EMAIL_BODY_RECEIPT', '".$_POST['EMAIL_BODY_RECEIPT']."'); // Receipt email Body\n";
	fwrite($newsettings, $txt);
	
	//Write Other Settings    INVOICE_PAYMENT_TERM 
	
	$txt = "\n// Other Settings\n";
	fwrite($newsettings, $txt);
	$txt = "define('INVOICE_PREFIX', '".$_POST['INVOICE_PREFIX']."'); // Prefix at start of invoice - leave empty '' for no prefix\n";
	fwrite($newsettings, $txt);
	$txt = "define('INVOICE_INITIAL_VALUE', '".$_POST['INVOICE_INITIAL_VALUE']."'); // Initial invoice order number (start of increment)\n";
	fwrite($newsettings, $txt);
	$txt = "define('QUOTE_INITIAL_VALUE', '".$_POST['QUOTE_INITIAL_VALUE']."'); // Initial quote number (start of increment)\n";
	fwrite($newsettings, $txt);
	$txt = "define('INVOICE_PAYMENT_TERM', '".$_POST['INVOICE_PAYMENT_TERM']."'); // Invoice Payment Term (Days)\n";
	fwrite($newsettings, $txt);
	$txt = "define('INVOICE_THEME', '".$_POST['INVOICE_THEME']."'); // Theme colour, this sets a colour theme for the PDF generate invoice\n";
	fwrite($newsettings, $txt);
	$txt = "define('INVOICE_THEME_HF', '".$_POST['INVOICE_THEME_HF']."'); // Theme colour, this sets a colour theme for the PDF generate invoice\n";
	fwrite($newsettings, $txt);
	$txt = "define('TIMEZONE', '".$_POST['TIMEZONE']."'); // Timezone - See for list of Timezone's http://php.net/manual/en/function.date-default-timezone-set.php\n";
	fwrite($newsettings, $txt);
	$txt = "define('DATE_FORMAT', '".$_POST['DATE_FORMAT']."'); // DD/MM/YYYY or MM/DD/YYYY\n";
	fwrite($newsettings, $txt);
	$txt = "define('CURRENCY', '".$_POST['CURRENCY']."'); // Currency symbol\n";
	fwrite($newsettings, $txt);
	$txt = "define('ENABLE_VAT', '".$_POST['ENABLE_VAT']."'); // Enable TAX/VAT\n";
	fwrite($newsettings, $txt);
	$txt = "define('VAT_INCLUDED', '".$_POST['VAT_INCLUDED']."'); // Is VAT included or excluded?\n";
	fwrite($newsettings, $txt);
	$txt = "define('VAT_RATE', '".$_POST['VAT_RATE']."'); // This is the percentage value\n";
	fwrite($newsettings, $txt);
	$txt = "define('PAYMENT_BANK', '".$_POST['PAYMENT_BANK']."'); // Bank\n";
	fwrite($newsettings, $txt);
	$txt = "define('PAYMENT_SORT', '".$_POST['PAYMENT_SORT']."'); // Sort Code\n";
	fwrite($newsettings, $txt);
	$txt = "define('PAYMENT_ACCTNO', '".$_POST['PAYMENT_ACCTNO']."'); // Acct Number\n";
	fwrite($newsettings, $txt);
	$txt = "define('PAYMENT_DETAILS', '".$_POST['COMPANY_NAME'].".<br>Bank: ".$_POST['PAYMENT_BANK']."<br>Sort Code: ".$_POST['PAYMENT_SORT']."<br>Account Number: ".$_POST['PAYMENT_ACCTNO']."'); // Payment information\n";
	fwrite($newsettings, $txt);
	$txt = "define('FOOTER_NOTE', '".$_POST['FOOTER_NOTE']."'); // \n";
	fwrite($newsettings, $txt);
	$txt = "define('TCDP', '".$fileUp."'); // \n";
	fwrite($newsettings, $txt);
	
	// Connect to DB
	
	$txt = "\n// CONNECT TO THE DATABASE\n$";
	fwrite($newsettings, $txt);
	$txt = "mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);\n\n";
	fwrite($newsettings, $txt);

	// Encrypt

	$txt = "\n//Define cipher\n$";
	fwrite($newsettings, $txt);
	$txt = "cipher = 'aes-256-cbc';\n";
	fwrite($newsettings, $txt);
	$txt = "// Use OpenSSl Encryption method\n$";
	fwrite($newsettings, $txt);
	$txt = "iv_length = openssl_cipher_iv_length($";
	fwrite($newsettings, $txt);
	$txt = "cipher);\n$";
	fwrite($newsettings, $txt);
	$txt = "options = 0;\n";
	fwrite($newsettings, $txt);
	$txt = "//Non-NULL Initialization Vector for encryption\n$";
	fwrite($newsettings, $txt);
	$txt = "encryption_iv = '1234567891011121';\n";
	fwrite($newsettings, $txt);
	fclose($newsettings);
	header("Location: ../settings.php?id=13");


	
}


/// LOGO & FAVICON ///
else if ($_GET['action'] == 'savelogo') {


	include_once('config.php');

	$target_dir = '../' . COMPANY_LOGO;
	$target_file = $target_dir . basename($_FILES["companylogo"]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// Check if image file is a actual image or fake image
	//if(isset($_POST["sendlogo"])) {
	$check = getimagesize($_FILES["companylogo"]["tmp_name"]);
	if($check !== false) {
		//echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		//echo "File is not an image.";
		$uploadOk = 0;
	}
	//}

	// Check if file already exists --- 1 = Ignore & replace
	if (file_exists($target_file)) {
	echo "Sorry, file already exists.";
	$uploadOk = 1;
	}

	// Check file size
	if ($_FILES["companylogo"]["size"] > 500000) {
		header("Location: ../settings_logos.php?id=15");
	$uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "ico" ) {
		header("Location: ../settings_logos.php?id=15");
	$uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		header("Location: ../settings_logos.php?id=15");
	// if everything is ok, try to upload file
	} else {
	if (move_uploaded_file($_FILES["companylogo"]["tmp_name"], $target_file)) {
		header("Location: ../settings_logos.php?id=11");
	} else {
		header("Location: ../settings_logos.php?id=12");
	}
	}
	$mysqli->close();
	exit();


} else if ($_GET['action'] == 'savefavicon') {


		include_once('config.php');
	
		$target_dir = '../' . COMPANY_FAVICON;
		$target_file = $target_dir . basename($_FILES["cfavicon"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	
		// Check if image file is a actual image or fake image
		//if(isset($_POST["sendlogo"])) {
		$check = getimagesize($_FILES["cfavicon"]["tmp_name"]);
		if($check !== false) {
			//echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			//echo "File is not an image.";
			$uploadOk = 0;
		}
		//}
	
		// Check if file already exists  --- 1 = Ignore & replace
		if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 1;
		}
	
		// Check file size
		if ($_FILES["cfavicon"]["size"] > 500000) {
			header("Location: ../settings_logos.php?id=15");
		$uploadOk = 0;
		}
	
		// Allow certain file formats
		if($imageFileType != "png" && $imageFileType != "ico" ) {
			header("Location: ../settings_logos.php?id=15");
		$uploadOk = 0;
		}
	
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			header("Location: ../settings_logos.php?id=15");
		// if everything is ok, try to upload file
		} else {
		if (move_uploaded_file($_FILES["cfavicon"]["tmp_name"], $target_file)) {
			header("Location: ../settings_logos.php?id=14");
		} else {
			header("Location: ../settings_logos.php?id=12");
		}
		$mysqli->close();
		exit();
		}


		/// TEST EMAIL ///

} else if ($_GET['action'] == 'testemail') {
		
		include_once('config.php');

		require '../phpmailer/src/Exception.php';
		require '../phpmailer/src/PHPMailer.php';
		require '../phpmailer/src/SMTP.php';

		$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
		try {
			//Server settings
			$mail->SMTPDebug = 2;                                 // Enable verbose debug output
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = SMTP_SERVER;  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = SMTP_USERNAME;                 // SMTP username
			$mail->Password = SMTP_PASSWORD;                           // SMTP password
			$mail->SMTPSecure = SMTP_USE_AUTH;                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = SMTP_PORT;                                    // TCP port to connect to

			//Recipients
			$mail->setFrom(EMAIL_FROM, EMAIL_NAME);
			$mail->addAddress($_POST['COMPANY_EMAIL'], COMPANY_NAME);     // Add a recipient
			$mail->addReplyTo(COMPANY_EMAIL, COMPANY_NAME);

			//Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			//Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = EMAIL_SUBJECT;
			$mail->Body    = 'This is a test message - Congratulations !';
			$mail->AltBody = 'This is the test body in plain text for non-HTML mail clients';

			$mail->send();
			header("Location: ../settings_testmail.php?id=17");
		} catch (Exception $e) {
			header("Location: ../settings_testmail.php?id=16");
		};
		$mysqli->close();
		exit();


		
		/// Save User Profile Changes ///

} else if ($_GET['action'] == 'spc') {
		
	include_once('config.php');

	$default = null;

	// Generate encryption key
	$encryption_key = generateRandomString();

	$user_id = $_SESSION['id'];
	$dob = assignIfNotEmpty($_POST['dob'], $default);
	$addressl1 = openssl_encrypt(assignIfNotEmpty($_POST['addressl1'], $default), $cipher, $encryption_key, $options, $encryption_iv);
	$addressl2 = openssl_encrypt(assignIfNotEmpty($_POST['addressl2'], $default), $cipher, $encryption_key, $options, $encryption_iv);
	$addressl3 = openssl_encrypt(assignIfNotEmpty($_POST['addressl3'], $default), $cipher, $encryption_key, $options, $encryption_iv);
	$postcode = assignIfNotEmpty($_POST['postcode'], $default);
	$mobile = assignIfNotEmpty($_POST['mobile'], $default);
	$ni_no = openssl_encrypt(assignIfNotEmpty($_POST['ni_no'], $default), $cipher, $encryption_key, $options, $encryption_iv);
	$utr_no = assignIfNotEmpty($_POST['utr_no'], $default);
	$cis_rate = assignIfNotEmpty($_POST['cis_rate'], $default);
	$vat_reg_no = assignIfNotEmpty($_POST['vat_reg_no'], $default);
	$vat_rate = assignIfNotEmpty($_POST['vat_rate'], $default);
	$pay_rate = assignIfNotEmpty($_POST['pay_rate'], $default);
	$salary = assignIfNotEmpty($_POST['salary'], $default);
	$bank = openssl_encrypt(assignIfNotEmpty($_POST['bank'], $default), $cipher, $encryption_key, $options, $encryption_iv);
	$srt = openssl_encrypt(assignIfNotEmpty($_POST['srt'], $default), $cipher, $encryption_key, $options, $encryption_iv);
	$acct = openssl_encrypt(assignIfNotEmpty($_POST['acct'], $default), $cipher, $encryption_key, $options, $encryption_iv);
	$k1 = "$encryption_key";
	$em_name = assignIfNotEmpty($_POST['em_name'], $default);
	$em_mobile = assignIfNotEmpty($_POST['em_mobile'], $default);
	$ins_company = assignIfNotEmpty($_POST['ins_company'], $default);
	$ins_exp_date = assignIfNotEmpty($_POST['ins_exp_date'], $default);
	$ins_policy_no = openssl_encrypt(assignIfNotEmpty($_POST['ins_policy_no'], $default), $cipher, $encryption_key, $options, $encryption_iv);



	if ($stmt = $mysqli->prepare('SELECT * FROM user_details WHERE user_id = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc)
		$stmt->bind_param("i", $_SESSION['id']);
		$stmt->execute();
		$stmt->store_result();
	
		if ($stmt->num_rows > 0) {
			$sql = "UPDATE user_details SET dob=?, addressl1=?, addressl2=?, addressl3=?, postcode=?, mobile=?, ni_no=?, utr_no=?, 
			cis_rate=?, vat_reg_no=?, vat_rate=?, pay_rate=?, salary=?, bank=?, srt=?, acct=?, k1=?, em_name=?, em_mobile=?, ins_company=?, ins_exp_date=?, ins_policy_no=? WHERE user_id = ?";
			$stmt= $mysqli->prepare($sql);
			//$stmt->bind_param('ssi', $dob, $addressl1, $user_id);
			$stmt->bind_param('sssssssssssissssssssssi', $dob, $addressl1, $addressl2, $addressl3, $postcode, $mobile, $ni_no, $utr_no, $cis_rate, $vat_reg_no, $vat_rate, 
			$pay_rate, $salary, $bank, $srt, $acct, $k1, $em_name, $em_mobile, $ins_company, $ins_exp_date, $ins_policy_no, $user_id);
			$stmt->execute();
			$stmt->close();

		} else {

			header("Location: ../dashboard.php?id=2");
		}
	}

	
	$new_pass = $_POST['new_pass'];
	$new_pass1 = $_POST['new_pass1'];
	if (!empty($new_pass && $new_pass1)){
		if ($new_pass != $new_pass1) {
			header("Location: ../user_details.php?id=19");
			exit;
			} else {
			$stmt = $mysqli->prepare("UPDATE users SET password=? WHERE id = ?");
			// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
			$password = password_hash($new_pass1, PASSWORD_DEFAULT);
			$stmt->bind_param('si', $password, $_SESSION['id']);
			$stmt->execute();
			$stmt->close();
		}
	}


	
	$newfilename= date('dmYHis').str_replace(" ", "", basename($_FILES["upload_avatar"]["name"]));
	$target_dir = "../theme-assets/images/portrait/";
	$target_file = $target_dir . $newfilename;
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	$check = getimagesize($_FILES["upload_avatar"]["tmp_name"]);
	if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		$uploadOk = 0;
	}
	}
	// Check if file already exists
	if (file_exists($target_file)) {
	$uploadOk = 0;
	}
	// Check file size 500kb
	if ($_FILES["upload_avatar"]["size"] > 500000) {
	$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		header("Location: ../user_details.php?id=20");
	// if everything is ok, try to upload file & store
	} else {
	if (move_uploaded_file($_FILES["upload_avatar"]["tmp_name"], $target_file)) {
		$stmt = $mysqli->prepare("UPDATE users SET avatar=? WHERE id = ?");
		$avatar = $newfilename;
		$stmt->bind_param('si', $avatar, $_SESSION['id']);
		$stmt->execute();
		$stmt->close();
	} else {
		header("Location: ../user_details.php?id=20");
	}
	}

	echo "Error updating record: " . $mysqli->error;
		echo ($user_id);
	printf("%d Rows.\n", $stmt->num_rows);
	printf("%d Row inserted.\n", $stmt->affected_rows);
	header("Location: ../user_details.php?id=18");
	$mysqli->close();
	exit();


		
	/// Submit User Timesheet ///

} else if ($_GET['action'] == 'sts') {
	
	include_once('config.php');

	require '../phpmailer/src/Exception.php';
	require '../phpmailer/src/PHPMailer.php';
	require '../phpmailer/src/SMTP.php';

	$default = 'null';

	// Set Variables

	$user_id = $_SESSION['id'];
	$user_name = $_SESSION['name'];
	$user_email = $_POST['user_email'];
	$wk_start = $_POST['wk_start'];
		$var = $_POST['wk_end'];
		$date = str_replace('/', '-', $var);
	$wk_end = date('Y-m-d', strtotime($date));
	$wk_startE = date('d-m-Y', strtotime($_POST['wk_start']));
	$wk_endE = date('d-m-Y', strtotime($date));
	$po_number = assignIfNotEmpty($_POST['po_number'], $default);
	$ref_number = assignIfNotEmpty($_POST['ref_number'], $default);
	$sum = assignIfNotEmpty($_POST['sum'], $default);
	$cis_total = assignIfNotEmpty($_POST['cis_total'], $default);
	$vat_total = assignIfNotEmpty($_POST['vat_total'], $default);
	$pay_total = assignIfNotEmpty($_POST['pay_total'], $default);
	$pay_rate = assignIfNotEmpty($_POST['rate'], $default);
	if (($_POST['rate'] > 0) && ($_POST['wk_hours'] == 0)){
		$over_time = 0;
	} else {
		$over_time = $_POST['over_time'];
	}

	echo "id-$user_id - nm-$user_name - wks-$wk_start - wke-$wk_end - po-$po_number - ref-$ref_number - sum-$sum - cis-$cis_total - vat-$vat_total - payt-$pay_total - OT-$over_time <br> <br>";

	for($i=0;$i<count($_POST['pd']);$i++){

	$sql = "INSERT INTO `timesheets`(`user_id`, `name`, `wk_start`, `wk_end`, `po_number`, `ref_number`, `pd`, `hours`, `location`, `details`, `sum_hours`, `cis_total`, `vat_total`, `pay_total`, `over_time`) VALUES 
	('$user_id', '$user_name', '$wk_start', '$wk_end', '$po_number', '$ref_number', '{$_POST['pd'][$i]}', '{$_POST['hours'][$i]}', '{$_POST['site'][$i]}', '{$_POST['details'][$i]}', 
	'$sum', '$cis_total', '$vat_total', '$pay_total', '$over_time')";
	mysqli_query($mysqli, $sql);
	}

	$sql2 = "INSERT INTO `timesheet_details`(`user_id`, `wk_start`, `sum_hours`, `pay_total`, `over_time`) VALUES 
	('$user_id', '$wk_start', '$sum', '$pay_total', '$over_time')";
	//mysqli_query($mysqli, $sql2);
	
	if (mysqli_query($mysqli, $sql2)) {
		//echo "New record created successfully";
		header("Location: ../dashboard.php?id=21");
		} else {
		//echo "New record NOT created<br><br>" . mysqli_error();
		header("Location: ../timesheet.php?id=4");
		}

// send email
// In-Email Variables //
// Self-Employed
if (($_POST['rate'] > 0) && ($_POST['wk_hours'] == 0)){
	$email_vars = array(
		'COMPANY_WEBSITE' => getenv('IP'),
		'COMPANY_NAME' => COMPANY_NAME,
		'name' => $_SESSION['name'],
		'HEADER' => " - Timesheet Information.",
		'MESSAGE' => "<br>Week Start: " . $wk_startE . "<br>Week End: " . $wk_endE . "<br>PO Number: " . $po_number . "<br>Ref Number: " . $ref_number . "<br><br>Total Hours: " . $sum
		. "<br>Pay Rate: " . $pay_rate . "<br>CIS Total: " . $cis_total . "<br>VAT Total: " . $vat_total . "<br><br><B>Pay Total: " . $pay_total . "<B>",
		'FOLLOW_UP' => "<br><br>Regards, " . COMPANY_NAME,
		'IMAGE' => $_SESSION['avatar'],
		'FOOTER' => "Break Down Below",
	);
// Employed
} else if (($_POST['rate'] == 0) && ($_POST['salary'] > 0)) {
	$email_vars = array(
		'COMPANY_WEBSITE' => getenv('IP'),
		'COMPANY_NAME' => COMPANY_NAME,
		'name' => $_SESSION['name'],
		'HEADER' => " - Timesheet Information.",
		'MESSAGE' => "<br>Week Start: " . $wk_startE . "<br>Week End: " . $wk_endE . "<br>PO Number: " . $po_number . "<br>Ref Number: " . $ref_number . "<br><br>Total Hours: " . $sum
		. "<br>Over-Time: " . $over_time,
		'FOLLOW_UP' => "<br><br>Regards, " . COMPANY_NAME,
		'IMAGE' => $_SESSION['avatar'],
		'FOOTER' => "Break Down Below",
	);
} else {
	$email_vars = array(
		'COMPANY_WEBSITE' => getenv('IP'),
		'COMPANY_NAME' => COMPANY_NAME,
		'name' => $_SESSION['name'],
		'HEADER' => " - Timesheet Information.",
		'MESSAGE' => "Error",
		'FOLLOW_UP' => "<br><br>Regards, " . COMPANY_NAME,
		'IMAGE' => $_SESSION['avatar'],
	);
}

// INSERT INTO BODY //
	$body = file_get_contents('../assets/email-templates/basicNotification.html');

	if(isset($email_vars)){
		foreach($email_vars as $k=>$v){
			$body = str_replace('{'.strtoupper($k).'}', $v, $body);
		}
	}


$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
	//Server settings
	$mail->SMTPDebug = 0;                                 // Enable verbose debug output
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = SMTP_SERVER;  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = SMTP_USERNAME;                 // SMTP username
	$mail->Password = SMTP_PASSWORD;                           // SMTP password
	$mail->SMTPSecure = SMTP_USE_AUTH;                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = SMTP_PORT;                                    // TCP port to connect to

	//Recipients
	$mail->setFrom(EMAIL_FROM, EMAIL_NAME);
	$mail->addAddress($user_email, COMPANY_NAME);     // Add a recipient
	$mail->addBCC(COMPANY_EMAIL, COMPANY_NAME);
	$mail->addReplyTo(COMPANY_EMAIL, COMPANY_NAME);

	//Content
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->Subject = $_SESSION['name'] . " Timesheet Details"; 
	$mail->Body    = $body;
	$mail->Body .= "<body><br><div align='center'><table border=\"1\" style='width:90%;padding:2px;text-align:center'><thead><tr>
		<th>Date</th>
		<th>Hours</th>
		<th>Site</th>
		<th>Details</th>
		</tr></thead><tbody>"; 
		for($i=0;$i<count($_POST['pd']);$i++){
	$mail->Body .= "<tr>
		<td>" . $date = date("D, d-m-Y",strtotime($_POST['pd'][$i])) . "</td>
		<td>" . $_POST['hours'][$i] . "</td>
		<td>" . $_POST['site'][$i] . "</td>
		<td>" . $_POST['details'][$i] . "</td>
		</tr>";
	}
	$mail->Body .= "</tbody></table>";

	$mail->send();
			header("Location: ../dashboard.php?id=21");
		} catch (Exception $e) {
			header("Location: ../timesheet.php?id=4");
		};
		$mysqli->close();
		exit();


		
	/// UPDATE CUSTOMER ///

} else if ($_GET['action'] == 'ecd') {
	
	include_once('config.php');

	$default = 'null';

	// Set Variables

	$customer_id = $_POST['cust_id']; // customer id
	$customer_name = $_POST['customer_name']; // customer name
	$customer_name_2 = $_POST['customer_name_2']; // customer name
	$customer_email = $_POST['customer_email']; // customer email
	$customer_email_2 = $_POST['customer_email_2']; // customer email 2
	$customer_address_1 = $_POST['customer_address_1']; // customer address
	$customer_address_2 = $_POST['customer_address_2']; // customer address
	$customer_town = $_POST['customer_town']; // customer town
	$customer_county = $_POST['customer_county']; // customer county
	$customer_postcode = $_POST['customer_postcode']; // customer postcode
	$customer_phone = $_POST['customer_phone']; // customer phone number
	
	//shipping
	$customer_name_ship = $_POST['customer_name_ship']; // customer name (shipping)
	$customer_address_1_ship = $_POST['customer_address_1_ship']; // customer address (shipping)
	$customer_address_2_ship = $_POST['customer_address_2_ship']; // customer address (shipping)
	$customer_town_ship = $_POST['customer_town_ship']; // customer town (shipping)
	$customer_county_ship = $_POST['customer_county_ship']; // customer county (shipping)
	$customer_postcode_ship = $_POST['customer_postcode_ship']; // customer postcode (shipping)

	//More Info
	$customer_website = $_POST['website']; // customer website
	$customer_vat = $_POST['vat_number']; // customer VAT number
	$customer_cis = $_POST['cis_number']; // customer CIS Number
	$customer_utr = $_POST['utr_number']; // customer UTR Number
	$customer_active = !empty($_POST['customer_active'])?$_POST['customer_active']:0; // customer active ?
	$addtosites = !empty($_POST['add_to_sites'])?$_POST['add_to_sites']:0; //add address to sites list
	$site_id = $_POST['site_id']; // customer website

	$siteaddress = $customer_address_1 . ', ' .$customer_address_2 . ', ' . $customer_town . ', ' . $customer_postcode;

	$sql2 = "UPDATE sites SET address = '$siteaddress', active = '$addtosites' WHERE id = $site_id";
	mysqli_query($mysqli, $sql2);

	
	$stmt = $mysqli->prepare("UPDATE store_customers SET name=?, name_2=?, email=?, email_2=?, address_1=?, address_2=?, town=?, county=?,
		 postcode=?, phone=?, name_ship=?, address_1_ship=?, address_2_ship=?, town_ship=?, county_ship=?, postcode_ship=?, website=?,
		 vat_number=?, cis_number=?, utr_number=?, active=? WHERE id = ?");
	$stmt->bind_param('ssssssssssssssssssssii', $customer_name, $customer_name_2, $customer_email, $customer_email_2, $customer_address_1, $customer_address_2,$customer_town, 
		$customer_county, $customer_postcode, $customer_phone, $customer_name_ship, $customer_address_1_ship, $customer_address_2_ship, $customer_town_ship, 
		$customer_county_ship, $customer_postcode_ship, $customer_website, $customer_vat, $customer_cis, $customer_utr, $customer_active, $customer_id);

	if ($stmt->execute()) {
		//echo "New record created successfully";
		header("Location: ../customer-view.php?id=22");
		} else {
		//echo "New record NOT created<br><br>" . mysqli_error();
		header("Location: ../customer-view.php?id=4");
		}
	$stmt->close();
	exit();


		
/// CREATE NEW CUSTOMER ///

} else if ($_GET['action'] == 'cnc') {

include_once('config.php');

$default = 'null';

// Set Variables

$customer_name = $_POST['customer_name']; // customer name
$customer_name_2 = $_POST['customer_name_2']; // customer name
$customer_email = $_POST['customer_email']; // customer email
$customer_email_2 = $_POST['customer_email_2']; // customer email 2
$customer_address_1 = $_POST['customer_address_1']; // customer address
$customer_address_2 = $_POST['customer_address_2']; // customer address
$customer_town = $_POST['customer_town']; // customer town
$customer_county = $_POST['customer_county']; // customer county
$customer_postcode = $_POST['customer_postcode']; // customer postcode
$customer_phone = $_POST['customer_phone']; // customer phone number

//shipping
$customer_name_ship = $_POST['customer_name_ship']; // customer name (shipping)
$customer_address_1_ship = $_POST['customer_address_1_ship']; // customer address (shipping)
$customer_address_2_ship = $_POST['customer_address_2_ship']; // customer address (shipping)
$customer_town_ship = $_POST['customer_town_ship']; // customer town (shipping)
$customer_county_ship = $_POST['customer_county_ship']; // customer county (shipping)
$customer_postcode_ship = $_POST['customer_postcode_ship']; // customer postcode (shipping)

//More Info
$customer_website = $_POST['website']; // customer website
$customer_vat = $_POST['vat_number']; // customer VAT number
$customer_cis = $_POST['cis_number']; // customer CIS Number
$customer_utr = $_POST['utr_number']; // customer UTR Number
$customer_active = !empty($_POST['customer_active'])?$_POST['customer_active']:0; // customer active ?
$addtosites = !empty($_POST['add_to_sites'])?$_POST['add_to_sites']:0; //add address to sites list

	
$stmt = $mysqli->prepare("INSERT INTO store_customers (name, name_2, email, email_2, address_1, address_2, town, county, postcode, phone, name_ship, address_1_ship, 
address_2_ship, town_ship, county_ship, postcode_ship, website, vat_number, cis_number, utr_number, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('ssssssssssssssssssssi', $customer_name, $customer_name_2, $customer_email, $customer_email_2, $customer_address_1, $customer_address_2,$customer_town, 
	$customer_county, $customer_postcode, $customer_phone, $customer_name_ship, $customer_address_1_ship, $customer_address_2_ship, $customer_town_ship, 
	$customer_county_ship, $customer_postcode_ship, $customer_website, $customer_vat, $customer_cis, $customer_utr, $customer_active);

$siteaddress = $customer_address_1 . ', ' .$customer_address_2 . ', ' . $customer_town . ', ' . $customer_postcode;
if ($addtosites == '1'){
	$sql2 = "INSERT INTO sites (customer, site, address, active) VALUES 
	('$customer_name_2', '$customer_name', '$siteaddress', '$addtosites')";
	mysqli_query($mysqli, $sql2);
} else {
	$sql3 = "INSERT INTO sites (customer, site, address, active) VALUES 
	('$customer_name_2', '$customer_name', '$siteaddress', '0')";
	mysqli_query($mysqli, $sql3);
}

if ($stmt->execute()) {
	//echo "New record created successfully";
	header("Location: ../customer-view.php?id=23");
	} else {
	//echo "New record NOT created<br><br>" . mysqli_error();
	header("Location: ../customer-view.php?id=4");
	}
$stmt->close();
exit();


		
/// CREATE NEW Product ///

} else if ($_GET['action'] == 'cnp') {

include_once('config.php');

$default = 'null';

// Set Variables

$product_name = $_POST['product_name']; // product name
$product_desc = $_POST['product_desc']; // product description
$product_price = $_POST['product_price']; // product unit price
$product_tax = $_POST['item_tax']; // product unit tax
$product_active = !empty($_POST['product_active'])?$_POST['product_active']:0; // product active ?
$date_added = date("d/m/Y");

	
$stmt = $mysqli->prepare("INSERT INTO products (product_name, product_desc, product_price, product_tax, product_active) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('ssssi', $product_name, $product_desc, $product_price, $product_tax, $product_active);

if ($stmt->execute()) {
	//echo "New record created successfully";
	header("Location: ../product-view.php?id=25");
	} else {
	//echo "New record NOT created<br><br>" . mysqli_error();
	header("Location: ../product-view.php?id=4");
	}
$stmt->close();
exit();
	
	
			
/// UPDATE PRODUCT ///

} else if ($_GET['action'] == 'epd') {

include_once('config.php');

$default = 'null';

// Set Variables

$product_id = $_POST['product_id']; // product id
$product_name = $_POST['product_name']; // product name
$product_desc = $_POST['product_desc']; // product description
$product_price = $_POST['product_price']; // product unit price
$product_tax = $_POST['item_tax']; // product unit tax
$product_active = !empty($_POST['product_active'])?$_POST['product_active']:0; // product active ?

$stmt = $mysqli->prepare("UPDATE products SET product_name=?, product_desc=?, product_price=?, product_tax=?, product_active=? WHERE product_id = ?");
$stmt->bind_param('ssssii', $product_name, $product_desc, $product_price, $product_tax, $product_active, $product_id);

if ($stmt->execute()) {
	//echo "New record created successfully";
	header("Location: ../product-view.php?id=24");
	} else {
	//echo "New record NOT created<br><br>" . mysqli_error();
	header("Location: ../product-view.php?id=4");
	}
$stmt->close();
exit();
	
	
			
/// SEND DASHBOARD FORM ///

} else if ($_GET['action'] == 'sdf') {

session_start();
include_once('config.php');

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

$default = 'null';

// Set Variables

$contact_name = $_POST['contact_name']; 
$contact_email = $_POST['contact_email']; 
$form_message = $_POST['message']; 
$message_subject = $_POST['message_subject']; 
$folow_up = $_POST['follow']; 

// In-Email Variables //
$email_vars = array(
    'COMPANY_WEBSITE' => getenv('IP'),
    'COMPANY_NAME' => COMPANY_NAME,
    'name' => $_SESSION['name'],
    'HEADER' => "has sent you a message.",
    'MESSAGE' => "<br>Message - " . $form_message,
    'FOLLOW_UP' => "<br><br>" . $folow_up,
    'IMAGE' => $_SESSION['avatar'],
);

// INSERT INTO BODY //
	$body = file_get_contents('../assets/email-templates/basicNotification.html');

	if(isset($email_vars)){
		foreach($email_vars as $k=>$v){
			$body = str_replace('{'.strtoupper($k).'}', $v, $body);
		}
	}

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
	//Server settings
	$mail->SMTPDebug = 0;                                 // Enable verbose debug output
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = SMTP_SERVER;  // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = SMTP_USERNAME;                 // SMTP username
	$mail->Password = SMTP_PASSWORD;                           // SMTP password
	$mail->SMTPSecure = SMTP_USE_AUTH;                            // Enable TLS encryption, `ssl` also accepted
	$mail->Port = SMTP_PORT;                                    // TCP port to connect to

	//Recipients
	$mail->setFrom(EMAIL_FROM, $_SESSION['name']);
	$mail->addAddress($contact_email, $contact_name);     // Add a recipient
	$mail->addReplyTo($_SESSION['email'], $_SESSION['name']);

	//Content
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->Subject = $message_subject; 
	$mail->Body    = $body;

	$mail->send();
	header("Location: ../dashboard.php?id=17");
} catch (Exception $e) {
	header("Location: ../timesheet.php?id=4");
};
$mysqli->close();
exit();
	
	
			
/// MAPS LINK ///

} else if ($_GET['action'] == 'maps_link') {
	
	$mapID = $_GET['maps_id'];
	$P1 = 1;
	$stmt = $mysqli->prepare("UPDATE sites SET clicks = clicks+ ? WHERE id = ?");
	$stmt->bind_param('ii', $P1, $mapID);
	$stmt->execute();

	$sql="SELECT * FROM sites WHERE id = $mapID";
	$result=mysqli_query($mysqli,$sql);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	$work_site = $row['site'];
	$site_address = $row['address'];
	$maps_link = $row['maps_link'];

	if (!empty($maps_link)) {
	header("Location: ". $maps_link);
	} else {
		header("Location: https://maps.google.com/?q=". $site_address);
	}
	$mysqli->close();
	exit();
	
	$vars = array_keys(get_defined_vars());
	foreach($vars as $var) {
		unset(${"$var"});
	}
	
	
			
/// ADD A SITE ///

} else if ($_GET['action'] == 'add_site') {

	$existing_customer = $_POST['customer_name'];
	$new_customer = $_POST['site_owner'];
	if ($existing_customer == ""){ $customer = $new_customer; } else if ($new_customer == ""){ $customer = $existing_customer; }
	$site = $_POST['AD'];
	$address = $_POST['fullAD'];
	if ($_POST['ADMapLink'] == "") {$maps_link = ""; } else { $maps_link = $_POST['ADMapLink'];	}

	$stmt = $mysqli->prepare("INSERT INTO sites (customer, site, address, maps_link) VALUES (?, ?, ?, ?)");
	$stmt->bind_param('ssss', $customer, $site, $address, $maps_link);

	if ($stmt->execute()) {
		//echo "New record created successfully";
		header("Location: ../sites.php?id=28");
		} else {
		//echo "New record NOT created<br><br>" . mysqli_error();
		header("Location: ../sites.php?id=4");
		}
	$stmt->close();
	exit();
	
			
/// UPDATE A SITE ///

} else if ($_GET['action'] == 'update_site') {

	$customer = $_POST['site_owner'];
	$id = $_POST['sid'];
	$site = $_POST['AD'];
	$address = $_POST['AD1'] . ", " . $_POST['AD2'] . ", " . $_POST['AD3'] . ", " . $_POST['ADCounty'] . ", " . $_POST['ADPC'];
	if ($_POST['ADMapLink'] == "") {$maps_link = ""; } else { $maps_link = $_POST['ADMapLink'];	}

	$stmt = $mysqli->prepare("UPDATE sites SET customer=?, site=?, address=?, maps_link=? WHERE id = ?");
	$stmt->bind_param('ssssi', $customer, $site, $address, $maps_link, $id);
	
	if ($stmt->execute()) {
		//echo "New record created successfully";
		header("Location: ../sites.php?id=29");
		} else {
		//echo "New record NOT created<br><br>" . mysqli_error();
		header("Location: ../sites.php?id=4");
		}
	$stmt->close();
	exit();
	
			
/// SAVE INVOICE ONLY ///
	
} else if ($_GET['action'] == 'sio') {
	
	session_start();
	include_once('config.php');
	
	require '../phpmailer/src/Exception.php';
	require '../phpmailer/src/PHPMailer.php';
	require '../phpmailer/src/SMTP.php';

	// PDF GENERATE
	// Include autoloader 
	require('../includes/TCPDF/tcpdf.php');
	
	// Set Variables
	
	$invoice_type = $_POST['invoice_type']; 
	$invoice_status = $_POST['invoice_status']; 
	$invoice_reference = $_POST['invoice_reference']; 
	$invoice_date = (new DateTime($_POST['invoice_date']))->format('d/m/Y');
	$invoice_due_date = $_POST['invoice_due_date']; 
	$invoice_pre = $_POST['invoice_pre']; 
	$invoice_id = $_POST['invoice_id']; 
	$customer_name = $_POST['customer']; 
	$customer_email_1 = $_POST['customer_email_1']; 
	$customer_email_2 = $_POST['customer_email_2']; 
	$contact_name = $_POST['customer_name_2']; 
	$customer_address_1 = $_POST['customer_address_1']; 
	$customer_address_2 = $_POST['customer_address_2']; 
	$customer_town = $_POST['customer_town']; 
	$customer_county = $_POST['customer_county']; 
	$customer_postcode = $_POST['customer_postcode']; 
	$customer_phone = $_POST['customer_phone']; 
	$customer_ship_name = $_POST['customer_ship_name']; 
	$customer_ship_address_1 = $_POST['customer_ship_address_1']; 
	$customer_ship_address_2 = $_POST['customer_ship_address_2']; 
	$customer_ship_town = $_POST['customer_ship_town']; 
	$customer_ship_county = $_POST['customer_ship_county']; 
	$customer_ship_postcode = $_POST['customer_ship_postcode']; 
	$customer_ship_phone = $_POST['customer_ship_phone']; 
	$notes = $_POST['notes']; 
	$total_subtotal = $_POST['total_subtotal']; 
	if ($_POST['total_line_tax'] == ''){ $total_line_tax = '0'; } else { $total_line_tax = $_POST['total_line_tax']; }
	if ($_POST['invoice_tax'] == ''){ $invoice_tax = '0'; } else { $invoice_tax = $_POST['invoice_tax']; }
	$subtotal_tax = $_POST['subtotal_tax']; 
	$total_balance_due = $_POST['total_balance_due']; 
	if ($invoice_type == 'Invoice'){ $due_exp = 'Due Date';} else if ($invoice_type == 'Quote'){ $due_exp = 'Valid Till';}


	// INSERT INTO INVOICE TABLE
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$stmt = $mysqli->prepare("INSERT INTO invoices (invoice_pre, invoice_no, invoice_reference, custom_email, custom_email_1, invoice_date, invoice_due_date, subtotal, line_taxes, 
	invoice_tax, invoice_tax_total, total, notes, invoice_type, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('sssssssssssssss', $invoice_pre, $invoice_id, $invoice_reference, $customer_email_1, $customer_email_2, $invoice_date, $invoice_due_date, $total_subtotal, 
		$total_line_tax, $invoice_tax, $subtotal_tax, $total_balance_due, $notes, $invoice_type, $invoice_status);
	if ($stmt->execute()) { $inv_id = $mysqli->insert_id;	} else {
		header("Location: ../invoice-create.php?id=4");
	}

	// INSERT INTO CUSTOMER TABLE
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$stmt = $mysqli->prepare("INSERT INTO customer (inv_id, invoice_pre, invoice_no, company, name, email_1, email_2, address_1, address_2, town, county, postcode, phone, name_ship, address_1_ship, address_2_ship,
	town_ship, county_ship, postcode_ship) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('sssssssssssssssssss', $inv_id, $invoice_pre, $invoice_id, $customer_name, $contact_name, $customer_email_1, $customer_email_2, $customer_address_1, $customer_address_2, $customer_town, 
		$customer_county, $customer_postcode, $customer_phone, $customer_ship_name, $customer_ship_address_1, $customer_ship_address_2, $customer_ship_town, $customer_ship_county,
		$customer_ship_postcode);
	if ($stmt->execute()) {	} else {
		header("Location: ../invoice-create.php?id=4");
	}


	// INSERT INTO INVOICE ITEMS TABLE
	$query = "INSERT INTO invoice_items (inv_id1, invoice_pre, invoice_no, product, product_desc, qty, unit_price, line_tax, line_tax_amt, line_subtotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$stmt = $mysqli->prepare($query);

	for ($i=0; $i<count($_POST['item']); $i++) {
		$item_name = $_POST['item'][$i];
		$item_unit_desc = $_POST['item_unit_description'][$i];
		$item_quantity = $_POST['item_quantity'][$i];
		$item_unit_cost = $_POST['item_unit_cost'][$i];
		$line_tax = $_POST['item_tax'][$i];
		$line_tax_amt = $_POST['line_tax_amt'][$i];
		$item_line_total = $_POST['item_line_total'][$i];
		$stmt->bind_param('ssssssssss', $inv_id, $invoice_pre, $invoice_id, $item_name, $item_unit_desc, $item_quantity, $item_unit_cost, $line_tax, $line_tax_amt, $item_line_total);
		$stmt->execute();
	}

	// CREATE PDF
	ini_set('memory_limit', '256M');
	class MYPDF extends TCPDF {
		public function Header() {
			$myBgColor = hex2rgb(INVOICE_THEME_HF);
			$this->Rect(0, 0, 2000, 43,'F',array(),$myBgColor,'');
			$this->setJPEGQuality(5);
			$this->Image('../'.COMPANY_LOGO . COMPANY_LOGO_NAME, 15, 10, COMPANY_LOGO_WIDTH, COMPANY_LOGO_HEIGHT, 'PNG', ''); // '../' . <-- May be needed at front.
			$this->SetTextColor(255,255,255);
			$this->CreateTextBox(COMPANY_NAME, 80, 5, 10, 10, 14, 'B');
			$this->CreateTextBox('Web: ' . COMPANY_WEBSITE, 80, 15, 10, 10, 8);
			$this->CreateTextBox('Phone: ' . COMPANY_CONTACT_1, 80, 20, 10, 10, 8);
			$this->CreateTextBox('E-mail: ' . COMPANY_EMAIL, 80, 25, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_1, 135, 10, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_2, 135, 15, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_3, 135, 20, 10, 10, 8);
			$this->CreateTextBox(COMPANY_POSTCODE, 135, 25, 10, 10, 8);

		}
		public function Footer() {
			$myBgColor = hex2rgb(INVOICE_THEME_HF);
			$this->Rect(0, 270, 2000, 27,'F',array(),$myBgColor,'');
			$this->setJPEGQuality(5);
			$this->Image('../'.COMPANY_FAVICON . COMPANY_FAVICON_NAME, 180, 273, 18, 0, 'PNG', ''); // '../' . <-- May be needed at front.
			$this->SetY(-15);
			$this->SetTextColor(255,255,255);
			$this->CreateTextBox('UTR: ' . COMPANY_UTR, 0, 273, 10, 10, 8);
			$this->CreateTextBox('VAT NO: ' . COMPANY_VAT, 0, 278, 10, 10, 8);
			$this->CreateTextBox('REG NO: ' . COMPANY_NUMBER, 0, 283, 10, 10, 8);
		}
		public function CreateTextBox($textval, $x = 0, $y, $width = 0, $height = 10, $fontsize = 10, $fontstyle = '', $align = 'L') {
			$this->SetXY($x+20, $y); // 20 = margin left
			$this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
			$this->Cell($width, $height, $textval, 0, false, $align);
		}
	}
	// create a PDF object
	$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

	// set document (meta) information
	$pdf->SetCreator(COMPANY_NAME);
	$pdf->SetAuthor(COMPANY_NAME);
	$pdf->SetTitle(COMPANY_NAME . ' Document');
	$pdf->SetSubject(COMPANY_NAME . ' Document');
	$pdf->SetKeywords(COMPANY_NAME . ' Document');

	// set document colours
	$theme = hex2rgb(INVOICE_THEME);
	$hex = INVOICE_THEME;
	list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");

	// add a page
	$pdf->AddPage();

	// invoice title / number
	$pdf->SetTextColor($r, $g, $b);
	$pdf->CreateTextBox('Your '.$invoice_type, 0, 55, 120, 20, 20, 'B');
	$pdf->SetTextColor(41,41,41);

	// create address box
	$pdf->CreateTextBox('TO:', 0, 75, 80, 10, 10);
	$pdf->CreateTextBox($customer_name, 0, 80, 80, 10, 10, 'B');
	$pdf->CreateTextBox($customer_address_1, 0, 85, 80, 10, 10);
	$pdf->CreateTextBox($customer_address_2, 0, 90, 80, 10, 10);
	$pdf->CreateTextBox($customer_town, 0, 95, 80, 10, 10);
	$pdf->CreateTextBox($customer_postcode, 0, 100, 80, 10, 10);
	//$pdf->CreateTextBox($customer_email_1, 0, 105, 80, 10, 10);
	//$pdf->CreateTextBox($customer_email_2, 0, 110, 80, 10, 10);

	// date, order ref
	$pdf->Rect(145, 79, 65, 32,'F',array(),$theme, 'R');
	$pdf->SetTextColor(255,255,255);
	$pdf->CreateTextBox('Order ID: ' . $invoice_pre . $invoice_id, 0, 80, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Date: ' . $invoice_date, 0, 85, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox($due_exp.': ' . $invoice_due_date, 0, 90, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Total: ' . CURRENCY . $total_balance_due, 0, 95, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Ref: ' . $invoice_reference, 0, 100, 0, 10, 10, '', 'R');
	// list headers
	$pdf->SetTextColor(41,41,41);
	$pdf->CreateTextBox('Quantity', 0, 120, 20, 10, 10, 'B', 'C');
	$pdf->CreateTextBox('Product or service', 20, 120, 90, 10, 10, 'B');
	$pdf->CreateTextBox('Price', 90, 120, 30, 10, 10, 'B', 'R');
	$pdf->CreateTextBox('Tax %', 110, 120, 30, 10, 10, 'B', 'R');
	$pdf->CreateTextBox('Amount', 140, 120, 30, 10, 10, 'B', 'R');

	$pdf->Line(20, 129, 195, 129);

	// Set Sales Line Variables
	$item_name = $_POST['item'];
	$item_unit_desc = $_POST['item_unit_description'];
	$item_quantity = $_POST['item_quantity'];
	$item_unit_cost = $_POST['item_unit_cost'];
	$line_tax = $_POST['item_tax'];
	$line_tax_amt = $_POST['line_tax_amt'];
	$item_line_total = $_POST['item_line_total'];
	$currY = 128;

	foreach($item_name as $key => $item_name) {
		$qty = $item_quantity[$key];
		$desc = $item_unit_desc[$key];
		$tax = $line_tax[$key];
		$cost = $item_unit_cost[$key];
		$total = $item_line_total[$key];

		$pdf->CreateTextBox($qty, 0, $currY, 20, 10, 10, '', 'C');
		$pdf->SetTextColor($r, $g, $b);
		$pdf->CreateTextBox($desc, 20, $currY, 90, 10, 10, 'B');
		$pdf->SetTextColor(41,41,41);
		$pdf->CreateTextBox(CURRENCY.' '.$cost, 90, $currY, 30, 10, 10, '', 'R');
		$pdf->CreateTextBox($tax, 110, $currY, 30, 10, 10, '', 'R');
		$pdf->CreateTextBox(CURRENCY.' '.$total, 140, $currY, 30, 10, 10, '', 'R');

		$currY = $currY+5;
	}

	$pdf->Line(20, $currY+4, 195, $currY+4);

	$pdf->CreateTextBox('Payment Term: ' . INVOICE_PAYMENT_TERM . ' Days.', 2, $currY+6, 20, 10, 10, '');
	$pdf->CreateTextBox('Bank: ' . PAYMENT_BANK, 2, $currY+11, 20, 10, 10, '');
	$pdf->CreateTextBox('Sort: ' . PAYMENT_SORT, 2, $currY+16, 20, 10, 10, '');
	$pdf->CreateTextBox('Acct: ' . PAYMENT_ACCTNO, 2, $currY+21, 20, 10, 10, '');
	$pdf->CreateTextBox('Full T&Cs on our website.', 2, $currY+26, 20, 10, 10, '');


	// output the sub-total row
	$pdf->CreateTextBox('Sub-Total', 15, $currY+6, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox(CURRENCY . $total_subtotal, 140, $currY+6, 30, 10, 10, 'B', 'R');
	// output the total line tax row
	$pdf->CreateTextBox('Line Taxes', 15, $currY+11, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox(CURRENCY . $total_line_tax, 140, $currY+11, 30, 10, 10, 'B', 'R');
	// output the total row
	$pdf->CreateTextBox('Tax', 15, $currY+16, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox($invoice_tax.'%', 140, $currY+16, 30, 10, 10, 'B', 'R');
	// output the total row
	$pdf->CreateTextBox('Tax Amt.', 15, $currY+21, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox(CURRENCY . $subtotal_tax, 140, $currY+21, 30, 10, 10, 'B', 'R');
	// output the total row
	$pdf->CreateTextBox('Total Due', 20, $currY+31, 150, 10, 14, 'B', 'R');
	$pdf->SetTextColor($r, $g, $b);
	$pdf->CreateTextBox(CURRENCY . $total_balance_due, 140, $currY+37, 30, 10, 14, 'B', 'R');
	$pdf->SetTextColor(41,41,41);

	// some payment instructions or information
	$pdf->setXY(20, $currY+60);
	$pdf->SetFont(PDF_FONT_NAME_MAIN, '', 10);
	$pdf->MultiCell(175, 10, $notes , 0, 'L', 0, 1, '', '', true, null, true);

	//Close and output PDF document
	$filename = $invoice_type.'-'.$invoice_pre.''.$invoice_id.".pdf"; 
	$upOne = dirname(__DIR__, 1);
	$folder = "/qtinvdcs/";
	$filelocation = $upOne . $folder;
	$fileNL = $filelocation.$filename;
	ob_clean();
	$pdf->Output($fileNL, 'F');
	// Insert into Invoice Docs Table
	$status = '0';
	$pass = uniqid();
	$insertquery = "INSERT INTO invoice_docs(invoice_pre, invoice_id, customer, email_1, email_2, folder, filename, status, pass) 
					VALUES('$invoice_pre','$invoice_id','$contact_name','$customer_email_1','$customer_email_2','$folder','$filename','$status','$pass')";
					$iquery = mysqli_query($mysqli, $insertquery);

	// UPLOAD DOCUMENTS
	$status = '1';
	if (isset($_FILES['upload_document']['name']))
	{
		$files = array_filter($_FILES['upload_document']['name']); //Use something similar before processing files.
		// Count the number of uploaded files in array
		$total_count = count($_FILES['upload_document']['name']);
		// Loop through every file
		for ($i=0; $i<count($_FILES['upload_document']['name']); $i++) {
			$file_name = $_FILES['upload_document']['name'][$i];
		//for( $i=0 ; $i < $total_count ; $i++ ) {
		//The temp file path is obtained
		$tmpFilePath = $_FILES['upload_document']['tmp_name'][$i];
		//A file path needs to be present
			if ($tmpFilePath != ""){
				//Setup our new file path
				$folder = "/qtinvdcs/inv_docs/";
				$newFilePath = '..' . $folder . $pass . '-' . $_FILES['upload_document']['name'][$i];
				//File is uploaded to temp dir
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					//Other code goes here
					$insertquery = "INSERT INTO invoice_docs(invoice_pre, invoice_id, customer, email_1, email_2, folder, filename, status, pass) 
					VALUES('$invoice_pre','$invoice_id','$contact_name','$customer_email_1','$customer_email_2','$folder','$file_name','$status','$pass')";
					$iquery = mysqli_query($mysqli, $insertquery);
					echo 'Files: ' . $total_count . ' - Have been uploaded';
				} else {
					//header("Location: ../invoice-create.php?id=4");
					echo 'FAILED doc upload';
				}
			}
		}
	}

	if ($invoice_type == 'Invoice'){
		header("Location: ../invoice-list.php?id=30");
	} else if ($invoice_type == 'Quote'){
		header("Location: ../quote-view.php?id=30");
	}
$mysqli->close();
exit();
	
			


/// PDF & EMAIL INVOICE ///

} else if ($_GET['action'] == 'eio') {

session_start();
include_once('config.php');

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

// PDF GENERATE
// Include autoloader 
require('../includes/TCPDF/tcpdf.php');


	// Set Variables
	$invoice_type = $_POST['invoice_type']; 
	$invoice_status = "Sent"; 
	$invoice_reference = $_POST['invoice_reference']; 
	$invoice_date = (new DateTime($_POST['invoice_date']))->format('d/m/Y');
	$invoice_due_date = $_POST['invoice_due_date']; 
	$invoice_pre = $_POST['invoice_pre']; 
	$invoice_id = $_POST['invoice_id']; 
	$customer_name = $_POST['customer']; 
	$customer_email_1 = $_POST['customer_email_1']; 
	$customer_email_2 = $_POST['customer_email_2']; 
	$contact_name = $_POST['customer_name_2']; 
	$customer_address_1 = $_POST['customer_address_1']; 
	$customer_address_2 = $_POST['customer_address_2']; 
	$customer_town = $_POST['customer_town']; 
	$customer_county = $_POST['customer_county']; 
	$customer_postcode = $_POST['customer_postcode']; 
	$customer_phone = $_POST['customer_phone']; 
	$customer_ship_name = $_POST['customer_ship_name']; 
	$customer_ship_address_1 = $_POST['customer_ship_address_1']; 
	$customer_ship_address_2 = $_POST['customer_ship_address_2']; 
	$customer_ship_town = $_POST['customer_ship_town']; 
	$customer_ship_county = $_POST['customer_ship_county']; 
	$customer_ship_postcode = $_POST['customer_ship_postcode']; 
	$customer_ship_phone = $_POST['customer_ship_phone']; 
	if ($_POST['notes'] == ''){ $notes = ''; } else { $notes = 'Notes: <br>' . $_POST['notes']; }
	$total_subtotal = $_POST['total_subtotal']; 
	if ($_POST['total_line_tax'] == ''){ $total_line_tax = '0'; } else { $total_line_tax = $_POST['total_line_tax']; }
	if ($_POST['invoice_tax'] == ''){ $invoice_tax = '0'; } else { $invoice_tax = $_POST['invoice_tax']; }
	$subtotal_tax = $_POST['subtotal_tax']; 
	$total_balance_due = $_POST['total_balance_due']; 
	if ($invoice_type == 'Invoice'){ $due_exp = 'Due Date';} else if ($invoice_type == 'Quote'){ $due_exp = 'Valid Till';}


	// INSERT INTO INVOICE TABLE
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$stmt = $mysqli->prepare("INSERT INTO invoices (invoice_pre, invoice_no, invoice_reference, custom_email, custom_email_1, invoice_date, invoice_due_date, subtotal, line_taxes, 
	invoice_tax, invoice_tax_total, total, notes, invoice_type, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('sssssssssssssss', $invoice_pre, $invoice_id, $invoice_reference, $customer_email_1, $customer_email_2, $invoice_date, $invoice_due_date, $total_subtotal, 
		$total_line_tax, $invoice_tax, $subtotal_tax, $total_balance_due, $notes, $invoice_type, $invoice_status);
	if ($stmt->execute()) { $inv_id = $mysqli->insert_id;	} else {
		header("Location: ../invoice-create.php?id=4");
	}

	// INSERT INTO CUSTOMER TABLE
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$stmt = $mysqli->prepare("INSERT INTO customer (inv_id, invoice_pre, invoice_no, company, name, email_1, email_2, address_1, address_2, town, county, postcode, phone, name_ship, address_1_ship, address_2_ship,
	town_ship, county_ship, postcode_ship) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('sssssssssssssssssss', $inv_id, $invoice_pre, $invoice_id, $customer_name, $contact_name, $customer_email_1, $customer_email_2, $customer_address_1, $customer_address_2, $customer_town, 
		$customer_county, $customer_postcode, $customer_phone, $customer_ship_name, $customer_ship_address_1, $customer_ship_address_2, $customer_ship_town, $customer_ship_county,
		$customer_ship_postcode);
	if ($stmt->execute()) {	} else {
		header("Location: ../invoice-create.php?id=4");
	}


	// INSERT INTO INVOICE ITEMS TABLE
	$query = "INSERT INTO invoice_items (inv_id1, invoice_pre, invoice_no, product, product_desc, qty, unit_price, line_tax, line_tax_amt, line_subtotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$stmt = $mysqli->prepare($query);

	for ($i=0; $i<count($_POST['item']); $i++) {
		$item_name = $_POST['item'][$i];
		$item_unit_desc = $_POST['item_unit_description'][$i];
		$item_quantity = $_POST['item_quantity'][$i];
		$item_unit_cost = $_POST['item_unit_cost'][$i];
		$line_tax = $_POST['item_tax'][$i];
		$line_tax_amt = $_POST['line_tax_amt'][$i];
		$item_line_total = $_POST['item_line_total'][$i];
		$stmt->bind_param('ssssssssss', $inv_id, $invoice_pre, $invoice_id, $item_name, $item_unit_desc, $item_quantity, $item_unit_cost, $line_tax, $line_tax_amt, $item_line_total);
		$stmt->execute();
	}
	

	// CREATE PDF
	ini_set('memory_limit', '256M');
	class MYPDF extends TCPDF {
		public function Header() {
			$myBgColor = hex2rgb(INVOICE_THEME_HF);
			$this->Rect(0, 0, 2000, 43,'F',array(),$myBgColor,'');
			$this->setJPEGQuality(10);
			$this->Image('../'.COMPANY_LOGO . COMPANY_LOGO_NAME, 15, 10, COMPANY_LOGO_WIDTH, COMPANY_LOGO_HEIGHT, 'PNG', ''); // '../' . <-- May be needed at front.
			$this->SetTextColor(255,255,255);
			$this->CreateTextBox(COMPANY_NAME, 80, 5, 10, 10, 14, 'B');
			$this->CreateTextBox('Web: ' . COMPANY_WEBSITE, 80, 15, 10, 10, 8);
			$this->CreateTextBox('Phone: ' . COMPANY_CONTACT_1, 80, 20, 10, 10, 8);
			$this->CreateTextBox('E-mail: ' . COMPANY_EMAIL, 80, 25, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_1, 135, 10, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_2, 135, 15, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_3, 135, 20, 10, 10, 8);
			$this->CreateTextBox(COMPANY_POSTCODE, 135, 25, 10, 10, 8);

		}
		public function Footer() {
			$myBgColor = hex2rgb(INVOICE_THEME_HF);
			$this->Rect(0, 270, 2000, 27,'F',array(),$myBgColor,'');
			$this->setJPEGQuality(10);
			$this->Image('../'.COMPANY_FAVICON . COMPANY_FAVICON_NAME, 180, 273, 18, 0, 'PNG', ''); // '../' . <-- May be needed at front.
			$this->SetY(-15);
			$this->SetTextColor(255,255,255);
			$this->CreateTextBox('UTR: ' . COMPANY_UTR, 0, 273, 10, 10, 8);
			$this->CreateTextBox('VAT NO: ' . COMPANY_VAT, 0, 278, 10, 10, 8);
			$this->CreateTextBox('REG NO: ' . COMPANY_NUMBER, 0, 283, 10, 10, 8);
		}
		public function CreateTextBox($textval, $x = 0, $y, $width = 0, $height = 10, $fontsize = 10, $fontstyle = '', $align = 'L') {
			$this->SetXY($x+20, $y); // 20 = margin left
			$this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
			$this->Cell($width, $height, $textval, 0, false, $align);
		}
	}
	// create a PDF object
	$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

	// set document (meta) information
	$pdf->SetCreator(COMPANY_NAME);
	$pdf->SetAuthor(COMPANY_NAME);
	$pdf->SetTitle(COMPANY_NAME . ' Document');
	$pdf->SetSubject(COMPANY_NAME . ' Document');
	$pdf->SetKeywords(COMPANY_NAME . ' Document');

	// set document colours
	$theme = hex2rgb(INVOICE_THEME);
	$hex = INVOICE_THEME;
	list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");

	// add a page
	$pdf->AddPage();

	// invoice title / number
	$pdf->SetTextColor($r, $g, $b);
	$pdf->CreateTextBox('Your '.$invoice_type, 0, 55, 120, 20, 20, 'B');
	$pdf->SetTextColor(41,41,41);

	// create address box
	$pdf->CreateTextBox('TO:', 0, 75, 80, 10, 10);
	$pdf->CreateTextBox($customer_name, 0, 80, 80, 10, 10, 'B');
	$pdf->CreateTextBox($customer_address_1, 0, 85, 80, 10, 10);
	$pdf->CreateTextBox($customer_address_2, 0, 90, 80, 10, 10);
	$pdf->CreateTextBox($customer_town, 0, 95, 80, 10, 10);
	$pdf->CreateTextBox($customer_postcode, 0, 100, 80, 10, 10);
	//$pdf->CreateTextBox($customer_email_1, 0, 105, 80, 10, 10);
	//$pdf->CreateTextBox($customer_email_2, 0, 110, 80, 10, 10);

	// date, order ref
	$pdf->Rect(145, 79, 65, 32,'F',array(),$theme, 'R');
	$pdf->SetTextColor(255,255,255);
	$pdf->CreateTextBox('Order ID: ' . $invoice_pre . $invoice_id, 0, 80, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Date: ' . $invoice_date, 0, 85, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox($due_exp.': ' . $invoice_due_date, 0, 90, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Total: ' . CURRENCY . $total_balance_due, 0, 95, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Ref: ' . $invoice_reference, 0, 100, 0, 10, 10, '', 'R');
	// list headers
	$pdf->SetTextColor(41,41,41);
	$pdf->CreateTextBox('Quantity', 0, 120, 20, 10, 10, 'B', 'C');
	$pdf->CreateTextBox('Product or service', 20, 120, 90, 10, 10, 'B');
	$pdf->CreateTextBox('Price', 90, 120, 30, 10, 10, 'B', 'R');
	$pdf->CreateTextBox('Tax %', 110, 120, 30, 10, 10, 'B', 'R');
	$pdf->CreateTextBox('Amount', 140, 120, 30, 10, 10, 'B', 'R');

	$pdf->Line(20, 129, 195, 129);

	// Set Sales Line Variables
	$item_name = $_POST['item'];
	$item_unit_desc = $_POST['item_unit_description'];
	$item_quantity = $_POST['item_quantity'];
	$item_unit_cost = $_POST['item_unit_cost'];
	$line_tax = $_POST['item_tax'];
	$line_tax_amt = $_POST['line_tax_amt'];
	$item_line_total = $_POST['item_line_total'];
	$currY = 128;

	foreach($item_name as $key => $item_name) {
		$qty = $item_quantity[$key];
		$desc = $item_unit_desc[$key];
		$tax = $line_tax[$key];
		$cost = $item_unit_cost[$key];
		$total = $item_line_total[$key];

		$pdf->CreateTextBox($qty, 0, $currY, 20, 10, 10, '', 'C');
		$pdf->SetTextColor($r, $g, $b);
		$pdf->CreateTextBox($desc, 20, $currY, 90, 10, 10, 'B');
		$pdf->SetTextColor(41,41,41);
		$pdf->CreateTextBox(CURRENCY.' '.$cost, 90, $currY, 30, 10, 10, '', 'R');
		$pdf->CreateTextBox($tax, 110, $currY, 30, 10, 10, '', 'R');
		$pdf->CreateTextBox(CURRENCY.' '.$total, 140, $currY, 30, 10, 10, '', 'R');

		$currY = $currY+5;
	}

	$pdf->Line(20, $currY+4, 195, $currY+4);

	$pdf->CreateTextBox('Payment Term: ' . INVOICE_PAYMENT_TERM . ' Days.', 2, $currY+6, 20, 10, 10, '');
	$pdf->CreateTextBox('Bank: ' . PAYMENT_BANK, 2, $currY+11, 20, 10, 10, '');
	$pdf->CreateTextBox('Sort: ' . PAYMENT_SORT, 2, $currY+16, 20, 10, 10, '');
	$pdf->CreateTextBox('Acct: ' . PAYMENT_ACCTNO, 2, $currY+21, 20, 10, 10, '');
	$pdf->CreateTextBox('Full T&Cs on our website.', 2, $currY+26, 20, 10, 10, '');


	// output the sub-total row
	$pdf->CreateTextBox('Sub-Total', 15, $currY+6, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox(CURRENCY . $total_subtotal, 140, $currY+6, 30, 10, 10, 'B', 'R');
	// output the total line tax row
	$pdf->CreateTextBox('Line Taxes', 15, $currY+11, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox(CURRENCY . $total_line_tax, 140, $currY+11, 30, 10, 10, 'B', 'R');
	// output the total row
	$pdf->CreateTextBox('Tax', 15, $currY+16, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox($invoice_tax.'%', 140, $currY+16, 30, 10, 10, 'B', 'R');
	// output the total row
	$pdf->CreateTextBox('Tax Amt.', 15, $currY+21, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox(CURRENCY . $subtotal_tax, 140, $currY+21, 30, 10, 10, 'B', 'R');
	// output the total row
	$pdf->CreateTextBox('Total Due', 20, $currY+31, 150, 10, 14, 'B', 'R');
	$pdf->SetTextColor($r, $g, $b);
	$pdf->CreateTextBox(CURRENCY . $total_balance_due, 140, $currY+37, 30, 10, 14, 'B', 'R');
	$pdf->SetTextColor(41,41,41);

	// some payment instructions or information
	$pdf->setXY(20, $currY+60);
	$pdf->SetFont(PDF_FONT_NAME_MAIN, '', 10);
	$pdf->MultiCell(175, 10, $notes , 0, 'L', 0, 1, '', '', true, null, true);

	//Close and output PDF document
	$filename = $invoice_type.'-'.$invoice_pre.''.$invoice_id.".pdf"; 
	$upOne = dirname(__DIR__, 1);
	$folder = "/qtinvdcs/";
	$filelocation = $upOne . $folder;
	$fileNL = $filelocation.$filename;
	ob_clean();
	$pdf->Output($fileNL, 'F');
	// Insert into Invoice Docs Table
	$status = '0';
	$pass = uniqid();
	$insertquery = "INSERT INTO invoice_docs(invoice_pre, invoice_id, customer, email_1, email_2, folder, filename, status, pass) 
					VALUES('$invoice_pre','$invoice_id','$contact_name','$customer_email_1','$customer_email_2','$folder','$filename','$status','$pass')";
					$iquery = mysqli_query($mysqli, $insertquery);


	// SEND EMAIL WITH ATTACHMENTS
	// In-Email Body Variables //
	$email_vars = array(
		'COMPANY_WEBSITE' => getenv('IP'),
		'COMPANY_NAME' => COMPANY_NAME,
		'name' => $_POST['customer'],
		'HEADER' => "Please find your " . $invoice_type . " for " . $invoice_reference . " attached.",
		'MESSAGE' => "<br> Thankyou for your recent request. <br>" . $invoice_type . " for " . $invoice_reference . ".<br><br>
						View Documents online using your Email & Password: " . $pass . "",
		'FOLLOW_UP' => "<br><br>Total: " . $total_balance_due . ".<br>" . $due_exp . ": " . $invoice_due_date,
		'IMAGE' => "../" . COMPANY_LOGO . COMPANY_LOGO_NAME,
		'FOOTER' => "Regards, " . COMPANY_NAME,
	);

	// INSERT INTO BODY //
	$body = file_get_contents('../assets/email-templates/basicNotification.html');

	if(isset($email_vars)){
		foreach($email_vars as $k=>$v){
			$body = str_replace('{'.strtoupper($k).'}', $v, $body);
		}
	}

	if (array_key_exists('upload_document', $_FILES)) {
		$status = '1';
		//Create a message
		$mail = new PHPMailer();
		//Server settings
		$mail->SMTPDebug = 0;
		$mail->isSMTP();
		$mail->Host = SMTP_SERVER;
		$mail->SMTPAuth = true;
		$mail->Username = SMTP_USERNAME;
		$mail->Password = SMTP_PASSWORD;
		$mail->SMTPSecure = SMTP_USE_AUTH;
		$mail->Port = SMTP_PORT;

		//Recipients
		$mail->setFrom(EMAIL_FROM, COMPANY_NAME);
		$mail->addAddress($customer_email_1, $customer_name); 
		if ($customer_email_2 == '') { } else {
		$mail->addCC($customer_email_2, $customer_name);}
		$mail->addReplyTo(COMPANY_EMAIL, COMPANY_NAME);
		$mail->isHTML(true); // Set email format to HTML
		$mail->Subject = "New " . $invoice_type . " received from " . COMPANY_NAME; 
		$mail->Body    = $body;
		$mail->addAttachment($fileNL);
		//Attach multiple files one by one
		for ($ct = 0, $ctMax = count($_FILES['upload_document']['tmp_name']); $ct < $ctMax; $ct++) {
			//Extract an extension from the provided filename
			$ext = PHPMailer::mb_pathinfo($_FILES['upload_document']['name'][$ct], PATHINFO_EXTENSION);
			//Define a safe location to move the uploaded file to, preserving the extension
			$folder = "/qtinvdcs/inv_docs/";
			$uploadfile = '..' . $folder . $pass . '-' . $_FILES['upload_document']['name'][$ct];
			$filename = $_FILES['upload_document']['name'][$ct];
			if (move_uploaded_file($_FILES['upload_document']['tmp_name'][$ct], $uploadfile)) {
				//Insert to DB
				$insertquery = "INSERT INTO invoice_docs(invoice_pre, invoice_id, customer, email_1, email_2, folder, filename, status, pass) 
				VALUES('$invoice_pre','$invoice_id','$contact_name','$customer_email_1','$customer_email_2','$folder','$filename','$status','$pass')";
				$iquery = mysqli_query($mysqli, $insertquery);
				// Attach to email
				if (!$mail->addAttachment($uploadfile, $filename)) {
					$msg .= 'Failed to attach file ' . $filename;
					header("Location: ../invoice-list.php?id=27");
				}
			} else {
				$msg .= 'Failed to move file to ' . $uploadfile;
				header("Location: ../invoice-list.php?id=27");
			}
		}
		if (!$mail->send()) {
			$msg .= 'Mailer Error: ' . $mail->ErrorInfo;
			header("Location: ../invoice-list.php?id=27");
		} else {
			$msg .= 'Message sent!';
		}
	}


	// UPLOAD DOCUMENTS
	$status = '1';
	if (isset($_FILES['upload_document']['name']))
	{
		$files = array_filter($_FILES['upload_document']['name']); //Use something similar before processing files.
		// Count the number of uploaded files in array
		$total_count = count($_FILES['upload_document']['name']);
		// Loop through every file
		for ($i=0; $i<count($_FILES['upload_document']['name']); $i++) {
			$file_name = $_FILES['upload_document']['name'][$i];
		//for( $i=0 ; $i < $total_count ; $i++ ) {
		//The temp file path is obtained
		$tmpFilePath = $_FILES['upload_document']['tmp_name'][$i];
		//A file path needs to be present
			if ($tmpFilePath != ""){
				//Setup our new file path
				$folder = "/qtinvdcs/inv_docs/";
				$newFilePath = '..' . $folder . $pass . '-' . $_FILES['upload_document']['name'][$i];
				//File is uploaded to temp dir
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					//Other code goes here
					$insertquery = "INSERT INTO invoice_docs(invoice_pre, invoice_id, customer, email_1, email_2, folder, filename, status, pass) 
					VALUES('$invoice_pre','$invoice_id','$contact_name','$customer_email_1','$customer_email_2','$folder','$file_name','$status','$pass')";
					$iquery = mysqli_query($mysqli, $insertquery);
					echo 'Files: ' . $total_count . ' - Have been uploaded';
				} else {
					//header("Location: ../invoice-create.php?id=4");
					echo 'FAILED doc upload';
				}
			}
		}
	}

	if ($invoice_type == 'Invoice'){
		header("Location: ../invoice-list.php?id=30");
	} else if ($invoice_type == 'Quote'){
		header("Location: ../quote-view.php?id=30");
	}
	$mysqli->close();
	exit();










	/// SAVE INVOICE ONLY - FROM EDIT - UPDATE SQL ///
	
} else if ($_GET['action'] == 'editsio') {
	
	session_start();
	include_once('config.php');
	
	require '../phpmailer/src/Exception.php';
	require '../phpmailer/src/PHPMailer.php';
	require '../phpmailer/src/SMTP.php';

	// PDF GENERATE
	// Include autoloader 
	require('../includes/TCPDF/tcpdf.php');
	
	// Set Variables
	$rowID = $_POST['rowID']; 
	$custID = $_POST['custID']; 
	$convert = $_POST['convert']; 
	$invoice_type = $_POST['invoice_type']; 
	$invoice_status = $_POST['invoice_status']; 
	$invoice_reference = $_POST['invoice_reference']; 
	if ($_POST['invoice_date'] == "") {
	$invoice_date = (new DateTime($_POST['invoice_date_original']))->format('d/m/Y'); } else {
		$invoice_date = (new DateTime($_POST['invoice_date']))->format('d/m/Y');}
	$invoice_due_date = $_POST['invoice_due_date']; 
	$invoice_pre = $_POST['invoice_pre']; 
	$invoice_id = $_POST['invoice_id']; 
	$customer_name = $_POST['customer']; 
	$customer_email_1 = $_POST['customer_email_1']; 
	$customer_email_2 = $_POST['customer_email_2']; 
	$contact_name = $_POST['customer_name_2']; 
	$customer_address_1 = $_POST['customer_address_1']; 
	$customer_address_2 = $_POST['customer_address_2']; 
	$customer_town = $_POST['customer_town']; 
	$customer_county = $_POST['customer_county']; 
	$customer_postcode = $_POST['customer_postcode']; 
	$customer_phone = $_POST['customer_phone']; 
	$customer_ship_name = $_POST['customer_ship_name']; 
	$customer_ship_address_1 = $_POST['customer_ship_address_1']; 
	$customer_ship_address_2 = $_POST['customer_ship_address_2']; 
	$customer_ship_town = $_POST['customer_ship_town']; 
	$customer_ship_county = $_POST['customer_ship_county']; 
	$customer_ship_postcode = $_POST['customer_ship_postcode']; 
	$customer_ship_phone = $_POST['customer_ship_phone']; 
	$notes = $_POST['notes']; 
	$total_subtotal = $_POST['total_subtotal']; 
	if ($_POST['total_line_tax'] == ''){ $total_line_tax = '0'; } else { $total_line_tax = $_POST['total_line_tax']; }
	if ($_POST['invoice_tax'] == ''){ $invoice_tax = '0'; } else { $invoice_tax = $_POST['invoice_tax']; }
	$subtotal_tax = $_POST['subtotal_tax']; 
	$total_balance_due = $_POST['total_balance_due']; 


	if ($convert == 'cti'){
		// INSERT INTO INVOICE TABLE
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$stmt = $mysqli->prepare("INSERT INTO invoices (invoice_pre, invoice_no, invoice_reference, custom_email, custom_email_1, invoice_date, invoice_due_date, subtotal, line_taxes, 
		invoice_tax, invoice_tax_total, total, notes, invoice_type, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('sssssssssssssss', $invoice_pre, $invoice_id, $invoice_reference, $customer_email_1, $customer_email_2, $invoice_date, $invoice_due_date, $total_subtotal, 
			$total_line_tax, $invoice_tax, $subtotal_tax, $total_balance_due, $notes, $invoice_type, $invoice_status);
		if ($stmt->execute()) { $inv_id = $mysqli->insert_id;	} else {
			header("Location: ../invoice-create.php?id=4");
		}
		// UPDATE INVOICE TABLE Status of quote
		$cvt = 'Converted- '.$invoice_id.'';
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$stmt = $mysqli->prepare("UPDATE invoices SET status=? WHERE id=?");
		$stmt->bind_param('ss', $cvt, $custID);
		if ($stmt->execute()) {	} else {
			header("Location: ../invoice-edit.php?id=4");}

		// DELETE CURRENT THEN INSERT INTO INVOICE ITEMS TABLE
		$query="DELETE FROM invoice_items WHERE inv_id1=?";
		$stmt = $mysqli->prepare($query);
		$stmt->bind_param('s', $custID);
		if ($stmt->execute()) {	} else {
			header("Location: ../invoice-edit.php?id=4");}
		
		// INSERT INTO CUSTOMER TABLE
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$stmt = $mysqli->prepare("INSERT INTO customer (inv_id, invoice_pre, invoice_no, company, name, email_1, email_2, address_1, address_2, town, county, postcode, phone, name_ship, address_1_ship, address_2_ship,
		town_ship, county_ship, postcode_ship) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('sssssssssssssssssss', $inv_id, $invoice_pre, $invoice_id, $customer_name, $contact_name, $customer_email_1, $customer_email_2, $customer_address_1, $customer_address_2, $customer_town, 
			$customer_county, $customer_postcode, $customer_phone, $customer_ship_name, $customer_ship_address_1, $customer_ship_address_2, $customer_ship_town, $customer_ship_county,
			$customer_ship_postcode);
		if ($stmt->execute()) {	} else {
			header("Location: ../invoice-create.php?id=4");
		}
	} else {
		// UPDATE INVOICE TABLE
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$stmt = $mysqli->prepare("UPDATE invoices SET invoice_pre=?, invoice_no=?, invoice_reference=?, custom_email=?, custom_email_1=?, invoice_date=?, invoice_due_date=?, 
		subtotal=?, line_taxes=?, invoice_tax=?, invoice_tax_total=?, total=?, notes=?, invoice_type=?, status=? WHERE id=?");
		$stmt->bind_param('ssssssssssssssss', $invoice_pre, $invoice_id, $invoice_reference, $customer_email_1, $customer_email_2, $invoice_date, $invoice_due_date, $total_subtotal, 
		$total_line_tax, $invoice_tax, $subtotal_tax, $total_balance_due, $notes, $invoice_type, $invoice_status, $custID);
		if ($stmt->execute()) {	} else {
			header("Location: ../invoice-edit.php?id=4");}

		// UPDATE CUSTOMER TABLE
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$stmt = $mysqli->prepare("UPDATE customer SET invoice_pre=?, invoice_no=?, email_1=?, email_2=?, name_ship=?, address_1_ship=?, address_2_ship=?, 
		town_ship=?, county_ship=?, postcode_ship=? WHERE inv_id=?");
		$stmt->bind_param('sssssssssss', $invoice_pre, $invoice_id, $customer_email_1, $customer_email_2, $customer_ship_name, $customer_ship_address_1, $customer_ship_address_2, 
		$customer_ship_town, $customer_ship_county, $customer_ship_postcode, $custID);
		if ($stmt->execute()) {	} else {
			header("Location: ../invoice-edit.php?id=4");}
	}


	// DELETE CURRENT THEN INSERT INTO INVOICE ITEMS TABLE
	$query="DELETE FROM invoice_items WHERE inv_id1=?";
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('s', $custID);
	if ($stmt->execute()) {	} else {
		header("Location: ../invoice-edit.php?id=4");}

	// INSERT INTO INVOICE ITEMS TABLE// INSERT INTO INVOICE ITEMS TABLE
	if ($convert == 'cti'){
		$inv_id1 = $inv_id;
	} else {
		$inv_id1 = $custID;
	}
	$query = "INSERT INTO invoice_items (inv_id1, invoice_pre, invoice_no, product, product_desc, qty, unit_price, line_tax, line_tax_amt, line_subtotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$stmt = $mysqli->prepare($query);

	for ($i=0; $i<count($_POST['item']); $i++) {
		$item_name = $_POST['item'][$i];
		$item_unit_desc = $_POST['item_unit_description'][$i];
		$item_quantity = $_POST['item_quantity'][$i];
		$item_unit_cost = $_POST['item_unit_cost'][$i];
		$line_tax = $_POST['item_tax'][$i];
		$line_tax_amt = $_POST['line_tax_amt'][$i];
		$item_line_total = $_POST['item_line_total'][$i];
		$stmt->bind_param('ssssssssss', $inv_id1, $invoice_pre, $invoice_id, $item_name, $item_unit_desc, $item_quantity, $item_unit_cost, $line_tax, $line_tax_amt, $item_line_total);
		$stmt->execute();
	}
	

	// CREATE PDF
	ini_set('memory_limit', '256M');
	class MYPDF extends TCPDF {
		public function Header() {
			$myBgColor = hex2rgb(INVOICE_THEME_HF);
			$this->Rect(0, 0, 2000, 43,'F',array(),$myBgColor,'');
			$this->setJPEGQuality(10);
			$this->Image('../'.COMPANY_LOGO . COMPANY_LOGO_NAME, 15, 10, COMPANY_LOGO_WIDTH, COMPANY_LOGO_HEIGHT, 'PNG', ''); // '../' . <-- May be needed at front.
			$this->SetTextColor(255,255,255);
			$this->CreateTextBox(COMPANY_NAME, 80, 5, 10, 10, 14, 'B');
			$this->CreateTextBox('Web: ' . COMPANY_WEBSITE, 80, 15, 10, 10, 8);
			$this->CreateTextBox('Phone: ' . COMPANY_CONTACT_1, 80, 20, 10, 10, 8);
			$this->CreateTextBox('E-mail: ' . COMPANY_EMAIL, 80, 25, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_1, 135, 10, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_2, 135, 15, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_3, 135, 20, 10, 10, 8);
			$this->CreateTextBox(COMPANY_POSTCODE, 135, 25, 10, 10, 8);

		}
		public function Footer() {
			$myBgColor = hex2rgb(INVOICE_THEME_HF);
			$this->Rect(0, 270, 2000, 27,'F',array(),$myBgColor,'');
			$this->setJPEGQuality(10);
			$this->Image('../'.COMPANY_FAVICON . COMPANY_FAVICON_NAME, 180, 273, 18, 0, 'PNG', ''); // '../' . <-- May be needed at front.
			$this->SetY(-15);
			$this->SetTextColor(255,255,255);
			$this->CreateTextBox('UTR: ' . COMPANY_UTR, 0, 273, 10, 10, 8);
			$this->CreateTextBox('VAT NO: ' . COMPANY_VAT, 0, 278, 10, 10, 8);
			$this->CreateTextBox('REG NO: ' . COMPANY_NUMBER, 0, 283, 10, 10, 8);
		}
		public function CreateTextBox($textval, $x = 0, $y, $width = 0, $height = 10, $fontsize = 10, $fontstyle = '', $align = 'L') {
			$this->SetXY($x+20, $y); // 20 = margin left
			$this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
			$this->Cell($width, $height, $textval, 0, false, $align);
		}
	}
	// create a PDF object
	$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

	// set document (meta) information
	$pdf->SetCreator(COMPANY_NAME);
	$pdf->SetAuthor(COMPANY_NAME);
	$pdf->SetTitle(COMPANY_NAME . ' Document');
	$pdf->SetSubject(COMPANY_NAME . ' Document');
	$pdf->SetKeywords(COMPANY_NAME . ' Document');

	// set document colours
	$theme = hex2rgb(INVOICE_THEME);
	$hex = INVOICE_THEME;
	list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");

	// add a page
	$pdf->AddPage();

	// invoice title / number
	$pdf->SetTextColor($r, $g, $b);
	$pdf->CreateTextBox('Your '.$invoice_type, 0, 55, 120, 20, 20, 'B');
	$pdf->SetTextColor(41,41,41);

	// create address box
	$pdf->CreateTextBox('TO:', 0, 75, 80, 10, 10);
	$pdf->CreateTextBox($customer_name, 0, 80, 80, 10, 10, 'B');
	$pdf->CreateTextBox($customer_address_1, 0, 85, 80, 10, 10);
	$pdf->CreateTextBox($customer_address_2, 0, 90, 80, 10, 10);
	$pdf->CreateTextBox($customer_town, 0, 95, 80, 10, 10);
	$pdf->CreateTextBox($customer_postcode, 0, 100, 80, 10, 10);
	//$pdf->CreateTextBox($customer_email_1, 0, 105, 80, 10, 10);
	//$pdf->CreateTextBox($customer_email_2, 0, 110, 80, 10, 10);

	// date, order ref
	$pdf->Rect(145, 79, 65, 32,'F',array(),$theme, 'R');
	$pdf->SetTextColor(255,255,255);
	$pdf->CreateTextBox('Order ID: ' . $invoice_pre . $invoice_id, 0, 80, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Date: ' . $invoice_date, 0, 85, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox($due_exp.': ' . $invoice_due_date, 0, 90, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Total: ' . CURRENCY . $total_balance_due, 0, 95, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Ref: ' . $invoice_reference, 0, 100, 0, 10, 10, '', 'R');
	// list headers
	$pdf->SetTextColor(41,41,41);
	$pdf->CreateTextBox('Quantity', 0, 120, 20, 10, 10, 'B', 'C');
	$pdf->CreateTextBox('Product or service', 20, 120, 90, 10, 10, 'B');
	$pdf->CreateTextBox('Price', 90, 120, 30, 10, 10, 'B', 'R');
	$pdf->CreateTextBox('Tax %', 110, 120, 30, 10, 10, 'B', 'R');
	$pdf->CreateTextBox('Amount', 140, 120, 30, 10, 10, 'B', 'R');

	$pdf->Line(20, 129, 195, 129);

	// Set Sales Line Variables
	$item_name = $_POST['item'];
	$item_unit_desc = $_POST['item_unit_description'];
	$item_quantity = $_POST['item_quantity'];
	$item_unit_cost = $_POST['item_unit_cost'];
	$line_tax = $_POST['item_tax'];
	$line_tax_amt = $_POST['line_tax_amt'];
	$item_line_total = $_POST['item_line_total'];
	$currY = 128;

	foreach($item_name as $key => $item_name) {
		$qty = $item_quantity[$key];
		$desc = $item_unit_desc[$key];
		$tax = $line_tax[$key];
		$cost = $item_unit_cost[$key];
		$total = $item_line_total[$key];

		$pdf->CreateTextBox($qty, 0, $currY, 20, 10, 10, '', 'C');
		$pdf->SetTextColor($r, $g, $b);
		$pdf->CreateTextBox($desc, 20, $currY, 90, 10, 10, 'B');
		$pdf->SetTextColor(41,41,41);
		$pdf->CreateTextBox(CURRENCY.' '.$cost, 90, $currY, 30, 10, 10, '', 'R');
		$pdf->CreateTextBox($tax, 110, $currY, 30, 10, 10, '', 'R');
		$pdf->CreateTextBox(CURRENCY.' '.$total, 140, $currY, 30, 10, 10, '', 'R');

		$currY = $currY+5;
	}

	$pdf->Line(20, $currY+4, 195, $currY+4);

	$pdf->CreateTextBox('Payment Term: ' . INVOICE_PAYMENT_TERM . ' Days.', 2, $currY+6, 20, 10, 10, '');
	$pdf->CreateTextBox('Bank: ' . PAYMENT_BANK, 2, $currY+11, 20, 10, 10, '');
	$pdf->CreateTextBox('Sort: ' . PAYMENT_SORT, 2, $currY+16, 20, 10, 10, '');
	$pdf->CreateTextBox('Acct: ' . PAYMENT_ACCTNO, 2, $currY+21, 20, 10, 10, '');
	$pdf->CreateTextBox('Full T&Cs on our website.', 2, $currY+26, 20, 10, 10, '');


	// output the sub-total row
	$pdf->CreateTextBox('Sub-Total', 15, $currY+6, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox(CURRENCY . $total_subtotal, 140, $currY+6, 30, 10, 10, 'B', 'R');
	// output the total line tax row
	$pdf->CreateTextBox('Line Taxes', 15, $currY+11, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox(CURRENCY . $total_line_tax, 140, $currY+11, 30, 10, 10, 'B', 'R');
	// output the total row
	$pdf->CreateTextBox('Tax', 15, $currY+16, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox($invoice_tax.'%', 140, $currY+16, 30, 10, 10, 'B', 'R');
	// output the total row
	$pdf->CreateTextBox('Tax Amt.', 15, $currY+21, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox(CURRENCY . $subtotal_tax, 140, $currY+21, 30, 10, 10, 'B', 'R');
	// output the total row
	$pdf->CreateTextBox('Total Due', 20, $currY+31, 150, 10, 14, 'B', 'R');
	$pdf->SetTextColor($r, $g, $b);
	$pdf->CreateTextBox(CURRENCY . $total_balance_due, 140, $currY+37, 30, 10, 14, 'B', 'R');
	$pdf->SetTextColor(41,41,41);

	// some payment instructions or information
	$pdf->setXY(20, $currY+60);
	$pdf->SetFont(PDF_FONT_NAME_MAIN, '', 10);
	$pdf->MultiCell(175, 10, $notes , 0, 'L', 0, 1, '', '', true, null, true);

	//Close and output PDF document
	$filename = $invoice_type.'-'.$invoice_pre.''.$invoice_id.".pdf"; 
	$upOne = dirname(__DIR__, 1);
	$folder = "/qtinvdcs/";
	$filelocation = $upOne . $folder;
	$fileNL = $filelocation.$filename;
	ob_clean();
	$pdf->Output($fileNL, 'F');
	// Insert into Invoice Docs Table
	$status = '0';
	$pass = uniqid();
	$stmt = $mysqli->prepare("UPDATE invoice_docs SET customer=?, email_1=?, email_2=?, folder=?, filename=?, status=?, pass=? WHERE invoice_pre=? AND invoice_id=?");
	$stmt->bind_param('sssssssss', $contact_name , $customer_email_1 , $customer_email_2 , $folder , $filename , $status , $pass, $invoice_pre , $invoice_id);
	$stmt->execute();


	// UPLOAD DOCUMENTS
	$status = '1';
	if (isset($_FILES['upload_document']['name']))
	{
		$files = array_filter($_FILES['upload_document']['name']); //Use something similar before processing files.
		// Count the number of uploaded files in array
		$total_count = count($_FILES['upload_document']['name']);
		// Loop through every file
		for ($i=0; $i<count($_FILES['upload_document']['name']); $i++) {
			$file_name = $_FILES['upload_document']['name'][$i];
		//for( $i=0 ; $i < $total_count ; $i++ ) {
		//The temp file path is obtained
		$tmpFilePath = $_FILES['upload_document']['tmp_name'][$i];
		//A file path needs to be present
			if ($tmpFilePath != ""){
				//Setup our new file path
				$folder = "/qtinvdcs/inv_docs/";
				$newFilePath = '..' . $folder . $pass . '-' . $_FILES['upload_document']['name'][$i];
				//File is uploaded to temp dir
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					//Other code goes here
					$insertquery = "INSERT INTO invoice_docs(invoice_pre, invoice_id, customer, email_1, email_2, folder, filename, status, pass) 
					VALUES('$invoice_pre','$invoice_id','$contact_name','$customer_email_1','$customer_email_2','$folder','$file_name','$status','$pass')";
					$iquery = mysqli_query($mysqli, $insertquery);
					echo 'Files: ' . $total_count . ' - Have been uploaded';
				} else {
					//header("Location: ../invoice-create.php?id=4");
					echo 'FAILED doc upload';
				}
			}
		}
	}

	if ($invoice_type == 'Invoice'){
		header("Location: ../invoice-list.php?id=30");
	} else if ($invoice_type == 'Quote'){
		header("Location: ../quote-view.php?id=30");
	}
$mysqli->close();
exit();
	
			


/// PDF & EMAIL INVOICE - FROM EDIT INVOICE - UPDATE SQL AND EMAIL ///

} else if ($_GET['action'] == 'editeio') {

session_start();
include_once('config.php');

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

// PDF GENERATE
// Include autoloader 
require('../includes/TCPDF/tcpdf.php');


	// Set Variables
	$rowID = $_POST['rowID']; 
	$custID = $_POST['custID']; 
	$convert = $_POST['convert']; 
	$qtpre = $_POST['qtpre']; 
	$qtno = $_POST['qtno']; 
	$invoice_type = $_POST['invoice_type']; 
	$invoice_status = "Sent"; 
	$invoice_reference = $_POST['invoice_reference']; 
	if ($_POST['invoice_date'] == "") {
	$invoice_date = (new DateTime($_POST['invoice_date_original']))->format('d/m/Y'); } else {
		$invoice_date = (new DateTime($_POST['invoice_date']))->format('d/m/Y');}
	$invoice_due_date = $_POST['invoice_due_date']; 
	$invoice_pre = $_POST['invoice_pre']; 
	$invoice_id = $_POST['invoice_id']; 
	$customer_name = $_POST['customer']; 
	$customer_email_1 = $_POST['customer_email_1']; 
	$customer_email_2 = $_POST['customer_email_2']; 
	$contact_name = $_POST['customer_name_2']; 
	$customer_address_1 = $_POST['customer_address_1']; 
	$customer_address_2 = $_POST['customer_address_2']; 
	$customer_town = $_POST['customer_town']; 
	$customer_county = $_POST['customer_county']; 
	$customer_postcode = $_POST['customer_postcode']; 
	$customer_phone = $_POST['customer_phone']; 
	$customer_ship_name = $_POST['customer_ship_name']; 
	$customer_ship_address_1 = $_POST['customer_ship_address_1']; 
	$customer_ship_address_2 = $_POST['customer_ship_address_2']; 
	$customer_ship_town = $_POST['customer_ship_town']; 
	$customer_ship_county = $_POST['customer_ship_county']; 
	$customer_ship_postcode = $_POST['customer_ship_postcode']; 
	$customer_ship_phone = $_POST['customer_ship_phone']; 
	$notes = $_POST['notes']; 
	$total_subtotal = $_POST['total_subtotal']; 
	if ($_POST['total_line_tax'] == ''){ $total_line_tax = '0'; } else { $total_line_tax = $_POST['total_line_tax']; }
	if ($_POST['invoice_tax'] == ''){ $invoice_tax = '0'; } else { $invoice_tax = $_POST['invoice_tax']; }
	$subtotal_tax = $_POST['subtotal_tax']; 
	$total_balance_due = $_POST['total_balance_due']; 
	if ($invoice_type == 'Invoice'){ $due_exp = 'Due Date';} else if ($invoice_type == 'Quote'){ $due_exp = 'Valid Till';}


	if ($convert == 'cti'){
		// INSERT INTO INVOICE TABLE
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$stmt = $mysqli->prepare("INSERT INTO invoices (invoice_pre, invoice_no, invoice_reference, custom_email, custom_email_1, invoice_date, invoice_due_date, subtotal, line_taxes, 
		invoice_tax, invoice_tax_total, total, notes, invoice_type, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('sssssssssssssss', $invoice_pre, $invoice_id, $invoice_reference, $customer_email_1, $customer_email_2, $invoice_date, $invoice_due_date, $total_subtotal, 
			$total_line_tax, $invoice_tax, $subtotal_tax, $total_balance_due, $notes, $invoice_type, $invoice_status);
		if ($stmt->execute()) { $inv_id = $mysqli->insert_id;	} else {
			header("Location: ../invoice-create.php?id=4");
		}
		// UPDATE INVOICE TABLE Status of quote
		$cvt = 'Converted';
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$stmt = $mysqli->prepare("UPDATE invoices SET status=? WHERE id=?");
		$stmt->bind_param('ss', $cvt, $custID);
		if ($stmt->execute()) {	} else {
			header("Location: ../invoice-edit.php?id=4");}

		// DELETE CURRENT THEN INSERT INTO INVOICE ITEMS TABLE
		$query="DELETE FROM invoice_items WHERE inv_id1=?";
		$stmt = $mysqli->prepare($query);
		$stmt->bind_param('i', $custID);
		$stmt->execute();
		
		// INSERT INTO CUSTOMER TABLE
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$stmt = $mysqli->prepare("INSERT INTO customer (inv_id, invoice_pre, invoice_no, company, name, email_1, email_2, address_1, address_2, town, county, postcode, phone, name_ship, address_1_ship, address_2_ship,
		town_ship, county_ship, postcode_ship) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('sssssssssssssssssss', $inv_id, $invoice_pre, $invoice_id, $customer_name, $contact_name, $customer_email_1, $customer_email_2, $customer_address_1, $customer_address_2, $customer_town, 
			$customer_county, $customer_postcode, $customer_phone, $customer_ship_name, $customer_ship_address_1, $customer_ship_address_2, $customer_ship_town, $customer_ship_county,
			$customer_ship_postcode);
		if ($stmt->execute()) {	} else {
			header("Location: ../invoice-create.php?id=4");
		}
	} else {
		// UPDATE INVOICE TABLE
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$stmt = $mysqli->prepare("UPDATE invoices SET invoice_pre=?, invoice_no=?, invoice_reference=?, custom_email=?, custom_email_1=?, invoice_date=?, invoice_due_date=?, 
		subtotal=?, line_taxes=?, invoice_tax=?, invoice_tax_total=?, total=?, notes=?, invoice_type=?, status=? WHERE id=?");
		$stmt->bind_param('ssssssssssssssss', $invoice_pre, $invoice_id, $invoice_reference, $customer_email_1, $customer_email_2, $invoice_date, $invoice_due_date, $total_subtotal, 
		$total_line_tax, $invoice_tax, $subtotal_tax, $total_balance_due, $notes, $invoice_type, $invoice_status, $custID);
		if ($stmt->execute()) {	} else {
			header("Location: ../invoice-edit.php?id=4");}

		// UPDATE CUSTOMER TABLE
		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$stmt = $mysqli->prepare("UPDATE customer SET invoice_pre=?, invoice_no=?, email_1=?, email_2=?, name_ship=?, address_1_ship=?, address_2_ship=?, 
		town_ship=?, county_ship=?, postcode_ship=? WHERE inv_id=?");
		$stmt->bind_param('sssssssssss', $invoice_pre, $invoice_id, $customer_email_1, $customer_email_2, $customer_ship_name, $customer_ship_address_1, $customer_ship_address_2, 
		$customer_ship_town, $customer_ship_county, $customer_ship_postcode, $custID);
		if ($stmt->execute()) {	} else {
			header("Location: ../invoice-edit.php?id=4");}
	}


	// DELETE CURRENT THEN INSERT INTO INVOICE ITEMS TABLE
	$query="DELETE FROM invoice_items WHERE inv_id1=?";
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('i', $custID);
	$stmt->execute();

	// INSERT INTO INVOICE ITEMS TABLE
	if ($convert == 'cti'){
		$inv_id1 = $inv_id;
	} else {
		$inv_id1 = $custID;
	}
	$query = "INSERT INTO invoice_items (inv_id1, invoice_pre, invoice_no, product, product_desc, qty, unit_price, line_tax, line_tax_amt, line_subtotal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$stmt = $mysqli->prepare($query);

	for ($i=0; $i<count($_POST['item']); $i++) {
		$item_name = $_POST['item'][$i];
		$item_unit_desc = $_POST['item_unit_description'][$i];
		$item_quantity = $_POST['item_quantity'][$i];
		$item_unit_cost = $_POST['item_unit_cost'][$i];
		$line_tax = $_POST['item_tax'][$i];
		$line_tax_amt = $_POST['line_tax_amt'][$i];
		$item_line_total = $_POST['item_line_total'][$i];
		$stmt->bind_param('ssssssssss', $inv_id1, $invoice_pre, $invoice_id, $item_name, $item_unit_desc, $item_quantity, $item_unit_cost, $line_tax, $line_tax_amt, $item_line_total);
		$stmt->execute();
	}
	

	// CREATE PDF
	ini_set('memory_limit', '256M');
	class MYPDF extends TCPDF {
		public function Header() {
			$myBgColor = hex2rgb(INVOICE_THEME_HF);
			$this->Rect(0, 0, 2000, 43,'F',array(),$myBgColor,'');
			$this->setJPEGQuality(5);
			$this->Image('../'.COMPANY_LOGO . COMPANY_LOGO_NAME, 15, 10, COMPANY_LOGO_WIDTH, COMPANY_LOGO_HEIGHT, 'PNG', ''); // '../' . <-- May be needed at front.
			$this->SetTextColor(255,255,255);
			$this->CreateTextBox(COMPANY_NAME, 80, 5, 10, 10, 14, 'B');
			$this->CreateTextBox('Web: ' . COMPANY_WEBSITE, 80, 15, 10, 10, 8);
			$this->CreateTextBox('Phone: ' . COMPANY_CONTACT_1, 80, 20, 10, 10, 8);
			$this->CreateTextBox('E-mail: ' . COMPANY_EMAIL, 80, 25, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_1, 135, 10, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_2, 135, 15, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_3, 135, 20, 10, 10, 8);
			$this->CreateTextBox(COMPANY_POSTCODE, 135, 25, 10, 10, 8);

		}
		public function Footer() {
			$myBgColor = hex2rgb(INVOICE_THEME_HF);
			$this->Rect(0, 270, 2000, 27,'F',array(),$myBgColor,'');
			$this->setJPEGQuality(5);
			$this->Image('../'.COMPANY_FAVICON . COMPANY_FAVICON_NAME, 180, 273, 18, 0, 'PNG', ''); // '../' . <-- May be needed at front.
			$this->SetY(-15);
			$this->SetTextColor(255,255,255);
			$this->CreateTextBox('UTR: ' . COMPANY_UTR, 0, 273, 10, 10, 8);
			$this->CreateTextBox('VAT NO: ' . COMPANY_VAT, 0, 278, 10, 10, 8);
			$this->CreateTextBox('REG NO: ' . COMPANY_NUMBER, 0, 283, 10, 10, 8);
		}
		public function CreateTextBox($textval, $x = 0, $y, $width = 0, $height = 10, $fontsize = 10, $fontstyle = '', $align = 'L') {
			$this->SetXY($x+20, $y); // 20 = margin left
			$this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
			$this->Cell($width, $height, $textval, 0, false, $align);
		}
	}
	// create a PDF object
	$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

	// set document (meta) information
	$pdf->SetCreator(COMPANY_NAME);
	$pdf->SetAuthor(COMPANY_NAME);
	$pdf->SetTitle(COMPANY_NAME . ' Document');
	$pdf->SetSubject(COMPANY_NAME . ' Document');
	$pdf->SetKeywords(COMPANY_NAME . ' Document');

	// set document colours
	$theme = hex2rgb(INVOICE_THEME);
	$hex = INVOICE_THEME;
	list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");

	// add a page
	$pdf->AddPage();

	// invoice title / number
	$pdf->SetTextColor($r, $g, $b);
	$pdf->CreateTextBox('Your '.$invoice_type, 0, 55, 120, 20, 20, 'B');
	$pdf->SetTextColor(41,41,41);

	// create address box
	$pdf->CreateTextBox('TO:', 0, 75, 80, 10, 10);
	$pdf->CreateTextBox($customer_name, 0, 80, 80, 10, 10, 'B');
	$pdf->CreateTextBox($customer_address_1, 0, 85, 80, 10, 10);
	$pdf->CreateTextBox($customer_address_2, 0, 90, 80, 10, 10);
	$pdf->CreateTextBox($customer_town, 0, 95, 80, 10, 10);
	$pdf->CreateTextBox($customer_postcode, 0, 100, 80, 10, 10);
	//$pdf->CreateTextBox($customer_email_1, 0, 105, 80, 10, 10);
	//$pdf->CreateTextBox($customer_email_2, 0, 110, 80, 10, 10);

	// date, order ref
	$pdf->Rect(145, 79, 65, 32,'F',array(),$theme, 'R');
	$pdf->SetTextColor(255,255,255);
	$pdf->CreateTextBox('Order ID: ' . $invoice_pre . $invoice_id, 0, 80, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Date: ' . $invoice_date, 0, 85, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox($due_exp.': ' . $invoice_due_date, 0, 90, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Total: ' . CURRENCY . $total_balance_due, 0, 95, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Ref: ' . $invoice_reference, 0, 100, 0, 10, 10, '', 'R');
	// list headers
	$pdf->SetTextColor(41,41,41);
	$pdf->CreateTextBox('Quantity', 0, 120, 20, 10, 10, 'B', 'C');
	$pdf->CreateTextBox('Product or service', 20, 120, 90, 10, 10, 'B');
	$pdf->CreateTextBox('Price', 90, 120, 30, 10, 10, 'B', 'R');
	$pdf->CreateTextBox('Tax %', 110, 120, 30, 10, 10, 'B', 'R');
	$pdf->CreateTextBox('Amount', 140, 120, 30, 10, 10, 'B', 'R');

	$pdf->Line(20, 129, 195, 129);

	// Set Sales Line Variables
	$item_name = $_POST['item'];
	$item_unit_desc = $_POST['item_unit_description'];
	$item_quantity = $_POST['item_quantity'];
	$item_unit_cost = $_POST['item_unit_cost'];
	$line_tax = $_POST['item_tax'];
	$line_tax_amt = $_POST['line_tax_amt'];
	$item_line_total = $_POST['item_line_total'];
	$currY = 128;

	foreach($item_name as $key => $item_name) {
		$qty = $item_quantity[$key];
		$desc = $item_unit_desc[$key];
		$tax = $line_tax[$key];
		$cost = $item_unit_cost[$key];
		$total = $item_line_total[$key];

		$pdf->CreateTextBox($qty, 0, $currY, 20, 10, 10, '', 'C');
		$pdf->SetTextColor($r, $g, $b);
		$pdf->CreateTextBox($desc, 20, $currY, 90, 10, 10, 'B');
		$pdf->SetTextColor(41,41,41);
		$pdf->CreateTextBox(CURRENCY.' '.$cost, 90, $currY, 30, 10, 10, '', 'R');
		$pdf->CreateTextBox($tax, 110, $currY, 30, 10, 10, '', 'R');
		$pdf->CreateTextBox(CURRENCY.' '.$total, 140, $currY, 30, 10, 10, '', 'R');

		$currY = $currY+5;
	}

	$pdf->Line(20, $currY+4, 195, $currY+4);

	$pdf->CreateTextBox('Payment Term: ' . INVOICE_PAYMENT_TERM . ' Days.', 2, $currY+6, 20, 10, 10, '');
	$pdf->CreateTextBox('Bank: ' . PAYMENT_BANK, 2, $currY+11, 20, 10, 10, '');
	$pdf->CreateTextBox('Sort: ' . PAYMENT_SORT, 2, $currY+16, 20, 10, 10, '');
	$pdf->CreateTextBox('Acct: ' . PAYMENT_ACCTNO, 2, $currY+21, 20, 10, 10, '');
	$pdf->CreateTextBox('Full T&Cs on our website.', 2, $currY+26, 20, 10, 10, '');


	// output the sub-total row
	$pdf->CreateTextBox('Sub-Total', 15, $currY+6, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox(CURRENCY . $total_subtotal, 140, $currY+6, 30, 10, 10, 'B', 'R');
	// output the total line tax row
	$pdf->CreateTextBox('Line Taxes', 15, $currY+11, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox(CURRENCY . $total_line_tax, 140, $currY+11, 30, 10, 10, 'B', 'R');
	// output the total row
	$pdf->CreateTextBox('Tax', 15, $currY+16, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox($invoice_tax.'%', 140, $currY+16, 30, 10, 10, 'B', 'R');
	// output the total row
	$pdf->CreateTextBox('Tax Amt.', 15, $currY+21, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox(CURRENCY . $subtotal_tax, 140, $currY+21, 30, 10, 10, 'B', 'R');
	// output the total row
	$pdf->CreateTextBox('Total Due', 20, $currY+31, 150, 10, 14, 'B', 'R');
	$pdf->SetTextColor($r, $g, $b);
	$pdf->CreateTextBox(CURRENCY . $total_balance_due, 140, $currY+37, 30, 10, 14, 'B', 'R');
	$pdf->SetTextColor(41,41,41);

	// some payment instructions or information
	$pdf->setXY(20, $currY+60);
	$pdf->SetFont(PDF_FONT_NAME_MAIN, '', 10);
	$pdf->MultiCell(175, 10, $notes , 0, 'L', 0, 1, '', '', true, null, true);

	//Close and output PDF document
	$filename = $invoice_type.'-'.$invoice_pre.''.$invoice_id.".pdf"; 
	$upOne = dirname(__DIR__, 1);
	$folder = "/qtinvdcs/";
	$filelocation = $upOne . $folder;
	$fileNL = $filelocation.$filename;
	ob_clean();
	$pdf->Output($fileNL, 'F');
	// Insert into Invoice Docs Table
	$status = '0';
	$pass = uniqid();
	if ($convert == 'cti'){
		$insertquery = "INSERT INTO invoice_docs(invoice_pre, invoice_id, customer, email_1, email_2, folder, filename, status, pass) 
		VALUES('$invoice_pre','$invoice_id','$contact_name','$customer_email_1','$customer_email_2','$folder','$filename','$status','$pass')";
		$iquery = mysqli_query($mysqli, $insertquery);
	} else {
	$stmt = $mysqli->prepare("UPDATE invoice_docs SET customer=?, email_1=?, email_2=?, folder=?, filename=?, pass=? WHERE invoice_pre=? AND invoice_id=? AND status=?");
	$stmt->bind_param('sssssssss', $contact_name , $customer_email_1 , $customer_email_2 , $folder , $filename , $pass, $invoice_pre , $invoice_id , $status);
	$stmt->execute();}


	// SEND EMAIL WITH ATTACHMENTS
	// In-Email Body Variables //
	$status = '0';
	if ($convert == 'cti'){
		$stmt = $mysqli->prepare("SELECT pass FROM invoice_docs WHERE invoice_pre='$invoice_pre' AND invoice_id='$invoice_id' AND status= '$status' LIMIT 1");
	} else {
		$stmt = $mysqli->prepare("SELECT pass FROM invoice_docs WHERE invoice_pre='$qtpre' AND invoice_id='$qtno' AND status= '$status' LIMIT 1");
	}
	$stmt->execute();
	$stmt->bind_result($docpass);
	$stmt->store_result();
	$stmt->fetch();
	echo 'MailPass = '. $docpass;
	$email_vars = array(
		'COMPANY_WEBSITE' => getenv('IP'),
		'COMPANY_NAME' => COMPANY_NAME,
		'name' => $_POST['customer'],
		'HEADER' => "Please find your " . $invoice_type . " for " . $invoice_reference . " attached.",
		'MESSAGE' => "<br> Thankyou for your recent request. <br>" . $invoice_type . " for " . $invoice_reference . ".<br><br>
						View Documents online using your Email & Password: " . $docpass . "",
		'FOLLOW_UP' => "<br><br>Total: " . $total_balance_due . ".<br>" . $due_exp . ": " . $invoice_due_date,
		'IMAGE' => "../" . COMPANY_LOGO . COMPANY_LOGO_NAME,
		'FOOTER' => "Regards, " . COMPANY_NAME,
	);

	// INSERT INTO BODY //
	$body = file_get_contents('../assets/email-templates/basicNotification.html');

	if(isset($email_vars)){
		foreach($email_vars as $k=>$v){
			$body = str_replace('{'.strtoupper($k).'}', $v, $body);
		}
	}

	if (array_key_exists('upload_document', $_FILES)) {
		//Create a message
		$mail = new PHPMailer();
		//Server settings
		$mail->SMTPDebug = 0;
		$mail->isSMTP();
		$mail->Host = SMTP_SERVER;
		$mail->SMTPAuth = true;
		$mail->Username = SMTP_USERNAME;
		$mail->Password = SMTP_PASSWORD;
		$mail->SMTPSecure = SMTP_USE_AUTH;
		$mail->Port = SMTP_PORT;

		//Recipients
		$mail->setFrom(EMAIL_FROM, COMPANY_NAME);
		$mail->addAddress($customer_email_1, $customer_name); 
		if ($customer_email_2 == '') { } else {
		$mail->addCC($customer_email_2, $customer_name);}
		$mail->addReplyTo(COMPANY_EMAIL, COMPANY_NAME);
		$mail->isHTML(true); // Set email format to HTML
		$mail->Subject = "New " . $invoice_type . " received from " . COMPANY_NAME; 
		$mail->Body    = $body;
		$mail->addAttachment($fileNL);

		//Attach multiple files one by one - FROM OLD FILES ALREADY UPLOADED
		$selquery = "SELECT * FROM invoice_docs
        WHERE invoice_pre = '" . $mysqli->real_escape_string($qtpre) . "' 
		AND invoice_id = '" . $mysqli->real_escape_string($qtno) . "'
		AND status = '1'";
        $attachResults = $mysqli->query($selquery);
        if($attachResults) {
			while($AttRow = $attachResults->fetch_assoc()) {
				$uploadedfile = dirname() . $AttRow['folder'] . $AttRow['pass'] . '-' . $AttRow['filename'];
				$fileName = $AttRow['filename'];
				$mail->addStringAttachment($uploadedfile, $fileName);
				echo $uploadedfile . '<br>';
				$attPass = $AttRow['pass'];
				// Update invoice_docs from quote to invoice
				$stmt = $mysqli->prepare("UPDATE invoice_docs SET invoice_pre=?, invoice_id=? WHERE filename=?");
				$stmt->bind_param('sss', $invoice_pre , $invoice_id , $fileName);
				$stmt->execute();
			}
        }
		//Attach multiple files one by one - FROM NEW FILE UPLOAD
		$status = '1';
		$pass= uniqid();
		if (isset($_FILES['upload_document']['name'])){
			for ($ct = 0, $ctMax = count($_FILES['upload_document']['tmp_name']); $ct < $ctMax; $ct++) {
				//Extract an extension from the provided filename
				$ext = PHPMailer::mb_pathinfo($_FILES['upload_document']['name'][$ct], PATHINFO_EXTENSION);
				//Define a safe location to move the uploaded file to, preserving the extension
				$folder = "/qtinvdcs/inv_docs/";
				$uploadfile = '..' . $folder . $pass . '-' . $_FILES['upload_document']['name'][$ct];
				$filename = $_FILES['upload_document']['name'][$ct];
				if (move_uploaded_file($_FILES['upload_document']['tmp_name'][$ct], $uploadfile)) {
					//Insert to DB
					$insertquery = "INSERT INTO invoice_docs(invoice_pre, invoice_id, customer, email_1, email_2, folder, filename, status, pass) 
					VALUES('$invoice_pre','$invoice_id','$contact_name','$customer_email_1','$customer_email_2','$folder','$filename','$status','$pass')";
					$iquery = mysqli_query($mysqli, $insertquery);
					// Attach to email
					if (!$mail->addAttachment($uploadfile, $filename)) {
						$msg .= 'Failed to attach file ' . $filename;
						header("Location: ../invoice-list.php?id=27");
					}
				} else {
					$msg .= 'Upload failed - ' . $uploadfile;
					header("Location: ../invoice-list.php?id=27");
				}
			}
		}
		if (!$mail->send()) {
			$msg .= 'Mailer Error: ' . $mail->ErrorInfo;
			header("Location: ../invoice-list.php?id=27");
		} else {
			$msg .= 'Message sent!';
		}
	}


	// UPLOAD DOCUMENTS
	$status = '1';
	if (isset($_FILES['upload_document']['name'])){
		$files = array_filter($_FILES['upload_document']['name']); //Use something similar before processing files.
		// Count the number of uploaded files in array
		$total_count = count($_FILES['upload_document']['name']);
		// Loop through every file
		for ($i=0; $i<count($_FILES['upload_document']['name']); $i++) {
			$file_name = $_FILES['upload_document']['name'][$i];
		//for( $i=0 ; $i < $total_count ; $i++ ) {
		//The temp file path is obtained
		$tmpFilePath = $_FILES['upload_document']['tmp_name'][$i];
		//A file path needs to be present
			if ($tmpFilePath != ""){
				//Setup our new file path
				$folder = "/qtinvdcs/inv_docs/";
				$newFilePath = '..' . $folder . $pass . '-' . $_FILES['upload_document']['name'][$i];
				//File is uploaded to temp dir
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					//Other code goes here
					$insertquery = "INSERT INTO invoice_docs(invoice_pre, invoice_id, customer, email_1, email_2, folder, filename, status, pass) 
					VALUES('$invoice_pre','$invoice_id','$contact_name','$customer_email_1','$customer_email_2','$folder','$file_name','$status','$pass')";
					$iquery = mysqli_query($mysqli, $insertquery);
					echo 'Files: ' . $total_count . ' - Have been uploaded';
				} else {
					header("Location: ../invoice-create.php?id=4");
					echo 'FAILED doc upload';
				}
			}
		}
	}

	if ($invoice_type == 'Invoice'){
		header("Location: ../invoice-list.php?id=30");
	} else if ($invoice_type == 'Quote'){
		header("Location: ../quote-view.php?id=30");
	}
	$mysqli->close();
	exit();

	
/// DELETE INVOICE & QUOTE FROM DATABASE ONLY ///
	
} else if ($_GET['action'] == 'deliq') {
	
	session_start();
	include_once('config.php');
	$invoice_pre = $_GET['pre'];
	$invoice_id = $_GET['no'];
	$p = $_GET['p'];
	if($p == '1'){
		$page = 'invoice-list';
	} else 
	if($p == '2'){
		$page = 'quote-view';
	}
	$key = $_GET['iq'];
	$pw = $_GET['en'];
	$pass = (openssl_decrypt ($pw, $cipher, $key, $options, $encryption_iv));
	echo $pass;

	// DELETE Invoice Or Quote
	if($pass=='DeleteIt'){
		$query="DELETE FROM invoices WHERE invoice_pre=? AND invoice_no=?";
		$stmt = $mysqli->prepare($query);
		$stmt->bind_param('ss', $invoice_pre, $invoice_id);
			if ($stmt->execute()) {
			$query="DELETE FROM invoice_items WHERE invoice_pre=? AND invoice_no=?";
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param('ss', $invoice_pre, $invoice_id);
				if ($stmt->execute()) {
				$query="DELETE FROM customer WHERE invoice_pre=? AND invoice_no=?";
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param('ss', $invoice_pre, $invoice_id);
					if ($stmt->execute()) {
					$query="DELETE FROM invoice_docs WHERE invoice_pre=? AND invoice_id=?";
					$stmt = $mysqli->prepare($query);
					$stmt->bind_param('ss', $invoice_pre, $invoice_id);
						if ($stmt->execute()) {
							header("Location: ../".$page.".php?id=31");
						} else {
							echo 'invoice docs issue';
							//header("Location: ../".$page.".php?id=4");
						}
					} else {
						echo 'customer issue';
						//header("Location: ../".$page.".php?id=4");
					}
				} else {
					echo 'invoice items issue';
					//header("Location: ../".$page.".php?id=4");
				}
			} else {
				echo 'invoices issue';
				//header("Location: ../".$page.".php?id=4");
			}
	} else {
		echo 'incorrect pass';
		echo $pass;
		//header("Location: ../".$page.".php?id=4");
	}
	$mysqli->close();
	exit();

	
/// EMAIL INVOICE & QUOTE from qoute or invoice list pages ///
	
} else if ($_GET['action'] == 'sendinqt') {
	
	session_start();
	include_once('config.php');

	require '../phpmailer/src/Exception.php';
	require '../phpmailer/src/PHPMailer.php';
	require '../phpmailer/src/SMTP.php';

	//Set Variables
	$invoice_pre = $_GET['pre'];
	$invoice_id = $_GET['no'];
	$customer_email_1 = $_GET['e1'];
	$customer_email_2 = $_GET['e2'];
	$total_balance_due = $_GET['bal'];
	$invoice_due_date = $_GET['dd'];
	$invoice_reference = $_GET['ir'];
	$company = $_GET['co'];

	$p = $_GET['p'];
	if($p == '1'){
		$page = 'invoice-list';
		$type = 'Invoice';
	} else 
	if($p == '2'){
		$page = 'quote-view';
		$type = 'Quote';
	}

	//Set Variables - Invoice Status to sent
	$invoice_status = 'Sent';

	// UPDATE INVOICE TABLE
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$stmt = $mysqli->prepare("UPDATE invoices SET status=? WHERE invoice_pre=? AND invoice_no=?");
	$stmt->bind_param('sss', $invoice_status, $invoice_pre, $invoice_id);
	if ($stmt->execute()) {	
		header("Location: ../invoice-list.php?id=32");
	} else {
		header("Location: ../invoice-list.php?id=4");
	}

// SEND EMAIL WITH ATTACHMENTS
	// In-Email Body Variables //
	$email_vars = array(
		'COMPANY_WEBSITE' => getenv('IP'),
		'COMPANY_NAME' => COMPANY_NAME,
		'name' => $company,
		'HEADER' => "Please find your " . $type . " for " . $invoice_reference . " attached.",
		'MESSAGE' => "<br> Thankyou for your recent request. <br>" . $type . " for " . $invoice_reference . ".",
		'FOLLOW_UP' => "<br><br>Total: " . $total_balance_due . ".<br>Exp: " . $invoice_due_date,
		'IMAGE' => "../" . COMPANY_LOGO . COMPANY_LOGO_NAME,
		'FOOTER' => "Regards, " . COMPANY_NAME,
	);

	// INSERT INTO BODY //
	$body = file_get_contents('../assets/email-templates/basicNotification.html');

	if(isset($email_vars)){
		foreach($email_vars as $k=>$v){
			$body = str_replace('{'.strtoupper($k).'}', $v, $body);
		}
	}
	$fileNL = '../qtinvdcs/'.$type.'-'.$invoice_pre.$invoice_id.'.pdf';

	//Create a message
	$mail = new PHPMailer();
	//Server settings
	$mail->SMTPDebug = 0;
	$mail->isSMTP();
	$mail->Host = SMTP_SERVER;
	$mail->SMTPAuth = true;
	$mail->Username = SMTP_USERNAME;
	$mail->Password = SMTP_PASSWORD;
	$mail->SMTPSecure = SMTP_USE_AUTH;
	$mail->Port = SMTP_PORT;

	//Recipients
	$mail->setFrom(EMAIL_FROM, COMPANY_NAME);
	$mail->addAddress($customer_email_1, $company); 
	if ($customer_email_2 == '') { } else {
	$mail->addCC($customer_email_2, $company);}
	$mail->addReplyTo(COMPANY_EMAIL, COMPANY_NAME);
	$mail->isHTML(true); // Set email format to HTML
	$mail->Subject = "New " . $type . " received from " . COMPANY_NAME; 
	$mail->Body    = $body;
	$mail->addAttachment($fileNL);
	//Attach multiple files one by one - FROM OLD FILES ALREADY UPLOADED
	$selquery = "SELECT * FROM invoice_docs
	WHERE invoice_pre = '" . $mysqli->real_escape_string($invoice_pre) . "' 
	AND invoice_id = '" . $mysqli->real_escape_string($invoice_id) . "'
	AND status = '1'";
	$attachResults = $mysqli->query($selquery);
	if($attachResults) {
		while($AttRow = $attachResults->fetch_assoc()) {
			$uploadedfile = dirname() . $AttRow['folder'] . $AttRow['pass'] . '-' . $AttRow['filename'];
			$fileName = $AttRow['filename'];
			$mail->addStringAttachment($uploadedfile, $fileName);
			echo $uploadedfile . '<br>';
			$attPass = $AttRow['pass'];
			// Update invoice_docs from quote to invoice
			$stmt = $mysqli->prepare("UPDATE invoice_docs SET invoice_pre=?, invoice_id=? WHERE filename=?");
			$stmt->bind_param('sss', $invoice_pre , $invoice_id , $fileName);
			$stmt->execute();
		}
	}
	if (!$mail->send()) {
		$msg .= 'Mailer Error: ' . $mail->ErrorInfo;
		header("Location: ../".$page.".php?id=4");
	} else {
		$msg .= 'Message sent!';
		header("Location: ../".$page.".php?id=17");
	}

	$mysqli->close();
	exit();

	
/// MARK INVOICE AS PAID ///
} else if ($_GET['action'] == 'paid') {
	
	session_start();
	include_once('config.php');

	//Set Variables
	$invoice_pre = $_GET['pre'];
	$invoice_id = $_GET['no'];
	$invoice_status = 'Paid';

	// UPDATE INVOICE TABLE
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$stmt = $mysqli->prepare("UPDATE invoices SET status=? WHERE invoice_pre=? AND invoice_no=?");
	$stmt->bind_param('sss', $invoice_status, $invoice_pre, $invoice_id);
	if ($stmt->execute()) {	
		header("Location: ../invoice-list.php?id=32");
	} else {
		header("Location: ../invoice-list.php?id=4");
	}
	$mysqli->close();
	exit();

	
/// MARK INVOICE AS OPEN ///
} else if ($_GET['action'] == 'open') {
	
	session_start();
	include_once('config.php');

	//Set Variables
	$invoice_pre = $_GET['pre'];
	$invoice_id = $_GET['no'];
	$invoice_status = 'Open';

	// UPDATE INVOICE TABLE
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$stmt = $mysqli->prepare("UPDATE invoices SET status=? WHERE invoice_pre=? AND invoice_no=?");
	$stmt->bind_param('sss', $invoice_status, $invoice_pre, $invoice_id);
	if ($stmt->execute()) {	
		header("Location: ../invoice-list.php?id=33");
	} else {
		header("Location: ../invoice-list.php?id=4");
	}
	$mysqli->close();
	exit();

	
/// Receipt For INVOICE & QUOTE ///
	
} else if ($_GET['action'] == 'paidinqt') {
	
	session_start();
	include_once('config.php');

	require '../phpmailer/src/Exception.php';
	require '../phpmailer/src/PHPMailer.php';
	require '../phpmailer/src/SMTP.php';

	//Set Variables
	$invoice_pre = $_GET['pre'];
	$invoice_id = $_GET['no'];
	$customer_email_1 = $_GET['e1'];
	$customer_email_2 = $_GET['e2'];
	$total_balance_due = $_GET['bal'];
	$invoice_due_date = $_GET['dd'];
	$invoice_reference = $_GET['ir'];
	$company = $_GET['co'];

	$p = $_GET['p'];
	if($p == '1'){
		$page = 'invoice-list';
		$type = 'Invoice';
	} else 
	if($p == '2'){
		$page = 'quote-view';
		$type = 'Quote';
	}

// SEND EMAIL WITH ATTACHMENTS
	// In-Email Body Variables //
	$email_vars = array(
		'COMPANY_WEBSITE' => getenv('IP'),
		'COMPANY_NAME' => COMPANY_NAME,
		'name' => $company,
		'HEADER' => "Thankyou for your recent payment.",
		'MESSAGE' => "<br> Your " . $type . " for " . $invoice_reference . " has been marked as paid.",
		'FOLLOW_UP' => "<br><br>Total: " . $total_balance_due . ".<br>Balance Due: 0.00",
		'IMAGE' => "../" . COMPANY_LOGO . COMPANY_LOGO_NAME,
		'FOOTER' => "Regards, " . COMPANY_NAME,
	);

	// INSERT INTO BODY //
	$body = file_get_contents('../assets/email-templates/basicNotification.html');

	if(isset($email_vars)){
		foreach($email_vars as $k=>$v){
			$body = str_replace('{'.strtoupper($k).'}', $v, $body);
		}
	}

	echo $invoice_pre . ' - ' .$invoice_id . ' - ' .$customer_email_1 . ' - ' .$customer_email_2 . ' - ' .
		$total_balance_due . ' - ' .$invoice_reference . ' - ' .$company . ' - ' .$p . ' - ' ;
	//$fileNL = '../qtinvdcs/'.$type.'-'.$invoice_pre.$invoice_id.'.pdf';

	//Create a message
	$mail = new PHPMailer();
	//Server settings
	$mail->SMTPDebug = 0;
	$mail->isSMTP();
	$mail->Host = SMTP_SERVER;
	$mail->SMTPAuth = true;
	$mail->Username = SMTP_USERNAME;
	$mail->Password = SMTP_PASSWORD;
	$mail->SMTPSecure = SMTP_USE_AUTH;
	$mail->Port = SMTP_PORT;

	//Recipients
	$mail->setFrom(EMAIL_FROM, COMPANY_NAME);
	$mail->addAddress($customer_email_1, $company); 
	if ($customer_email_2 == '') { } else {
	$mail->addCC($customer_email_2, $company);}
	$mail->addReplyTo(COMPANY_EMAIL, COMPANY_NAME);
	$mail->isHTML(true); // Set email format to HTML
	$mail->Subject = "Receipt for payment of " . $type; 
	$mail->Body    = $body;
	//$mail->addAttachment($fileNL);
	if (!$mail->send()) {
		echo 'Mailer Error: ' . $mail->ErrorInfo;
		header("Location: ../".$page.".php?id=4");
	} else {
		echo 'Message sent!';
		header("Location: ../".$page.".php?id=17");
	}
	$mysqli->close();
	exit();

	
/// DARK & LIGHT MODE UPDATE USER PREFERENCE ///
	
} else if ($_GET['action'] == 'darkMode') {
	
	session_start();
	$page = $_GET['p'];
	$stmt = $mysqli->prepare("UPDATE users SET dark_mode=? WHERE id = ?");
	$dark = '1';
	$stmt->bind_param('ii', $dark, $_SESSION['id']);
	$stmt->execute();
	$stmt->close();
	header("Location: ../".$page."?id=34");
	
} else if ($_GET['action'] == 'lightMode') {
	
	session_start();
	$page = $_GET['p'];
	$stmt = $mysqli->prepare("UPDATE users SET dark_mode=? WHERE id = ?");
	$dark = '0';
	$stmt->bind_param('ii', $dark, $_SESSION['id']);
	$stmt->execute();
	$stmt->close();
	header("Location: ../".$page."?id=34");


/////////// END OF FORM SUBMITS ///////////////////////
}
///////////////////////////////////////////////////////


/// Generate Random String for Security

function generateRandomString($length = 40) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

// ASSIGN VALUE IF NULL
function assignIfNotEmpty(&$item, $default)
{
    return (!empty($item)) ? $item : $default;
}

// CONVERT HEX TO RGB FOR INVOICE
function hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);
 
	if(strlen($hex) == 3) {
	   $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	   $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	   $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
	   $r = hexdec(substr($hex,0,2));
	   $g = hexdec(substr($hex,2,2));
	   $b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
	//return implode(",", $rgb); // returns the rgb values separated by commas
	return $rgb; // returns an array with the rgb values
 }

/////////////////////////////////////////

?>