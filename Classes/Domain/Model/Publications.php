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
    DescriptionTrait,
    IdentifierTrait,
    ImageTrait,
    PageTrait,
    PersistentIdentifierTrait,
    RelationsTrait,
    SlugTrait,
    TitleTrait
};
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Represents a research publication
 *
 * @author Torsten Schrade <torsten.schrade@adwmainz.de>
 * @author Frodo Podschwadek <frodo.podschwadek@adwmainz.de>
 * @author Linnaea Söhn <linnaea.soehn@adwmainz.de>
 */

class Publications extends AbstractEntity
{
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
    use TitleTrait;

    protected const RELATIONS_CRITERION = 'publication_symmetric';

    /**
     * A subtitle for the publication
     *
     * @var string $subtitle
     */
    protected $subtitle;

    /**
     * An abbreviation for the publication
     *
     * @var string $abbreviation
     */
    protected $abbreviation;

    /**
     * A volume for the publication
     *
     * @var string $volume
     */
    protected $volume;

    /**
     * A number for the publication
     *
     * @var string $number
     */
    protected $number;

    /**
     * An issue for the publication
     *
     * @var string $issue
     */
    protected $issue;

    /**
     * An edition for the publication
     *
     * @var string $edition
     */
    protected $edition;

    /**
     * A series for the publication
     *
     * @var string $series
     */
    protected $series;

    /**
     * A startPage for the publication
     *
     * @var string $startPage
     */
    protected $startPage;

    /**
     * An endPage for the publication
     *
     * @var string $endPage
     */
    protected $endPage;

    /**
     * totalPages for the publication
     *
     * @var string $totalPages
     */
    protected $totalPages;

    /**
     * A bibliographic note
     *
     * @var string $bibliographicNote
     */
    protected $bibliographicNote;

    /**
     * Returns the subtitle
     *
     * @return string $subtitle
     */
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    /**
     * Sets the subtitle
     *
     * @param string $subtitle
     */
    public function setSubtitle(string $subtitle): void
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Returns the abbreviation
     *
     * @return string $abbreviation
     */
    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }

    /**
     * Sets the abbreviation
     *
     * @param string $abbreviation
     */
    public function setAbbreviation(string $abbreviation): void
    {
        $this->abbreviation = $abbreviation;
    }

    /**
     * Returns the volume
     *
     * @return string $volume
     */
    public function getVolume(): string
    {
        return $this->volume;
    }

    /**
     * Sets the volume
     *
     * @param string $volume
     */
    public function setVolume(string $volume): void
    {
        $this->volume = $volume;
    }

    /**
     * Returns the number
     *
     * @return string $number
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * Sets the number
     *
     * @param string $number
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * Returns the issue
     *
     * @return string $issue
     */
    public function getIssue(): string
    {
        return $this->issue;
    }

    /**
     * Sets the issue
     *
     * @param string $issue
     */
    public function setIssue(string $issue): void
    {
        $this->issue = $issue;
    }

    /**
     * Returns the edition
     *
     * @return string $edition
     */
    public function getEdition(): string
    {
        return $this->edition;
    }

    /**
     * Sets the edition
     *
     * @param string $edition
     */
    public function setEdition(string $edition): void
    {
        $this->edition = $edition;
    }

    /**
     * Returns the series
     *
     * @return string $series
     */
    public function getSeries(): string
    {
        return $this->series;
    }

    /**
     * Sets the series
     *
     * @param string $series
     */
    public function setSeries(string $series): void
    {
        $this->series = $series;
    }

    /**
     * Returns the startPage
     *
     * @return string $startPage
     */
    public function getStartPage(): string
    {
        return $this->startPage;
    }

    /**
     * Sets the startPage
     *
     * @param string $startPage
     */
    public function setStartPage(string $startPage): void
    {
        $this->startPage = $startPage;
    }

    /**
     * Returns the endPage
     *
     * @return string $endPage
     */
    public function getEndPage(): string
    {
        return $this->endPage;
    }

    /**
     * Sets the endPage
     *
     * @param string $endPage
     */
    public function setEndPage(string $endPage): void
    {
        $this->endPage = $endPage;
    }

    /**
     * Returns the totalPages
     *
     * @return string $totalPages
     */
    public function getTotalPages(): string
    {
        return $this->totalPages;
    }

    /**
     * Sets the totalPages
     *
     * @param string $totalPages
     */
    public function setTotalPages(string $totalPages): void
    {
        $this->totalPages = $totalPages;
    }

    /**
     * Returns the bibliographicNote
     *
     * @return string $bibliographicNote
     */
    public function getBibliographicNote(): string
    {
        return $this->bibliographicNote;
    }

    /**
     * Sets the bibliographicNote
     *
     * @param string $bibliographicNote
     */
    public function setBibliographicNote(string $bibliographicNote): void
    {
        $this->bibliographicNote = $bibliographicNote;
    }
}
