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

namespace Digicademy\Academy\Domain\Model;

use Digicademy\Academy\Domain\Model\Traits\RelationsTrait;
use Exception;
use GeorgRinger\News\Domain\Model\News as GeorgRingerNews;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Represents news about research activities
 *
 * @author Torsten Schrade <torsten.schrade@adwmainz.de>
 * @author Frodo Podschwadek <frodo.podschwadek@adwmainz.de>
 * @author Linnaea Söhn <linnaea.soehn@adwmainz.de>
 */

class News extends GeorgRingerNews
{
    use RelationsTrait;

    // note: this logic appears not to be needed any more in TYPO3 12.4
    // symmetric relations seem to be fetched just as asymmetric relations
    // @TODO Team note: if it was used, it should not contain the database field name but the propertyName
    protected const RELATIONS_CRITERION = 'newsSymmetric';

    /**
     * Returns the relations
     *
     * @return ObjectStorage<Relations> $newsRelations
     * @throws Exception
     */
    public function getNewsRelations(): ObjectStorage
    {
        return $this->getRelations();
    }

    /**
     * Sets the relations
     *
     * For backwards compatibility, we keep this method as a wrapper around the
     * generic setRelations() method from the Relations trait.
     *
     * @param ObjectStorage<Relations> $newsRelations
     */
    public function setNewsRelations(ObjectStorage $newsRelations): void
    {
        $this->setRelations($newsRelations);
    }
}
