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
 * Registration controller class for the timetracking extension. Provides actions for
 * registration listing, creating and updating registrations and displaying registration details.
 *
 * @author     Hauke Webermann <hauke@webermann.net>
 * @package    EcDonationrun
 * @subpackage Controller
 * @version    $Id$
 * @license    GNU Public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 *
 */

class Tx_EcDonationrun_Controller_RegistrationController extends Tx_EcDonationrun_Controller_AbstractController {

	/*
	 * ATTRIBUTES
	 */

	/**
	 * A registration repository instance
	 * @var Tx_EcDonationrun_Domain_Repository_RegistrationRepository
	 */
	protected $registrationRepository;

	/**
	 * A run repository instance
	 * @var Tx_EcDonationrun_Domain_Repository_RunRepository
	 */
	protected $runRepository;

	/**
	 * A frontend user repository instance
	 * @var Tx_EcAssociation_Domain_Repository_UserRepository
	 */
	protected $userRepository;
	/**
	 * A donation repository instance
	 * @var Tx_EcDonationrun_Domain_Repository_DonationRepository
	 */
	protected $donationRepository;
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
	 * The initialization action. This methods creates instances of all required
	 * repositories.
	 *
	 * @return void
	 *
	 */
	protected function initializeAction() {
		$this->registrationRepository =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_RegistrationRepository');
		$this->donationRepository     =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_DonationRepository');
		$this->runRepository          =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_RunRepository');
		$this->userRepository         =& t3lib_div::makeInstance('Tx_EcAssociation_Domain_Repository_UserRepository');
		$this->frontendUserGroupRepository =& t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserGroupRepository');
	}

	/**
	 *
	 * The index action. Displays a list of all top-level registrations.
	 * @return void
	 *
	 */
	public function indexAction() {
		$registrations = NULL;
		foreach ($this->registrationRepository->findAllActive() as $registration) {
			if ($registration->getUser()->getName() == NULL) {
				continue;
			}
			$registrations[$registration->getRun()->getEvent()->getName()][$registration->getRun()->getName()][] = $registration;
		}
		if (!isset($this->settings['registrationNew'])) throw new Exception('EC Donationrun: EC Donationrun: registrationNew not set');
		if (!isset($this->settings['donationNew'])) throw new Exception('EC Donationrun: EC Donationrun: donationNew not set');
		$this->view->assign('registrations', $registrations)
				   ->assign('registrationNewPageUid', $this->settings['registrationNew'])
				   ->assign('donationNewPageUid', $this->settings['donationNew']);
	}

	/**
	 *
	 * The generateNewLink action. Displays a link to new registration.
	 * @return void
	 *
	 */
	public function generateNewLinkAction() {
		$registrations = NULL;
		foreach ($this->registrationRepository->findAllActive() as $registration) {
			if ($registration->getUser()->getName() == NULL) {
				continue;
			}
			$registrations[$registration->getRun()->getName()][] = $registration;
		}
		if (!isset($this->settings['registrationNew'])) throw new Exception('EC Donationrun: EC Donationrun: registrationNew not set');
		$this->view->assign('pageUid', $this->settings['registrationNew']);
	}

	/**
	 *
	 * The show action. Displays details for a specific registration.
	 *
	 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The registration that is to be displayed.
	 * @return void
	 *
	 */
	public function showAction(Tx_EcDonationrun_Domain_Model_Registration $registration) {
		$this->view->assign('registration', $registration);
	}

	/**
	 *
	 * The new action. Displays a form for creating a new registration.
	 *
	 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The new registration
	 * @return void
	 * @dontvalidate $registration
	 *
	 */
	public function newAction(Tx_EcDonationrun_Domain_Model_Registration $registration=NULL) {
		if ($GLOBALS['TSFE']->loginUser == 0) {
			if (!isset($this->settings['loginPageRunner'])) throw new Exception('EC Donationrun: loginPageRunner not set');
			$this->redirectToUri('index.php?id='.$this->settings['loginPageRunner'].
				'&return_url='.urlencode($GLOBALS['TSFE']->anchorPrefix));
		}
		$runs = NULL;
		/* Get all runs without registration */
		foreach ($this->runRepository->findAllActive() as $run) {
			if (!$run->hasUserRegistration()) {
				$runs[$run->getEvent()->getName()][] = $run;
			}
		}
		// Check if user has all registrations
		if ($runs == NULL) {
			$this->flashMessages->add('Du bist bereits für alle Läufe angemeldet.');
			$this->redirect('index', 'Registration', NULL, NULL, $this->settings['registrationIndex']);
		}
		
		if (!isset($this->settings['donationNew'])) throw new Exception('EC Donationrun: EC Donationrun: donationNew not set');
		$this->view->assign('runs', $runs)
				   ->assign('user', $this->getCurrentFeUser())
				   ->assign('registrationIndexPageUid', $this->settings['registrationIndex']);
	}

	/**
	 *
	 * The create action. This method creates a new registration and stores it into the
	 * database.
	 *
	 * @param Tx_EcDonationrun_Domain_Model_Run $run The new Run
	 * @return void
	 */

