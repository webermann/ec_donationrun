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

require_once t3lib_extMgm::extPath('fpdf').'class.tx_fpdf.php';

Class Tx_EcDonationrun_Utility_Invoice {

	/*
	 * @param array<Tx_EcDonationrun_Domain_Model_Donation> $donations
	 * */

	static public function generateInvoice(array &$donations, $destinationPath, $templatePath = '') {
		if (!t3lib_extMgm::isLoaded('fpdf')) {
			throw new Exception('EC Donationrun: fpdf not loaded in Tx_EcDonationrun_Utility_Invoice.');
		}
		
		$year = date("Y", time());
		$invoiceId = 0;
		do {
			$invoiceId++;
			$invoicePath = $destinationPath.'/RJ'.'_'.$year.$invoiceId.'.pdf';
		} while (is_file($invoicePath)) ;
		$invoiceNumber = 'RJ '.$year.$invoiceId;
		
		// Some defaults and configuration
		$h = 5;
		
		// Get a new instance of the FPDF library
		$pdf = new PDF('portrait','mm','A4');
		
		if (($templatePath != '') && ($donations[0]->getNotificationVia() != 1)) { // Not by Post?
			$pdf->tx_fpdf->template = $templatePath;
		}
		$pdf->SetMargins(26, 50, 26);
		$pdf->AddPage();
		// Shoe template only on first page
		$pdf->tx_fpdf->template = '';
		$pdf->SetFont('Arial', '', 10);
		
		// Print Address
		$pdf->Cell(100, $h, self::c($donations[0]->getUser()->getName()), 0, 2);
		$pdf->Cell(100, $h, self::c($donations[0]->getUser()->getAddress()), 0, 2);
		$pdf->Cell(100, $h, self::c($donations[0]->getUser()->getZip().' '.$donations[0]->getUser()->getCity()), 0, 2);
		
		// Print Subject
		$pdf->SetY(95);
		$pdf->Cell(158, $h, date('d.m.Y', time()), 0, 2, 'R');
		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(100, $h, 'Running for Jesus - Spendenbenachrichtigung', 0, 2);
		$pdf->SetFont('Arial', '', 10);
		// Print Text
		$pdf->SetY(110);
		$pdf->Cell(100, $h, self::c('Liebe/r '.$donations[0]->getUser()->getName().', (Sehr geehrte '.$donations[0]->getUser()->getName().'),'), 0, 2);
		$pdf->MultiCell(158, $h,self::c(
			'am '.$donations[0]->getRegistration()->getRun()->getStart()->format('d.m.Y').
			' fand der Sponsorenlauf "Running for Jesus" statt. '.
			'Viele Läufer gingen an den Start und wir freuen uns über Deine (Ihre) Zusage diesen Erfolg finanziell zu unterstützen.')
		);
		
		$donationsRunSuccessful = array();
		$donationsRunAborted = array();
		$donationsRunDeregistered = array();
		
		foreach ($donations as &$donation) {
			// Set invoice number
//TODO !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!			$donation->setInvoiceNumber($invoiceNumber);
			// Sort donations
			$runStatus = $donation->getRegistration()->getRunStatus();
			if ($runStatus == 0) { // Run successful
				$donationsRunSuccessful[] = $donation;
			} elseif ($runStatus == 1) { // Run aborted
				$donationsRunAborted[] = $donation;
			} else { // Run deregistered
				$donationsRunDeregistered[] = $donation;
			}
		}
		
		$tableHeader = array('Läufer', 'Lauf', 'Spende', 'Summe');
		$tableWidth = array(45, 45, 40, 30);
		$pdf->SetFillColor(169, 169, 169);
	    $pdf->SetTextColor(0);
	    $pdf->SetDrawColor(0);
	    $pdf->SetLineWidth(.3);
		
		if (!empty($donationsRunSuccessful)) {
			$pdf->Ln();
			if (count($donationsRunSuccessful) != 1) {
				$pdf->Cell(100, $h, self::c('Für folgende Läufer hast du (haben Sie) eine Spende zugesagt:'), 0, 2);
				
			    $pdf->SetFont('Arial','B',10);
				for ($i=0; $i<count($tableHeader); $i++) {
					$pdf->Cell($tableWidth[$i], 7, self::c($tableHeader[$i]), 1, 0, 'C', 1);
				}
				$pdf->SetFont('Arial', '', 10);
				$pdf->Ln();
				$fill=0;
				$donationAmount = 0.0;
				
				foreach ($donationsRunSuccessful as &$donation) {
					$pdf->Cell($tableWidth[0], $h, self::c($donation->getRegistration()->getUser()->getName()), 'LR', 0, 'L', $fill);
					$pdf->Cell($tableWidth[1], $h, self::c($donation->getRegistration()->getRun()->getName()), 'LR', 0, 'L', $fill);
					$pdf->Cell($tableWidth[2], $h, self::c(self::getRealDonationFormated($donation)), 'LR', 0, 'R', $fill);
					$pdf->Cell($tableWidth[3], $h, self::c(number_format(self::getRealDonationValue($donation), 2, ',', '.').' Euro'), 'LR', 1, 'R', $fill);
					$donationAmount += self::getRealDonationValue($donation);
					$fill=!$fill;
				}
				$pdf->Cell(array_sum($tableWidth), $h, '', 'T', 1);
				$pdf->MultiCell(158, $h, self::c(
					"Wir würden uns sehr freuen wenn Du (Sie) den Betrag von ".number_format($donationAmount, 2, ',', '.').
					" Euro überweist (überweisen)."
				));
			} else {
				$pdf->MultiCell(158, $h, self::c(
					"Für ".$donation->getRegistration()->getUser()->getName().
					" (".$donation->getRegistration()->getRun()->getName().")".
					" hast Du (haben Sie) einen Betrag von ".number_format(self::getRealDonationValue($donation), 2, ',', '.')." Euro zugesagt.".
					" Wir würden uns sehr freuen wenn Du (Sie) den Betrag überweist (überweisen)."
				));
			}
		}
		
		if (!empty($donationsRunAborted)) {
			$text = '';
			foreach ($donationsRunAborted as $donation) {
				if ($text == '') {
					$text .= "Für ".$donation->getRegistration()->getUser()->getName().
						" (".$donation->getRegistration()->getRun()->getName().")".
						" hast Du (haben Sie) einen Betrag von ".number_format(self::getRealDonationValue($donation), 2, ',', '.')." Euro zugesagt";
				} else {
					$text .= ", für ".$donation->getRegistration()->getUser()->getName().
						" (".$donation->getRegistration()->getRun()->getName().")".
						" einen Betrag von ".number_format(self::getRealDonationValue($donation), 2, ',', '.')." Euro";
				}
			}
			$text .= '.';

			$pdf->Ln();
			$pdf->MultiCell(158, $h, self::c(
				"Leider musste der Lauf von einigen abgebrochen werden und das Ziel wurde nicht erreicht. Trotz des Abbruchs wurde voller Einsatz gezeigt. ".
				$text.
				" Natürlich brauchst Du (brauchen Sie) den Betrag nicht überweisen. ".
				"Falls Du (Sie) den Betrag trotzdem spenden möchtest (möchten), wären wir Dir (Ihnen) natürlich sehr dankbar."
			));
		}
			
		if (!empty($donationsRunDeregistered)) {
			$text = '';
			foreach ($donationsRunDeregistered as $donation) {
				if ($text == '') {
					$text .= "Du hattest (Sie hatten) für ".$donation->getRegistration()->getUser()->getName().
						" (".$donation->getRegistration()->getRun()->getName().")".
						" eine Unterstützung von ".number_format(self::getRealDonationValue($donation), 2, ',', '.')." Euro zugesagt";
				} else {
					$text .= ", für ".$donation->getRegistration()->getUser()->getName().
						" (".$donation->getRegistration()->getRun()->getName().")".
						" einen Betrag von ".number_format(self::getRealDonationValue($donation), 2, ',', '.')." Euro";
				}
			}
			$text .= '.';
						
			$pdf->Ln();
			$pdf->MultiCell(158, $h, self::c(
				$text.
				" Der Lauf wurde leider nicht angetreten. Natürlich brauchst Du (brauchen Sie) den Betrag somit auch nicht überweisen. ".
				"Falls Du (Sie) den Betrag trotzdem spenden möchtest (möchten), wären wir Dir (Ihnen) natürlich sehr dankbar."
			));
		}
		
		$pdf->Ln();
		$pdf->MultiCell(158, $h, self::c(
			"Bitte überweise den Gesamtbetrag, mit Angabe der Vorgangsnummer auf das Konto des Niedersächsischen EC-Verbandes:\n".
			"IBAN: DE58 5206 0410 0000 6159 78\n".
			"BIC: GENODEF1EK1\n".
			"Verwendungszweck: ".$invoiceNumber
		));
		
		$pdf->SetFont('Arial', '', 10);
		$pdf->Ln();
		$pdf->MultiCell(158, $h, self::c(
			"Mit Deinem (Ihrem) Beitrag unterstützt Du (unterstützen Sie) die sozial-diakonische ".
			"Stadtteilarbeit 'Die PLiNKE' in Hannover/Linden und ermöglichst (ermöglichen) die wertvolle ".
			"Arbeit im Niedersächsischen EC-Verband. Weitere Infos findest Du (finden Sie) unter www.die-plinke.de ".
			"und www.ec-niedersachsen.de.\n\n".
			"Für Rückfragen stehen wir Dir (Ihnen) gern zur Verfügung.\n".
			"Vielen Dank für Deine (Ihre)Unterstützung.\n\n".
			"Herzliche Grüße\n".
			"- Im Namen des Running for Jesus - Teams -\n".
			"Carsten Müller")
		);
		
		$pdf->Output($invoicePath, 'f');
		
		return $invoicePath;
	}
	
	protected function getRealDonationValue(Tx_EcDonationrun_Domain_Model_Donation $donation) {
		if ($donation->getDonationFixValue() == 0) {
			return $donation->getDonationValue() * $donation->getRegistration()->getRun()->getDistance();
		} else {
			return $donation->getDonationFixValue() * $donation->getRegistration()->getRun()->getDistance();
		}
	}
	protected function getRealDonationFormated(Tx_EcDonationrun_Domain_Model_Donation $donation) {
		if ($donation->getDonationFixValue() == 0) {
			return number_format($donation->getDonationValue(), 2, ',', '.')." Euro pro km";
		} else {
			return number_format($donation->getDonationFixValue(), 2, ',', '.')." Euro Festbetrag";
		}
	}
	protected function c($data) {
		return iconv("UTF-8", "iso-8859-1", $data);
	}

}

?>
