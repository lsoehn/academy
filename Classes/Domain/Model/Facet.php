<?php

namespace Digicademy\Academy\Domain\Model;

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

/**
 * A facet in this extension's context is understood as a generic class for
 * filtering objects by certain properties. It can contain categories,
 * roles or any other type of assignable object property that is abstracted
 * into this class. Facets can be displayed in trees or lists with the FacetService.
 * Therefore, they just consist of an uid, a label, a count (of objects) and
 * a property that indicates if a facet is currently selected or not.
 */

class Facet
{
    /**
     * uid
     *
     * @var int
     */
    protected int $uid;

    /**
     * label
     *
     * @var string
     */
    protected string $label;

    /**
     * count
     *
     * @var int
     */
    protected int $count = 0;

    /**
     * selected
     *
     * @var int
     */
    protected int $selected = 0;

    /**
     * Returns the uid
     *
     * @return int $uid
     */
    public function getUid(): int
    {
        return $this->uid;
    }

    /**
     * Sets the uid
     *
     * @param int $uid
     */
    public function setUid(int $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * Returns the label
     *
     * @return string $label
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Sets the label
     *
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * Returns the count
     *
     * @return int $count
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * Sets the count
     *
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * Returns selected property
     *
     * @return int $selected
     */
    public function getSelected(): int
    {
        return $this->selected;
    }

    /**
     * Sets the selected property
     *
     * @param int $selected
     */
    public function setSelected(int $selected): void
    {
        $this->selected = $selected;
    }
}
