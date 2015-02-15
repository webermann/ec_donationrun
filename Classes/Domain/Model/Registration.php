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

class Tx_EcDonationrun_Domain_Model_Registration extends Tx_Extbase_DomainObject_AbstractEntity {

	/*
	 * ATTRIBUTES
	 */

	/**
	 * The run.
	 * @var Tx_EcDonationrun_Domain_Model_Run
	 * @lazy
	 */
	protected $run=NULL;

	/**
	 * The runner of this registraion.
	 * @var Tx_EcAssociation_Domain_Model_User
	 * @lazy
	 */
	protected $user;
	/**
	 * The run status.
	 * @var int
	 */
	protected $runStatus;
	/**
	 * The runner number.
	 * @var string
	 */
	protected $runnerNumber;

	/**
	 * The runner time.
	 * @var integer
	 */
	protected $runnerTime;

	/**
	 * A list of all donations that are assigned to this run
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Donation>
	 * @lazy
	 */
	protected $donations = NULL;


	/*
	 * CONSTRUCTORS
	 */





	/**
	 *
	 * Creates a new project.
	 *
	 */

	public function __construct() {
		$this->donations = new Tx_Extbase_Persistence_ObjectStorage();
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

	public function getRun() {
		return $this->run;
	}

	/**
	 *
	 * Gets the runner
	 * @return Tx_EcAssociation_Domain_Model_User The runner
	 *
	 */

	public function getUser() {
		return $this->user;
	}

	/**
	 *
	 * Gets the name
	 * @return string The runners name
	 *
	 */

	public function getName() {
		return $this->getUser()->getName();
	}

	/**
	 * Gets the run status.
	 * @return int
	 */

	public function getRunStatus() {
		return $this->runStatus;
	}

	/**
	 * Gets the runner number.
	 * @return string The runner number
	 *
	 */

	public function getRunnerNumber() {
		return $this->runnerNumber;
	}

	/**
	 *
	 * Gets the runner time.
	 * @return timesec The runner time
	 *
	 */

	public function getRunnerTime() {
		return $this->runnerTime;
	}

	/**
	 *
	 * Gets the edit date.
	 * @return DateTime The edit date
	 *
	 */

	public function getEditDate() {
		return $this->tstamp;
	}

	/**
	 *
	 * Gets all donations for this registration.
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Donation>
	 *
	 */
	public function getDonations() {
		return $this->donations;
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
	public function setRun(Tx_EcDonationrun_Domain_Model_Run $run) {
		$this->run = $run;
	}
	
	/**
	 *
	 * Sets the user.
	 * @param Tx_EcAssociation_Domain_Model_User $user The user
	 * @return void
	 *
	 */
	public function setUser(Tx_EcAssociation_Domain_Model_User $user) {
		$this->user = $user;
	}

	/**
	 *
	 * Sets the run status
	 * @param int $value
	 * @return void
	 *
	 */

	public function setRunStatus($value) {
		$this->runStatus = $value;
	}
	
	/**
	 *
	 * Sets the start number.
	 * @param string $runnerNumber The start number
	 * @return void
	 *
	 */

	public function setRunnerNumber($runnerNumber) {
		$this->runnerNumber = $runnerNumber;
	}

	/**
	 *
	 * Sets the runners time.
	 * @param timesec $runnerTime The runners time
	 * @return void
	 *
	 */

	public function setRunnerTime($runnerTime) {
		$this->runnerTime = $runnerTime;
	}

	/**
	 *
	 * Is login user equal registration user.
	 * @return boolan
	 *
	 */

	public function isCurrentFeUserEqualUser() {
		if (intval($GLOBALS['TSFE']->fe_user->user['uid']) < 0) {
			return false;
		}
		if (intval($GLOBALS['TSFE']->fe_user->user['uid']) == $this->getUser()->getUid()) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 *
	 * Gets the total amount of this registration. This methods
	 * accumulates the donation amount to this registration.
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Donation>
	 * @return double The total amount of donation of this registration
	 *
	 */

	public function getDonationAmount() {
		$amount = 0.0;

		foreach ($this->getDonations() as $donation) {
			if ($donation->getDonationFixValue() == 0) {
				$amount += $donation->getDonationValue() * $donation->getRegistration()->getRun()->getDistance();
			} else {
				$amount += $donation->getDonationFixValue();
			}
		}

		return $amount;
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
