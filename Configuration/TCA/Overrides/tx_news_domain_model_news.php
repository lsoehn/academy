<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

$tca = [
    'type' => [
        'exclude' => false,
        'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.doktype_formlabel',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.type.I.0', 0, 'ext-news-type-default'],
                ['LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.type.I.1', 1, 'ext-news-type-internal'],
                ['LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.type.I.2', 2, 'ext-news-type-external'],
                ['LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_news_domain_model_news.type.I.3', 3, 'ext-news-type-default'],
            ],
            'fieldWizard' => [
                'selectIcons' => [
                    'disabled' => false,
                ],
            ],
            'size' => 1,
            'maxitems' => 1,
        ]
    ],
    'news_relations' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_news.news_relations',
        'l10n_display' => 'defaultAsReadonly',
        'l10n_mode' => 'exclude',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_academy_domain_model_relations',
            'foreign_field' => 'news',
            'foreign_sortby' => 'sorting',
            'foreign_label' => 'news',
            'symmetric_field' => 'news_symmetric',
            'symmetric_sortby' => 'sorting_symmetric',
            'maxitems' => 9999,
            'behaviour' => [
                'disableMovingChildrenWithParent' => 1,
//                    'allowLanguageSynchronization' => true,
            ],
            'appearance' => [
                'collapseAll' => 1,
                'expandSingle' => 1,
                'useSortable' => true,
                'levelLinksPosition' => 'bottom',
            ],
            'overrideChildTca' => [
                'columns' => [
                    'type' => [
                        'config' => [
                            'items' => [
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.14',
                                    'value' => '14'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.22',
                                    'value' => '22'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.33',
                                    'value' => '33'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.40',
                                    'value' => '40'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.41',
                                    'value' => '41'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.42',
                                    'value' => '42'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.43',
                                    'value' => '43'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.74',
                                    'value' => '74'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.84',
                                    'value' => '84'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.94',
                                    'value' => '94'
                                ],
                            ]
                        ]
                    ]
                ],
            ],
        ],
    ],
    'event_relations' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_news.event_relations',
        'l10n_display' => 'defaultAsReadonly',
        'l10n_mode' => 'exclude',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_academy_domain_model_relations',
            'foreign_field' => 'event',
            'foreign_sortby' => 'sorting',
            'foreign_label' => 'news',
            'symmetric_field' => 'event_symmetric',
            'symmetric_sortby' => 'sorting_symmetric',
            'maxitems' => 9999,
            'behaviour' => [
                'disableMovingChildrenWithParent' => 1,
//                    'allowLanguageSynchronization' => true,
            ],
            'appearance' => [
                'collapseAll' => 1,
                'expandSingle' => 1,
                'useSortable' => true,
                'levelLinksPosition' => 'bottom',
            ],
            'overrideChildTca' => [
                'columns' => [
                    'type' => [
                        'config' => [
                            'items' => [
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.13',
                                    'value' => '13'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.23',
                                    'value' => '23'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.41',
                                    'value' => '41'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.34',
                                    'value' => '34'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.50',
                                    'value' => '50'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.51',
                                    'value' => '51'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.52',
                                    'value' => '52'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.75',
                                    'value' => '75'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.85',
                                    'value' => '85'
                                ],
                                [
                                    'label' => 'LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_relations.type.I.95',
                                    'value' => '95'
                                ],
                            ]
                        ]
                    ]
                ],
            ],
        ],
    ],
];

ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news', $tca);

$GLOBALS['TCA']['tx_news_domain_model_news']['types']['3']['showitem'] = $GLOBALS['TCA']['tx_news_domain_model_news']['types']['0']['showitem'];

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    'news_relations',
    '0',
    ''
);

ExtensionManagementUtility::addToAllTCAtypes(
    'tx_news_domain_model_news',
    'event_relations',
    '3',
    ''
);
