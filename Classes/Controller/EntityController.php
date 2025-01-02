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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Http\ForwardResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Exception;

class EntityController extends ActionController
{
    /**
     * @var FacetService
     */
    protected FacetService $facetService;

    /**
     * @var FilterService
     */
    protected FilterService $filterService;

    /**
     * @param ConfigurationManagerInterface    $configurationManager
     * @param FacetService  $facetService
     * @param FilterService $filterService
     */
    public function __construct(
        ConfigurationManagerInterface $configurationManager,
        FacetService $facetService,
        FilterService $filterService
    )
    {
        $this->injectConfigurationManager($configurationManager);
        $this->facetService = $facetService;
        $this->filterService = $filterService;
    }

    /**
     * @return void
     */
    protected function getRepository()
    {}

    /**
     * Initializes the current action
     *
     * @return void
     */
    public function initializeAction(): void
    {}

    /**
     * The EntityController serves as a "router" to the "real" controllers/actions that
     * are configured in the plugin settings in BE.
     * It is only called during default action requests (which it catches) and thereby
     * avoids unnecessary/inflationary plugin declaration due to the removal
     * of switchableControllerActions from TYPO3 12.4 onwards.
     * Imagine: Let alone for this extension we would have to declare more than 16 (!)
     * plugins (at least two for each CRIS entity) without switchableControllerActions...
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function routeAction(): ResponseInterface
    {
        if (!$this->settings['entityType']) {
            throw new Exception('You need to set an entity type in the plugin configuration', 1735538304);
        }

        $arguments = $this->request->getArguments();

        $action = strtolower($this->request->getPluginName());

        if ($action == 'show' && array_key_exists('filters', $this->settings) &&
            array_key_exists('selectedEntities', $this->settings['filters']) &&
            $this->settings['filters']['selectedEntities'] !== null
        ) {
            $this->settings['filters'] = $this->filterService->sanitizeFilterData(
                $this->settings['filters'],
                ['selectedEntities']
            );
            $arguments['project'] = $this->settings['filters']['selectedEntities'][0];
        }

        return (new ForwardResponse($action))
            ->withControllerName($this->settings['entityType'])
            ->withArguments($arguments);
    }

    /**
     * Displays a faceted/filterable list of entities
     *
     * @return ResponseInterface
     * @throws Exception|InvalidQueryException
     */
    public function listAction(): ResponseInterface
    {
        $arguments = $this->request->getArguments();
        $this->view->assign('arguments', $arguments);

        $settings = $this->settings;
        $this->view->assign('settings', $settings);

        $filters = $this->filterService->mergeFilters($settings, $arguments);
        $this->view->assign('filters', $filters);

        /** @var ContentObjectRenderer $contentObject */
        $plugin = $this->request->getAttribute('currentContentObject')->data;
        $this->view->assign('plugin', $plugin);

        $facets = [];
        if ($settings['facets']['categoryFacets']['facetParents']) {
            $settings['facets']['categoryFacets']['facetTable'] = 'sys_category';
            $settings['facets']['categoryFacets']['facetParents'] =
                array_map(fn($uid) => ['uid' => $uid], explode(',', $settings['facets']['categoryFacets']['facetParents']));;
            $facetTree = $this->facetService->generateFacetTree(
                (object)$this->getRepository(),
                $settings['facets']['categoryFacets'],
                $filters
            );
            $facets['categoryFacets'] = $facetTree;
        }
        // @TODO: here we can implement selectedRoles and selectedEntities facets (later)
        $this->view->assign('facets', $facets);

        // get list of projects
        if ($filters['selectedCategories'] || $filters['selectedEntities'] || $filters['selectedRoles']) {
            $projects = $this->getRepository()->findByFilters($filters);
        } else {
            $projects = $this->getRepository()->findAll();
        }
        $this->view->assign('projects', $projects);

        return $this->htmlResponse();
    }

    /**
     * Filter entities by query, categories, roles and forward to list (uncached)
     *
     * @param string $query
     *
     * @Extbase\Validate("regularExpression", options={"regularExpression": "/^[\,\.\*\-""\p{L}\p{M}\p{N}\p{Sk}\s]*$/u"}, param="query")
     *
     * @return ResponseInterface
     */
    public function filterAction(
        string $query = ''
    ): ResponseInterface
    {
        $arguments = $this->request->getArguments();

        // Sanitize filters and selected values
        $arguments['filters'] = $this->filterService->sanitizeFilterData(
            $arguments['filters'] ?? [],
            ['selectedCategories', 'selectedEntities', 'selectedRoles']
        );

        $arguments['selected'] = $this->filterService->sanitizeFilterData(
            $arguments['selected'] ?? [],
            ['category', 'entity', 'role']
        );

        // Add or remove selected categories, entities, or roles
        if (!empty($arguments['selected']['category'][0])) {
            $arguments['filters']['selectedCategories'] = $this->filterService->toggleFilterValue(
                $arguments['filters']['selectedCategories'],
                $arguments['selected']['category'][0]
            );
        }

        if (!empty($arguments['selected']['entity'][0])) {
            $arguments['filters']['selectedEntities'] = $this->filterService->toggleFilterValue(
                $arguments['filters']['selectedEntities'],
                $arguments['selected']['entity'][0]
            );
        }

        if (!empty($arguments['selected']['role'][0])) {
            $arguments['filters']['selectedRoles'] = $this->filterService->toggleFilterValue(
                $arguments['filters']['selectedRoles'],
                $arguments['selected']['role'][0]
            );
        }

        // Finalize filters (convert to CSV strings)
        $arguments['filters'] = $this->filterService->finalizeFilters($arguments['filters']);

        return (new ForwardResponse('list'))->withArguments($arguments);
    }

}
