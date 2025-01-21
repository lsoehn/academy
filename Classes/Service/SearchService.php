<?php

/***************************************************************
 *  Copyright notice
 *
 *  Copyright (C) 2011-2025 Academy of Sciences and Literature | Mainz
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

namespace Digicademy\Academy\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This service implements search by query over all or single CRIS entities
 *
 * @author Torsten Schrade <torsten.schrade@adwmainz.de>
 */

class SearchService
{

    public function __construct(
    ) {}

    /**
     * Performs a search query
     *
     * @param array $arguments
     * @param array $settings
     *
     * @return array
     */
    public function search(array $arguments, array $settings): array
    {
        $result = [];

        $allTypes = [
            'persons' => 'PersonsRepository',
            'units' => 'UnitsRepository',
            'projects' => 'ProjectsRepository',
            'media' => 'MediaRepository',
            'news' => 'NewsRepository',
            'events' => 'EventsRepository',
            'products' => 'ProductsRepository',
            'services' => 'ServicesRepository',
            'publications' => 'PublicationsRepository',
            'pages' => 'PagesRepository',
        ];
        $types = $arguments['type'] ?? $allTypes;

        foreach ($types as $key => $type) {
            if (array_key_exists($key, $allTypes)) {
                $repositoryClass = 'Digicademy\\Academy\\Domain\\Repository\\' . $allTypes[$key];
                if (class_exists($repositoryClass)) {
                    $repository = GeneralUtility::makeInstance($repositoryClass);

                    $querySettings = $repository->createQuery()->getQuerySettings();
                    $querySettings->setRespectStoragePage(false);
                    $repository->setDefaultQuerySettings($querySettings);

                    $result[$key] = $repository->searchAll($arguments);
                }
            }
        }

        return $result;
    }

}