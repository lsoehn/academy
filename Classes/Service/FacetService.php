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

/**
 * A facet in this extension's context is understood as a generic class for
 * filtering objects by certain properties. It can contain categories,
 * roles or any other type of assignable object property.
 * This service provides facet tree structures and mapping of facets
 * to the "real" objects that make up a facet. Currently, just sys_categories
 * are implemented, but we could well think of roles and other properties
 * of objects used for filtering.
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
     * Builds a two-dimensional structure of facet groups (parent + children)
     *
     * @param array $settings
     *
     * @return array
     */
    public function prepareFacetGroups(array $settings): array
    {
        $facetGroups = [];

        if ($settings['facetTable'] == 'sys_category' && count($settings['parents']) > 0) {
            foreach ($settings['parents'] as $key => $value) {
                $maxLevels = (isset($value['maxLevels']) && $value['maxLevels'] > 0) ? $value['maxLevels'] : 1;
                $getChildrenOnLevel = (isset($value['getChildrenOnLevel']) && $value['getChildrenOnLevel'] > 0) ? $value['getChildrenOnLevel'] : 0;
                // get the records from the category repository
                $facetGroups[$key] = $this->categoriesRepository->findAllChildren(
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
     * Sorts a given list of facets into a facet tree
     *
     * @param array $facets
     * @param array $facetTree
     * @param array $selectedFacets
     *
     * @return array
     */
    public function sortIntoFacetTree(
        array $facets,
        array $facetTree,
        array $selectedFacets = []
    ): array {

        $selectedFacetUids = [];
        if (is_array($selectedFacets)) {
            foreach ($selectedFacets as $selectedFacet) {
                $selectedFacetUids[] = $selectedFacet->getUid();
            }
        }

        $facetResult = [];

        if ($facets && $facetTree) {
            foreach ($facets as $facet) {
                $facetUid = $facet->getUid();
                foreach (array_keys($facetTree) as $facetTreeGroup) {
                    if (in_array($facetUid, $facetTree[$facetTreeGroup])) {
                        if (in_array($facetUid, $selectedFacetUids)) {
                            $facet->setSelected(1);
                        }
                        $facetResult[$facetTreeGroup][] = $facet;
                    }
                }
            }
        }

        // sort content of all branches alphabetically
        foreach ($facetResult as $branch => $facets) {
            $facetResult[$branch] = $this->sortFacets($facets);
        }

        return $facetResult;
    }

    /**
     * Sorts an array containing facet objects with the help of a stringified version of the same array
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
     * Maps a given array of rows to Facet objects
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
        $category = $this->categoriesRepository->findByUid($uid);
        $label = $category->getTitle();
        return $label;
    }

    /**
     * Generates a simple facetTree configuration from plain CSV uids.
     * No max levels, no label overrides, no getChildrenOnLevel.
     *
     * @param string $facetTable
     * @param string $facetParents
     * @param int $facetCount
     * @param int $facetSelection
     *
     * @return array
     */
    public function generateConfiguration(
        string $facetTable,
        string $facetParents,
        int $facetCount = 1,
        int $facetSelection = 1
    ): array {

        $settings = [
            'facetTable' => $facetTable,
            'facetCount' => $facetCount,
            'facetSelection' => $facetSelection,
        ];

        $uidArray = GeneralUtility::trimExplode(',', $facetParents);
        $parents = [];
        foreach ($uidArray as $uid) {
            $parents[]['uid'] = $uid;
        }
        $settings['parents'] = $parents;

        return $settings;
    }

    /**
     * @param object $repository
     * @param string $facetTable
     * @param string $facetUids
     * @param string $selectedFacets
     * @param int $facetCount
     *
     * @return array
     */
    public function generateFacetTree(
        object $repository,
        string $facetTable,
        string $facetUids,
        string $selectedFacets = '',
        int $facetCount = 1
    ): array {

        $settings = $this->generateConfiguration(
            $facetTable,
            $facetUids
        );

        $facetGroups = $this->prepareFacetGroups($settings);

\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($facetGroups, NULL, 5, FALSE, TRUE, FALSE, array(), array());

        $facetList = [];
        foreach ($facetGroups as $facetGroup) {
            foreach ($facetGroup as $facetUid) {

                // @TODO: take selectedCategories into account
                // @TODO: generalize for other tables
                if ($facetCount) {
                    $objectCount = $repository->findByCategories($facetUid)->count();
                } else {
                    $objectCount = 0;
                }

                // mind: will only return facets with objects (drill down)
                if ($objectCount > 0) {
                    $facetList[] = [
                        'uid' => $facetUid,
                        'count' => $objectCount,
                        'label' => $this->getFacetLabel($facetUid),
                        // @TODO: add check if facet in selected facet
                        'selected' => 0
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

}
