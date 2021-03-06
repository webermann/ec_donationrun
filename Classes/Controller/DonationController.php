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
	 * Donation controller class for the timetracking extension. This controller provides
	 * actiosn for creating new donations.
	 *
	 * @author     Hauke Webermann <hauke@webermann.net>
	 * @package    EcDonationrun
	 * @subpackage Controller
	 * @version    $Id$
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 *
	 */

class Tx_EcDonationrun_Controller_DonationController extends Tx_EcDonationrun_Controller_AbstractController {

		/*
		 * ATTRIBUTES
		 */

		/**
		 * A registration repository instance
		 * @var Tx_EcDonationrun_Domain_Repository_RegistrationRepository
		 */
	protected $registrationRepository;

		/**
		 * A donation repository instance
		 * @var Tx_EcDonationrun_Domain_Repository_DonationRepository
		 */
	protected $donationRepository;

	/**
     * A FE User repository instance
     * @var Tx_EcAssociation_Domain_Repository_UserRepository
     */
    protected $frontendUserRepository;
    /**
     * A FE User Group repository instance
     * @var Tx_Extbase_Domain_Repository_FrontendUserGroupRepository
     */
    protected $frontendUserGroupRepository;

		/*
		 * ACTION METHODS
		 */

		/**
		 *
		 * The initialization action. Creates instances of all required repositories.
		 * @return void
		 *
		 */

	public function initializeAction() {
		$this->registrationRepository      =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_RegistrationRepository');
		$this->donationRepository          =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_DonationRepository');
		$this->frontendUserRepository      =& t3lib_div::makeInstance('Tx_EcAssociation_Domain_Repository_UserRepository');
		$this->frontendUserGroupRepository =& t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserGroupRepository');
	}



		/**
		 *
		 * The index action. This method displays a list of all donations for a specific
		 * registration.
		 *
		 * @param Tx_EcAssociation_Domain_Model_User $user
		 * @return void
		 * @dontvalidate $user
		 */
	public function indexAction(Tx_EcAssociation_Domain_Model_User $user = NULL) {
		// Check parameter and if null registration load from current user
		if ($user == NULL) {
			$user = $this->getCurrentFeUser();
		}
		$registrations = $this->registrationRepository->findRegistrationsFromUser($user);
		if ($registrations->getFirst() == NULL) {
			$this->flashMessages->add('Bitte erst für einen Lauf anmelden.');
			$this->redirect('index', 'Registration', 'ecdonationrun', NULL, $this->settings['registrationIndex']);
		}
		$donationAmount = 0.0;
		foreach ($registrations as $registration) {
			$donationAmount += $registration->getDonationAmount();
		}

		if (!isset($this->settings['donationEdit'])) throw new Exception('EC Donationrun: donationEdit not set');
		$this->view->assign('registrations' , $registrations)
				   ->assign('donation_amount', $donationAmount)
				   ->assign('donationNewPageUid', $this->settings['donationNew'])
				   ->assign('donationEditPageUid', $this->settings['donationEdit']);

		// TODO Add List with Registrations from previous years
	}



		/**
		 *
		 * The new action. This method displays a form for creating a new donation.
		 *
		 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The registration the new donation is to be assigned to
		 * @param Tx_EcDonationrun_Domain_Model_Donation $donation The new donation
		 * @return void
		 * @dontvalidate $donation
		 */

	public function newAction ( Tx_EcDonationrun_Domain_Model_Registration $registration,
	                            Tx_EcDonationrun_Domain_Model_Donation $donation=NULL) {
		if ($GLOBALS['TSFE']->loginUser == 0) {
			if (!isset($this->settings['loginPageDonator'])) throw new Exception('EC Donationrun: loginPageDonator not set');
			$this->redirectToUri('index.php?id='.$this->settings['loginPageDonator'].
				'&tx_ecdonationrun_pi1[registration]='.$registration->getUid().'&no_cache=1'. // For Registration with No Login
				//'&return_url='.urlencode($GLOBALS['TSFE']->anchorPrefix)); TODO
				'&return_url=index.php?id='.$this->settings['registrationIndex']);
		}

		$this->view->assign('registration', $registration)
		           ->assign('donation', $donation)
		           ->assign('user', $this->getCurrentFeUser())
		           ->assign('isOwnRegistration', $registration->isCurrentFeUserEqualUser());
	}

