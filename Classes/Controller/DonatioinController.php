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
	 * actiosn for creating new timesets.
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
	}



		/**
		 *
		 * The index action. This method displays a list of all timesets for a specific
		 * registration.
		 *
		 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The registration for which the timesets are to be
		 *                                                           displayed for.
		 * @return void
		 *
		 */
	Public Function indexAction ( Tx_EcDonationrun_Domain_Model_Registration $registration ) {
		$timesetRepository =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_DonationRepository');
		$this->view->assign('registration' , $registration)
		           ->assign('timesets', $timesetRepository->getDonationsForRegistration($registration));
	}



		/**
		 *
		 * The new action. This method displays a form for creating a new timeset.
		 *
		 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The registration the new timeset is to be assigned to
		 * @param Tx_EcDonationrun_Domain_Model_Donation $timeset The new timeset
		 * @return void
		 * @dontvalidate $timeset
		 *
		 */

	Public Function newAction ( Tx_EcDonationrun_Domain_Model_Registration $registration,
	                            Tx_EcDonationrun_Domain_Model_Donation $timeset=NULL ) {
		$user       = $this->getCurrentFeUser();
		$assignment = $user ? $registration->getAssignmentForUser($user) : NULL;
		If($assignment === NULL) Throw New Tx_EcDonationrun_Domain_Exception_NoRegistrationMemberException();

		$this->view->assign('registration'   , $registration    )
		           ->assign('timeset'   , $timeset    )
		           ->assign('user'      , $user       )
		           ->assign('assignment', $assignment );
	}

		/**
		 *
		 * The create action. Stores a new timeset into the database.
		 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The registration the new timeset is to be assigned to
		 * @param Tx_EcDonationrun_Domain_Model_Donation $timeset The new timeset
		 * @return void
		 *
		 */

	Public Function createAction ( Tx_EcDonationrun_Domain_Model_Registration $registration,
	                               Tx_EcDonationrun_Domain_Model_Donation $timeset ) {

			# Get the user assignment and throw an exception if the current user is not a
			# member of the selected registration.
		$user       = $this->getCurrentFeUser();
		$assignment = $user ? $registration->getAssignmentForUser($user) : NULL;
		If($assignment === NULL) Throw New Tx_EcDonationrun_Domain_Exception_NoRegistrationMemberException();

			# Add the new timeset to the registration assingment. The $assignment property in
			# the timeset object is set automatically.
		$assignment->addDonation($timeset);
		$timeset->getRegistration()->addAssignment($assignment);

			# Since the registration is the aggregate root, update only the registration to save
			# the new timeset.
		$this->registrationRepository->update($timeset->getRegistration());

			# Print a success message and return to the registration detail view.
		$this->flashMessages->add('Zeitbuchung erfolgt.');
		$this->redirect('show', 'Registration', NULL, Array('registration' => $timeset->getRegistration() ));
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
			? $userRepository->findByUid( intval($GLOBALS['TSFE']->fe_user->user['uid']) )
			: NULL;
	}

}

?>