<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_ecdonationrun_domain_model_run'] = array(
	'ctrl' => $TCA['tx_ecdonationrun_domain_model_run']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name,start,distance,registrations'
	),
	'types' => array(
		'1' => array('showitem' => 'name,start,distance,registrations')
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
		'name' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_run.name',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'start' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_run.start',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'datetime,required'
			)
		),
		'distance' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_run.distance',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'tx_ecdonationrun_double3,required'
			)
		),
		'registrations' => array(
			'exclude' => 0,
			'label'   => 'Anmeldungen',
			'config'  => array(
				'type' => 'inline',
				'foreign_class' => 'Tx_EcAssociation_Domain_Model_Registration',
				'foreign_table' => 'tx_ecdonationrun_domain_model_registration',
				'foreign_field' => 'run',
				'maxitems'      => 9999
			)
		),
	),
);
?>
