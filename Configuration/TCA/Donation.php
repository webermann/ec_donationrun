<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_ecdonationrun_domain_model_donation'] = array(
	'ctrl' => $TCA['tx_ecdonationrun_domain_model_donation']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'donation_value, donation_fix_value, notification_via, notification_status, is_paid, comment, registration, user'
	),
	'types' => array(
		'1' => array('showitem' => 'donation_value, donation_fix_value, notification_via, notification_status, is_paid, comment, registration, user')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_ecdonationrun_domain_model_donation',
				'foreign_table_where' => 'AND tx_ecdonationrun_domain_model_donation.uid=###REC_FIELD_l18n_parent### AND tx_ecdonationrun_domain_model_donation.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array(
			'config'=>array(
				'type'=>'passthrough')
		),
		't3ver_label' => array(
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => array(
				'type'=>'none',
				'cols' => 27
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'donation_value' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_donation.value',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'double2,required'
			)
		),
		'donation_fix_value' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_donation.fixvalue',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'double2'
			)
		),
		'comment' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_donation.comment',
			'config'  => array(
				'type' => 'text',
				'cols' => '40',
		        'rows' => '5',
				'eval' => 'trim'
			)
		),
		'notification_via' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_donation.notification_via',
			'config'  => array(
				'type' => 'select',
				'readOnly' => true,
				'items' => array(
				    array('E-Mail', 0),
				    array('Brief', 1)
				)
			)
		),
		'notification_status' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_donation.mailstatus',
			'config'  => array(
				'type' => 'select',
				'readOnly' => true,
				'items' => array(
				    array('Bestätigungs Mail verschickt', 0),
				    array('Spende bestätigt', 1),
				    array('Zahlungsaufforderung', 2),
				    array('Erinnerung', 4),
				    array('Danke', 5),
				)
			)
		),
		'is_paid' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_donation.ispaid',
			'config'  => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'registration' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_registration',
			'config' => array(
				'type' => 'select',
				'foreign_class' => 'Tx_EcDonationrun_Domain_Model_Registration',
				'foreign_table' => 'tx_ecdonationrun_domain_model_registration',
				'maxitems' => 1
			)
		),
		'user' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_donation.user',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
//				'foreign_table_where' => Usergroup == Spender
				'maxitems' => 1
			)
		),
		/*
		 'user' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_donation.user',
			'config' => array (
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'fe_users',
				'size' => 1,
				'minitems' => 1,
				'maxitems' => 1,
				'show_thumbs' => '1',
				'wizards' => Array (
					'suggest' => array(
						'type' => 'suggest'
					)
				)
			)
		),
		 */
	),
);
?>
