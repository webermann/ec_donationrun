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
 * Controller class for the backend module. Provides actions for listing all projects
 * in the TYPO3 backend.
 *
 * @author     Hauke Webermann <hauke@webermann.net>
 * @package    EcDonationrun
 * @subpackage Controller
 * @version    $Id$
 * @license    GNU Public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 *
 */

Class Tx_EcDonationrun_Controller_BackendController Extends Tx_Extbase_MVC_Controller_ActionController {

	/*
	 * ATTRIBUTES
	 */
	/**
	 * A run repository instance
	 * @var Tx_EcDonationrun_Domain_Repository_RunRepository
	 */
	//Protected $runRepository;
	/**
	* A registration repository.
	* @var Tx_EcDonationrun_Domain_Repository_RegistrationRepository
	*/
	Protected $registrationRepository;

	/**
	 * A donatoin repository.
	 * @var Tx_EcDonationrun_Domain_Repository_DonationRepository
	 */
	Protected $donationRepository;

	/**
	 * A FE User repository instance
	 * @var Tx_EcAssociation_Domain_Repository_UserRepository
	 */
	//protected $frontendUserRepository;
	/**
	* A FE User Group repository instance
	* @var Tx_Extbase_Domain_Repository_FrontendUserGroupRepository
	*/
	//protected $frontendUserGroupRepository;

	/*
	 * ACTION METHODS
	 */

	/**
	 *
	 * The initialization action. This methods creates instances of all required
	 * repositories.
	 *
	 * @return void
	 *
	 */
	Protected Function initializeAction() {
		//$this->runRepository          =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_RunRepository');
		$this->registrationRepository =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_RegistrationRepository');
		$this->registrationRepository->initializeObjectForBe();
		$this->donationRepository     =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_DonationRepository');
		$this->donationRepository->initializeObjectForBe();
		//$this->userRepository         =& t3lib_div::makeInstance('Tx_EcAssociation_Domain_Repository_UserRepository');
		//$this->frontendUserGroupRepository =& t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserGroupRepository');
	}



	/**
	 * The index action. Displays a list of all available registrations.
	 * @return void
	 */
	Public Function indexAction() {
		/* Registrion Ranking */
		$registrations = $this->registrationRepository->findAllActive();
		$ranking = Tx_EcDonationrun_Controller_RegistrationController::getRankingRunner($registrations);
		$this->view->assign('registrations', $ranking);
		/* Open invoices */
		$this->view->assign('donations', $this->donationRepository->findAllNoInvoice());
		/* List all registrion emails */
		$emails = '';
		foreach ($registrations as $registration) {
			$emails .= $registration->getUser()->getEmail().'; ';
		}
		$this->view->assign('registration_emails', $emails);
	}

	/**
	 * The sendDonationRequest action.
	 * @return void
	 */
	Public Function sendDonationRequestAction() {
		if (!isset($this->settings['invoicePath'])) throw new Exception('EC Donationrun: invoicePath not set');
		if (!isset($this->settings['invoiceTemplate'])) throw new Exception('EC Donationrun: invoiceTemplate not set');
		if (!isset($this->settings['mail']['viaPostAddress'])) throw new Exception('EC Donationrun: mail.viaPostAddress not set');
		$startTime = microtime(true);
		$donations = $this->donationRepository->findAllNoInvoice();
		$usersDonationsByRunner = array();
		$usersDonations = array();
		foreach ($donations as $donation) {
			if (($donation->getDonationValue() == 0.0) && ($donation->getDonationFixValue() == 0.0)) {
				continue;
			}
			if ($donation->getNotificationVia() == 2) { // by runner?
				$usersDonationsByRunner[$donation->getRegistration()->getUser()->getUid()][] = $donation;
			} else {
				$usersDonations[$donation->getUser()->getUid()][] = $donation;
			}
		}
		$log = '';
		$invoicesByPost = array();
		foreach ($usersDonations as $donations) {
			$invoice = Tx_EcDonationrun_Utility_Invoice::generateInvoice($donations, $this->settings['invoicePath'], $this->settings['invoiceTemplate']);
			
			if (!is_file($invoice)) {
				throw new Exception('EC Donationrun: Generate Invoice failt!');
			}
			//sendmail
			if ($donations[0]->getNotificationVia() == 1) { // By Post
				$invoicesByPost[] = $invoice;
			} else {
				Tx_EcDonationrun_Utility_SendMail::sendMail(
					array($donations[0]->getUser()->getEmail() => $donation->getUser()->getName()),
					"Running for Jesus - Spendenbenachrichtigung",
					"Hallo ".$donations[0]->getUser()->getName().",\n".
					"herzlichen Dank für deine Spende bei Running for Jesus im Anhang findest du die Spendenbenachrichtigung als pdf.",
					$invoice);
				$log .= "Mail verschickt an ".$donations[0]->getUser()->getName().' ('.str_replace($this->settings['invoicePath'].'/','', $invoice).")\n";
			}
			foreach ($donations as $donation) {
				$donation->setNotificationStatus(2); //	Mail sent
			}
		}
		if (!empty($invoicesByPost)) {
			Tx_EcDonationrun_Utility_SendMail::sendMail(
				$this->settings['mail']['viaPostAddress'],
				"Running for Jesus - Spendenbenachrichtigung per Post",
				"Hallo Nina,\n".
				"hier kommt eine Spendenbenachrichting per Post.",
				$invoicesByPost);
				$log .= "Mail verschickt an ".$this->settings['mail']['viaPostAddress']."\n";
		}
		foreach ($usersDonationsByRunner as $donations) {
			$invoices = array();
			foreach ($donations as $donation) {
				$donationToGenerate = array(&$donation);
				$invoice = Tx_EcDonationrun_Utility_Invoice::generateInvoice($donationToGenerate, $this->settings['invoicePath'], $this->settings['invoiceTemplate']);
				if (!is_file($invoice)) {
					throw new Exception('EC Donationrun: Generate Invoice failt!');
				}
				$invoices[] = $invoice;
			}
			// Send mail to runner
			Tx_EcDonationrun_Utility_SendMail::sendMail(
				array($donations[0]->getRegistration()->getUser()->getEmail() => $donations[0]->getRegistration()->getUser()->getName()),
				"Running for Jesus - Spendenbenachrichtigung per Läufer",
				"Hallo ".$donations[0]->getRegistration()->getUser()->getName().",\n".
				"im Anhang erhälst du die Spendenbenachrichtigung für deine Spender.",
				$invoices);
			$log .= "Mail verschickt an ".$donations[0]->getRegistration()->getUser()->getName()."\n";
			foreach ($donations as $donation) {
				$donation->setNotificationStatus(2); //	Mail sent
			}
		}
		$this->view->assign('log', $log);
		$this->view->assign('processingTime', number_format((microtime(true) - $startTime), 2, ',', '.'));
	}



		// TODO generate xls



}

?>
