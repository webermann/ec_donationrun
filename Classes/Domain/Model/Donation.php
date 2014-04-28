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

	/**
	 * The registration
	 * @var Tx_EcDonationrun_Domain_Model_Registration
	 * @lazy
	 */
	Protected $registration;

	/**
	 * The user of this donation.
	 * @var Tx_EcAssociation_Domain_Model_User
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
	 * The fix value of this donation
	 * @var float
	 */
	Protected $donationFixValue;


	/**
	 * A informaiton if the donator gets notification via E-Mail or Letter
	 * 'items' => array(
		 'E-Mail',
		 'Brief',
		 'Läufer')
	 * @var int
	 */
	Protected $notificationVia;

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
	Protected $notificationStatus;

	/**
	 * A informaiton if the donator has paid the donatoin
	 * @var string
	 */
	Protected $comment;

	/**
	 * A informaiton if the donator wants a contribution receipt
	 * @var boolean
	 */
	Protected $contributionReceipt;

	/**
	 * A informaiton of the invoice number
	 * @var string
	 */
	Protected $invoiceNumber;
	
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

	Public Function getRegistration() {
		Return $this->registration;
	}

	/**
	 *
	 * Gets the donator
	 * @return Tx_EcAssociation_Domain_Model_User
	 */

	Public Function getUser() {
		Return $this->user;
	}

	/**
	 *
	 * Gets the runner
	 * @return Tx_EcAssociation_Domain_Model_User
	 */

	Public Function getRunner() {
		Return $this->getRegistration()->getUser();
	}

	/**
	 *
	 * Gets the donation value
	 * @return float $donationValue
	 */

	Public Function getDonationValue() {
		Return $this->donationValue;
	}

	/**
	 *
	 * Gets the donation fix value
	 * @return float $donationFixValue
	 */

	Public Function getDonationFixValue() {
		Return $this->donationFixValue;
	}

	/**
	 *
	 * Gets notification via
	 * @return int $notificationVia
	 */

	Public Function getNotificationVia() {
		Return $this->notificationVia;
	}

	/**
	 *
	 * Gets notification status
	 * @return int $notificationStatus
	 */

	Public Function getNotificationStatus() {
		Return $this->notificationStatus;
	}

	/**
	 *
	 * Gets comment
	 * @return string $comment
	 */

	Public Function getComment() {
		Return $this->comment;
	}

	/**
	 *
	 * Gets contribution receipt
	 * @return boolean $contributionReceipt
	 */

	Public Function getContributionReceipt() {
		Return $this->contributionReceipt;
	}

/**
	 *
	 * Gets invoice number
	 * @return string $invoiceNumber
	 */

	Public Function getInvoiceNumber() {
		Return $this->invoiceNumber;
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

	Public Function setRegistration(Tx_EcDonationrun_Domain_Model_Registration $registration) {
		$this->registration = $registration;
	}

	/**
	 *
	 * Sets the donator of this donation.
	 * @param Tx_EcAssociation_Domain_Model_User $user
	 * @return void
	 */

	Public Function setUser(Tx_EcAssociation_Domain_Model_User $user) {
		$this->user = $user;
	}

	/**
	 *
	 * Sets value of this donation.
	 * @param float $value
	 * @return void
	 */

	Public Function setDonationValue($value) {
		$value = floatval(str_replace(',', '.', str_replace('.', '', $value)));
		$this->donationValue = $value;
	}

	/**
	 *
	 * Sets the fix value of this donation.
	 * @param float $value
	 * @return void
	 */

	Public Function setDonationFixValue($value) {
		$value = floatval(str_replace(',', '.', str_replace('.', '', $value)));
		$this->donationFixValue = $value;
	}

	/**
	 *
	 * Sets notification via
	 * @param int $value
	 * @return void
	 */

	Public Function setNotificationVia($value) {
		$this->notificationVia = $value;
	}

	/**
	 *
	 * Gets notification status
	 * @param int $value
	 * @return void
	 */

	Public Function setNotificationStatus($value) {
		$this->notificationStatus = $value;
	}

	/**
	 *
	 * Sets the comment.
	 * @param string $comment
	 * @return void
	 */

	Public Function setComment($value) {
		$this->comment = $value;
	}

	/**
	 *
	 * Sets the contribution receipt flag.
	 * @param boolean $value
	 * @return void
	 */

	Public Function setContributionReceipt($value) {
		$this->contributionReceipt = $value;
	}
	
	/**
	 *
	 * Sets the invoice number.
	 * @param string $invoiceNumber
	 * @return void
	 */

	Public Function setInvoiceNumber($value) {
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
