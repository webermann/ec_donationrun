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



If(!defined('TYPO3_MODE')) Die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY, 'Pi1',
	Array ( 'Registration' => 'index,show,new,create,delete,edit,update',
	        'Donation' => 'index,new,create' ),
	Array ( 'Registration' => 'index,show,new,create,delete,edit,update',
	        'Donation' => 'index,new,create' )
);

/**
 * Extra evaluation of TCA fields
 */
$TYPO3_CONF_VARS['SC_OPTIONS']['tce']['formevals']['tx_ecdonationrun_double3'] = 'EXT:ec_donationrun/Classes/Utility/EvaluateDouble3.php';

if (TYPO3_MODE=='FE'){
	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['sr_feuser_register']['extendingTCA'][] = 'extbase';
}

?>
