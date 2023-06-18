<?php
/*
 * Produced: Fri Jan 07 2022
 * Author: Alec M.
 * GitHub: https://amattu.com/links/github
 * Copyright: (C) 2022 Alec M.
 * License: License GNU Affero General Public License v3.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// Namespace
namespace amattu\PDF;

// Import FPDF
use FPDF;

/**
 * A class to create basic PDF invoices
 *
 * @author Alec M.
 */
class Invoice extends FPDF {
  /**
   * Class Constructor
   */
  public function __construct()
  {
    parent::__construct();
    $this->AliasNbPages();
    $this->SetTopMargin(20);
    $this->Body();
  }

  /**
   * Class Header
   *
   * @return void
   */
  public function Header() : void
  {
    $this->SetFillColor(59, 59, 59);
    $this->rect(0, 0, $this->GetPageWidth(), 40, "F");
    $this->SetFillColor(244, 244, 244);
    $this->rect(0, 40, $this->GetPageWidth(), 11, "F");
    $this->SetFont('Helvetica', '', 17);
    $this->SetTextColor(255, 255, 255);
    $this->Text(25, 15, "Company");
    $this->SetFontSize(36);
    $this->Text(25, 27, "INVOICE");
    $this->SetTextColor(244, 244, 244);
    $this->SetFontSize(11);
    $this->SetXY(97, 11);
    $this->Cell(35, 6, "www.example.com", 0, 2, "R");
    $this->Cell(35, 6, "email@example.com", 0, 2, "R");
    $this->Cell(35, 6, "Tel: Phone", 0, 2, "R");
    $this->SetXY(160, 11);
    $this->Cell(35, 6, "Street Address", 0, 2, "R");
    $this->Cell(35, 6, "City State, Zip", 0, 2, "R");
    $this->Cell(35, 6, "Country", 0, 2, "R");
    $this->SetXY(114, 43.2);
    $this->SetFillColor(59, 59, 59);
    $this->SetTextColor(158, 158, 158);
    $this->SetFontSize(9);
    $this->Cell(21, 5, "Account No:", 0, 0);
    $this->SetTextColor(255, 255, 255);
    $this->RoundedRect($this->GetX(), 43, 17, 5, 1, "F");
    $this->SetFontSize(11);
    $this->Cell(17, 5, "#1", 0, 0, "L");
    $this->SetX($this->GetX() + 2);
    $this->SetTextColor(158, 158, 158);
    $this->SetFontSize(9);
    $this->Cell(21, 5, "Invoice Date:", 0, 0);
    $this->SetTextColor(255, 255, 255);
    $this->RoundedRect($this->GetX(), 43, 17, 5, 1, "F");
    $this->SetFontSize(11);
    $this->Cell(17, 5, "Jan-2022", 0, 0, "C");
  }

