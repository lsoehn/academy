<?php
namespace Digicademy\Academy\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) Torsten Schrade <Torsten.Schrade@adwmainz.de>
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

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * This is a pretty nasty hackaround to solve TYPO3 core issues with Fluid
 * and lazy loading (especially with respect to relations). Long story short:
 * Depending on context magic getters in Fluid do not always get resolved properly
 * when working with LazyLoadingProxy. This ViewHelper forces loading of a property
 * which is still the better approach with regard to performance rather than not
 * using Extbase/ORM/Lazy.
 *
 * @see: https://forge.typo3.org/issues/90215
 * @see: https://github.com/TYPO3/Fluid/issues/513
 */
class GetPropertyViewHelper extends AbstractViewHelper
{
    /**
     * Initialize ViewHelper arguments
     */
    public function initializeArguments(): void
    {
        $this->registerArgument(
            'object',
            'object',
            'The object for which to get the real instance',
            true
        );
        $this->registerArgument(
            'property',
            'string',
            'The property to get from the object',
            true
        );
    }

    /**
     * @return mixed
     */
    public function render(): mixed
    {
        $object =  $this->arguments['object'];
        $property = $this->arguments['property'];

        if ($object instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $object = $object->_loadRealInstance();
        }
        return $object->_getProperty($property);
    }
}
