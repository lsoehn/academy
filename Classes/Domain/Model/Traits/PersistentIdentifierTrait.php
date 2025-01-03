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

namespace Digicademy\Academy\Domain\Model\Traits;

use TYPO3\CMS\Extbase\Annotation\Validate;

/**
 * Provides all necessary variables and methods for handling model persistent
 * identifier properties.
 *
 * @author Frodo Podschwadek <frodo.podschwadek@adwmainz.de>
 * @author Linnaea Söhn <linnaea.soehn@adwmainz.de>
 */
trait PersistentIdentifierTrait
{
    /**
     * @TODO: Team reminder - we MUST NOT expect a persistent identifier to always exist.
     * There are projects where this property was never and probably will
     * never be used strategically (like the ADW-HP). Therefore, notEmpty validation
     * is dropped from 12.4 onwards (if projects still want to make sure this property exists they
     * can override and validate it downstream).
     * @var string
     */
    protected string $persistentIdentifier;

    /**
     * Returns the persistentIdentifier
     *
     * @return string $persistentIdentifier
     */
    public function getPersistentIdentifier(): string
    {
        return $this->persistentIdentifier;
    }

    /**
     * Sets the persistentIdentifier
     *
     * @param string $persistentIdentifier
     */
    public function setPersistentIdentifier(string $persistentIdentifier): void
    {
        $this->persistentIdentifier = $persistentIdentifier;
    }
}
