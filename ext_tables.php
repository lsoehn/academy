<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

// TYPOSCRIPT

ExtensionManagementUtility::addStaticFile('academy', 'Configuration/TypoScript', 'Academy');

// PLUGIN DEFINITIONS

ExtensionUtility::registerPlugin(
    'Academy',
    'List',
    'Academy: List entities'
);

ExtensionUtility::registerPlugin(
    'Academy',
    'Show',
    'Academy: Show entity'
);

ExtensionUtility::registerPlugin(
    'academy',
    'Search',
    'Academy: Search entities'
);

ExtensionUtility::registerPlugin(
    'academy',
    'Media',
    'Academy: Media Library'
);

ExtensionUtility::registerPlugin(
    'academy',
    'Mediaviewer',
    'Academy: Media Viewer'
);
