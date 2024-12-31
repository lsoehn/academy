<?php

namespace Digicademy\Academy\Domain\Repository;

/***************************************************************
 *  Copyright notice
 *
 *  Torsten Schrade <Torsten.Schrade@adwmainz.de>, Academy of Sciences and Literature | Mainz
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;

class CommonRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * Finds selected objects
     *
     * @param string $selectedObjects
     *
     * @return object
     */
    public function findBySelection(string $selectedObjects): object
    {
        $query = $this->createQuery();

        $constraints = array();

        $selectedObjects = GeneralUtility::trimExplode(',', $selectedObjects);

        foreach ($selectedObjects as $selectedObject) {
            $constraints[] = $query->equals('uid', $selectedObject);
        }

        $query->matching(
            $query->logicalOr(...array_values($constraints))
        );

        $result = $query->execute();

        return $result;
    }

    /**
     * Finds objects based on selected categories
     *
     * @param string $selectedCategories
     *
     * @return object
     * @throws InvalidQueryException
     */
    public function findByCategories(string $selectedCategories): object
    {
        $query = $this->createQuery();

        $constraints = array();

        $selectedCategories = GeneralUtility::trimExplode(',', $selectedCategories);

        foreach ($selectedCategories as $selectedCategory) {
            $constraints[] = $query->contains('categories', $selectedCategory);
        }

        // @TODO: implement OR mode as well
        $query->matching(
            $query->logicalAnd(...array_values($constraints))
        );

        $result = $query->execute();

        return $result;
    }

    /**
     * Finds objects based on a specific role/relation
     *
     * @param integer $role
     *
     * @return object
     */
    public function findByRole(int $role): object
    {
        // @TODO: change this to allow multiple selected roles
        $query = $this->createQuery();

        $constraints = array();
        $constraints[] = $query->equals('relations.role', $role);

        $query->matching(
            $query->logicalAnd(...array_values($constraints))
        );

        $result = $query->execute();

        return $result;
    }

    /**
     * Finds objects based on a specific role/relation
     *
     * @param array $filters
     *
     * @return object
     * @throws InvalidQueryException
     */
    public function findByFilters(array $filters): object
    {
        $query = $this->createQuery();

        $outerConstraints = [];

        if (array_key_exists('selectedCategories', $filters) && $filters['selectedCategories']) {
            $innerConstraints = [];
            $selectedCategories = GeneralUtility::trimExplode(',', $filters['selectedCategories']);
            foreach ($selectedCategories as $selectedCategory) {
                $innerConstraints[] = $query->contains('categories', $selectedCategory);
            }
            $outerConstraints[] = $query->logicalAnd(...array_values($innerConstraints));
        }

        if (array_key_exists('selectedEntities', $filters) && $filters['selectedEntities']) {
            $innerConstraints = [];
            $selectedEntities = preg_replace('/tx_academy_domain_model_.*?_/','', $filters['selectedEntities']);

            $selectedEntities = GeneralUtility::trimExplode(',', $selectedEntities);
            foreach ($selectedEntities as $selectedEntity) {
                $innerConstraints[] = $query->equals('uid', $selectedEntity);
            }
            $outerConstraints[] = $query->logicalOr(...array_values($innerConstraints));
        }

        if (array_key_exists('selectedRoles', $filters) && $filters['selectedRoles']) {
            $innerConstraints = [];
            $roles = GeneralUtility::trimExplode(',', $filters['selectedRoles']);
            foreach ($roles as $role) {
                $innerConstraints[] = $query->equals('relations.role', $role);
            }
            $outerConstraints[] = $query->logicalAnd(...array_values($innerConstraints));
        }

        $query->matching(
            $query->logicalAnd(...array_values($outerConstraints))
        );

        $result = $query->execute();

        return $result;
    }

}
