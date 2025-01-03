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
    CategoriesTrait,
    ContentElementsTrait,
    DateRangeTrait,
    ImageTrait,
    PageTrait,
    PersistentIdentifierTrait,
    RelationsTrait,
    SlugTrait,
    SortingTrait
};
use TYPO3\CMS\Extbase\Annotation\Validate;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Represents a person involved in the research domain
 *
 * @author Torsten Schrade <torsten.schrade@adwmainz.de>
 * @author Frodo Podschwadek <frodo.podschwadek@adwmainz.de>
 * @author Linnaea Söhn <linnaea.soehn@adwmainz.de>
 */

class Persons extends AbstractEntity
{
    use CategoriesTrait;
    use ContentElementsTrait;
    use DateRangeTrait;
    use ImageTrait;
    use PageTrait;
    use PersistentIdentifierTrait;
    use RelationsTrait;
    use SlugTrait;
    use SortingTrait;

    protected const RELATIONS_CRITERION = 'person_symmetric';

    /**
     * Given name of the person
     *
     * @var string $givenName
     */
    protected $givenName;

    /**
     * Additional name
     *
     * @var string $additionalName
     */
    protected $additionalName;

    /**
     * Family name of the person
     *
     * @var string $familyName
     * @Validate("NotEmpty")
     */
    protected $familyName;

    /**
     * honorificSuffix
     *
     * @var string $honorificPrefix
     */
    protected $honorificPrefix;

    /**
     * honorificSuffix
     *
     * @var string $honorificSuffix
     */
    protected $honorificSuffix;

    /**
     * cv
     *
     * @var string $cv
     */
    protected $cv;

    /**
     * expertise
     *
     * @var string $expertise
     */
    protected $expertise;

    /**
     * awards
     *
     * @var string $awards
     */
    protected $awards;

    /**
     * publications
     *
     * @var string $publications
     */
    protected $publications;

    /**
     * Returns the given name
     *
     * @return string $givenName
     */
    public function getGivenName(): string
    {
        return $this->givenName;
    }

    /**
     * Sets the givenName
     *
     * @param string $givenName
     */
    public function setGivenName(string $givenName): void
    {
        $this->givenName = $givenName;
    }

    /**
     * Returns the additional name
     *
     * @return string $additionalName
     */
    public function getAdditionalName(): string
    {
        return $this->additionalName;
    }

    /**
     * Sets the additionalName
     *
     * @param string $additionalName
     */
    public function setAdditionalName(string $additionalName): void
    {
        $this->additionalName = $additionalName;
    }

    /**
     * Returns the family name
     *
     * @return string $familyName
     */
    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    /**
     * Sets the familyName
     *
     * @param string $familyName
     */
    public function setFamilyName(string $familyName): void
    {
        $this->familyName = $familyName;
    }

    /**
     * Returns the honorific prefix
     *
     * @return string $honorificPrefix
     */
    public function getHonorificPrefix(): string
    {
        return $this->honorificPrefix;
    }

    /**
     * Sets the honorific prefix
     *
     * @param string $honorificPrefix
     */
    public function setHonorificPrefix(string $honorificPrefix): void
    {
        $this->honorificPrefix = $honorificPrefix;
    }

    /**
     * Returns the honorific suffix
     *
     * @return string $honorificSuffix
     */
    public function getHonorificSuffix(): string
    {
        return $this->honorificSuffix;
    }

    /**
     * Sets the honorific suffix
     *
     * @param string $honorificSuffix
     */
    public function setHonorificSuffix(string $honorificSuffix): void
    {
        $this->honorificSuffix = $honorificSuffix;
    }

    /**
     * Returns the CV
     *
     * @return string $cv
     */
    public function getCv(): string
    {
        return $this->cv;
    }

    /**
     * Sets the CV
     *
     * @param string $cv
     */
    public function setCv(string $cv): void
    {
        $this->cv = $cv;
    }

    /**
     * Returns the expertise
     *
     * @return string $expertise
     */
    public function getExpertise(): string
    {
        return $this->expertise;
    }

    /**
     * Sets the expertise
     *
     * @param string $expertise
     */
    public function setExpertise(string $expertise): void
    {
        $this->expertise = $expertise;
    }

    /**
     * Returns the awards
     *
     * @return string $awards
     */
    public function getAwards(): string
    {
        return $this->awards;
    }

    /**
     * Sets the awards
     *
     * @param string $awards
     */
    public function setAwards(string $awards): void
    {
        $this->awards = $awards;
    }

    /**
     * Returns the publications
     *
     * @return string $publications
     */
    public function getPublications(): string
    {
        return $this->publications;
    }

    /**
     * Sets the publications
     *
     * @param string $publications
     */
    public function setPublications(string $publications): void
    {
        $this->publications = $publications;
    }
}
