<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

$TCA['tx_ecdonationrun_domain_model_registration'] = array(
	'ctrl' => $TCA['tx_ecdonationrun_domain_model_registration']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'run,user,run_status,runner_number,runner_time,donations'
	),
	'types' => array(
		'1' => array('showitem' => 'run,user,run_status,runner_number,runner_time,donations')
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
				'foreign_table' => 'tx_ecdonationrun_domain_model_registration',
				'foreign_table_where' => 'AND tx_ecdonationrun_domain_model_registration.uid=###REC_FIELD_l18n_parent### AND tx_ecdonationrun_domain_model_registration.sys_language_uid IN (-1,0)',
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
		'run' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_run',
			'config'  => array(
				'type' => 'select',
				'foreign_class' => 'Tx_EcAssociation_Domain_Model_Run',
				'foreign_table' => 'tx_ecdonationrun_domain_model_run',
				//TODO 'foreign_table_where' => 'is in future and sort by distance',
				'maxitems'      => 1
			)
		),
		'user' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_run.user',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
//				'foreign_table_where' => Usergroup == Läufer
				'maxitems' => 1
			)
		),
		'run_status' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_registration.runstatus',
			'config'  => array(
				'type' => 'select',
				'items' => array(
					array('Erfolgreich', 0),
				    array('Abgebrochen', 1),
				    array('Nicht teilgenommen', 2),
				)
			)
		),
		'runner_number' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_registration.runnernumber',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'runner_time' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:ec_donationrun/Resources/Private/Language/locallang_db.xml:tx_ecdonationrun_domain_model_registration.runnertime',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'integer',
			)
		),
		'donations' => array(
			'exclude' => 0,
			'label'   => 'Spenden',
			'config'  => array(
				'type' => 'inline',
				'foreign_class' => 'Tx_EcAssociation_Domain_Model_Donation',
				'foreign_table' => 'tx_ecdonationrun_domain_model_donation',
				'foreign_field' => 'registration',
				'maxitems'      => 9999
			)
		),
	),
);
?>