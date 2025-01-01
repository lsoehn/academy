<?php
namespace Digicademy\Academy\Service;

/***************************************************************
 *  Copyright notice
 *
 *  Torsten Schrade <Torsten.Schrade@adwmainz.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This service processes and aligns filters between arguments
 * and settings for all CRIS domain entities.
 */
class FilterService
{
    public function __construct()
    {
    }

    /**
     * Aligns plugin/filter settings and controller arguments for entities
     *
     * @param array $settings
     * @param array $arguments
     *
     * @return array
     */
    public function mergeFilters(array $settings, array $arguments): array
    {
        $filterKeys = ['selectedCategories', 'selectedEntities', 'selectedRoles'];
        $filters = [];

        foreach ($filterKeys as $key) {
            $filters[$key] = $this->mergeFilterValues(
                $settings['filters'][$key] ?? '',
                $arguments['filters'][$key] ?? ''
            );
        }

        return $filters;
    }

    /**
     * Merges filter values from settings and arguments, removes duplicates, and returns a CSV string
     *
     * @param string $settingsValue
     * @param string $argumentsValue
     *
     * @return string
     */
    private function mergeFilterValues(string $settingsValue, string $argumentsValue): string
    {
        $settingsArray = GeneralUtility::trimExplode(',', $settingsValue, true);
        $argumentsArray = GeneralUtility::trimExplode(',', $argumentsValue, true);
        $mergedArray = array_unique(array_merge($settingsArray, $argumentsArray));

        return implode(',', $mergedArray);
    }

    /**
     * Sanitizes filters and selected data
     *
     * @param array $data
     * @param array $allowedKeys
     * @return array
     */
    public function sanitizeFilterData(array $data, array $allowedKeys): array
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $allowedKeys, true)) {
                unset($data[$key]);
            } else {
                $data[$key] = GeneralUtility::intExplode(',', $value, true);
            }
        }
        return $data;
    }

    /**
     * Adds or removes a value from a filter array
     *
     * @param array $filter
     * @param int $value
     * @return array
     */
    public function toggleFilterValue(array $filter, int $value): array
    {
        $key = array_search($value, $filter, true);
        if ($key !== false) {
            unset($filter[$key]);
        } else {
            $filter[] = $value;
        }
        return $filter;
    }

    /**
     * Converts filter arrays to CSV strings
     *
     * @param array $filters
     * @return array
     */
    public function finalizeFilters(array $filters): array
    {
        foreach ($filters as $key => $filter) {
            $filters[$key] = implode(',', $filter);
        }
        return $filters;
    }

}
