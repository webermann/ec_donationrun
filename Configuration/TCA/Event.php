<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$TCA['tx_ecdonationrun_domain_model_event'] = array(
	'ctrl' => $TCA['tx_ecdonationrun_domain_model_event']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'name,city,info,website,runs'
	),
	'types' => array(
		'1' => array('showitem' => 'name,city,info,website,runs')
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
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_event.name',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'city' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_event.city',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'info' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_event.info',
			'config'  => array(
				'type' => 'text',
				'cols' => '40',
		        'rows' => '5',
				'eval' => 'trim'
			)
		),
		'website' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_event.website',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'runs' => array(
			'exclude' => 0,
			'label'   => 'Läufe',
			'config'  => array(
				'type' => 'inline',
				'foreign_class' => 'Tx_EcAssociation_Domain_Model_run',
				'foreign_table' => 'tx_ecdonationrun_domain_model_run',
				'foreign_field' => 'event',
				'maxitems'      => 9999
			)
		),
	),
);
?>
