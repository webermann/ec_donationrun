<?php

/*                                                                      *
 *  COPYRIGHT NOTICE                                                    *
 *                                                                      *
 *  (c) 2013 Hauke Webermann <hauke@webermann.net>                      *
 *           webermann.net                                              *
 *           All rights reserved                                        *
 *                                                                      *
 *  This script is part of the TYPO3 project. The TYPO3 project is      *
 *  free software; you can redistribute it and/or modify                *
 *  it under the terms of the GNU General Public License as published   *
 *  by the Free Software Foundation; either version 2 of the License,   *
 *  or (at your option) any later version.                              *
 *                                                                      *
 *  The GNU General Public License can be found at                      *
 *  http://www.gnu.org/copyleft/gpl.html.                               *
 *                                                                      *
 *  This script is distributed in the hope that it will be useful,      *
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of      *
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the       *
 *  GNU General Public License for more details.                        *
 *                                                                      *
 *  This copyright notice MUST APPEAR in all copies of the script!      *
 *                                                                      */



/**
 *
 * A ViewHelper for formatting time amounts. In dependence of the time amount, the
 * time amount if formatted with a different unit (seconds, minutes, hours, days).
 *
 * @author     Hauke Webermann <hauke@webermann.net>
 * @package    EcDonationrun
 * @subpackage Utility
 * @version    $Id: Invoice.php 46 2014-02-26 06:48:05Z hauke $
 * @license    GNU Public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 *
 */

Class Tx_EcDonationrun_Utility_Invoice {

	/*
	 *
	 * */

	static public function generateInvoice(Tx_EcDonationrun_Domain_Model_Donation $donation) {
		if (t3lib_extMgm::isLoaded('fpdf')){
			require(t3lib_extMgm::extPath('fpdf').'class.tx_fpdf.php');
		}
		if (!t3lib_extMgm::isLoaded('fpdf')) return;
		// Get a new instance of the FPDF library
		if(isset($pdf)){
			$pdf=NULL;
		}
		 
		$pdf = t3lib_div::makeInstance('PDF');
		$pdf = new PDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		
		$pdf->Cell(40,10,'No value');
		
		$pdf->Output();

		return $mail->isSent();
	}


}

?>
