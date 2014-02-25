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
	 * An assignment. Models an association between users, projects and roles.
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

Class Tx_EcDonationrun_Domain_Model_Run Extends Tx_Extbase_DomainObject_AbstractEntity {

		/*
		 * ATTRIBUTES
		 */
	
		/**
		 * The project name
		 * @var string
		 * @validate StringLength(minimum = 3, maximum = 255)
		 */
	Protected $name;

		/**
		 * The start time.
		 * @var DateTime
		 */
	Protected $start;
	
		/**
		 * The run distance.
		 * @var double
		 */
	Protected $distance;
	
		/**
		 * A list of all registrations that are assigned to this run
		 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Registration>
		 * @lazy
		 */
	Protected $registrations = NULL;
	
		/**
		 * A list of all donations that are assigned to this run
		 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Donation>
		 * @lazy
		 */
	Protected $donations = NULL;


		/*
		 * CONSTRUCTOR
		 */


		 /**
		  *
		  * Creates a new run. All arguments are optional, since every model class
		  * has to implement an empty constructor.
		  *
		  *
		  */

	Public Function __construct () {

	}

		/*
		 * GETTERS
		 */

		 /**
		  *
		  * Gets the run name
		  * @return string The run name
		  *
		  */
	Public Function getName() {
		Return $this->name;
	}

		 /**
		  *
		  * Gets the run start time
		  * @return DateTime The run start time
		  *
		  */
	Public Function getStart() {
		Return $this->start;
	}
	
		 /**
		  *
		  * Gets the run distance
		  * @return double The run distance
		  *
		  */
	Public Function getDistance() {
		Return $this->distance;
	}
	
		/**
		 *
		 * Gets all registrations for this run.
		 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Registration> All registrations
		 *
		 */

	Public Function getRegistrations() {
		If($this->registrations === NULL) {
			$this->registrations = New Tx_Extbase_Persistence_ObjectStorage();
		}
		Return $this->registrations;
	}

		/**
		 *
		 * Gets all donations for this run.
		 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Donation> All donations
		 *
		 */
	Public Function getDonations() {
		If($this->donations === NULL) {
			$this->donations = New Tx_Extbase_Persistence_ObjectStorage();
			ForEach($this->getRegistrations() As $registration)
				$this->donations->addAll($registration->getDonations());
		}
		Return $this->donations;
	}
	
		/**
		 *
		 * Gets the edit date.
		 * @return DateTime The edit date
		 *
		 */

	Public Function getEditDate() { Return $this->tstamp; }


		/*
		 * SETTERS
		 */
		 /**
		  *
		  * Sets the run name
		  * @param string $name The run name
		  * @return void
		  *
		  */

	Public Function setName($name) {
		$this->name = $name;
	}

		/**
		 *
		 * Sets the start date.
		 * @param DateTime $start The start date
		 * @return void
		 *
		 */

	Public Function setStart(DateTime $start) {
		$this->start = $start;
	}
	
		/**
		 *
		 * Sets the distance.
		 * @param double $distance The run distance
		 * @return void
		 *
		 */

	Public Function setDistance(DateTime $distance) {
		$this->distance = $distance;
	}
	
}

?>
