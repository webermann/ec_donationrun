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
	 * A run.
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

class Tx_EcDonationrun_Domain_Model_Run extends Tx_Extbase_DomainObject_AbstractEntity {

		/*
		 * ATTRIBUTES
		 */
	
		/**
		 * The run name
		 * @var string
		 * @validate StringLength(minimum = 3, maximum = 255)
		 */
	protected $name;

		/**
		 * The start time.
		 * @var DateTime
		 */
	protected $start;
	
		/**
		 * The run distance.
		 * @var double
		 */
	protected $distance;
	
	/**
	 * The event
	 * @var Tx_EcDonationrun_Domain_Model_Event
	 * @lazy
	 */
	protected $event=NULL;
	
		/**
		 * A list of all registrations that are assigned to this run
		 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Registration>
		 * @lazy
		 */
	protected $registrations = NULL;
	
		/**
		 * A list of all donations that are assigned to this run
		 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Donation>
		 * @lazy
		 */
	protected $donations = NULL;


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

	public function __construct () {

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
	public function getName() {
		return $this->name;
	}

		 /**
		  *
		  * Gets the run start time
		  * @return DateTime The run start time
		  *
		  */
	public function getStart() {
		return $this->start;
	}
	
		 /**
		  *
		  * Gets the run distance
		  * @return double The run distance
		  *
		  */
	public function getDistance() {
		return $this->distance;
	}
	/**
	 *
	 * Gets the event
	 * @return Tx_EcDonationrun_Domain_Model_Event
	 *
	 */
	public function getEvent() {
		return $this->event;
	}
		/**
		 *
		 * Gets all registrations for this run.
		 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Registration> All registrations
		 *
		 */
	public function getRegistrations() {
		if ($this->registrations === NULL) {
			$this->registrations = New Tx_Extbase_Persistence_ObjectStorage();
		}
		return $this->registrations;
	}

		/**
		 *
		 * Gets all donations for this run.
		 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Donation> All donations
		 *
		 */
	public function getDonations() {
		if ($this->donations === NULL) {
			$this->donations = New Tx_Extbase_Persistence_ObjectStorage();
			ForEach($this->getRegistrations() As $registration)
				$this->donations->addAll($registration->getDonations());
		}
		return $this->donations;
	}
	
		/**
		 *
		 * Gets the edit date.
		 * @return DateTime The edit date
		 *
		 */
	public function getEditDate() { return $this->tstamp; }

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
	public function setName($name) {
		$this->name = $name;
	}

		/**
		 *
		 * Sets the start date.
		 * @param DateTime $start The start date
		 * @return void
		 *
		 */
	public function setStart(DateTime $start) {
		$this->start = $start;
	}
	
		/**
		 *
		 * Sets the distance.
		 * @param double $distance The run distance
		 * @return void
		 *
		 */
	public function setDistance($distance) {
		$this->distance = $distance;
	}
	
	/**
	 *
	 * Sets the event.
	 * @param Tx_EcDonationrun_Domain_Model_Event $event
	 * @return void
	 *
	 */
	public function setEvent(Tx_EcDonationrun_Domain_Model_Event $event) {
		$this->event = $event;
	}
	
	/**
	 * Has the current fe user already a registration?
	 * @return boolean
	 */
	public function hasUserRegistration() {
		$userHasRegistration = false;
		foreach ($this->getRegistrations() as $registration) {
			if ($registration->getUser()->getName() == NULL) {
				continue;
			}
			if ($registration->isCurrentFeUserEqualUser()) {
				$userHasRegistration = true;
				break;
			}
		}
		return $userHasRegistration;
		
	}
	
}

?>
