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
	 * A ViewHelper for formatting time amounts. In dependence of the time amount, the
	 * time amount if formatted with a different unit (seconds, minutes, hours, days).
	 *
	 * @author     Hauke Webermann <hauke@webermann.net>
	 * @package    EcDonationrun
	 * @subpackage Utility
	 * @version    $Id$
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 *
	 */

Class tx_ecdonationrun_double3 {
    function returnFieldJS() {
        return "
            var theVal = ''+value;
            var dec=0;
            if (!value)    return 0;
            for (var a=theVal.length; a>0; a--)    {
                if (theVal.substr(a-1,1)=='.' || theVal.substr(a-1,1)==',')    {
                    dec = theVal.substr(a);
                    theVal = theVal.substr(0,a-1);
                    break;
                }
            }
            dec = evalFunc.getNumChars(dec)+'000';
            theVal=evalFunc.parseInt(evalFunc.noSpace(theVal))+TS.decimalSign+dec.substr(0,3);
            return theVal;
        ";
    }
    function evaluateFieldValue($value, $is_in, &$set) {
        $theDec = 0;
        for ($a=strlen($value); $a>0; $a--)    {
            if (substr($value,$a-1,1)=='.' || substr($value,$a-1,1)==',')    {
                $theDec = substr($value,$a);
                $value = substr($value,0,$a-1);
                break;
            }
        }
        $theDec = preg_replace('[^0-9]','',$theDec).'000';
        $value = intval(str_replace(' ','',$value)).'.'.substr($theDec,0,3);
        return $value;
    }
}

?>
