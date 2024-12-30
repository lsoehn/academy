<?php

namespace Digicademy\Academy\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  Torsten Schrade <Torsten.Schrade@adwmainz.de>, Academy of Sciences and Literature | Mainz
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

use Digicademy\Academy\Domain\Repository\RelationsRepository;
use GeorgRinger\News\Domain\Model\TtContent;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use Digicademy\ChfTime\Domain\Model\DateRanges;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Projects extends AbstractEntity
{

    /**
     * persistentIdentifier
     *
     * @var string
     */
    protected string $persistentIdentifier;

    /**
     * The identifier of the project
     *
     * @var string $identifier
     */
    protected string $identifier;

    /**
     * The title of the project
     *
     * @var string $title
     * @Extbase\Validate("NotEmpty")
     */
    protected string $title;

    /**
     * An acronym for the project
     *
     * @var string $acronym
     */
    protected string $acronym;

    /**
     * @var string $slug
     */
    protected string $slug;

    /**
     * The internal sorting for project list (if not alphabetic)
     *
     * @var string $sorting
     */
    protected string $sorting;

    /**
     * A description of the projects scientific activities
     *
     * @var string $description
     */
    protected string $description;

    /**
     * Additional free text information about a project
     *
     * @var ObjectStorage<TtContent>
     */
    protected ObjectStorage $contentElements;

    /**
     * Image
     *
     * @var ObjectStorage<FileReference>
     * @Extbase\ORM\Lazy
     */
    protected ObjectStorage $image;

    /**
     * Duration of the project
     *
     * @var ?DateRanges $dateRange
     */
    protected ?DateRanges $dateRange;

    /**
     * The page where the project details are listed
     *
     * @var integer $page
     */
    protected int $page;

    /**
     * Relations of the project with persons, events, news, media etc.
     *
     * @var ObjectStorage<Relations>
     * @Extbase\ORM\Lazy
     */
    protected ObjectStorage $relations;

    /**
     * Selected categories for the project
     *
     * @var ObjectStorage<Categories>
     * @Extbase\ORM\Lazy
     */
    protected ObjectStorage $categories;

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
     *
     * @return void
     */
    public function setPersistentIdentifier(string $persistentIdentifier): void
    {
        $this->persistentIdentifier = $persistentIdentifier;
    }

    /**
     * Returns the identifier
     *
     * @return string $identifier
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Sets the identifier
     *
     * @param string $identifier
     *
     * @return void
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Returns the acronym
     *
     * @return string $acronym
     */
    public function getAcronym(): string
    {
        return $this->acronym;
    }

    /**
     * Sets the acronym
     *
     * @param string $acronym
     *
     * @return void
     */
    public function setAcronym(string $acronym): void
    {
        $this->acronym = $acronym;
    }

    /**
     * Returns the slug
     *
     * @return string $slug
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Sets the slug
     *
     * @param string $slug
     *
     * @return void
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * Returns the sorting
     *
     * @return string $sorting
     */
    public function getSorting(): string
    {
        return $this->sorting;
    }

    /**
     * Sets the sorting
     *
     * @param string $sorting
     *
     * @return void
     */
    public function setSorting(string $sorting): void
    {
        $this->sorting = $sorting;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     *
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get content elements
     *
     * @return ObjectStorage
     */
    public function getContentElements(): ObjectStorage
    {
        return $this->contentElements;
    }

    /**
     * Set content element list
     *
     * @param ObjectStorage $contentElements content elements
     * @return void
     */
    public function setContentElements(ObjectStorage $contentElements): void
    {
        $this->contentElements = $contentElements;
    }

    /**
     * Returns the image
     *
     * @return ObjectStorage<FileReference> $image
     */
    public function getImage(): ObjectStorage
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param ObjectStorage<FileReference> $image
     *
     * @return void
     */
    public function setImage(ObjectStorage $image)
    {
        $this->image = $image;
    }

    /**
     * Returns the dateRange
     *
     * @return DateRanges|null $dateRange
     */
    public function getDateRange(): ?DateRanges
    {
        return $this->dateRange;
    }

    /**
     * Sets the dateRange
     *
     * @param DateRanges $dateRange
     *
     * @return void
     */
    public function setDateRange(DateRanges $dateRange): void
    {
        $this->dateRange = $dateRange;
    }

    /**
     * Returns the page
     *
     * @return integer $page
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Sets the page
     *
     * @param integer $page
     *
     * @return void
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * Returns the relations
     *
     * @return ObjectStorage<Relations> $relations
     */
    public function getRelations(): ObjectStorage
    {
        $relationsRepository = GeneralUtility::makeInstance(RelationsRepository::class);
        $symmetricRelations = $relationsRepository->findByProjectSymmetric($this);
        if ($symmetricRelations) {
            foreach ($symmetricRelations as $symmetricRelation) {
                $this->relations->attach($symmetricRelation);
            }
        }
        return $this->relations;
    }

    /**
     * Sets the relations
     *
     * @param ObjectStorage<Relations> $relations
     *
     * @return void
     */
    public function setRelations($relations): void
    {
        $this->relations = $relations;
    }

    /**
     * Returns the categories
     *
     * @return ObjectStorage<Categories> $categories
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * Sets the categories
     *
     * @param ObjectStorage<Categories> $categories
     *
     * @return void
     */
    public function setCategories($categories): void
    {
        $this->categories = $categories;
    }

}