  /**
   * Write the PDF body content
   *
   * @return void
   */
  public function Body() : void
  {
    $this->AddPage("P", "Letter");
    $this->SetXY(25, 55);
    $this->SetFont("Helvetica", "", 13);
    $this->SetTextColor(84, 84, 84);
    $this->SetFillColor(255, 255, 255);
    $this->Cell((($this->GetPageWidth() - 50) / 2), 5, "Billing Details", 0, 2, "L");
    $this->SetLineWidth(0.5);
    $this->Line(25, $this->GetY() + 1, $this->GetPageWidth() - 25, $this->GetY() + 1);
    $this->SetXY(25, 65);
    $this->SetFont("Helvetica", "B", 9);
    $this->SetTextColor(84, 84, 84);
    $this->SetFillColor(255, 255, 255);
    $this->Cell(75, 5, "From [Remit To]", 0, 2, "L");
    $this->SetFont("Helvetica", "", 9);
    $this->MultiCell(75, 5, "Your Company\nStreet Address\nCity State, Zip\nCountry", 0, "L", false);
    $this->SetXY($this->GetPageWidth() - 100, 65);
    $this->SetFont("Helvetica", "B", 9);
    $this->Cell(75, 5, "Details", 0, 2, "L");
    $this->SetFont("Helvetica", "", 9);
    $this->MultiCell(37.5, 5, "Invoice Num:\nInvoice Date:\nBilling Period:\n ", 0, "L", false);
    $this->SetXY($this->GetPageWidth() - 62.5, 70);
    $this->MultiCell(37.5, 5, "#QCF9GNM5\nJanuary 1st, 2022\n12/01/2021 - 12/31/2021\n ", 0, "R", false);
    $this->Ln(5);
    $this->SetX(25);
    $this->SetFont("Helvetica", "B", 9);
    $this->Cell(75, 5, "To", 0, 2, "L");
    $this->SetFont("Helvetica", "", 9);
    $this->MultiCell(75, 5, "Account <email@email.com>\nCustomer Addr\nCity State, Zip", 0, 2, "L", false);
    $this->Ln(5);
    $this->SetX(25);
    $this->SetFont("Helvetica", "", 13);
    $this->SetTextColor(84, 84, 84);
    $this->SetFillColor(255, 255, 255);
    $this->Cell((($this->GetPageWidth() - 50) / 2), 5, "Charge Details", 0, 2, "L");
    $this->Line(25, $this->GetY() + 1, $this->GetPageWidth() - 25, $this->GetY() + 1);
    $this->Ln(5);
    $this->SetX(25);
    $this->SetFont("Helvetica", "", 9);
    $this->Cell((($this->GetPageWidth() - 50) / 2), 5, "Billing period balance", 0, 0, "L");
    $this->Cell((($this->GetPageWidth() - 50) / 2), 5, "$11.97", 0, 2, "R");
    $this->SetX(25);
    $this->Cell((($this->GetPageWidth() - 50) / 2), 5, "Billing year-to-date balance", 0, 0, "L");
    $this->Cell((($this->GetPageWidth() - 50) / 2), 5, "$75.97", 0, 2, "R");
    $this->Ln(4);
    $this->Line(25, $this->GetY() + 1, $this->GetPageWidth() - 25, $this->GetY() + 1);
  }

  /**
   * Write the PDF footer
   *
   * @return void
   */
  public function Footer()
  {
    $this->SetXY(10, -10);
    $this->SetFont("Helvetica", "", 9);
    $this->SetTextColor(84, 84, 84);
    $this->Cell($this->GetPageWidth() - 20, 5, "Page ". $this->PageNo() ." of {nb}", 0, 0, "R");
    $this->SetXY(0, 0);
  }

  /**
   * Produce a Rounded Rectangle
   *
   * @param int $x
   * @param int $y
   * @param int $w
   * @param int $h
   * @param int $r radius pixels
   * @param string $style
   * @return void
   */
  public function RoundedRect($x, $y, $w, $h, $r, $style = '') : void
  {
    $k = $this->k;
    $hp = $this->h;
    if($style=='F')
      $op='f';
    elseif($style=='FD' || $style=='DF')
      $op='B';
    else
      $op='S';
    $MyArc = 4/3 * (sqrt(2) - 1);
    $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
    $xc = $x+$w-$r ;
    $yc = $y+$r;
    $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

    $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
    $xc = $x+$w-$r ;
    $yc = $y+$h-$r;
    $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
    $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
    $xc = $x+$r ;
    $yc = $y+$h-$r;
    $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
    $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
    $xc = $x+$r ;
    $yc = $y+$r;
    $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
    $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
    $this->_out($op);
  }

  /**
   * Produce a Rectangle Arc
   *
   * @param int $x1
   * @param int $y1
   * @param int $x2
   * @param int $y2
   * @param int $x3
   * @param int $y3
   * @return void
   */
  protected function _Arc($x1, $y1, $x2, $y2, $x3, $y3) : void
  {
    $h = $this->h;
    $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k, $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
  }
}