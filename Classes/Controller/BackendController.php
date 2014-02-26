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
	 * Controller class for the backend module. Provides actions for listing all projects
	 * in the TYPO3 backend.
	 *
	 * @author     Hauke Webermann <hauke@webermann.net>
	 * @package    EcDonationrun
	 * @subpackage Controller
	 * @version    $Id$
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 *
	 */

Class Tx_EcDonationrun_Controller_BackendController Extends Tx_Extbase_MVC_Controller_ActionController {

		/*
		 * ATTRIBUTES
		 */

		 /**
		  * A registration repository.
		  * @var Tx_EcDonationrun_Domain_Repository_RegistrationRepository
		  */
	Protected $registrationRepository;
	
		 /**
		  * A donatoin repository.
		  * @var Tx_EcDonationrun_Domain_Repository_DonationRepository
		  */
	Protected $donatoinRepository;

		/*
		 * ACTION METHODS
		 */

		/**
		 *
		 * The initialization action. This methods creates instances of all required
		 * repositories.
		 *
		 * @return void
		 *
		 */

	Protected Function initializeAction() {
		$this->registrationRepository =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_RegistrationRepository');
		$this->donatoinRepository     =& t3lib_div::makeInstance('Tx_EcDonationrun_Domain_Repository_DonationRepository');
	}



		/**
		 *
		 * The index action. Displays a list of all available registrations.
		 *
		 * @return void
		 *
		 */

	Public Function indexAction() {
		$this->view->assign('registrations', $this->registrationRepository->findAll());
		$this->view->assign('donation', $this->donatoinRepository->findAll());
	}

}

?>
