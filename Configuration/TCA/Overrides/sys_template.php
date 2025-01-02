<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

// TYPOSCRIPT

ExtensionManagementUtility::addStaticFile(
    'academy',
    'Configuration/TypoScript',
    'Academy'
);
