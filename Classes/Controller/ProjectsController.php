<?php
namespace Digicademy\Academy\Controller;

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

use Digicademy\Academy\Service\FacetService;
use Digicademy\Academy\Service\FilterService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use Digicademy\Academy\Controller\EntityController;
use Digicademy\Academy\Domain\Repository\ProjectsRepository;
use Digicademy\Academy\Domain\Model\Projects;

class ProjectsController extends EntityController
{
    /**
     * @var ProjectsRepository
     */
    protected ProjectsRepository $projectsRepository;

    /**
     * Constructor for dependency injection
     *
     * @param ConfigurationManagerInterface $configurationManager
     * @param FacetService $facetService
     * @param FilterService $filterService
     * @param ProjectsRepository $projectsRepository
     */
    public function __construct(
        ConfigurationManagerInterface $configurationManager,
        FacetService $facetService,
        FilterService $filterService,
        ProjectsRepository $projectsRepository
    )
    {
        parent::__construct($configurationManager, $facetService, $filterService);
        $this->projectsRepository = $projectsRepository;
    }

    /**
     * Returns the repository for the current entity
     *
     * @return ProjectsRepository
     */
    protected function getRepository(): ProjectsRepository
    {
        return $this->projectsRepository;
    }

    /**
     * @TODO: implement
     * @return ResponseInterface
     */
    public function filterAction(): ResponseInterface
    {
        // filter by search query, categories, roles and forward to list (uncached)
        return (new ForwardResponse('list'))->withArguments($this->request->getArguments());
    }

    /**
     * Displays a project by uid
     *
     * @param Projects $project
     *
     * @return void
     */
    public function showAction(Projects $project): ResponseInterface
    {
        $arguments = $this->request->getArguments();
        $this->view->assign('arguments', $arguments);

        $this->view->assign('project', $project);

        return $this->htmlResponse();
    }

}
