<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "ec_donationrun".
 *
 * Auto generated 26-02-2014 07:34
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
	'version' => '0.4.0',
	'dependencies' => 'extbase,fluid',
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
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:54:{s:12:"ext_icon.gif";s:4:"ac09";s:17:"ext_localconf.php";s:4:"66eb";s:14:"ext_tables.php";s:4:"5464";s:14:"ext_tables.sql";s:4:"a302";s:41:"Classes/Controller/AbstractController.php";s:4:"3b09";s:40:"Classes/Controller/BackendController.php";s:4:"7bc2";s:41:"Classes/Controller/DonationController.php";s:4:"2b9d";s:45:"Classes/Controller/RegistrationController.php";s:4:"597d";s:46:"Classes/Domain/Exception/AbstractException.php";s:4:"9ad2";s:53:"Classes/Domain/Exception/NoProjectMemberException.php";s:4:"a0ce";s:33:"Classes/Domain/Model/Donation.php";s:4:"c2d9";s:37:"Classes/Domain/Model/Registration.php";s:4:"579f";s:28:"Classes/Domain/Model/Run.php";s:4:"47e3";s:48:"Classes/Domain/Repository/DonationRepository.php";s:4:"7dc1";s:52:"Classes/Domain/Repository/RegistrationRepository.php";s:4:"1beb";s:43:"Classes/Domain/Repository/RunRepository.php";s:4:"e109";s:46:"Classes/Domain/Validator/DonationValidator.php";s:4:"c07f";s:35:"Classes/Utility/EvaluateDouble3.php";s:4:"cd9d";s:28:"Classes/Utility/SendMail.php";s:4:"4170";s:44:"Classes/ViewHelpers/TimeFormatViewHelper.php";s:4:"5287";s:47:"Classes/ViewHelpers/Form/UserRoleViewHelper.php";s:4:"1026";s:45:"Configuration/FlexForms/ControllerActions.xml";s:4:"fc4b";s:30:"Configuration/TCA/Donation.php";s:4:"acab";s:34:"Configuration/TCA/Registration.php";s:4:"da82";s:25:"Configuration/TCA/Run.php";s:4:"52bc";s:34:"Configuration/TypoScript/setup.txt";s:4:"2b3f";s:18:"Doc/ext_tables.sql";s:4:"464a";s:15:"Doc/rfj_eer.mwb";s:4:"2092";s:40:"Resources/Private/Language/locallang.xml";s:4:"7262";s:83:"Resources/Private/Language/locallang_csh_tx_ecdonationrun_domain_model_donation.xml";s:4:"d656";s:87:"Resources/Private/Language/locallang_csh_tx_ecdonationrun_domain_model_registration.xml";s:4:"1eb1";s:78:"Resources/Private/Language/locallang_csh_tx_ecdonationrun_domain_model_run.xml";s:4:"7a05";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"8d81";s:44:"Resources/Private/Language/locallang_mod.xml";s:4:"5ef3";s:35:"Resources/Private/Layouts/main.html";s:4:"bee9";s:41:"Resources/Private/Partials/exception.html";s:4:"f218";s:42:"Resources/Private/Partials/formErrors.html";s:4:"ea34";s:46:"Resources/Private/Templates/Backend/index.html";s:4:"bea0";s:46:"Resources/Private/Templates/Default/error.html";s:4:"7b66";s:56:"Resources/Private/Templates/Donation/confirmNoLogin.html";s:4:"05d8";s:61:"Resources/Private/Templates/Donation/generateNoLoginLink.html";s:4:"4a2c";s:47:"Resources/Private/Templates/Donation/index.html";s:4:"b2ff";s:45:"Resources/Private/Templates/Donation/new.html";s:4:"c97b";s:52:"Resources/Private/Templates/Donation/newNoLogin.html";s:4:"0dd1";s:50:"Resources/Private/Templates/Registration/edit.html";s:4:"3023";s:61:"Resources/Private/Templates/Registration/generateNewLink.html";s:4:"2950";s:51:"Resources/Private/Templates/Registration/index.html";s:4:"4f57";s:49:"Resources/Private/Templates/Registration/new.html";s:4:"4c3f";s:50:"Resources/Private/Templates/Registration/show.html";s:4:"c35b";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:65:"Resources/Public/Icons/tx_ecdonationrun_domain_model_donation.gif";s:4:"1103";s:69:"Resources/Public/Icons/tx_ecdonationrun_domain_model_registration.gif";s:4:"905a";s:60:"Resources/Public/Icons/tx_ecdonationrun_domain_model_run.gif";s:4:"1103";s:39:"Resources/Public/Stylesheets/styles.css";s:4:"4544";}',
	'suggests' => array(
	),
);

?>