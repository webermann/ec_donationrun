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
	 * The registration repository class. Provides methods for accessing the registration table.
	 *
	 * @author     Hauke Webermann <hauke@webermann.net>
	 * @package    EcDonationrun
	 * @subpackage Domain_Repository
	 * @version    $Id$
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 *
	 */

Class Tx_EcDonationrun_Domain_Repository_RegistrationRepository Extends Tx_Extbase_Persistence_Repository {
	protected $defaultOrderings = array ('run' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING);
	
	public function initializeObjectForBe() {
		/**
		 * http://forge.typo3.org/projects/typo3v4-mvc/wiki/Default_Orderings_and_Query_Settings_in_Repository
		 * @var $defaultQuerySettings Tx_Extbase_Persistence_Typo3QuerySettings */
		$defaultQuerySettings = $this->objectManager->get('Tx_Extbase_Persistence_Typo3QuerySettings');
		$defaultQuerySettings->setRespectStoragePage(FALSE);
		$this->setDefaultQuerySettings($defaultQuerySettings);
	}
	
	/**
	 * Returns all objects of this repository.
	 *
	 * @return Array<Tx_EcDonationrun_Domain_Model_Registration>  The result list.
	 */
	public function findAllActive() {
		$query = $this->createQuery();
		$result = $query
			->matching($query->greaterThanOrEqual('run.start', time()-60*60*24*90)) // Zeige 90 Tage nach start noch an.
			//->matching($query->greaterThan('user.name', '')) TODO
			->setOrderings(Array('run' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING))
			->execute();
		return $result;
	}
	
	
		/**
		 *
		 * Find Registrations from User
		 *
		 * @param  Tx_Extbase_Domain_Model_FrontendUser $user The parent user
		 * @return Array<Tx_EcDonationrun_Domain_Model_Registration>  The result list.
		 *
		 */

	Public Function findRegistrationsFromUser($user) {
		$query = $this->createQuery();
		Return $query
			->matching($query->equals('user', $user->getUid()))
			->setOrderings(Array('crdate' => Tx_Extbase_Persistence_Query::ORDER_DESCENDING))
			->execute();

	}
	
}


?>
