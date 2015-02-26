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
 * A ViewHelper for formatting distance unit. In dependence of the  distance_unit, the
 * distance if formatted with a different unit (pro km, pro Etappe).
 *
 * @author     Hauke Webermann <hauke@webermann.net>
 * @package    EcDonationrun
 * @subpackage ViewHelpers
 * @version    $Id: TimeFormatViewHelper.php 130 2015-02-15 13:17:42Z hauke $
 * @license    GNU Public License, version 2
 *             http://opensource.org/licenses/gpl-license.php
 *
 */

class Tx_EcDonationrun_ViewHelpers_DistanceFormatViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	/**
	 * Renders the distance unit.
	 *
	 * @param  $unit int unit
	 * @param  $plural int options
	 * @return string The formatted output
	 */
	public function render($unit, $plural=1) {
		if ($unit == 0) {
			return "km";
		} elseif ($unit == 1) {
			if ($plural == 0) {
				return "Runde";
			} else {
				return "Runden";
			}
		} elseif ($unit == 2) {
			if ($plural == 0) {
				return "Etappe";
			} else {
				return "Etappen";
			}
		} else {
			return NULL;
		}
	}

}

?>
