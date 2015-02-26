<?php

/*                                                                      *
 *  COPYRIGHT NOTICE                                                    *
 *                                                                      *
 *  (c) 2015 Hauke Webermann <hauke@webermann.net>                      *
 *           webermann.net                                              *
 *           All rights reserved                                        *
 *                                                                      *
 *  This script is part of the TYPO3 project. The TYPO3 project is      *
 *  free software; you can redistribute it and/or modify                *
 *  it under the terms of the GNU General public License as published   *
 *  by the Free Software Foundation; either version 2 of the License,   *
 *  or (at your option) any later version.                              *
 *                                                                      *
 *  The GNU General public License can be found at                      *
 *  http://www.gnu.org/copyleft/gpl.html.                               *
 *                                                                      *
 *  This script is distributed in the hope that it will be useful,      *
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of      *
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the       *
 *  GNU General public License for more details.                        *
 *                                                                      *
 *  This copyright notice MUST APPEAR in all copies of the script!      *
 *                                                                      */



/**
 *
 * An event.
 *
 * @author     Hauke Webermann <hauke@webermann.net>
 * @package    EcDonationrun
 * @subpackage Domain_Model
 * @version    $Id: Run.php 46 2014-02-26 06:48:05Z hauke $
 * @license    GNU public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 * @entity
 *
 */

class Tx_EcDonationrun_Domain_Model_Event extends Tx_Extbase_DomainObject_AbstractEntity {
	/*
	 * ATTRIBUTES
	 */
	/**
	 * The event name
	 * @var string
	 * @validate StringLength(minimum = 3, maximum = 255)
	 */
	protected $name;

	/**
	 * The city
	 * @var string
	 */
	protected $city;

	/**
	 * The info
	 * @var string
	 */
	protected $info;

	/**
	 * The event website
	 * @var string
	 */
	protected $website;
	
	/**
	 * The event donation info
	 * @var string
	 */
	protected $donationInfo;
	
	/**
	 * The event bank account 
	 * @var string
	 */
	protected $bankAccount;
	
	/**
	 * The event contact person 
	 * @var string
	 */
	protected $contactPerson;
	
	/**
	 * The event contact person mail 
	 * @var string
	 */
	protected $contactPersonMail;
	
	/**
	 * The event invoice number format 
	 * @var string
	 */
	protected $invoiceNumberFormat;
	
	/**
	 * A list of all runs that are assigned to this event
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Run>
	 * @lazy
	 */
	protected $runs = NULL;

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
		$this->runs = New Tx_Extbase_Persistence_ObjectStorage();
	}

	/*
	 * GETTERS
	 */

	/**
	 *
	 * Gets the event name
	 * @return string
	 *
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 *
	 * Gets the event city
	 * @return string
	 *
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 *
	 * Gets the event info
	 * @return string
	 *
	 */
	public function getInfo() {
		return $this->info;
	}

	/**
	 *
	 * Gets the event website
	 * @return string
	 *
	 */
	public function getWebsite() {
		return $this->website;
	}
	
	/**
	 * Gets the event donation info
	 * @return string
	 */
	public function getDonationInfo() {
		return $this->donationInfo;
	}
	
	/**
	 * Gets the event bank account
	 * @return string
	 */
	public function getBankAccount() {
		return $this->bankAccount;
	}
	
	/**
	 * Gets the event contact person
	 * @return string
	 */
	public function getContactPerson() {
		return $this->contactPerson;
	}
	
	/**
	 * Gets the event contact person mail
	 * @return string
	 */
	public function getContactPersonMail() {
		return $this->contactPersonMail;
	}
	
	/**
	 * Gets the event invoice number format
	 * @return string
	 */
	public function getInvoiceNumberFormat() {
		return $this->invoiceNumberFormat;
	}
	
	/**
	 * Gets all runs for this event.
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_EcDonationrun_Domain_Model_Runs>
	 */
	public function getRuns() {
		return $this->runs;
	}

	/**
	 * Gets the edit date.
	 * @return DateTime
	 */
	public function getEditDate() {
		return $this->tstamp;
	}

	/*
	 * SETTERS
	 */
	/**
	 * Sets the event name
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Sets the event city.
	 * @param string $val
	 * @return void
	 *
	 */
	public function setCity($val) {
		$this->city = $val;
	}

	/**
	 * Sets the info
	 * @param string $val
	 * @return void
	 *
	 */
	public function setInfo($val) {
		$this->info = $val;
	}
	
	/**
	 * Sets the website
	 * @param string $val
	 * @return void
	 */
	public function setWebsite($val) {
		$this->website = $val;
	}
	
	/**
	 * Sets the donation info
	 * @param string $val
	 * @return void
	 */
	public function setDonationInfo($val) {
		$this->donationInfo = $val;
	}

	/**
	 * Sets the bank account
	 * @param string $val
	 * @return void
	 */
	public function setBankAccount($val) {
		$this->bankAccount = $val;
	}
	
	/**
	 * Sets the contact person
	 * @param string $val
	 * @return void
	 */
	public function setContactPerson($val) {
		$this->contactPerson = $val;
	}
	
	/**
	 * Sets the contact person mail
	 * @param string $val
	 * @return void
	 */
	public function setContactPersonMail($val) {
		$this->contactPersonMail = $val;
	}
	
	/**
	 * Sets the invoice number format
	 * @param string $val
	 * @return void
	 */
	public function setInvoiceNumberFormat($val) {
		$this->invoiceNumberFormat = $val;
	}
	
}

?>
