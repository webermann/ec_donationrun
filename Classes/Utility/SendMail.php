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

Class Tx_EcDonationrun_Utility_SendMail {
    
	/*
	 * http://swiftmailer.org/docs/messages.html
	 * http://api.typo3.org/typo3cms/47/html/classt3lib__mail___message.html
	 *
	 * */
	
	static public function sendMail($email, $subjectText, $mailText, $replyTo=NULL, $cc=NULL, $bcc=NULL, $from=NULL) {
		$mail = t3lib_div::makeInstance('t3lib_mail_Message');
		//Adressen festlegen
		if ($from == NULL) {
			//TODO $mail->setFrom(array($this->settings['mail']['fromAddress'] => $this->settings['mail']['fromName']));
			$mail->setFrom(array('info@runningforjesus.de' => 'Running for Jesus'));
		} else {
			$mail->setFrom($from);
		}
		$mail->setTo($email);
		
		if ($replyTo !== NULL) {
			$mail->setReplyTo($replyTo);
		}
		if ($cc !== NULL) {
			$mail->setCc($cc);
		}
		if ($bcc !== NULL) {
			$mail->setBcc($bcc);
		}
		//$mail->setBcc(array('rfj@webermann.net' => 'RfJ'));

		//Betreffzeile
		$mail->setSubject($subjectText);

		//Mailtext
		$text = $mailText.
				"\n\nViele Grüße\n".
				"Dein Running for Jesus - Team\n\n".
				"Weiter Infos findest Du unter www.runningforjesus.de.\n".
				"Bei Fragen zu Running for Jesus, kannst Du Dich gerne an Carsten Müller wenden: \n".
				"info@runningforjesus.de\n";
		
		//$mail->setBody($text, 'text/html');
		$mail->setBody(strip_tags(preg_replace('/(<br*)(>)/', "\n", $text)), 'text/plain');
		
		$mail->Send();

		return $mail->isSent();
	}
	
	
}

?>
