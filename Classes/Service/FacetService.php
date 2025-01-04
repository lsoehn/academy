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

use Digicademy\Academy\Domain\Repository\CategoriesRepository;
use Digicademy\Academy\Domain\Model\Facet;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Exception;

/**
 * A facet in this extension's context is understood as a generic class for
 * filtering objects by certain properties. It can contain categories,
 * roles or any other type of assignable object property.
 * This service provides facet tree structures and mapping of facets
 * to the "real" objects that make up a facet. Currently, just sys_categories
 * are implemented, but we could well think of roles and other properties
 * of objects used for filtering.
 *
 * @author Torsten Schrade <torsten.schrade@adwmainz.de>
 *
 * # example for a generic facet tree configuration
 * plugin.tx_academy {
 *     settings {
 *         # this TS key can be anything alphanumeric, settings start from below this key
 *         facetTree {
 *             # the table from which to generate the facet tree (required)
 *             facetTable = sys_category
 *             # the parents that make up a facet branch (required)
 *             facetParents {
 *                  # key can be anything alphanumeric
 *                  group_one {
 *                     # uid of the parent record (required)
 *                     uid = 1
 *                     # override the parent's label with this string (optional)
 *                     label = something
 *                     # maximum levels to traverse for children of the parent (optional)
 *                     maxLevels = 3
 *                     # fetches only the children of a specific level during traversal (optional)
 *                     getChildrenOnLevel = 2
 *                  }
 *             }
 *             # displays an object count for each facet (optional)
 *             facetCount = 1
 *          }
 *     }
 * }
 */

class FacetService
{
    /**
     * @param CategoriesRepository $categoriesRepository
     */
    public function __construct(
        protected CategoriesRepository $categoriesRepository
    ) {}

    /**
     * @param object $repository
     * @param array $settings
     * @param array $filters
     *
     * @return array
     * @throws Exception
     */
    public function generateFacetTree(
        object $repository,
        array $settings,
        array $filters
    ): array {

        // prepare facet groups with their children
        $facetGroups = $this->prepareFacetGroups($settings);

        // unless explicitly set to 0 facet count will always be delivered
        (array_key_exists('facetCount', $settings)) ? $facetCount = $settings['facetCount'] : $facetCount = 1;

        $facetList = [];
        foreach ($facetGroups as $facetGroup) {
            foreach ($facetGroup as $facetUid) {

                if ($facetCount) {
                    $filterCopy = $filters;
                    if (array_key_exists('selectedCategories', $filters) && !empty($filters['selectedCategories'])) {
                        $uids =  (string)$facetUid . ',' . $filters['selectedCategories'];
                    } else { $uids = (string)$facetUid; }
                    $filterCopy['selectedCategories'] = $uids;

                    switch ($settings['facetTable']) {
                        case 'sys_category':
                                $objectCount = $repository->findByFilters($filterCopy)->count();
                            break;
                        default:
                            throw new Exception('No facet table was given for counting objects', 1735645845);
                    }
                } else {
                    // in objects per facet are not counted we override the object count so that
                    // the facets will always be included in the tree
                    $objectCount = 1;
                }

                // search in filters if current facet is selected
                $selected = !empty(array_filter($filters, fn($value) => in_array($facetUid, explode(',', $value))));

                // exclude
                (array_key_exists('exclude', $settings) && strpos($settings['exclude'], $facetUid)) ? $exclude = true : $exclude = false;

                // mind: we only return a facet when the object count > 0 (= drill down) or if count is disabled
                if (!$exclude && $objectCount > 0) {
                    $facetList[] = [
                        'uid' => $facetUid,
                        'count' => $objectCount,
                        'label' => $this->getFacetLabel($facetUid),
                        'selected' => $selected
                    ];
                }
            }
        }

        $facetTree = $this->sortIntoFacetTree(
            $this->mapFacets($facetList),
            $facetGroups,
            []
        );

        return $facetTree;
    }

