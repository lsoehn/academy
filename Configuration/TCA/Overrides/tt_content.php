<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

$tca = [
    'tx_academy_parent' => [
        'config' => [
            'type' => 'passthrough',
        ],
    ],
    'tx_academy_tablename' => [
        'config' => [
            'type' => 'passthrough',
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    $tca
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['academy_list'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue('academy_list', 'FILE:EXT:academy/Configuration/FlexForms/ListPlugin.xml');

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['academy_show'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue('academy_show', 'FILE:EXT:academy/Configuration/FlexForms/ShowPlugin.xml');

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['academy_media'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue('academy_media', 'FILE:EXT:academy/Configuration/FlexForms/MediaPlugin.xml');

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['academy_mediaviewer'] = 'pi_flexform';
ExtensionManagementUtility::addPiFlexFormValue('academy_mediaviewer', 'FILE:EXT:academy/Configuration/FlexForms/MediaviewerPlugin.xml');