		/**
		 *
		 * The edit action. This method displays a form for editing a donation.
		 *
		 * @param Tx_EcDonationrun_Domain_Model_Donation $donation The donation
		 * @return void
		 *
		 */

	public function editAction(Tx_EcDonationrun_Domain_Model_Donation $donation) {



		$this->view->assign('registration', $donation->getRegistration())
		           ->assign('donation', $donation);
	}

		/**
		 *
		 * The new action. This method displays a form for creating a new donation.
		 *
		 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The registration the new donation is to be assigned to
		 * @param Tx_EcDonationrun_Domain_Model_Donation $donation The new donation
		 * @return void
		 * @dontvalidate $registration
		 * @dontvalidate $donation
		 */

	public function newNoLoginAction(Tx_EcDonationrun_Domain_Model_Registration $registration=NULL,
	                                 Tx_EcDonationrun_Domain_Model_Donation $donation=NULL) {
		if ($GLOBALS['TSFE']->loginUser != 0) {
			// TODO wenn doch eingeloggt...
		}

		if ($registration == NULL) {
			$this->flashMessages->add('Wähle bitte zuerst für wen du Spenden möchtest.');
			$this->redirect('index', 'Registration', NULL, NULL, $this->settings['registrationIndex']);
		}
		$this->view->assign('registration', $registration)
		           ->assign('donation', $donation);
	}

		/**
		 *
		 * The create action. Stores a new donation into the database.
		 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The registration the new donation is to be assigned to
		 * @param Tx_EcDonationrun_Domain_Model_Donation $donation The new donation
		 * @param string $isOffline
		 * @return void
		 * @dontvalidate $isNoLogin
		 */

