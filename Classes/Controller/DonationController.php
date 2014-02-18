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

Class Tx_EcDonationrun_Controller_DonationController Extends Tx_EcDonationrun_Controller_AbstractController {

		/*
		 * ATTRIBUTES
		 */

		/**
		 * A registration repository instance
		 * @var Tx_EcDonationrun_Domain_Repository_RegistrationRepository
		 */
	Protected $registrationRepository;
		
		/**
		 * A donation repository instance
		 * @var Tx_EcDonationrun_Domain_Repository_DonationRepository
		 */
	Protected $donationRepository;
		
	/**
     * A FE User repository instance
     * @var Tx_Extbase_Domain_Repository_FrontendUserRepository
     */
    protected $frontendUserRepository;
    /**
     * A FE User Group repository instance
     * @var Tx_Extbase_Domain_Model_FrontendUserGroup
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

	Public Function initializeAction() {
		$this->registrationRepository =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_RegistrationRepository');
		$this->donationRepository =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_DonationRepository');
		$this->frontendUserRepository =& t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserRepository');
		$this->frontendUserGroupRepository =& t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserGroupRepository');
	}



		/**
		 *
		 * The index action. This method displays a list of all donations for a specific
		 * registration.
		 *
		 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The registration for which the donations are to be
		 *                                                           displayed for.
		 * @return void
		 * @dontvalidate $registration
		 */
	Public Function indexAction ( Tx_EcDonationrun_Domain_Model_Registration $registration = NULL) {
		// Check parameter and if null registration load from current user
		if ($registration == NULL) {
			$registrations = $this->registrationRepository->findRegistrationsFromUser($this->getCurrentFeUser());
			$registration = $registrations->getFirst();
			if ($registration == NULL) {
				$this->flashMessages->add('Bitte erst für einen Lauf anmelden.');
				$this->redirect('index', 'Registration', 'ecdonationrun', NULL, $this->settings['registrationIndex']);
			}
		}
		$donations = $this->donationRepository->findDonationsFromRegistration($registration);
		$this->view->assign('registration' , $registration)
				   ->assign('donations', $donations)
				   ->assign('donation_amount', Tx_EcDonationrun_Domain_Model_Registration::getDonationAmount($donations));
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

	Public Function newAction ( Tx_EcDonationrun_Domain_Model_Registration $registration,
	                            Tx_EcDonationrun_Domain_Model_Donation $donation=NULL) {
		if ($GLOBALS['TSFE']->loginUser == 0) {
			if (isset($this->settings['loginPageDonator'])) {
				$this->redirectToUri('index.php?id='.$this->settings['loginPageDonator'].
					'&tx_ecdonationrun_pi1[registration]='.$registration->getUid().
					'&return_url='.urlencode($GLOBALS['TSFE']->anchorPrefix));
			} else {
				$this->redirectToUri('index.php');
			}
		}
		
		$this->view->assign('registration', $registration)
		           ->assign('donation', $donation)
		           ->assign('user', $this->getCurrentFeUser())
		           ->assign('isOwnRegistration', $registration->isCurrentFeUserEqualUser());
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

	Public Function newOfflineAction(Tx_EcDonationrun_Domain_Model_Registration $registration,
	                                 Tx_EcDonationrun_Domain_Model_Donation $donation=NULL) {
		if ($GLOBALS['TSFE']->loginUser != 0) {
			// TODO
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
		 * @dontvalidate $isOffline
		 */

	Public Function createAction(Tx_EcDonationrun_Domain_Model_Registration $registration,
	                             Tx_EcDonationrun_Domain_Model_Donation $donation,
	                             $isOffline = '') {
        
	    if ($isOffline == 'isOffline' || $registration->isCurrentFeUserEqualUser()) {
	    	$isOfflineDonation = true;
			$user = $donation->getUser();
		    $user->setName($user->getFirstName().' '.$user->getLastName());
		    $user->setUsername($user->getName().'-anonymous');
		    $user->setPassword('NO_PASSWORT_SET_'.mt_rand());
		    if (isset($this->settings['pidOfflineUser'])) {
	    		$user->setPid($this->settings['pidOfflineUser']);
		    } else {
		    	$user->setPid($registration->getUser()->getPid());
		    }
	    } else {
	    	$isOfflineDonation = false;
	    	$user = $this->getCurrentFeUser();
	    }
	    if (isset($this->settings['userGroupDonator'])) {
	    	$userGroup = $this->frontendUserGroupRepository->findByUid($this->settings['userGroupDonator']);
	    	if ($userGroup) {
				$user->addUsergroup($userGroup);
	    	}
		}
        if ($user->_isNew()) {
			$this->frontendUserRepository->add($user);
		}
		$donation->setRegistration($registration);
		$donation->setUser($user);
		
		if ($isOffline == 'isOffline') {
			$donation->
			$this->donationRepository->add($donation);
			
			Tx_EcDonationrun_Utility_SendMail::sendMail(
				// TODO Set Admin Address
				array('hauke@webermann.net'=>'Hauke Webermann'),
				"Info Spendenzusage (Ohne Login)",
				"Hallo,".
				"\nes ist eine neue Spende (ohne Login) eingegangen.".
				"\nSpender: ".$donation->getUser()->getName().
				"\nSpende:  ".$this->getRealDonation($donation).
				"\nLäufer:  ".$donation->getRegistration()->getUser()->getName().
				"\nLauf:    ".$donation->getRegistration()->getRun()->getName());
			
			// TODO Send Mail
			
			$confirmLink = $this->controllerContext->getUriBuilder()->buildFrontendUri('confirm','Donation',$donation);
			
			debug($this->settings['cryptKey']);
			
			$key = hash('sha256', $this->settings['cryptKey'], true);
			$key_size =  strlen($key);
			
   			debug("Key size: " . $key_size);
   			
   			
			if (!defined('MCRYPT_RIJNDAEL_128')) throw new Exception('The MCRYPT_RIJNDAEL_128 algorithm is required (PHP 5.3).');
			
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    		
    		debug($iv);
			
			$ciphertext =  mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, "Hallo dies ist ein Test",MCRYPT_MODE_CBC, $iv);
			$ciphertext = $iv.$ciphertext;
			$ciphertext_base64 = base64_encode($ciphertext);
			debug($ciphertext_base64);
			
			$ciphertext_dec = base64_decode($ciphertext_base64);
			$iv_dec = substr($ciphertext_dec, 0, $iv_size);
			$ciphertext_dec = substr($ciphertext_dec, $iv_size);
			
			$plaintext = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec,MCRYPT_MODE_CBC, $iv_dec);
			debug($plaintext);
			
			debug($confirmLink);
			$message = "Hallo " .$user->getName().",\n".
				"bitte bestätige deine Spende über ".
			
				"für den Lauf von ".$donation->getRegistration()->getUser()->getName()." über foldenden Link\n\n".
				$confirmLink
				."\n\nVielen Dank\Running for Jesus";
			
			Tx_EcDonationrun_Utility_SendMail::sendMail(
				array($donation->getUser()->getEmail() => $donation->getUser()->getName()),
				"Spendenzusage",
				"Hallo ".$donation->getUser()->getName().",\n".
				
				"herzlichen Dank für deine Spendenzusage bei Running for Jesus in Höhe von ".$this->getRealDonation($donation)." .\n".
				$donation->getRegistration()->getUser()->getName()." läuft/skatet/walkt am ".
				date("d.m.Y", $donation->getRegistration()->getRun()->getStart()->getTimestamp())." ".
				$donation->getRegistration()->getRun()->getDistance()." km für ".
				"die sozial-diakonischen Stadtteilarbeit 'Die PLiNKe' in Hannover und den niedersächsischen EC-Jugendverband.\n\n".
				"Bitte klicke folgenden Link, um Deine Spendenzusage zu bestätigen:\n".$confirmLink.
				"\n\nNach Running for Jesus bekommst du eine Mail mit allen wichtigen Infos zur Spendenabwicklung!");

			$this->flashMessages->add('Vielen Dank für deine Spende. Du bekommst eine E-Mail mit der du deine Spende noch bestätigen musst.');
return;
//TODO
			if (isset($this->settings['registrationIndex'])) {
				$this->redirectToUri('index.php?id='.$this->settings['registrationIndex']);
			} else {
				$this->redirectToUri('index.php');
			}
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
				$donation->getRegistration()->getRun()->getDistance()." km für ".
				"die sozial-diakonischen Stadtteilarbeit 'Die PLiNKe' in Hannover und den niedersächsischen EC-Jugendverband.\n".
				"Nach Running for Jesus bekommst du eine Mail mit allen wichtigen Infos zur Spendenabwicklung!");
		}
			
		Tx_EcDonationrun_Utility_SendMail::sendMail(
			array($donation->getRegistration()->getUser()->getEmail() => $donation->getRegistration()->getUser()->getName()),
			"Info Spendenzusage",
			"Hallo ".$donation->getRegistration()->getUser()->getName().",\n".
			$donation->getUser()->getName(). " wird dich bei Running for Jesus mit ".
			$this->getRealDonation($donation)." unterstützen.");
		
		Tx_EcDonationrun_Utility_SendMail::sendMail(
			// TODO Set Admin Address
			array('hauke@webermann.net'=>'Hauke Webermann'),
			"Info Spendenzusage",
			"Hallo,".
			"\nes ist eine neue Spende eingegangen.".
			"\nSpender: ".$donation->getUser()->getName().
			"\nSpende:  ".$this->getRealDonation($donation).
			"\nLäufer:  ".$donation->getRegistration()->getUser()->getName().
			"\nLauf:    ".$donation->getRegistration()->getRun()->getName());
		
		// Print a success message and return to the registration detail view.
		$this->flashMessages->add('Spende gespeichert.');
		if ($isOfflineDonation) {
			$this->redirect('index', 'Donation');
		} else {
			$this->redirect('index', 'Registration');
		}
		
	}
	
	/**
		 *
		 * The create offline finish action.
		 * @return void
		 *
		 */
	Public Function confirmAction() {
		
		
		debug($_GET);
		
		
		
		
		$this->view->assign('donation', $donation);
	}
	
	
	/**
		 *
		 * The generate link action. generates a link for
		 * @return void
		 *
		 */
	Public Function generateOfflineDonationLinkAction() {
		$formValues = t3lib_div::_GP('tx_ecdonationrun_pi1');
		$registration = $this->registrationRepository->findByUid($formValues['registration']);
		$this->view->assign('registration', $registration)
		           ->assign('pageUid', $this->settings['registerOffline']);
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
				return number_format($donation->getDonationValue(), 2, ',', '.')." Euro pro km";
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

	Protected Function getCurrentFeUser() {
		$userRepository = New Tx_Extbase_Domain_Repository_FrontendUserRepository();
		Return intval($GLOBALS['TSFE']->fe_user->user['uid']) > 0
			? $userRepository->findByUid( intval($GLOBALS['TSFE']->fe_user->user['uid']) )
			: NULL;
	}
	

	

}

?>
