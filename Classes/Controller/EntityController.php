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

class EntityController extends ActionController
{

    /**
     * @param ConfigurationManagerInterface    $configurationManager
     */
    public function __construct(
        ConfigurationManagerInterface $configurationManager
    )
    {
        $this->injectConfigurationManager($configurationManager);
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
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {

\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($this->settings, NULL, 5, FALSE, TRUE, FALSE, array(), array());
die();
        return $this->htmlResponse();
    }

    /**
     * @return ResponseInterface
     */
    public function filterAction(): ResponseInterface
    {
        // filter by search query, categories, roles and forward to list (uncached)
        return (new ForwardResponse('list'))->withArguments($this->request->getArguments());
    }

}
