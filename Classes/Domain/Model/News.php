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

use Exception;
use GeorgRinger\News\Domain\Model\News as NewsDefault;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Represents news about research activities.
 *
 * NOTE: We CAN NOT use the RelationsTrait. The relations
 * property MUST be called $newsRelations as it - according to
 * extbase doctrine - MUST match to the news_relations field
 * that extends tx_news_domain_model_news for this entity type.
 * Why not just the field relations? BECAUSE $eventRelations
 * of the Event Model extend precisely the same table (with the
 * field "event_relations"). If the field was jus called "relations"
 * it would not be possible to differentiate between relations
 * to news and relations to events.
 *
 * @author Torsten Schrade <torsten.schrade@adwmainz.de>
 * @author Frodo Podschwadek <frodo.podschwadek@adwmainz.de>
 * @author Linnaea Söhn <linnaea.soehn@adwmainz.de>
 */

class News extends NewsDefault
{
    /**
     * Relations with other entities.
     *
     * @var ObjectStorage<Relations>|null
     */
    protected ?ObjectStorage $newsRelations;

    /**
     * Initialize relation objects
     */
    public function __construct(
    )
    {
        parent::__construct();
        $this->newsRelations = new ObjectStorage();
    }

    /**
     * Returns the relations
     * @return ObjectStorage<Relations>|null $newsRelations
     * @throws Exception
     */
    public function getNewsRelations(): ?ObjectStorage
    {
        return $this->newsRelations;
    }

    /**
     * Sets the relations
     *
     * @param ObjectStorage<Relations> $newsRelations
     */
    public function setNewsRelations(ObjectStorage $newsRelations): void
    {
        $this->newsRelations = $newsRelations;
    }
}
