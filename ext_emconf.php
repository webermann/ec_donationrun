<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "ec_donationrun".
 *
 * Auto generated 28-05-2014 11:59
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
	'version' => '0.7.3',
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
	'_md5_values_when_last_written' => 'a:62:{s:12:"ext_icon.gif";s:4:"ac09";s:17:"ext_localconf.php";s:4:"f339";s:14:"ext_tables.php";s:4:"202a";s:14:"ext_tables.sql";s:4:"0de4";s:41:"Classes/Controller/AbstractController.php";s:4:"a268";s:40:"Classes/Controller/BackendController.php";s:4:"fb8c";s:41:"Classes/Controller/DonationController.php";s:4:"8c66";s:45:"Classes/Controller/RegistrationController.php";s:4:"dc1f";s:46:"Classes/Domain/Exception/AbstractException.php";s:4:"2c7c";s:53:"Classes/Domain/Exception/NoProjectMemberException.php";s:4:"fe16";s:33:"Classes/Domain/Model/Donation.php";s:4:"67cb";s:37:"Classes/Domain/Model/Registration.php";s:4:"ee6d";s:28:"Classes/Domain/Model/Run.php";s:4:"3f17";s:48:"Classes/Domain/Repository/DonationRepository.php";s:4:"533b";s:52:"Classes/Domain/Repository/RegistrationRepository.php";s:4:"a2c7";s:43:"Classes/Domain/Repository/RunRepository.php";s:4:"c288";s:46:"Classes/Domain/Validator/DonationValidator.php";s:4:"dec7";s:35:"Classes/Utility/EvaluateDouble3.php";s:4:"e8e0";s:27:"Classes/Utility/Invoice.php";s:4:"41e6";s:28:"Classes/Utility/SendMail.php";s:4:"dda8";s:44:"Classes/ViewHelpers/TimeFormatViewHelper.php";s:4:"3e75";s:47:"Classes/ViewHelpers/Form/UserRoleViewHelper.php";s:4:"0478";s:45:"Configuration/FlexForms/ControllerActions.xml";s:4:"13b6";s:30:"Configuration/TCA/Donation.php";s:4:"1b0f";s:34:"Configuration/TCA/Registration.php";s:4:"dd04";s:25:"Configuration/TCA/Run.php";s:4:"7a75";s:34:"Configuration/TypoScript/setup.txt";s:4:"8fa4";s:25:"Doc/_Briefkopfvorlage.pdf";s:4:"fdf4";s:22:"Doc/Briefpapier EC.doc";s:4:"beee";s:15:"Doc/rfj_eer.mwb";s:4:"2092";s:40:"Resources/Private/Language/locallang.xml";s:4:"96d8";s:83:"Resources/Private/Language/locallang_csh_tx_ecdonationrun_domain_model_donation.xml";s:4:"1dc4";s:87:"Resources/Private/Language/locallang_csh_tx_ecdonationrun_domain_model_registration.xml";s:4:"2f54";s:78:"Resources/Private/Language/locallang_csh_tx_ecdonationrun_domain_model_run.xml";s:4:"a2e3";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"b508";s:44:"Resources/Private/Language/locallang_mod.xml";s:4:"6128";s:35:"Resources/Private/Layouts/main.html";s:4:"5def";s:41:"Resources/Private/Partials/exception.html";s:4:"6109";s:42:"Resources/Private/Partials/formErrors.html";s:4:"cc71";s:47:"Resources/Private/Templates/Backend/export.html";s:4:"1091";s:46:"Resources/Private/Templates/Backend/index.html";s:4:"8a57";s:60:"Resources/Private/Templates/Backend/sendDonationRequest.html";s:4:"3a71";s:46:"Resources/Private/Templates/Default/error.html";s:4:"40f5";s:56:"Resources/Private/Templates/Donation/confirmNoLogin.html";s:4:"a72b";s:46:"Resources/Private/Templates/Donation/edit.html";s:4:"f630";s:61:"Resources/Private/Templates/Donation/generateNoLoginLink.html";s:4:"ab1d";s:47:"Resources/Private/Templates/Donation/index.html";s:4:"08a7";s:45:"Resources/Private/Templates/Donation/new.html";s:4:"41cf";s:52:"Resources/Private/Templates/Donation/newNoLogin.html";s:4:"94be";s:50:"Resources/Private/Templates/Registration/edit.html";s:4:"c588";s:61:"Resources/Private/Templates/Registration/generateNewLink.html";s:4:"5f02";s:51:"Resources/Private/Templates/Registration/index.html";s:4:"22f1";s:49:"Resources/Private/Templates/Registration/new.html";s:4:"bcc9";s:50:"Resources/Private/Templates/Registration/show.html";s:4:"bfa3";s:64:"Resources/Private/Templates/Registration/showDonationAmount.html";s:4:"012e";s:59:"Resources/Private/Templates/Registration/showRankingKv.html";s:4:"44c2";s:63:"Resources/Private/Templates/Registration/showRankingRunner.html";s:4:"0879";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:65:"Resources/Public/Icons/tx_ecdonationrun_domain_model_donation.gif";s:4:"1103";s:69:"Resources/Public/Icons/tx_ecdonationrun_domain_model_registration.gif";s:4:"905a";s:60:"Resources/Public/Icons/tx_ecdonationrun_domain_model_run.gif";s:4:"1103";s:39:"Resources/Public/Stylesheets/styles.css";s:4:"d5ac";}',
	'suggests' => array(
	),
);

?>