	public function createAction(Tx_EcDonationrun_Domain_Model_Registration $registration,
	                             Tx_EcDonationrun_Domain_Model_Donation $donation,
	                             $isNoLogin = '') {
	    if ($isNoLogin == 'isNoLogin' || $registration->isCurrentFeUserEqualUser()) {
	    	$isOfflineDonation = true;
			$user = $donation->getUser();
		    $user->setName($user->getFirstName().' '.$user->getLastName());
		    $user->setUsername($user->getName().' - Anonymous');
		    $user->setPassword('NO_PASSWORT_SET_'.mt_rand());
		    if (isset($this->settings['pidOfflineUser'])) {
	    		$user->setPid($this->settings['pidOfflineUser']);
		    } else {
		    	$user->setPid($registration->getUser()->getPid());
		    }
	    } else {
	    	$isOfflineDonation = false;
	    	$user = $this->frontendUserRepository->findByUid($this->getCurrentFeUser()->getUid());
	    }
	    if (!isset($this->settings['userGroupDonator'])) throw new Exception('EC Donationrun: userGroupDonator not set');
    	$userGroup = $this->frontendUserGroupRepository->findByUid($this->settings['userGroupDonator']);
    	if ($userGroup) {
			$user->addUsergroup($userGroup);
    	}
        if ($user->_isNew()) {
			$this->frontendUserRepository->add($user);
		}
		$donation->setRegistration($registration);
		$donation->setUser($user);

		if ($isNoLogin == 'isNoLogin') {
			$donation->setHidden(TRUE);
			$this->donationRepository->add($donation);
		    $persistenceManager = t3lib_div::makeInstance('Tx_Extbase_Persistence_Manager');
    		$persistenceManager->persistAll();
			$addedDonation = $this->donationRepository->getAddedObjects()->toArray();

			if (isset($this->settings['mail']['adminAddress'])) {
				Tx_EcDonationrun_Utility_SendMail::sendMail(
					array($this->settings['mail']['adminAddress']),
					"Info Spendenzusage (Ohne Login)",
					"Hallo,".
					"\nes ist eine neue Spende (ohne Login) eingegangen.".
					"\nSpender:  ".$donation->getUser()->getName().
					"\nSpende:   ".$this->getRealDonation($donation).
					"\nLäufer:   ".$donation->getRegistration()->getUser()->getName().
					"\nLauf:     ".$donation->getRegistration()->getRun()->getName()." (".
							       $donation->getRegistration()->getRun()->getEvent()->getName().")".
					"\nKomentar: ".$donation->getComment().
			       	Tx_EcDonationrun_Utility_MailTexter::getMailGreeting($donation->getRegistration()->getRun()->getEvent()));
			}
			if (!defined('MCRYPT_RIJNDAEL_128')) throw new Exception('EC Donationrun: The MCRYPT_RIJNDAEL_128 algorithm is required (PHP 5.3).');
			if (!isset($this->settings['cryptKey'])) throw new Exception('EC Donationrun: cryptKey not set');
			$key = hash('sha256', $this->settings['cryptKey'], true);
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			$ciphertext =  mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $addedDonation[0]->getUid(), MCRYPT_MODE_CBC, $iv);
			$ciphertext = $iv.$ciphertext;
			$ciphertext_base64 = base64_encode($ciphertext);

			if (!isset($this->settings['confirmNoLogin'])) throw new Exception('EC Donationrun: confirmNoLogin not set');
			$this->controllerContext->getUriBuilder()->setTargetPageUid($this->settings['confirmNoLogin']);
			$this->controllerContext->getUriBuilder()->setArguments(array('tx_ecdonationrun_pi1[donationToConfirm]' => urlencode($ciphertext_base64)));
			$this->controllerContext->getUriBuilder()->setCreateAbsoluteUri(true);
			$confirmLink = $this->controllerContext->getUriBuilder()->buildFrontendUri();

			Tx_EcDonationrun_Utility_SendMail::sendMail(
				array($donation->getUser()->getEmail() => $donation->getUser()->getName()),
				"Spendenzusage",
				"Hallo ".$donation->getUser()->getName().",\n".

				"herzlichen Dank für deine Spendenzusage bei Running for Jesus in Höhe von ".$this->getRealDonation($donation)." .\n".
				$donation->getRegistration()->getUser()->getName()." läuft/skatet/walkt am ".
				date("d.m.Y", $donation->getRegistration()->getRun()->getStart()->getTimestamp())." ".
				$donation->getRegistration()->getRun()->getRealDistance()." ".
				$donation->getRegistration()->getRun()->getDistanceUnitFormated().".\n\n".
				$donation->getRegistration()->getRun()->getEvent()->getDonationInfo().".\n\n".
				"Bitte klicke folgenden Link, um Deine Spendenzusage zu bestätigen:\n".$confirmLink.
				"\n\nNach Running for Jesus bekommst du eine Mail mit allen wichtigen Infos zur Spendenabwicklung!".
				Tx_EcDonationrun_Utility_MailTexter::getMailGreeting($donation->getRegistration()->getRun()->getEvent()));
				// TODO Sätze entkoppeln

			$this->flashMessages->add('Vielen Dank für deine Spende. Du bekommst eine E-Mail mit der du deine Spende noch bestätigen musst.');
			$this->redirect('index', 'Registration', NULL, NULL, $this->settings['registrationIndex']);
		}

