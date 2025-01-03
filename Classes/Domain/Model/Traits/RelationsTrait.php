<?php

/***************************************************************
 *  Copyright notice
 *
 *  Copyright (C) 2024 Academy of Sciences and Literature | Mainz
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

namespace Digicademy\Academy\Domain\Model\Traits;

use Digicademy\Academy\Domain\Model\Relations;
use Digicademy\Academy\Domain\Repository\RelationsRepository;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Provides all necessary variables and methods for handling model relation
 * properties.
 *
 * Every class implementing this trait MUST define the following
 * constant:
 *
 * protected const RELATIONS_CRITERION = '{ property }';
 *
 * The value is the property name (i.e., name of the table column) by which the
 * model is related to another type of models, e.g. 'medium_symmetric',
 * 'project_symmetric', etc. Note that for now, models are always looking
 * for symmetric relations.
 *
 * @author Frodo Podschwadek <frodo.podschwadek@adwmainz.de>
 * @author Linnaea Söhn <linnaea.soehn@adwmainz.de>
 */
trait RelationsTrait
{
    /**
     * Relations with other entities.
     *
     * @var ObjectStorage<Relations>
     *
     * @Lazy
     */
    protected ObjectStorage $relations;

    /**
     * @var RelationsRepository
     */
    protected RelationsRepository $relationsRepository;

    /**
     * @param  RelationsRepository $relationsRepository
     */
    public function injectRelationsRepository(
        RelationsRepository $relationsRepository
    ): void {
        $this->relationsRepository = $relationsRepository;
    }

    /**
     * Returns the relations
     *
     * In the past, the Academy Extension used magic methods (findBy[Property]()).
     * These will disappear in TYPO3 14, so we already refactored when upgrading
     * to 12.4.
     *
     * @see https://api.typo3.org/11.5/classes/TYPO3-CMS-Extbase-Persistence-Repository.html#method___call
     *
     * @return ObjectStorage<Relations> $relations
     */
    public function getRelations(): ObjectStorage
    {
        if (!defined(self::RELATIONS_CRITERION)) {
            throw new \Exception(
                'Criterion to get relations by not set.',
                855563544182
            );
        }

        if (!is_string(self::RELATIONS_CRITERION)) {
            throw new \Exception(
                'Criterion to get relations by not a string.',
                855563544183
            );
        }

        if (empty($this->persistentIdentifier)) {
            throw new \Exception(
                'Persistent identifier to get relations for not set.',
                855563544184
            );
        }

        $symmetricRelations = $this->relationsRepository->findBy(
            [
                self::RELATIONS_CRITERION => $this->persistentIdentifier
            ]
        )->toArray();
        foreach ($symmetricRelations as $symmetricRelation) {
            $this->relations->attach($symmetricRelation);
        }
        return $this->relations;
    }

    /**
     * Sets the relations
     *
     * @param ObjectStorage<Relations> $relations
     */
    public function setRelations(ObjectStorage $relations): void
    {
        $this->relations = $relations;
    }
}
