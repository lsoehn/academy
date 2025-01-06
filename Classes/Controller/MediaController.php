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

namespace Digicademy\Academy\Controller;

use Digicademy\Academy\Domain\Repository\MediaRepository;
use Digicademy\Academy\Service\FacetService;
use Digicademy\Academy\Service\FilterService;
use Digicademy\Academy\Service\PaginationService;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * Controller for media
 *
 * @author Torsten Schrade <torsten.schrade@adwmainz.de>
 */

class MediaController extends EntityController
{
    /**
     * @var MediaRepository
     */
    protected MediaRepository $mediaRepository;

    /**
     * @param ConfigurationManagerInterface $configurationManager
     * @param FacetService $facetService
     * @param FilterService $filterService
     * @param PaginationService $paginationService
     * @param MediaRepository $mediaRepository
     */
    public function __construct(
        ConfigurationManagerInterface $configurationManager,
        FacetService $facetService,
        FilterService $filterService,
        PaginationService $paginationService,
        MediaRepository $mediaRepository
    )
    {
        parent::__construct($configurationManager, $facetService, $filterService, $paginationService);
        $this->mediaRepository = $mediaRepository;
    }

    /**
     * Returns the repository for the current entity
     *
     * @return MediaRepository
     */
    protected function getRepository(): MediaRepository
    {
        return $this->mediaRepository;
    }

}
