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
 * @author     Hauke Webermann <hauke@webermann.net>
 * @package    EcDonationrun
 * @subpackage Domain_Model
 * @version    $Id$
 * @license    GNU Public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 * @entity
 *
 */

class Tx_EcDonationrun_Domain_Model_Donation extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * The registration
	 * @var Tx_EcDonationrun_Domain_Model_Registration
	 * @lazy
	 */
	protected $registration;

	/**
	 * The user of this donation.
	 * @var Tx_EcAssociation_Domain_Model_User
	 * @lazy
	 */
	protected $user;


	/**
	 * The value of this donation
	 * @var float
	 * @validate NotEmpty
	 */
	protected $donationValue;


	/**
	 * The fix value of this donation
	 * @var float
	 */
	protected $donationFixValue;


	/**
	 * A informaiton if the donator gets notification via E-Mail or Letter
	 * 'items' => array(
		 'E-Mail',
		 'Brief',
		 'Läufer')
	 * @var int
	 */
	protected $notificationVia;

	/**
	 * A informaiton about the Notification Status
	 * 'items' => array(
		 'Bestätigungs Mail verschickt',
		 'Spende bestätigt',
		 'Zahlungsaufforderung',
		 'Erinnerung',
		 'Danke')
	 * @var int
	 */
	protected $notificationStatus;

	/**
	 * A informaiton if the donator has paid the donatoin
	 * @var string
	 */
	protected $comment;

	/**
	 * A informaiton if the donator wants a contribution receipt
	 * @var boolean
	 */
	protected $contributionReceipt;

	/**
	 * A informaiton of the invoice number
	 * @var string
	 */
	protected $invoiceNumber;
	
	/**
	 * tstamp
	 *
	 * @var DateTime
	 */
	protected $tstamp;
	
	/**
	 * hidden
	 *
	 * @var boolean
	 */
	protected $hidden = FALSE;


	/*
	 * GETTERS
	 */

	/**
	 *
	 * Gets the registration
	 * @return Tx_EcDonationrun_Domain_Model_Registration
	 */

	public function getRegistration() {
		return $this->registration;
	}

	/**
	 *
	 * Gets the donator
	 * @return Tx_EcAssociation_Domain_Model_User
	 */

	public function getUser() {
		return $this->user;
	}

	/**
	 *
	 * Gets the runner
	 * @return Tx_EcAssociation_Domain_Model_User
	 */

	public function getRunner() {
		return $this->getRegistration()->getUser();
	}

	/**
	 *
	 * Gets the donation value
	 * @return float $donationValue
	 */

	public function getDonationValue() {
		return $this->donationValue;
	}

	/**
	 *
	 * Gets the donation fix value
	 * @return float $donationFixValue
	 */

	public function getDonationFixValue() {
		return $this->donationFixValue;
	}

	/**
	 *
	 * Gets notification via
	 * @return int $notificationVia
	 */

	public function getNotificationVia() {
		return $this->notificationVia;
	}

	/**
	 *
	 * Gets notification status
	 * @return int $notificationStatus
	 */

	public function getNotificationStatus() {
		return $this->notificationStatus;
	}

	/**
	 *
	 * Gets comment
	 * @return string $comment
	 */

	public function getComment() {
		return $this->comment;
	}

	/**
	 *
	 * Gets contribution receipt
	 * @return boolean $contributionReceipt
	 */

	public function getContributionReceipt() {
		return $this->contributionReceipt;
	}

/**
	 *
	 * Gets invoice number
	 * @return string $invoiceNumber
	 */

	public function getInvoiceNumber() {
		return $this->invoiceNumber;
	}

	/**
	 *
	 * Gets the edit date.
	 * @return DateTime The edit date
	 *
	 */
	public function getTimestamp() {
		return $this->tstamp;
	}
	
	/**
	 * Returns hidden
	 *
	 * @return boolean $hidden
	 */
	public function getHidden() {
		return $this->hidden;
	}

	/*
	 * SETTERS
	 */

	/**
	 *
	 * Sets the registration of this donation.
	 * @param Tx_EcDonationrun_Domain_Model_Registration $registration The assignment
	 * @return void
	 */

	public function setRegistration(Tx_EcDonationrun_Domain_Model_Registration $registration) {
		$this->registration = $registration;
	}

	/**
	 *
	 * Sets the donator of this donation.
	 * @param Tx_EcAssociation_Domain_Model_User $user
	 * @return void
	 */

	public function setUser(Tx_EcAssociation_Domain_Model_User $user) {
		$this->user = $user;
	}

	/**
	 *
	 * Sets value of this donation.
	 * @param float $value
	 * @return void
	 */

	public function setDonationValue($value) {
		$value = floatval(str_replace(',', '.', str_replace('.', '', $value)));
		$this->donationValue = $value;
	}

	/**
	 *
	 * Sets the fix value of this donation.
	 * @param float $value
	 * @return void
	 */

	public function setDonationFixValue($value) {
		$value = floatval(str_replace(',', '.', str_replace('.', '', $value)));
		$this->donationFixValue = $value;
	}

	/**
	 *
	 * Sets notification via
	 * @param int $value
	 * @return void
	 */

	public function setNotificationVia($value) {
		$this->notificationVia = $value;
	}

	/**
	 *
	 * Gets notification status
	 * @param int $value
	 * @return void
	 */

	public function setNotificationStatus($value) {
		$this->notificationStatus = $value;
	}

	/**
	 *
	 * Sets the comment.
	 * @param string $comment
	 * @return void
	 */

	public function setComment($value) {
		$this->comment = $value;
	}

	/**
	 *
	 * Sets the contribution receipt flag.
	 * @param boolean $value
	 * @return void
	 */

	public function setContributionReceipt($value) {
		$this->contributionReceipt = $value;
	}
	
	/**
	 *
	 * Sets the invoice number.
	 * @param string $invoiceNumber
	 * @return void
	 */

	public function setInvoiceNumber($value) {
		$this->invoiceNumber = $value;
	}

	/**
	 * Sets hidden
	 *
	 * @param boolean $hidden
	 * @return void
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
	}


	/**
	 * Returns the boolean state of hidden
	 *
	 * @return boolean
	 */
	public function isHidden() {
		return $this->getHidden();
	}
	/**
	 * Load title for TCA label_userFunc
	 *
	 */
	public function getLabel(&$parameters, $parentObject) {
		$donation = t3lib_BEfunc::getRecord($parameters['table'], $parameters['row']['uid']);
		$user = t3lib_BEfunc::getRecord("fe_users", $donation['user']);

		if ($donation['donation_fix_value'] == 0) {
			$realDonation = number_format($donation['donation_value'], 2, ',', '.')." € pro km";
		} else {
			$realDonation = number_format($donation['donation_fix_value'], 2, ',', '.')." € Festbetrag";
		}
		$parameters['title'] = $user['first_name'].' '.$user['last_name'].': '.$realDonation;
	}
}

?>
