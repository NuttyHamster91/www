<?
ini_set('memory_limit', '256M');
	class MYPDF extends TCPDF {
		public function Header() {
			$myBgColor = hex2rgb(INVOICE_THEME_HF);
			$this->Rect(0, 0, 2000, 43,'F',array(),$myBgColor,'');
			$this->setJPEGQuality(10);
			$this->Image('../' . COMPANY_LOGO . COMPANY_LOGO_NAME, 15, 10, COMPANY_LOGO_WIDTH, COMPANY_LOGO_HEIGHT, 'PNG', '');
			$this->SetTextColor(255,255,255);
			$this->CreateTextBox(COMPANY_NAME, 80, 10, 10, 10, 14, 'B');
			$this->CreateTextBox('Web: ' . COMPANY_EMAIL, 80, 20, 10, 10, 8);
			$this->CreateTextBox('Phone: ' . COMPANY_CONTACT_1, 80, 25, 10, 10, 8);
			$this->CreateTextBox('E-mail: ' . COMPANY_EMAIL, 80, 30, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_1, 135, 15, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_2, 135, 20, 10, 10, 8);
			$this->CreateTextBox(COMPANY_ADDRESS_3, 135, 25, 10, 10, 8);
			$this->CreateTextBox(COMPANY_POSTCODE, 135, 30, 10, 10, 8);

		}
		public function Footer() {
			$myBgColor = hex2rgb(INVOICE_THEME_HF);
			$this->Rect(0, 270, 2000, 27,'F',array(),$myBgColor,'');
			$this->setJPEGQuality(10);
			$this->Image('../' . COMPANY_FAVICON . COMPANY_FAVICON_NAME, 180, 273, 18, 0, 'PNG', '');
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

	// add a page
	$pdf->AddPage();

	$theme = hex2rgb(INVOICE_THEME);
	// invoice title / number
	$pdf->SetTextColor($theme);
	$pdf->CreateTextBox('Your '.$invoice_type, 0, 55, 120, 20, 20);
	$pdf->SetTextColor(0,0,0);

	// create address box
	$pdf->CreateTextBox('TO:', 0, 75, 80, 10, 10);
	$pdf->CreateTextBox($customer_name, 0, 80, 80, 10, 10, 'B');
	$pdf->CreateTextBox($customer_address_1, 0, 85, 80, 10, 10);
	$pdf->CreateTextBox($customer_address_2, 0, 90, 80, 10, 10);
	$pdf->CreateTextBox($customer_town . ', ' . $customer_postcode, 0, 95, 80, 10, 10);
	$pdf->CreateTextBox($customer_email_1, 0, 100, 80, 10, 10);
	$pdf->CreateTextBox($customer_email_2, 0, 105, 80, 10, 10);

	// date, order ref
	$pdf->Rect(145, 79, 65, 32,'F',array(),$theme, 'R');
	$pdf->SetTextColor(255,255,255);
	$pdf->CreateTextBox('Order ID: ' . $invoice_pre . $invoice_id, 0, 80, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Date: ' . $invoice_date, 0, 85, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Due Date: ' . $invoice_due_date, 0, 90, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Balance Due: ' . CURRENCY . $total_balance_due, 0, 95, 0, 10, 10, '', 'R');
	$pdf->CreateTextBox('Ref: ' . $invoice_reference, 0, 100, 0, 10, 10, '', 'R');
	// list headers
	$pdf->SetTextColor(0,0,0);
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

		$pdf->SetTextColor($theme);
		$pdf->CreateTextBox($qty, 0, $currY, 20, 10, 10, '', 'C');
		$pdf->SetTextColor(0,0,0);
		$pdf->CreateTextBox($desc, 20, $currY, 90, 10, 10, '');
		$pdf->CreateTextBox(CURRENCY.' '.$cost, 90, $currY, 30, 10, 10, '', 'R');
		$pdf->CreateTextBox($tax, 110, $currY, 30, 10, 10, '', 'R');
		$pdf->CreateTextBox(CURRENCY.' '.$total, 140, $currY, 30, 10, 10, '', 'R');

		$currY = $currY+5;
	}

	$pdf->Line(20, $currY+4, 195, $currY+4);
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
	$pdf->SetTextColor($theme);
	$pdf->CreateTextBox(CURRENCY . $total_balance_due, 140, $currY+37, 30, 10, 14, 'B', 'R');
	$pdf->SetTextColor(0,0,0);

	// some payment instructions or information
	$pdf->setXY(20, $currY+50);
	$pdf->SetFont(PDF_FONT_NAME_MAIN, '', 10);
	$pdf->MultiCell(175, 10, $notes , 0, 'L', 0, 1, '', '', true, null, true);
	
	$pdf->CreateTextBox('Payment Details. ', 0, 240, 30, 10, 10, 'L');
	$pdf->CreateTextBox('Payment Term: ' . INVOICE_PAYMENT_TERM, 0, 245, 30, 10, 10, 'L');
	$pdf->CreateTextBox('Bank: ' . PAYMENT_BANK, 0, 250, 30, 10, 10, 'L');
	$pdf->CreateTextBox('Sort: ' . PAYMENT_SORT, 0, 255, 30, 10, 10, 'L');
	$pdf->CreateTextBox('Acct: ' . PAYMENT_ACCTNO, 0, 260, 30, 10, 10, 'L');

	//Close and output PDF document
	//$pdf->Output($invoice_type.'_'.$invoice_pre.'_'.$invoice_id, 'I');
	$filename= $invoice_type.'-'.$invoice_pre.''.$invoice_id.".pdf"; 
	$filelocation = $_SERVER['DOCUMENT_ROOT'] ."qtinvdcs/";

	$fileNL = $filelocation.$filename;
	ob_clean();
	$pdf->Output($fileNL, 'F');