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
use GeorgRinger\Eventnews\Domain\Model\News as EventNews;
use Exception;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * An event in the research domain (like a conference, workshop,
 * hackathon etc.)
 *
 * @author Torsten Schrade <torsten.schrade@adwmainz.de>
 * @author Frodo Podschwadek <frodo.podschwadek@adwmainz.de>
 * @author Linnaea Söhn <linnaea.soehn@adwmainz.de>
 */

class Events extends EventNews
{
    use RelationsTrait;

    protected const RELATIONS_CRITERION = 'event_symmetric';

    /**
     * Returns the relations
     *
     * For backwards compatibility, we keep this method as a wrapper around the
     * generic getRelations() method from the Relations trait.
     *
     * @return ObjectStorage<Relations> $eventRelations
     * @throws Exception
     */
    public function getEventRelations(): ObjectStorage
    {
        return $this->getRelations();
    }

    /**
     * Sets the relations
     *
     * For backwards compatibility, we keep this method as a wrapper around the
     * generic setRelations() method from the Relations trait.
     *
     * @param ObjectStorage<Relations> $eventRelations
     */
    public function setEventRelations(ObjectStorage $eventRelations): void
    {
        $this->setRelations($eventRelations);
    }
}
