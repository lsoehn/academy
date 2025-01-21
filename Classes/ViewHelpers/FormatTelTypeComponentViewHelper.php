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

namespace Digicademy\Academy\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Exception;

class FormatTelTypeComponentViewHelper extends AbstractViewHelper
{
    /**
     * Initialize arguments
     *
     * @return void
     *
     * @throws Exception
     */
    public function initializeArguments()
    {
        $this->registerArgument(
            'type',
            'string',
            'Type of telephone number',
            true
        );
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $type = $this->arguments['type'];

        $formatedType = '';

        switch ($type) {
            case 21:
                $formatedType = 'voice,WORK';
                break;
            case 22:
                $formatedType = 'cell';
                break;
            case 23:
                $formatedType = 'fax';
                break;
            case 24:
                $formatedType = 'voice,home';
                break;
        }

        return $formatedType;
    }
}
