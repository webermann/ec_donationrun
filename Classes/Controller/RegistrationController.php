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

Class Tx_EcDonationrun_Controller_RegistrationController Extends Tx_EcDonationrun_Controller_AbstractController {

		/*
		 * ATTRIBUTES
		 */

		/**
		 * A registration repository instance
		 * @var Tx_EcDonationrun_Domain_Repository_RegistrationRepository
		 */
	Protected $registrationRepository;

		/**
		 * A run repository instance
		 * @var Tx_EcDonationrun_Domain_Repository_RunRepository
		 */
	Protected $runRepository;

		/**
		 * A frontend user repository instance
		 * @var Tx_Extbase_Domain_Repository_FrontendUserRepository
		 */
	Protected $userRepository;
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
		 * The initialization action. This methods creates instances of all required
		 * repositories.
		 *
		 * @return void
		 *
		 */

	Protected Function initializeAction() {
		$this->registrationRepository =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_RegistrationRepository');
		$this->runRepository     =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_RunRepository');
		$this->userRepository    =& t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserRepository');
		$this->frontendUserGroupRepository =& t3lib_div::makeInstance('Tx_Extbase_Domain_Repository_FrontendUserGroupRepository');
	}



		/**
		 *
		 * The index action. Displays a list of all top-level registrations.
		 * @return void
		 *
		 */

	Public Function indexAction() {
		$registrations = NULL;
		$userHasNoRegistration = true;
		foreach ($this->registrationRepository->findAll() as $registration) {
			if ($registration->getRun()->getStart()->getTimestamp() < time()) {
				continue;
			}
			if ($registration->getUser()->getName() == NULL) {
				continue;
			}
			$registrations[$registration->getRun()->getName()][] = $registration;
			if ($registration->isCurrentFeUserEqualUser()) {
				$userHasNoRegistration = false;
			}
		}
		$this->view->assign('registrations', $registrations);
		$this->view->assign('userHasNoRegistration', $userHasNoRegistration);
	}

		/**
		 *
		 * The generateNewLink action. Displays a link to new registration.
		 * @return void
		 *
		 */

	Public Function generateNewLinkAction() {
		$registrations = NULL;
		$userHasNoRegistration = true;
		foreach ($this->registrationRepository->findAll() as $registration) {
			if ($registration->getRun()->getStart()->getTimestamp() < time()) {
				continue;
			}
			if ($registration->getUser()->getName() == NULL) {
				continue;
			}
			$registrations[$registration->getRun()->getName()][] = $registration;
			if ($registration->isCurrentFeUserEqualUser()) {
				$userHasNoRegistration = false;
			}
		}
		$this->view->assign('userHasNoRegistration', $userHasNoRegistration)
				   ->assign('pageUid', $this->settings['registrationIndex']);
	}

		/**
		 *
		 * The show action. Displays details for a specific registration.
		 *
		 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The registration that is to be displayed.
		 * @return void
		 *
		 */

	Public Function showAction(Tx_EcDonationrun_Domain_Model_Registration $registration) {
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

	Public Function newAction(Tx_EcDonationrun_Domain_Model_Registration $registration=NULL) {
		if ($GLOBALS['TSFE']->loginUser == 0) {
			if (isset($this->settings['loginPageRunner'])) {
				$this->redirectToUri('index.php?id='.$this->settings['loginPageRunner'].'&return_url='.urlencode($GLOBALS['TSFE']->anchorPrefix));
			} else {
				$this->redirectToUri('index.php');
			}
		}
		$this->view->assign('runs', $this->runRepository->findAll())
				   ->assign('user', $this->getCurrentFeUser());
	}



		/**
		 *
		 * The create action. This method creates a new registration and stores it into the
		 * database.
		 *
		 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The new Registration
		 * @return void
		 */

	Public Function createAction(Tx_EcDonationrun_Domain_Model_Registration $registration) {
		$user = $this->getCurrentFeUser();
		$registration->setUser($user);
		if (isset($this->settings['userGroupRunner'])) {
			$userGroup = $this->frontendUserGroupRepository->findByUid($this->settings['userGroupRunner']);
	    	if ($userGroup) {
				$user->addUsergroup($userGroup);
	    	}
		}
		
		$this->registrationRepository->add($registration);
		$this->flashMessages->add('Du bist für den Lauf "'.$registration->getRun()->getName().'" angemeldet.');

		$this->redirect('index', 'Registration');
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

	Public Function editAction( Tx_EcDonationrun_Domain_Model_Registration $registration) {
		$this->view->assign('registration' , $registration)
		           ->assign('registrations', array_merge(Array(NULL), $this->registrationRepository->findAll()))
		           ->assign('users'   , $this->userRepository->findAll())
		           ->assign('runs'   , $this->runRepository->findAll());
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

	Public Function updateAction( Tx_EcDonationrun_Domain_Model_Registration $registration, $assignments) {
		$registration->removeAllAssignments();
		ForEach($assignments As $userId => $runId) {
			If($runId == 0) Continue;
			$registration->assignUser($this->userRepository->findByUid((int)$userId),
			                       $this->runRepository->findByUid((int)$runId));
		}
		$this->registrationRepository->update($registration);
		$this->flashMessages->add("Das Projekt {$registration->getName()} wurde erfolgreich bearbeitet.");

		$this->redirect('show', NULL, NULL, Array('registration' => $registration));
	}



		/**
		 *
		 * The delete action. Deletes an existing registration from the database.
		 *
		 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The registration that is to be deleted
		 * @return void
		 *
		 */

	Public Function deleteAction( Tx_EcDonationrun_Domain_Model_Registration $registration) {
		$this->registrationRepository->remove($registration);
		$this->flashMessages->add("Das Projekt {$registration->getName()} wurde erfolgreich gelöscht.");

		$this->redirect('index');
	}
		
		/*
		 * HELPER METHODS
		 */
	
	
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
			? $userRepository->findByUid( intval($GLOBALS['TSFE']->fe_user->user['uid']))
			: NULL;
	}
	
}

?>