		$donation->setNotificationStatus(1);//TODO
		$this->donationRepository->add($donation);
		if (!$isOfflineDonation) {
			Tx_EcDonationrun_Utility_SendMail::sendMail(
				array($donation->getUser()->getEmail() => $donation->getUser()->getName()),
				"Spendenzusage",
				"Hallo ".$donation->getUser()->getName().",\n".

				"herzlichen Dank für deine Spendenzusage bei Running for Jesus in Höhe von ".$this->getRealDonation($donation)." .\n".
				$donation->getRegistration()->getUser()->getName()." läuft/skatet/walkt am ".
				date("d.m.Y", $donation->getRegistration()->getRun()->getStart()->getTimestamp())." ".
				$donation->getRegistration()->getRun()->getDistance()." ".
				$donation->getRegistration()->getRun()->getDistanceUnitFormated().".\n\n".
				$donation->getRegistration()->getRun()->getEvent()->getDonationInfo().".\n\n".
				"Nach Running for Jesus bekommst du eine Mail mit allen wichtigen Infos zur Spendenabwicklung!".
				Tx_EcDonationrun_Utility_MailTexter::getMailGreeting($donation->getRegistration()->getRun()->getEvent()));
		}

		Tx_EcDonationrun_Utility_SendMail::sendMail(
			array($donation->getRegistration()->getUser()->getEmail() => $donation->getRegistration()->getUser()->getName()),
			"Info Spendenzusage",
			"Hallo ".$donation->getRegistration()->getUser()->getName().",\n".
			$donation->getUser()->getName(). " wird dich bei Running for Jesus mit ".
			$this->getRealDonation($donation)." unterstützen.".
			Tx_EcDonationrun_Utility_MailTexter::getMailGreeting($donation->getRegistration()->getRun()->getEvent()));

		if (isset($this->settings['mail']['adminAddress'])) {
			Tx_EcDonationrun_Utility_SendMail::sendMail(
				array($this->settings['mail']['adminAddress']),
				"Info Spendenzusage",
				"Hallo,".
				"\nes ist eine neue Spende eingegangen.".
				"\nSpender:  ".$donation->getUser()->getName().
				"\nSpende:   ".$this->getRealDonation($donation).
				"\nLäufer:   ".$donation->getRegistration()->getUser()->getName().
				"\nLauf:     ".$donation->getRegistration()->getRun()->getName()." (".
							   $donation->getRegistration()->getRun()->getEvent()->getName().")".
				"\nKomentar: ".$donation->getComment().
				Tx_EcDonationrun_Utility_MailTexter::getMailGreeting($donation->getRegistration()->getRun()->getEvent()));
		}