    /**
     * Builds a two-dimensional structure of facet groups (parent + children)
     *
     * @param array $settings
     *
     * @return array
     */
    public function prepareFacetGroups(array $settings): array
    {
        $facetGroups = [];

        if ($settings['facetTable'] == 'sys_category' && count($settings['facetParents']) > 0) {
            foreach ($settings['facetParents'] as $value) {
                $maxLevels = (isset($value['maxLevels']) && $value['maxLevels'] > 0) ? $value['maxLevels'] : 1;
                $getChildrenOnLevel = (isset($value['getChildrenOnLevel']) && $value['getChildrenOnLevel'] > 0) ? $value['getChildrenOnLevel'] : 0;
                // get the records from the category repository
                $facetGroups[$value['uid']] = $this->categoriesRepository->findAllChildren(
                    (int)$value['uid'],
                    // settings for walking down to deeper levels in the category tree or for picking certain
                    (int)$maxLevels,
                    // levels from a given entry point
                    (int)$getChildrenOnLevel
                );
            }
        }

        // @TODO: facets from other tables besides sys_category (like roles) can be implemented here

        return $facetGroups;
    }

    /**
     * Sorts a given list of facets into groups of a facet tree
     *
     * @param array $facetList
     * @param array $facetGroups
     * @param array $selectedFacets
     *
     * @return array
     */
    public function sortIntoFacetTree(
        array $facetList,
        array $facetGroups
    ): array {

        $facetTree = [
            'facetGroups' => [],
            'metaData' => [
                'totalFacets' => count($facetList),
                'totalGroups' => count($facetGroups)
            ],
        ];

        if ($facetList && $facetGroups) {
            foreach ($facetList as $facet) {
                $facetUid = $facet->getUid();
                foreach (array_keys($facetGroups) as $facetGroup) {
                    if (in_array($facetUid, $facetGroups[$facetGroup])) {
                        $facetTree['facetGroups'][$facetGroup]['items'][] = $facet;
                    }
                }
            }
        }

        // sort content of all branches alphabetically
        foreach ($facetTree['facetGroups'] as $facetGroup => $facets) {
            $facetTree['facetGroups'][$facetGroup]['label'] = $this->getFacetLabel($facetGroup);
            $facetTree['facetGroups'][$facetGroup]['items'] = $this->sortFacets($facets['items']);
        }

        return $facetTree;
    }

    /**
     * Sorts an array containing facets with the help of a stringified version of the same array
     *
     * @param array $facets
     *
     * @return array
     */
    public function sortFacets(array $facets): array
    {
        $facetsToSort = [];
        foreach ($facets as $key => $value) {
            $facetsToSort[$key] = $value->getLabel();
        }

        asort($facetsToSort);

        return array_replace($facetsToSort, $facets);
    }

    /**
     * Maps a given array of (database) rows to Facet objects
     *
     * @param array $rows
     * @param array $keys
     *
     * @return array
     */
    public function mapFacets(
        array $rows,
        array $keys = ['uid', 'label', 'count', 'selected']
    ): array {
        $mappedFacets = [];
        $basicFacet = GeneralUtility::makeInstance(Facet::class);
        foreach ($rows as $row) {
            $mappedFacet = clone $basicFacet;

            (is_array($row) && array_key_exists($keys[0], $row))
            ? $mappedFacet->setUid($row[$keys[0]])
            : $mappedFacet->setUid(0);

            (is_array($row) && array_key_exists($keys[0], $row))
            ? $mappedFacet->setLabel($row[$keys[1]])
            : $mappedFacet->setLabel('');

            (is_array($row) && array_key_exists($keys[0], $row))
            ? $mappedFacet->setCount($row[$keys[2]])
            : $mappedFacet->setCount(0);

            (is_array($row) && array_key_exists($keys[0], $row))
            ? $mappedFacet->setSelected($row[$keys[3]])
            : $mappedFacet->setSelected(0);

            $mappedFacets[] = $mappedFacet;
        }
        return $mappedFacets;
    }

    /**
     * Gets the label for a facet from DB
     *
     * @param int $uid
     *
     * @return string
     */
    public function getFacetLabel(int $uid): string
    {
        // @TODO: generalize for other tables
        $category = $this->categoriesRepository->findByUid($uid);
        $label = $category->getTitle();
        return $label;
    }

}
