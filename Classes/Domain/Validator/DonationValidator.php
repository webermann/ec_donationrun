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
	 * The timeset validator class. This class is a service class for validating timeset
	 * domain objects.
	 *
	 * @author     Hauke Webermann <hauke@webermann.net>
	 * @package    EcDonationrun
	 * @subpackage Domain_Validator
	 * @version    $Id$
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 *
	 */

Class Tx_EcDonationrun_Domain_Validator_DonationValidator Extends Tx_Extbase_Validation_Validator_AbstractValidator {



		/**
		 *
		 * Determines if a timeset object is valid.
		 * @param Tx_EcDonationrun_Domain_Model_Donation $donation The donation object that
		 *                                                           is to be validated.
		 * @return boolean TRUE, if the donation object is valid, otherwise FALSE.
		 *
		 */
	
	Public Function isValid($donation) {
		
		if(!$donation InstanceOf Tx_EcDonationrun_Domain_Model_Donation)
			$this->addError(Tx_Extbase_Utility_Localization::translate('Donation_Error_Invalid', 'EcDonationrun'), 1265721022);
		if (($donation->getDonationValue() == 0) && ($donation->getDonationFixValue() == 0))
			$this->addError(Tx_Extbase_Utility_Localization::translate('Donation_Error_1392464794', 'EcDonationrun'), 1392464794);
		
		if ($donation->getUser() != NULL) {
			if (!is_string($donation->getUser()->getFirstName()) || (strlen($donation->getUser()->getFirstName()) < 2))
				$this->addError(Tx_Extbase_Utility_Localization::translate('Donation_Error_1392551500', 'EcDonationrun'), 1392551500);
			if (!is_string($donation->getUser()->getLastName()) || (strlen($donation->getUser()->getLastName()) < 2))
				$this->addError(Tx_Extbase_Utility_Localization::translate('Donation_Error_1392551501', 'EcDonationrun'), 1392551501);
			if (!is_string($donation->getUser()->getAddress()) || (strlen($donation->getUser()->getAddress()) < 5))
				$this->addError(Tx_Extbase_Utility_Localization::translate('Donation_Error_1392551502', 'EcDonationrun'), 1392551502);
			if (!is_string($donation->getUser()->getCity()) || (strlen($donation->getUser()->getCity()) < 2))
				$this->addError(Tx_Extbase_Utility_Localization::translate('Donation_Error_1392551503', 'EcDonationrun'), 1392551503);
			if (!is_string($donation->getUser()->getZip()) || (strlen($donation->getUser()->getZip()) != 5))
				$this->addError(Tx_Extbase_Utility_Localization::translate('Donation_Error_1392551504', 'EcDonationrun'), 1392551504);
			if ($donation->getNotificationVia() == 0 || ($donation->getUser()->getEmail() != '')) { // E-Mail
				$emailValidator = new Tx_Extbase_Validation_Validator_EmailAddressValidator();
				if (!$emailValidator->isValid($donation->getUser()->getEmail()))
					$this->addError(Tx_Extbase_Utility_Localization::translate('Donation_Error_1392551505', 'EcDonationrun'), 1392551505);
			}
		}
		return count($this->getErrors()) === 0;
	}
}

?>
