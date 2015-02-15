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

class Tx_EcDonationrun_Domain_Repository_DonationRepository extends Tx_Extbase_Persistence_Repository {
	
	public function initializeObjectForBe() {
		/**
		 * http://forge.typo3.org/projects/typo3v4-mvc/wiki/Default_Orderings_and_Query_Settings_in_Repository
		 * @var $defaultQuerySettings Tx_Extbase_Persistence_Typo3QuerySettings */
		$defaultQuerySettings = $this->objectManager->get('Tx_Extbase_Persistence_Typo3QuerySettings');
		$defaultQuerySettings->setRespectStoragePage(FALSE);
		$this->setDefaultQuerySettings($defaultQuerySettings);
	}
	 
	/**
	 * Returns all objects with no invoice number of this repository.
	 *
	 * @return array<Tx_EcDonationrun_Domain_Model_Donation>  The result list.
	 */
	public function findAllNoInvoice() {
		$query = $this->createQuery();
		$result = $query
		->matching($query->equals('invoiceNumber', NULL))
		->setOrderings(array('user' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING))
		->execute();
		return $result;
	}



	/**
	 *
	 * Find Donation from Registration
	 *
	 * @param  Tx_EcDonationrun_Domain_Model_Registration $registration The parent registration
	 * @return array<Tx_EcDonationrun_Domain_Model_Donation>  The result list.
	 *
	 */

	public function findDonationsFromRegistration($registration) {
		$query = $this->createQuery();
		return $query
		->matching($query->equals('registration', $registration->getUid()))
		->setOrderings(array('crdate' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING))
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
