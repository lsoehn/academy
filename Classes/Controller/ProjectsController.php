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

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Digicademy\Academy\Domain\Repository\ProjectsRepository;
use Digicademy\Academy\Domain\Model\Projects;

class ProjectsController extends ActionController
{

    /**
     * @var ProjectsRepository
     */
    protected $projectsRepository;

    /**
     * @param ConfigurationManagerInterface    $configurationManager
     * @param ProjectsRepository               $projectsRepository
     */
    public function __construct(
        ConfigurationManagerInterface $configurationManager,
        ProjectsRepository $projectsRepository
    )
    {
        $this->injectConfigurationManager($configurationManager);
        $this->projectsRepository = $projectsRepository;
    }

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction(): void
    {
    }

    /**
     * Displays a list of projects, possibly filtered by categories
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $arguments = $this->request->getArguments();
        $this->view->assign('arguments', $arguments);

        if ($this->settings['selectedCategories'] || $this->settings['selectedEntities'] || $this->settings['selectedRoles']) {
            $projects = $this->projectsRepository->findByAttributes($this->settings);
        } else {
            $projects = $this->projectsRepository->findAll();
        }
        $this->view->assign('projects', $projects);

        return $this->htmlResponse();
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

    // show project action either by argument or set via FlexForm

    /**
     * Displays a project by uid
     *
     * @param Projects $project
     *
     * @return void
     */
    public function showAction(Projects $project)
    {
        $arguments = $this->request->getArguments();
        $this->view->assign('arguments', $arguments);

        $this->view->assign('project', $project);
    }

}
