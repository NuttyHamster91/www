<?

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
include_once("includes/functions.php");
verifyAdmin();
include_once("includes/header.php");

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$theme = hex2rgb(INVOICE_THEME);
$theme1 = $theme;
var_dump($theme1);
// PDF GENERATE
// Include autoloader 
require('includes/TCPDF/tcpdf.php');

	// Set Variables
	$invoice_type = 'Invoice'; 
	$invoice_status = 'Open'; 
	$invoice_reference = 'Works Order Reference'; 
	$invoice_date = '1/1/1111';
	$invoice_due_date = '2/2/2222'; 
	$invoice_pre = 'INV-'; 
	$invoice_id = '1001'; 
	$customer_name = 'Customer / Business Name'; 
	$customer_email_1 = 'customer@email1.co.uk'; 
	$customer_email_2 = 'customer@email2.co.uk'; 
	$contact_name = 'Contact Name'; 
	$customer_address_1 = 'Address Line 1'; 
	$customer_address_2 = 'Address Line 2'; 
	$customer_town = 'CustomerTown'; 
	$customer_county = 'CustomerCounty'; 
	$customer_postcode = 'PO57CD'; 
	$customer_phone = '01234123456'; 
	$customer_ship_name = 'Customer Ship Name'; 
	$customer_ship_address_1 = 'Ship Address Line 1'; 
	$customer_ship_address_2 = 'Ship Address Line 2'; 
	$customer_ship_town = 'Ship Town'; 
	$customer_ship_county = 'Ship County'; 
	$customer_ship_postcode = 'Ship Postcode'; 
	$customer_ship_phone = '01234123456'; 
	//if ($_POST['notes'] == ''){ $notes = ''; } else { $notes = 'Notes: <br>' . $_POST['notes']; }
	$notes = 'Your Notes Will Appear Here - These are public notes that will be sent on the invoice / quote if more detail is required than just a reference etc.';
	$total_subtotal = '1000.00'; 
	//if ($_POST['total_line_tax'] == ''){ $total_line_tax = '0'; } else { $total_line_tax = $_POST['total_line_tax']; }
	$total_line_tax = '0';
	//if ($_POST['invoice_tax'] == ''){ $invoice_tax = '0'; } else { $invoice_tax = $_POST['invoice_tax']; }
	$invoice_tax = '20';
	$subtotal_tax = '200.00'; 
	$total_balance_due = '1200.00'; 

	// Set Sales Line Variables
	$item_name = ['Labour Charge','Materials'];
	$item_unit_desc = ['Labour Charge','Materials'];
	$item_quantity = ['1','1'];
	$item_unit_cost = ['500','500'];
	$line_tax = ['0','0'];
	$line_tax_amt = ['0','0'];
	$item_line_total = ['500','500'];

	


	// CREATE PDF
	ini_set('memory_limit', '256M');
	class MYPDF extends TCPDF {
		public function Header() {
			$myBgColor = hex2rgb(INVOICE_THEME_HF);
			$this->Rect(0, 0, 2000, 43,'F',array(),$myBgColor,'');
			$this->setJPEGQuality(5);
			$this->Image(COMPANY_LOGO . COMPANY_LOGO_NAME, 15, 10, COMPANY_LOGO_WIDTH, COMPANY_LOGO_HEIGHT, 'PNG', ''); // '../' . <-- May be needed at front.
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
			$this->Image(COMPANY_FAVICON . COMPANY_FAVICON_NAME, 180, 273, 18, 0, 'PNG', ''); // '../' . <-- May be needed at front.
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
	$pdf->CreateTextBox('Due Date: ' . $invoice_due_date, 0, 90, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Balance Due: ' . CURRENCY . $total_balance_due, 0, 95, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Ref: ' . $invoice_reference, 0, 100, 0, 10, 10, '', 'R');
	// list headers
	$pdf->SetTextColor(41,41,41);
	$pdf->CreateTextBox('Quantity', 0, 120, 20, 10, 10, 'B', 'C');
	$pdf->CreateTextBox('Product or service', 20, 120, 90, 10, 10, 'B');
	$pdf->CreateTextBox('Price', 90, 120, 30, 10, 10, 'B', 'R');
	$pdf->CreateTextBox('Tax %', 110, 120, 30, 10, 10, 'B', 'R');
	$pdf->CreateTextBox('Amount', 140, 120, 30, 10, 10, 'B', 'R');

	$pdf->Line(20, 129, 195, 129);
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
	$pdf->CreateTextBox($invoice_type.' Tax', 15, $currY+16, 135, 10, 10, 'B', 'R');
	$pdf->CreateTextBox($invoice_tax.'%', 140, $currY+16, 30, 10, 10, 'B', 'R');
	// output the total row
	$pdf->CreateTextBox($invoice_type.' Tax Amt.', 15, $currY+21, 135, 10, 10, 'B', 'R');
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
	ob_end_clean();
	$pdf->Output($invoice_type.'_'.$invoice_pre.'_'.$invoice_id, 'I');
?>