<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_ecdonationrun_domain_model_donation'] = array(
	'ctrl' => $TCA['tx_ecdonationrun_domain_model_donation']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'donationValue,donationMaxValue,isPaid,registration,user,associationGroup'
	),
	'types' => array(
		'1' => array('showitem' => 'donationValue,donationMaxValue,isPaid,registration,user,associationGroup')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(
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
		'donationValue' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_donation.value',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'double2,required'
			)
		),
		'donationMaxValue' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_donation.maxvalue',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'double2'
			)
		),
		'isPaid' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_donation.ispaid',
			'config'  => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'registration' => array(
			'exclude' => 0,
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
				'maxitems' => 1
			)
		),
		'associationGroup' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_donation.associationgroup',
			'config' => array(
				'type' => 'select',
				'foreign_class' => 'Tx_EcAssociation_Domain_Model_Group',
				'foreign_table' => 'tx_ecassociation_domain_model_group',
				'maxitems' => 1
			)
		),
	),
);
?>