	public function createAction(Tx_EcDonationrun_Domain_Model_Run $run) {
		$registration = new Tx_EcDonationrun_Domain_Model_Registration;

		$user = $this->userRepository->findByUid($this->getCurrentFeUser()->getUid());
		$registration->setUser($user);
		if (isset($this->settings['userGroupRunner'])) {
			$userGroup = $this->frontendUserGroupRepository->findByUid($this->settings['userGroupRunner']);
			if ($userGroup) {
				$user->addUsergroup($userGroup);
			}
		}
		$registration->setRun($run);
		$this->registrationRepository->add($registration);

		Tx_EcDonationrun_Utility_SendMail::sendMail(
		array($registration->getUser()->getEmail() => $registration->getUser()->getName()),
			"Anmeldung für einen Lauf",
			"Hallo ".$registration->getUser()->getName().",\n".
			"hiermit bestätigen wir, dass du dich für den ".
		$registration->getRun()->getName()." am ".
		date("d.m.Y", $registration->getRun()->getStart()->getTimestamp()).
			" angemeldet hast.\n".
			"Wir freuen uns sehr, dass du Running for Jesus durch deinen sportlichen Einsatz unterstützt.\n".
			"Im internen Bereich der Homepage bekommst du wertvolle Tipps für dein Training und deine Sponsorensuche. ".
			"Dort hast du auch unter 'Meine Spender' die Möglichkeit, deine Spenderliste zu verwalten.");

		if (isset($this->settings['mail']['adminAddress'])) {
			Tx_EcDonationrun_Utility_SendMail::sendMail(
			array($this->settings['mail']['adminAddress']),
				"Info Registrierung",
				"Hallo,".
				"\nes hat sich ein neuer Läufer angemeldet.".
				"\nLäufer: ".$registration->getUser()->getName().
				"\nLauf:   ".$registration->getRun()->getName());
		}
		$this->flashMessages->add('Du bist für den Lauf "'.$registration->getRun()->getName().'" angemeldet.');
		if (!isset($this->settings['registrationIndex'])) throw new Exception('EC Donationrun: registrationIndex not set');
		$this->redirect('index', 'Registration', NULL, NULL, $this->settings['registrationIndex']);
	}

	/**
	 *
	 * The edit action. This method displays a form for editing existing registrations.
	 *
	 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The registration
	 * @return void
	 * @dontvalidate $registration
	 *
	 */
	public function editAction( Tx_EcDonationrun_Domain_Model_Registration $registration) {
		$this->view->assign('registration' , $registration)
				   ->assign('registrations', array_merge(array(NULL), $this->registrationRepository->findAll()))
				   ->assign('users', $this->userRepository->findAll())
				   ->assign('runs', $this->runRepository->findAll());
	}



	/**
	 *
	 * The update action. Updates an existing registration in the database.
	 *
	 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The registration
	 * @param array $assignments                                 An array of users and runs that are to be assigned to this registration.
	 * @return void
	 * @dontverifyrequesthash
	 *
	 */
	public function updateAction( Tx_EcDonationrun_Domain_Model_Registration $registration, $assignments) {
		$registration->removeAllAssignments();
		ForEach($assignments As $userId => $runId) {
			if ($runId == 0) Continue;
			$registration->assignUser($this->userRepository->findByUid((int)$userId),
			$this->runRepository->findByUid((int)$runId));
		}
		$this->registrationRepository->update($registration);
		$this->flashMessages->add("Das Projekt {$registration->getName()} wurde erfolgreich bearbeitet.");

		$this->redirect('show', NULL, NULL, array('registration' => $registration));
	}

	/**
	 *
	 * The delete action. Deletes an existing registration from the database.
	 *
	 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The registration that is to be deleted
	 * @return void
	 *
	 */
	public function deleteAction( Tx_EcDonationrun_Domain_Model_Registration $registration) {
		$this->registrationRepository->remove($registration);
		$this->flashMessages->add("Das Projekt {$registration->getName()} wurde erfolgreich gelöscht.");

		$this->redirect('index');
	}

	/**
	 * The ranking helper
	 * @return array
	 * */
	static public function getRankingRunner($registrations) {
		$ranking = array();
		foreach ($registrations as $registration) {
			$ranking[] = $registration;
		}
		usort($ranking,'cmpDonationAmount');
		return $ranking;
	}

	/**
	 * The ranking action
	 * @return void
	 */
	public function showRankingRunnerAction() {
		$registrations = $this->registrationRepository->findAllActive();
		$ranking = $this->getRankingRunner($registrations);
		array_splice($ranking,5);
		if (!isset($this->settings['donationNew'])) throw new Exception('EC Donationrun: EC Donationrun: donationNew not set');
		$this->view->assign('registrations', $ranking)
				   ->assign('donationNewPageUid', $this->settings['donationNew']);
	}

	/**
	 * The ranking action
	 * @return void
	 */
	public function showRankingKvAction() {

	}

	/**
	 * The donation global amount action
	 * @return void
	 */
	public function showDonationAmountAction() {
		$registrations = $this->registrationRepository->findAllActive();
		$amount = 0.0;
		foreach ($registrations as $registration) {
			$amount += $registration->getDonationAmount();
		}
		$this->view->assign('amount', $amount);
	}

	/*
	 * HELPER METHODS
	 */
	/**
	 * Gets the currently logged in frontend user.
	 * @return Tx_Extbase_Domain_Model_FrontendUser The currently logged in frontend
	 *                                              user, or NULL if no user is
	 *                                              logged in.
	 */

	protected function getCurrentFeUser() {
		$userRepository = New Tx_Extbase_Domain_Repository_FrontendUserRepository();
		return intval($GLOBALS['TSFE']->fe_user->user['uid']) > 0
			? $userRepository->findByUid( intval($GLOBALS['TSFE']->fe_user->user['uid']))
			: NULL;
	}

}
/* Compare function for Ranking */
function cmpDonationAmount($a, $b) {
	if ($a->getDonationAmount() == $b->getDonationAmount()) {
		return 0;
	}
	return ($a->getDonationAmount() < $b->getDonationAmount()) ? 1 : -1;
}


?>
