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

/**
 * Provides all necessary variables and methods for handling value
 * properties. Currently only used by HCard components.
 *
 * @author Frodo Podschwadek <frodo.podschwadek@adwmainz.de>
 * @author Linnaea Söhn <linnaea.soehn@adwmainz.de>
 */
trait ValueTrait
{
    /**
     * The value of the component
     *
     * @var string $value
     */
    protected string $value;

    /**
     * Returns the value
     *
     * @return string $value
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Sets the value
     *
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}
