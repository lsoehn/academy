<?php

namespace Digicademy\Academy\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Torsten Schrade <Torsten.Schrade@adwmainz.de>, Academy of Sciences and Literature | Mainz
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 medium. The TYPO3 medium is
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
use Digicademy\ChfTime\Domain\Model\DateRanges;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Media extends AbstractEntity
{

    /**
     * persistentIdentifier
     *
     * @var string
     *
     * @Extbase\Validate("NotEmpty")
     */
    protected $persistentIdentifier;

    /**
     * Display type of the media object
     *
     * @var integer $type
     */
    protected $type;

    /**
     * Creation date of the typo3 record
     *
     * @var integer $crdate
     */
    protected $crdate;

    /**
     * The title of the medium
     *
     * @var string $title
     * @Extbase\Validate("NotEmpty")
     */
    protected $title;

    /**
     * A description of the mediums scientific activities
     *
     * @var string $description
     */
    protected $description;

    /**
     * Creation date of the medium
     *
     * @var DateRanges $dateRange
     */
    protected $dateRange = null;

    /**
     * @var string $slug
     */
    protected $slug;

    /**
     * Images
     *
     * @var ObjectStorage<FileReference>
     * @Extbase\ORM\Lazy
     */
    protected $image = null;

    /**
     * Files
     *
     * @var ObjectStorage<FileReference>
     * @Extbase\ORM\Lazy
     */
    protected $files = null;

    /**
     * File collections
     *
     * @var ObjectStorage<FileCollection>
     * @Extbase\ORM\Lazy
     */
    protected $collections = null;

    /**
     * Relations of the medium with persons, events, news, media etc.
     *
     * @var ObjectStorage<Relations>
     * @Extbase\ORM\Lazy
     */
    protected $relations = null;

    /**
     * Selected categories for the medium
     *
     * @var ObjectStorage<Categories>
     * @Extbase\ORM\Lazy
     */
    protected $categories = null;

    /**
     * Returns the persistentIdentifier
     *
     * @return string $persistentIdentifier
     */
    public function getPersistentIdentifier()
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
    public function setPersistentIdentifier($persistentIdentifier)
    {
        $this->persistentIdentifier = $persistentIdentifier;
    }

    /**
     * Returns the type
     *
     * @return integer $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param integer $type
     *
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns the crdate
     *
     * @return integer $crdate
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * Sets the crdate
     *
     * @param integer $crdate
     *
     * @return void
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
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
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
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
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the dateRange
     *
     * @return DateRanges $dateRange
     */
    public function getDateRange()
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
    public function setDateRange(DateRanges $dateRange)
    {
        $this->dateRange = $dateRange;
    }

    /**
     * Returns the slug
     *
     * @return string $slug
     */
    public function getSlug()
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
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Returns the image
     *
     * @return ObjectStorage<FileReference> $image
     */
    public function getImage()
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
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Returns the files
     *
     * @return ObjectStorage<FileReference> $files
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Sets the files
     *
     * @param ObjectStorage<FileReference> $files
     *
     * @return void
     */
    public function setFiles($files)
    {
        $this->files = $files;
    }

    /**
     * Returns the collections
     *
     * @return ObjectStorage<FileCollection> $collections
     */
    public function getCollections()
    {
        return $this->collections;
    }

    /**
     * Sets the collections
     *
     * @param ObjectStorage<FileCollection> $collections
     *
     * @return void
     */
    public function setCollections($collections)
    {
        $this->collections = $collections;
    }

    /**
     * Returns the relations
     *
     * @return ObjectStorage<Relations> $relations
     */
    public function getRelations()
    {
        $objectStorage = GeneralUtility::makeInstance(ObjectStorage::class);
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $relationsRepository = $objectManager->get(RelationsRepository::class);
        $symmetricRelations = $relationsRepository->findByMediumSymmetric($this);
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
    public function setRelations($relations)
    {
        $this->relations = $relations;
    }

    /**
     * Returns the categories
     *
     * @return ObjectStorage<Categories> $categories
     */
    public function getCategories()
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
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

}
