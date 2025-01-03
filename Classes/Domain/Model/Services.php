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

use Digicademy\Academy\Domain\Model\Traits\{
    AcronymTrait,
    CategoriesTrait,
    ContentElementsTrait,
    DateRangeTrait,
    DescriptionTrait,
    IdentifierTrait,
    ImageTrait,
    PageTrait,
    PersistentIdentifierTrait,
    RelationsTrait,
    SlugTrait,
    SortingTrait,
    TitleTrait
};
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Represents a service in the research domain
 *
 * @author Torsten Schrade <torsten.schrade@adwmainz.de>
 * @author Frodo Podschwadek <frodo.podschwadek@adwmainz.de>
 * @author Linnaea Söhn <linnaea.soehn@adwmainz.de>
 */

class Services extends AbstractEntity
{
    use AcronymTrait;
    use CategoriesTrait;
    use ContentElementsTrait;
    use DateRangeTrait;
    use DescriptionTrait;
    use IdentifierTrait;
    use ImageTrait;
    use PageTrait;
    use PersistentIdentifierTrait;
    use RelationsTrait;
    use SlugTrait;
    use SortingTrait;
    use TitleTrait;

    protected const RELATIONS_CRITERION = 'service_symmetric';
}
