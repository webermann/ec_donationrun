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
	 * The class for the timeset domain model. Models a single timeset with a start and a
	 * stop time. Each timeset is associated with an assignment.
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

Class Tx_EcDonationrun_Domain_Model_Donation Extends Tx_Extbase_DomainObject_AbstractEntity {

		/*
		 * ATTRIBUTES
	donationValue float unsigned DEFAULT '0' NOT NULL,
	donatioinMaxValue float unsigned DEFAULT '0',
	isPaid tinyint(4) unsigned DEFAULT '0',
		 */

		/**
		 * The registration
		 * @var Tx_EcDonationrun_Domain_Model_Registration
		 * @lazy
		 */
	Protected $registration;
	
		/**
		 * The user of this assignment.
		 * @var Tx_Extbase_Domain_Model_FrontendUser
		 * @lazy
		 */
	Protected $user;
	

		/**
		 * The value of this donation
		 * @var float
		 * @validate NotEmpty
		 */
	Protected $donationValue;

		/**
		 * The maximum value of this donation
		 * @var float
		 */
	Protected $donationMaxValue;

		/**
		 * A informaiton if the donator has paid the donatoin
		 * @var boolean
		 */
	Protected $isPaid;

		/*
		 * GETTERS
		 */

		 /**
		  *
		  * Gets the registration
		  * @return Tx_EcDonationrun_Domain_Model_Registration The registration
		  *
		  */

	Public Function getRegistration() {
		Return $this->registration;
	}

		/**
		 *
		 * Gets the donator
		 * @return Tx_Extbase_Domain_Model_FrontendUser The donator
		 *
		 */

	Public Function getUser() {
		Return $this->user;
	}

		/**
		 *
		 * Gets the runner
		 * @return Tx_Extbase_Domain_Model_FrontendUser The runner
		 *
		 */

	Public Function getRunner() {
		Return $this->getRegistration()->getUser();
	}

		/**
		 *
		 * Gets the donation value
		 * @return float The donatoin value
		 *
		 */

	Public Function getDonationValue() {
		Return $this->donationValue;
	}

		/**
		 *
		 * Gets the donation max value
		 * @return float The max value
		 *
		 */

	Public Function getDonationMaxValue() {
		Return $this->donationMaxValue;
	}
	
		/**
		 *
		 * Gets is paid
		 * @return boolean Is paid
		 *
		 */

	Public Function getIsPaid() {
		Return $this->isPaid;
	}

		/*
		 * SETTERS
		 */

		 /**
		  *
		  * Sets the registration of this donation.
		  * @param Tx_EcDonationrun_Domain_Model_Registration $registration The assignment
		  * @return void
		  *
		  */

	Public Function setRegistration(Tx_EcDonationrun_Domain_Model_Registration $registration) {
		$this->registration = $registration;
	}

		/**
		 *
		 * Sets the donator of this donation.
		 * @param Tx_Extbase_Domain_Model_FrontendUser $user The start time
		 * @return void
		 *
		 */

	Public Function setUser(Tx_Extbase_Domain_Model_FrontendUser $user) {
		$this->user = $user;
	}

	/**
		 *
		 * Sets the maximum value of this donation.
		 * @param float $value The max donatoin value
		 * @return void
		 *
		 */

	Public Function setDonationMaxValue($value) {
		$this->donationMaxValue = $value;
	}
		
		/**
		 *
		 * Sets value of this donation.
		 * @param float $value The donatoin value
		 * @return void
		 *
		 */

	Public Function setDonationValue($value) {
		$this->donationValue = $value;
	}
		
		/**
		 *
		 * Sets the is paid flag.
		 * @param boolean $isPaid The is paid flag
		 * @return void
		 *
		 */

	Public Function setIsPaid($isPaid) {
		$this->isPaid = $isPaid;
	}

}

?>
