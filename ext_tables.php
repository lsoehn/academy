<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

// TYPOSCRIPT

ExtensionManagementUtility::addStaticFile('academy', 'Configuration/TypoScript', 'Academy');

// PLUGIN DEFINITIONS

ExtensionUtility::registerPlugin(
    'academy',
    'Projects',
    'Academy: Projects'
);

ExtensionUtility::registerPlugin(
    'academy',
    'Units',
    'Academy: Units'
);

ExtensionUtility::registerPlugin(
    'academy',
    'Persons',
    'Academy: Persons'
);

ExtensionUtility::registerPlugin(
    'academy',
    'Media',
    'Academy: Media'
);

ExtensionUtility::registerPlugin(
    'academy',
    'Mediaviewer',
    'Academy: Mediaviewer'
);

ExtensionUtility::registerPlugin(
    'academy',
    'Search',
    'Academy: Search'
);

ExtensionUtility::registerPlugin(
    'academy',
    'Hcards',
    'Academy: Hcards'
);

ExtensionUtility::registerPlugin(
    'academy',
    'Products',
    'Academy: Products'
);

ExtensionUtility::registerPlugin(
    'academy',
    'Services',
    'Academy: Services'
);

ExtensionUtility::registerPlugin(
    'academy',
    'Publications',
    'Academy: Publications'
);

// TABLES

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_projects', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_projects.xml');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_units', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_units.xml');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_persons', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_persons.xml');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_hcards', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_hcards.xml');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_hcards_adr', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_hcards_adr.xml');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_hcards_adrcomponents', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_hcards_adrcomponents.xml');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_hcards_tel', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_hcards_tel.xml');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_hcards_email', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_hcards_email.xml');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_hcards_url', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_hcards_url.xml');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_relations', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_relations.xml');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_roles', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_roles.xml');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_media', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_media.xml');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_products', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_products.xml');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_publications', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_publications.xml');

ExtensionManagementUtility::addLLrefForTCAdescr('tx_academy_domain_model_services', 'EXT:academy/Resources/Private/Language/locallang_csh_tx_academy_domain_model_services.xml');