		// Print a success message and return to the registration detail view.
		$this->flashMessages->add('Spende gespeichert.');
		if ($isOfflineDonation) {
			if (!isset($this->settings['donationIndex'])) throw new Exception('EC Donationrun: donationIndex not set');
			$this->redirect('index', 'Donation', NULL, NULL, $this->settings['donationIndex']);
		} else {
			$this->redirect('index', 'Registration', NULL, NULL, $this->settings['registrationIndex']);
		}
	}

	/**
		 *
		 * The update action. Updates a donation into the database.
		 * @param Tx_EcDonationrun_Domain_Model_Donation $donation The new donation
		 * @return void
		 */

	public function updateAction(Tx_EcDonationrun_Domain_Model_Donation $donation) {
		$this->donationRepository->update($donation);

		if (isset($this->settings['mail']['adminAddress'])) {
			Tx_EcDonationrun_Utility_SendMail::sendMail(
				array($this->settings['mail']['adminAddress']),
				"Spende aktualisiert",
				"Hallo,".
				"\nes eine Spende wurde bearbeitet.".
				"\nSpender:  ".$donation->getUser()->getName().
				"\nSpende:   ".$this->getRealDonation($donation).
				"\nLäufer:   ".$donation->getRegistration()->getUser()->getName().
				"\nLauf:     ".$donation->getRegistration()->getRun()->getName()." (".
							   $donation->getRegistration()->getRun()->getEvent()->getName().")".
				"\nKomentar: ".$donation->getComment().
				"\nBearbeiter: ".$this->getCurrentFeUser()->getName().
			   	Tx_EcDonationrun_Utility_MailTexter::getMailGreeting($donation->getRegistration()->getRun()->getEvent()));
		}
		// Print a success message and return to the registration detail view.
		$this->flashMessages->add('Spende gespeichert.');
		$this->redirect('index', 'Donation', NULL, NULL, $this->settings['donationIndex']);
	}

	/**
		 *
		 * The create offline finish action.
		 * @return void
		 *
		 */
	public function confirmNoLoginAction() {
		$formValues = t3lib_div::_GP('tx_ecdonationrun_pi1');
		if (!isset($formValues['donationToConfirm'])) {
			$this->view->assign('confirmStatus', FALSE);
		} else {
			$key = hash('sha256', $this->settings['cryptKey'], true);
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
			$ciphertext_dec = base64_decode($formValues['donationToConfirm']);
			$iv_dec = substr($ciphertext_dec, 0, $iv_size);
			$ciphertext_dec = substr($ciphertext_dec, $iv_size);
			$donationUid = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
			$donationUid = rtrim($donationUid, "\0");
			$donation = $this->donationRepository->findByUid(intval($donationUid));
			if ($donation) {
				$donation->setHidden(FALSE);
				if (isset($this->settings['mail']['adminAddress'])) {
					Tx_EcDonationrun_Utility_SendMail::sendMail(
						array($this->settings['mail']['adminAddress']),
						"Info Bestätigung Spendenzusage (Ohne Login)",
						"Hallo,".
						"\ndie Spende (ohne Login) wurde bestätigt.".
						"\nSpender: ".$donation->getUser()->getName().
						"\nSpende:  ".$this->getRealDonation($donation).
						"\nLäufer:  ".$donation->getRegistration()->getUser()->getName().
						"\nLauf:    ".$donation->getRegistration()->getRun()->getName()." (".
									  $donation->getRegistration()->getRun()->getEvent()->getName().")".
					  	Tx_EcDonationrun_Utility_MailTexter::getMailGreeting($donation->getRegistration()->getRun()->getEvent()));
				}
				$this->view->assign('confirmStatus', TRUE);
			} else {
				/* TODO Manchmal können die Spenden nicht bestätigt werden evtl + Zeichen??? */
				$this->view->assign('confirmStatus', FALSE);
			}
		}
	}


	/**
		 *
		 * The generate link action. generates a link for
		 * @return void
		 *
		 */
	public function generateNoLoginLinkAction() {
		$formValues = t3lib_div::_GP('tx_ecdonationrun_pi1');
		$registration = $this->registrationRepository->findByUid($formValues['registration']);
		if (!isset($this->settings['donationNoLogin'])) throw new Exception('EC Donationrun: donationNoLogin not set');
		if ($registration == NULL) {
			$this->view->assign('pageUid', $this->settings['donationNoLogin']);
		}
		$this->view->assign('registration', $registration)
		           ->assign('pageUid', $this->settings['donationNoLogin']);
	}



		/*
		 * HELPER METHODS
		 */

		protected function getErrorFlashMessage() {
		    return false;
		}

		/**
		 *
		 * Returns the real Donation as String
		 *
		 * @param Tx_EcDonationrun_Domain_Model_Donation $donation The new donation
		 * @return String
		 */
		protected function getRealDonation(Tx_EcDonationrun_Domain_Model_Donation $donation) {
			if ($donation->getDonationFixValue() == 0) {
				return number_format($donation->getDonationValue(), 2, ',', '.')." Euro pro ".
					Tx_EcDonationrun_ViewHelpers_DistanceFormatViewHelper::render($donation->getRegistration()->getRun()->getDistanceUnit());
			} else {
				return number_format($donation->getDonationFixValue(), 2, ',', '.')." Euro Festbetrag";
			}

		}

		/**
		 *
		 * Gets the currently logged in frontend user.
		 * @return Tx_Extbase_Domain_Model_FrontendUser The currently logged in frontend
		 *                                              user, or NULL if no user is
		 *                                              logged in.
		 *
		 */

	protected function getCurrentFeUser() {
		$userRepository = New Tx_Extbase_Domain_Repository_FrontendUserRepository();
		return intval($GLOBALS['TSFE']->fe_user->user['uid']) > 0
			? $userRepository->findByUid( intval($GLOBALS['TSFE']->fe_user->user['uid']) )
			: NULL;
	}




}

?>
