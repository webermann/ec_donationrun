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
	 * The donation repository class. Provides methods for accessing the donation table.
	 *
	 * @author     Hauke Webermann <hauke@webermann.net>
	 * @package    EcDonationrun
	 * @subpackage Domain_Repository
	 * @version    $Id$
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 *
	 */

Class Tx_EcDonationrun_Domain_Repository_DonationRepository Extends Tx_Extbase_Persistence_Repository {

	/**
	 * Returns all objects with no invoice number of this repository.
	 *
	 * @return Array<Tx_EcDonationrun_Domain_Model_Donation>  The result list.
	 */
	public function findAllNoInvoice() {
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE); // to get functionality in BE Module
		$result = $query
			->matching($query->equals('invoiceNumber', NULL))
			->setOrderings(Array('user' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING))
			->execute();
		return $result;
	}
	
	
	
	/**
	 *
	 * Find Donation from Registration
	 *
	 * @param  Tx_EcDonationrun_Domain_Model_Registration $registration The parent registration
	 * @return Array<Tx_EcDonationrun_Domain_Model_Donation>  The result list.
	 *
	 */

	Public Function findDonationsFromRegistration($registration) {
		$query = $this->createQuery();
		Return $query
			->matching($query->equals('registration', $registration->getUid()))
			->setOrderings(Array('crdate' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING))
			->execute();

	}
	
	/**
	 * Finds an object matching the given identifier.
	 *
	 * @param int $uid The identifier of the object to find
	 * @return object The matching object if found, otherwise NULL
	 */
	public function findByUid($uid) {
		if ($this->identityMap->hasIdentifier($uid, $this->objectType)) {
			$object = $this->identityMap->getObjectByIdentifier($uid, $this->objectType);
		} else {
			$query = $this->createQuery();
			$query->getQuerySettings()->setRespectSysLanguage(FALSE);
			$query->getQuerySettings()->setRespectStoragePage(FALSE);
			$query->getQuerySettings()->setRespectEnableFields(FALSE); // because of this line hidden objects can be retrieved
			$object = $query
					->matching(
						$query->equals('uid', $uid)
					)
					->execute()
					->getFirst();
		}
		return $object;
	}


}

?>
