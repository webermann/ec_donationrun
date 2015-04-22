<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "ec_donationrun".
 *
 * Auto generated 22-04-2015 20:42
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Donation Run',
	'description' => '',
	'category' => 'Frontend-Plug-Ins',
	'shy' => 0,
	'version' => '0.8.1',
	'dependencies' => 'extbase,fluid,ec_association,fpdf',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 1,
	'lockType' => '',
	'author' => 'Hauke Webermann',
	'author_email' => 'hauke@webermann.net',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.5.0-0.0.0',
			'extbase' => '1.3.0-0.0.0',
			'fluid' => '1.3.0-0.0.0',
			'ec_association' => '0.2.0-0.0.0',
			'fpdf' => '0.2.2-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:70:{s:12:"ext_icon.gif";s:4:"ac09";s:17:"ext_localconf.php";s:4:"6210";s:14:"ext_tables.php";s:4:"4498";s:14:"ext_tables.sql";s:4:"912f";s:7:"LICENSE";s:4:"d279";s:41:"Classes/Controller/AbstractController.php";s:4:"e29a";s:40:"Classes/Controller/BackendController.php";s:4:"f1ff";s:41:"Classes/Controller/DonationController.php";s:4:"a290";s:45:"Classes/Controller/RegistrationController.php";s:4:"419f";s:46:"Classes/Domain/Exception/AbstractException.php";s:4:"269e";s:53:"Classes/Domain/Exception/NoProjectMemberException.php";s:4:"5eee";s:33:"Classes/Domain/Model/Donation.php";s:4:"55dd";s:30:"Classes/Domain/Model/Event.php";s:4:"9fa1";s:37:"Classes/Domain/Model/Registration.php";s:4:"9aa4";s:28:"Classes/Domain/Model/Run.php";s:4:"f4f6";s:48:"Classes/Domain/Repository/DonationRepository.php";s:4:"c734";s:45:"Classes/Domain/Repository/EventRepository.php";s:4:"8b66";s:52:"Classes/Domain/Repository/RegistrationRepository.php";s:4:"589e";s:43:"Classes/Domain/Repository/RunRepository.php";s:4:"fb5f";s:46:"Classes/Domain/Validator/DonationValidator.php";s:4:"42e7";s:35:"Classes/Utility/EvaluateDouble3.php";s:4:"8814";s:27:"Classes/Utility/Invoice.php";s:4:"4e02";s:30:"Classes/Utility/MailTexter.php";s:4:"ecc3";s:28:"Classes/Utility/SendMail.php";s:4:"1c38";s:42:"Classes/ViewHelpers/ArrayKeyViewHelper.php";s:4:"b3ee";s:48:"Classes/ViewHelpers/DistanceFormatViewHelper.php";s:4:"5aef";s:44:"Classes/ViewHelpers/TimeFormatViewHelper.php";s:4:"1878";s:47:"Classes/ViewHelpers/Form/UserRoleViewHelper.php";s:4:"7104";s:45:"Configuration/FlexForms/ControllerActions.xml";s:4:"13b6";s:32:"Configuration/Mail/mail_tmpl.php";s:4:"2194";s:30:"Configuration/TCA/Donation.php";s:4:"f1fa";s:27:"Configuration/TCA/Event.php";s:4:"2b9c";s:34:"Configuration/TCA/Registration.php";s:4:"66c9";s:25:"Configuration/TCA/Run.php";s:4:"9575";s:34:"Configuration/TypoScript/setup.txt";s:4:"8fa4";s:25:"Doc/_Briefkopfvorlage.pdf";s:4:"fdf4";s:22:"Doc/Briefpapier EC.doc";s:4:"beee";s:15:"Doc/rfj_eer.mwb";s:4:"2092";s:40:"Resources/Private/Language/locallang.xml";s:4:"96d8";s:83:"Resources/Private/Language/locallang_csh_tx_ecdonationrun_domain_model_donation.xml";s:4:"ddc1";s:80:"Resources/Private/Language/locallang_csh_tx_ecdonationrun_domain_model_event.xml";s:4:"ef41";s:87:"Resources/Private/Language/locallang_csh_tx_ecdonationrun_domain_model_registration.xml";s:4:"2f54";s:78:"Resources/Private/Language/locallang_csh_tx_ecdonationrun_domain_model_run.xml";s:4:"1dab";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"2384";s:44:"Resources/Private/Language/locallang_mod.xml";s:4:"6128";s:35:"Resources/Private/Layouts/main.html";s:4:"5def";s:41:"Resources/Private/Partials/exception.html";s:4:"6109";s:42:"Resources/Private/Partials/formErrors.html";s:4:"cc71";s:47:"Resources/Private/Templates/Backend/export.html";s:4:"1091";s:46:"Resources/Private/Templates/Backend/index.html";s:4:"fc0f";s:60:"Resources/Private/Templates/Backend/sendDonationRequest.html";s:4:"3a71";s:46:"Resources/Private/Templates/Default/error.html";s:4:"40f5";s:56:"Resources/Private/Templates/Donation/confirmNoLogin.html";s:4:"a72b";s:46:"Resources/Private/Templates/Donation/edit.html";s:4:"f630";s:61:"Resources/Private/Templates/Donation/generateNoLoginLink.html";s:4:"ab1d";s:47:"Resources/Private/Templates/Donation/index.html";s:4:"6a1d";s:45:"Resources/Private/Templates/Donation/new.html";s:4:"b849";s:52:"Resources/Private/Templates/Donation/newNoLogin.html";s:4:"9dc1";s:61:"Resources/Private/Templates/Registration/generateNewLink.html";s:4:"d428";s:51:"Resources/Private/Templates/Registration/index.html";s:4:"499f";s:49:"Resources/Private/Templates/Registration/new.html";s:4:"9372";s:64:"Resources/Private/Templates/Registration/showDonationAmount.html";s:4:"012e";s:59:"Resources/Private/Templates/Registration/showRankingKv.html";s:4:"44c2";s:63:"Resources/Private/Templates/Registration/showRankingRunner.html";s:4:"0879";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:65:"Resources/Public/Icons/tx_ecdonationrun_domain_model_donation.gif";s:4:"1103";s:62:"Resources/Public/Icons/tx_ecdonationrun_domain_model_event.gif";s:4:"1103";s:69:"Resources/Public/Icons/tx_ecdonationrun_domain_model_registration.gif";s:4:"905a";s:60:"Resources/Public/Icons/tx_ecdonationrun_domain_model_run.gif";s:4:"1103";s:39:"Resources/Public/Stylesheets/styles.css";s:4:"fac6";}',
	'suggests' => array(
	),
);

?>