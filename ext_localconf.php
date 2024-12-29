<?php
if (!defined('TYPO3')) {
    die('Access denied!');
}

// PLUGIN CONFIGURATION
use Digicademy\Academy\Controller\EntityController;
use Digicademy\Academy\Controller\ProjectsController;
use Digicademy\Academy\Controller\UnitsController;
use Digicademy\Academy\Controller\PersonsController;
use Digicademy\Academy\Controller\MediaController;
use Digicademy\Academy\Controller\SearchController;
use Digicademy\Academy\Controller\HcardsController;
use Digicademy\Academy\Controller\ProductsController;
use Digicademy\Academy\Controller\ServicesController;
use Digicademy\Academy\Controller\PublicationsController;

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Academy',
    'list',
    [
        EntityController::class => 'list',
        ProjectsController::class => 'list,filter,show'
    ],
    [
        ProjectsController::class => 'filter'
    ],
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Academy',
    'show',
    [
        EntityController::class => 'list',
        ProjectsController::class => 'list,filter,show'
    ],
    [],
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Academy',
    'Units',
    array(
        UnitsController::class => 'list, listBySelection, listByCategories, listByRoles, show',
    ),
    array(
        UnitsController::class => '',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Academy',
    'Persons',
    array(
        PersonsController::class => 'list, listBySelection, listByCategories, listByRoles, show',
    ),
    array(
        PersonsController::class => '',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Academy',
    'Media',
    array(
        MediaController::class => 'list, listBySelection, listByCategories, listByRoles, listByGroups, listByTypes, listByRecent, show',
    ),
    array(
        MediaController::class => '',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Academy',
    'Mediaviewer',
    array(
        MediaController::class => 'viewer',
    ),
    array(
        MediaController::class => '',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Academy',
    'Search',
    array(
        SearchController::class => 'searchForm, searchAll, searchSingle',
    ),
    array(
        SearchController::class => 'searchForm, searchAll, searchSingle',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Academy',
    'Hcards',
    array(
        HcardsController::class => 'list, listBySelection, show',
    ),
    array(
        HcardsController::class => '',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Academy',
    'Products',
    array(
        ProductsController::class => 'list, listBySelection, listByCategories, listByRoles, show',
    ),
    array(
        ProductsController::class => '',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Academy',
    'Services',
    array(
        ServicesController::class => 'list, listBySelection, listByCategories, listByRoles, show',
    ),
    array(
        ServicesController::class => '',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Academy',
    'Publications',
    array(
        PublicationsController::class => 'list, listBySelection, listByCategories, listByRoles, show',
    ),
    array(
        PublicationsController::class => '',
    )
);

// BACKEND RELATED

// hook for generating CERIF-XML compliant UUIDs for CRIS entities
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'Digicademy\Academy\Hooks\Backend\DataHandler';

// XClasses to patch core bug with IRRE localization handing (@see Digicademy\Academy\Hooks\Backend\DataHandler 89ff)
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][TYPO3\CMS\Backend\Form\FormDataProvider\TcaInline::class] = [
   'className' => Digicademy\Academy\Xclass\Backend\Form\FormDataProvider\AcademyTcaInline::class
];
// XClasses to patch an IRRE bug with localization handling @see: https://forge.typo3.org/issues/80944
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][TYPO3\CMS\Core\DataHandling\DataHandler::class] = [
   'className' => Digicademy\Academy\Xclass\Core\DataHandling\AcademyDataHandler::class
];
// @TODO: report core bug for 12.4 (fatal error due to wrong array access on int)
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][TYPO3\CMS\Backend\Form\FormDataProvider\TcaInlineIsOnSymmetricSide::class] = [
   'className' => Digicademy\Academy\Xclass\Backend\Form\FormDataProvider\AcademyTcaInlineIsOnSymmetricSide::class
];
