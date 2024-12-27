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
