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
	 * The class for the project domain model. The project class models the project
	 * object, that is characterized by a name attribute and a start and end date. Each
	 * project may have an infinite number of sub-projects.
	 *
	 * @author     Hauke Webermann <hauke@webermann.net>
	 * @package    EcDonationrun
	 * @subpackage Domain_Model
	 * @version    $Id$
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 * @entity
	 *
	 */

Class Tx_EcDonationrun_Domain_Model_Registration Extends Tx_Extbase_DomainObject_AbstractEntity {

		/*
		 * ATTRIBUTES
		 */

		/**
		 * The run.
		 * @var Tx_EcDonationrun_Domain_Model_Run
		 * @lazy
		 */
	Protected $run=NULL;
	
		/**
		 * The runner of this registraion.
		 * @var Tx_Extbase_Domain_Model_FrontendUser
		 * @lazy
		 */
	Protected $user;

		/**
		 * The runner number.
		 * @var string
		 */
	Protected $runnerNumber;

		/**
		 * The runner time.
		 * @var integer
		 */
	Protected $runnerTime;
	
		/**
		 * A list of all donations that are assigned to this registration
		 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Donation>
		 * @lazy
		 */
	Protected $donations = NULL;

		/*
		 * CONSTRUCTORS
		 */





		 /**
		  *
		  * Creates a new project.
		  *
		  */

	Public Function __construct() {
		$this->donations = New Tx_Extbase_Persistence_ObjectStorage();
	}


		/*
		 * GETTERS
		 */

		 /**
		  *
		  * Gets the run
		  * @return Tx_EcDonationrun_Domain_Model_Run The run
		  *
		  */

	Public Function getRun() {
		Return $this->run;
	}
	
		 /**
		  *
		  * Gets the runner
		  * @return Tx_Extbase_Domain_Model_FrontendUser The runner
		  *
		  */

	Public Function getUser() {
		Return $this->user;
	}
	
	 	/**
		  *
		  * Gets the name
		  * @return string The runners name
		  *
		  */

	Public Function getName() {
		Return $this->getUser()->getName();
	}

		/**
		 *
		 * Gets the runner number.
		 * @return string The runner number
		 *
		 */

	Public Function getRunnerNumber() {
		Return $this->runnerNumber;
	}

		/**
		 *
		 * Gets the runner time.
		 * @return timesec The runner time
		 *
		 */

	Public Function getRunnerTime() {
		Return $this->runnerTime;
	}

		/**
		 *
		 * Gets the edit date.
		 * @return DateTime The edit date
		 *
		 */

	Public Function getEditDate() {
		Return $this->tstamp;
	}

		/**
		 *
		 * Gets all donations for this registration.
		 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Donation>
		 *
		 */

	Public Function getDonations() {
		Return $this->donations;
	}



		/**
		 *
		 * Gets the total amount of this registration. This methods
		 * accumulates the donation amount to this registration.
		 *
		 * @return double The total amount of donation of this registration
		 *
		 */

	Public Function getDonation() {
		$amount = 0.0;
		/*
		ForEach($this->getDonations() As $donation)
			$amount += $donation->getDonationValue();
			*/
		Return $amount;
	}


		/*
		 * SETTERS
		 */
		/**
		  *
		  * Sets the run.
		  * @param Tx_EcDonationrun_Domain_Model_Run $run The run
		  * @return void
		  *
		  */

	Public Function setRun(Tx_EcDonationrun_Domain_Model_Run $run) {
		$this->run = $run;
	}
		/**
		  *
		  * Sets the user.
		  * @param Tx_Extbase_Domain_Model_FrontendUser $user The user
		  * @return void
		  *
		  */

	Public Function setUser(Tx_Extbase_Domain_Model_FrontendUser $user) {
		$this->user = $user;
	}

		/**
		 *
		 * Sets the start number.
		 * @param string $runnerNumber The start number
		 * @return void
		 *
		 */

	Public Function setRunnerNumber($runnerNumber) {
		$this->runnerNumber = $runnerNumber;
	}

		/**
		 *
		 * Sets the runners time.
		 * @param timesec $runnerTime The runners time
		 * @return void
		 *
		 */

	Public Function setRunnerTime($runnerTime) {
		$this->runnerTime = $runnerTime;
	}
	
	
	/**
	 * Load title for TCA label_userFunc
	 *
	 */
	
	public function getLabel(&$parameters, $parentObject) {
		$registration = t3lib_BEfunc::getRecord($parameters['table'], $parameters['row']['uid']);
        $run = t3lib_BEfunc::getRecord("tx_ecdonationrun_domain_model_run", $registration['run']);
        $user = t3lib_BEfunc::getRecord("fe_users", $registration['user']);
        
        $parameters['title'] = $user['first_name'].' '.$user['last_name'].' @ '.$run['name'];
	}
	
}

?>
