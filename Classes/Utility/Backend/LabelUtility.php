<?php

namespace Digicademy\Academy\Utility\Backend;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2021 Torsten Schrade <Torsten.Schrade@adwmainz.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class LabelUtility
{

    public function relationsLabel(array &$parameters)
    {
        // @TODO: since TYPO3 v12 we do not get the full row in parameters any more...
        // reason unclear, no time to waste researching internal API changes, fetch the full record instead
        $fullRecord = BackendUtility::getRecord($parameters['table'], (int)$parameters['row']['uid']);

        // get basic contact information label from lang file
        $contactInformationLabel = $GLOBALS['LANG']->sL('LLL:EXT:academy/Resources/Private/Language/locallang_db.xml:tx_academy_domain_model_hcards');

        // get role - freetext_roles overrides role record
        $role = '';
        ($fullRecord['role']) ? $roleRecord = BackendUtility::getRecord('tx_academy_domain_model_roles', (int)$fullRecord['role']) : $roleRecord = '';

        if (is_array($roleRecord) && !$fullRecord['role_freetext']) {
            $role = $roleRecord['title'];
        }
        if ($fullRecord['role_freetext']) {
            $role = htmlspecialchars($fullRecord['role_freetext']);
        }

        // get the records for the related objects
        ($fullRecord['person'] > 0) ? $person = BackendUtility::getRecord('tx_academy_domain_model_persons', $fullRecord['person']) : $person = '';
        ($fullRecord['person_symmetric'] > 0) ? $person_symmetric = BackendUtility::getRecord('tx_academy_domain_model_persons', $fullRecord['person_symmetric']) : $person_symmetric = '';

        ($fullRecord['project'] > 0) ? $project = BackendUtility::getRecord('tx_academy_domain_model_projects', $fullRecord['project']) : $project = '';
        ($fullRecord['project_symmetric'] > 0) ? $project_symmetric = BackendUtility::getRecord('tx_academy_domain_model_projects', $fullRecord['project_symmetric']) : $project_symmetric = '';

        ($fullRecord['unit'] > 0) ? $unit = BackendUtility::getRecord('tx_academy_domain_model_units', $fullRecord['unit']) : $unit = '';
        ($fullRecord['unit_symmetric'] > 0) ? $unit_symmetric = BackendUtility::getRecord('tx_academy_domain_model_units', $fullRecord['unit_symmetric']) : $unit_symmetric = '';

        if (is_array($fullRecord['news'])) {
            $news = BackendUtility::getRecord('tx_news_domain_model_news', $fullRecord['news'][0]['uid']);
        } elseif ($fullRecord['news'] > 0) {
            $news = BackendUtility::getRecord('tx_news_domain_model_news', $fullRecord['news']);
        } else {
            $news = '';
        }

        if (is_array($fullRecord['news_symmetric'])) {
            $news_symmetric = BackendUtility::getRecord('tx_news_domain_model_news', $fullRecord['news_symmetric'][0]['uid']);
        } elseif ($fullRecord['news_symmetric'] > 0) {
            $news_symmetric = BackendUtility::getRecord('tx_news_domain_model_news', $fullRecord['news_symmetric']);
        } else {
            $news_symmetric = '';
        }

        ($fullRecord['event'] > 0) ? $event = BackendUtility::getRecord('tx_news_domain_model_news', $fullRecord['event']) : $event = '';
        ($fullRecord['event_symmetric'] > 0) ? $event_symmetric = BackendUtility::getRecord('tx_news_domain_model_news', $fullRecord['event_symmetric']) : $event_symmetric = '';

        ($fullRecord['medium'] > 0) ? $medium = BackendUtility::getRecord('tx_academy_domain_model_media', $fullRecord['medium']) : $medium = '';
        ($fullRecord['medium_symmetric'] > 0) ? $medium_symmetric = BackendUtility::getRecord('tx_academy_domain_model_media', $fullRecord['medium_symmetric']) : $medium_symmetric = '';

        ($fullRecord['product'] > 0) ? $product = BackendUtility::getRecord('tx_academy_domain_model_products', $fullRecord['product']) : $product = '';
        ($fullRecord['product_symmetric'] > 0) ? $product_symmetric = BackendUtility::getRecord('tx_academy_domain_model_products', $fullRecord['product_symmetric']) : $product_symmetric = '';

        ($fullRecord['service'] > 0) ? $service = BackendUtility::getRecord('tx_academy_domain_model_services', $fullRecord['service']) : $service = '';
        ($fullRecord['service_symmetric'] > 0) ? $service_symmetric = BackendUtility::getRecord('tx_academy_domain_model_services', $fullRecord['service_symmetric']) : $service_symmetric = '';

        ($fullRecord['publication'] > 0) ? $publication = BackendUtility::getRecord('tx_academy_domain_model_publications', $fullRecord['publication']) : $publication = '';
        ($fullRecord['publication_symmetric'] > 0) ? $publication_symmetric = BackendUtility::getRecord('tx_academy_domain_model_publications', $fullRecord['publication_symmetric']) : $publication_symmetric = '';

        ($fullRecord['hcard'] > 0) ? $hcard = BackendUtility::getRecord('tx_academy_domain_model_hcards', $fullRecord['hcard']) : $hcard = '';

        $freetext = htmlspecialchars($fullRecord['freetext']);

        // build the labels for the different objects; reused below in label context
        $personLabel = '';
        $personSymmetricLabel = '';
        $projectLabel = '';
        $projectSymmetricLabel = '';
        $unitLabel = '';
        $unitSymmetricLabel = '';
        $hcardLabel = '';
        $newsLabel = '';
        $newsSymmetricLabel = '';
        $eventLabel = '';
        $eventSymmetricLabel = '';
        $mediumLabel = '';
        $mediumSymmetricLabel = '';
        $productLabel = '';
        $productSymmetricLabel = '';
        $serviceLabel = '';
        $serviceSymmetricLabel = '';
        $publicationLabel = '';
        $publicationSymmetricLabel = '';

        if (is_array($person)) {
            $personLabel = $person['honorific_prefix'] . ' ' . $person['given_name'] . ' ' . $person['family_name'] . ' ' . $person['honorific_suffix'];
        }
        if (is_array($person_symmetric)) {
            $personSymmetricLabel = $person_symmetric['honorific_prefix'] . ' ' . $person_symmetric['given_name'] . ' ' . $person_symmetric['family_name'] . ' ' . $person_symmetric['honorific_suffix'];
        }
        if (is_array($project)) {
            $projectLabel = $project['title'];
        }
        if (is_array($project_symmetric)) {
            $projectSymmetricLabel = $project_symmetric['title'];
        }
        if (is_array($unit)) {
            $unitLabel = $unit['title'];
        }
        if (is_array($unit_symmetric)) {
            $unitSymmetricLabel = $unit_symmetric['title'];
        }
        if (is_array($hcard)) {
            $hcardLabel = $hcard['label'];
        }
        if (is_array($news)) {
            $newsLabel = $news['title'];
        }
        if (is_array($news_symmetric)) {
            $newsSymmetricLabel = $news_symmetric['title'];
        }
        if (is_array($event)) {
            $eventLabel = $event['title'];
        }
        if (is_array($event_symmetric)) {
            $eventSymmetricLabel = $event_symmetric['title'];
        }
        if (is_array($medium)) {
            $mediumLabel = $medium['title'];
        }
        if (is_array($medium_symmetric)) {
            $mediumSymmetricLabel = $medium_symmetric['title'];
        }
        if (is_array($product)) {
            $productLabel = $product['title'];
        }
        if (is_array($product_symmetric)) {
            $productSymmetricLabel = $product_symmetric['title'];
        }
        if (is_array($service)) {
            $serviceLabel = $service['title'];
        }
        if (is_array($service_symmetric)) {
            $serviceSymmetricLabel = $service_symmetric['title'];
        }
        if (is_array($publication)) {
            $publicationLabel = $publication['title'];
        }
        if (is_array($publication_symmetric)) {
            $publicationSymmetricLabel = $publication_symmetric['title'];
        }

        // in list view field type is string, in inline and record view field type is array (due to select type of field)
        (is_array($fullRecord['type'])) ? $type = (int)$fullRecord['type'][0] : $type = (int)$fullRecord['type'];

        $separator = ': ';
        if ($role) {
            $roleAndSeparator = $role . $separator;
        } else {
            $roleAndSeparator = '';
        }
        $contactInformationLabelWithSeparator = $contactInformationLabel . $separator;

        // switch the context in which the label appears
        switch ($type) {
            case 10:
                ($role) ? $parameters['title'] = $roleAndSeparator . $hcardLabel : $parameters['title'] = $contactInformationLabelWithSeparator . $hcardLabel;
                break;
            case 11:
                if (array_key_exists('parent', $parameters) && $parameters['parent']['config']['foreign_field'] == 'project') {
                    $parameters['title'] = $roleAndSeparator  . $personLabel;
                } elseif (array_key_exists('parent', $parameters) && $parameters['parent']['config']['foreign_field'] == 'person') {
                    $parameters['title'] = $roleAndSeparator  . $projectLabel;
                } else {
                    $parameters['title'] = $roleAndSeparator . $personLabel . ' (' . $projectLabel . ')';
                }
                break;
            case 12:
                if (array_key_exists('parent', $parameters) && $parameters['parent']['config']['foreign_field'] == 'unit') {
                    $parameters['title'] = $roleAndSeparator . $personLabel;
                } elseif (array_key_exists('parent', $parameters) && $parameters['parent']['config']['foreign_field'] == 'person') {
                    $parameters['title'] = $roleAndSeparator . $unitLabel;
                } else {
                    $parameters['title'] = $roleAndSeparator . $personLabel . ', ' . $unitLabel;
                }
                break;
            case 13:
                ($role) ? $parameters['title'] = $roleAndSeparator . $personLabel . ', ' . $eventLabel : $parameters['title'] = $personLabel . ', ' . $eventLabel;
                break;
            case 14:
                ($role) ? $parameters['title'] = $roleAndSeparator . $personLabel . ', ' . $newsLabel : $parameters['title'] = $personLabel . ', ' . $newsLabel;
                break;
            case 15:
                ($role) ? $parameters['title'] = $roleAndSeparator . $personLabel . ', ' . $mediumLabel : $parameters['title'] = $personLabel . ', ' . $mediumLabel;
                break;
            case 16:
                ($role) ? $parameters['title'] = $roleAndSeparator . $personLabel . ', ' . $personSymmetricLabel : $parameters['title'] = $personLabel . ', ' . $personSymmetricLabel;
                break;
            case 20:
                ($role) ? $parameters['title'] = $roleAndSeparator . $hcardLabel : $parameters['title'] = $contactInformationLabelWithSeparator . $hcardLabel;
                break;
            case 21:
                ($role) ? $parameters['title'] = $roleAndSeparator . $projectLabel . ', ' . $unitLabel : $parameters['title'] = $projectLabel . ', ' . $unitLabel;
                break;
            case 22:
                ($role) ? $parameters['title'] = $roleAndSeparator . $projectLabel . ', ' . $newsLabel : $parameters['title'] = $projectLabel . ', ' . $newsLabel;
                break;
            case 23:
                ($role) ? $parameters['title'] = $roleAndSeparator . $projectLabel . ', ' . $eventLabel : $parameters['title'] = $projectLabel . ', ' . $eventLabel;
                break;
            case 24:
                ($role) ? $parameters['title'] = $roleAndSeparator . $projectLabel . ', ' . $mediumLabel : $parameters['title'] = $projectLabel . ', ' . $mediumLabel;
                break;
            case 25:
                ($role) ? $parameters['title'] = $roleAndSeparator . $projectLabel . ', ' . $freetext : $parameters['title'] = $roleAndSeparator . $projectLabel . ', ' . $freetext;
                break;
            case 26:
                ($role) ? $parameters['title'] = $roleAndSeparator . $projectLabel . ', ' . $projectSymmetricLabel : $parameters['title'] = $projectLabel . ', ' . $projectSymmetricLabel;
                break;
            case 30:
                ($role) ? $parameters['title'] = $roleAndSeparator . $hcardLabel : $parameters['title'] = $contactInformationLabelWithSeparator . $hcardLabel;
                break;
            case 31:
                ($role) ? $parameters['title'] = $roleAndSeparator . $role . $unitLabel . $freetext : $parameters['title'] = $role . $unitLabel . $freetext;
                break;
            case 32:
                ($role) ? $parameters['title'] = $roleAndSeparator . $unitLabel . ', ' . $unitSymmetricLabel : $parameters['title'] = $unitLabel . ', ' . $unitSymmetricLabel;
                break;
            case 33:
                ($role) ? $parameters['title'] = $roleAndSeparator . $unitLabel . ', ' . $newsLabel : $parameters['title'] = $unitLabel . ', ' . $newsLabel;
                break;
            case 34:
                ($role) ? $parameters['title'] = $roleAndSeparator . $unitLabel . ', ' . $eventLabel : $parameters['title'] = $unitLabel . ', ' . $eventLabel;
                break;
            case 35:
                ($role) ? $parameters['title'] = $roleAndSeparator . $unitLabel . ', ' . $mediumLabel : $parameters['title'] = $unitLabel . ', ' . $mediumLabel;
                break;
            case 40:
                ($role) ? $parameters['title'] = $roleAndSeparator . $hcardLabel : $parameters['title'] = $contactInformationLabelWithSeparator . $hcardLabel;
                break;
            case 41:
                ($role) ? $parameters['title'] = $roleAndSeparator . $newsLabel . ', ' . $eventLabel : $parameters['title'] = $newsLabel . ', ' . $eventLabel;
                break;
            case 42:
                ($role) ? $parameters['title'] = $roleAndSeparator . $newsLabel . ', ' . $mediumLabel : $parameters['title'] = $newsLabel . ', ' . $mediumLabel;
                break;
            case 43:
                ($role) ? $parameters['title'] = $roleAndSeparator . $newsLabel . ', ' . $newsSymmetricLabel : $parameters['title'] = $newsLabel . ', ' . $newsSymmetricLabel;
                break;
            case 50:
                ($role) ? $parameters['title'] = $roleAndSeparator . $hcardLabel : $parameters['title'] = $contactInformationLabelWithSeparator . $hcardLabel;
                break;
            case 51:
                ($role) ? $parameters['title'] = $roleAndSeparator . $eventLabel . ', ' . $mediumLabel : $parameters['title'] = $eventLabel . ', ' . $mediumLabel;
                break;
            case 52:
                ($role) ? $parameters['title'] = $roleAndSeparator . $eventLabel . ', ' . $eventSymmetricLabel : $parameters['title'] = $eventLabel . ', ' . $eventSymmetricLabel;
                break;
            case 60:
                ($role) ? $parameters['title'] = $roleAndSeparator . $mediumLabel . ', ' . $mediumSymmetricLabel : $parameters['title'] = $mediumLabel . ', ' . $mediumSymmetricLabel;
                break;

            case 70:
                ($role) ? $parameters['title'] = $roleAndSeparator . $productLabel . ', ' . $personLabel : $parameters['title'] = $productLabel . ', ' . $personLabel;
                break;
            case 71:
                ($role) ? $parameters['title'] = $roleAndSeparator . $productLabel . ', ' . $projectLabel : $parameters['title'] = $productLabel . ', ' . $projectLabel;
                break;
            case 72:
                ($role) ? $parameters['title'] = $roleAndSeparator . $productLabel . ', ' . $unitLabel : $parameters['title'] = $productLabel . ', ' . $unitLabel;
                break;
            case 73:
                ($role) ? $parameters['title'] = $roleAndSeparator . $productLabel . ', ' . $mediumLabel : $parameters['title'] = $productLabel . ', ' . $mediumLabel;
                break;
            case 74:
                ($role) ? $parameters['title'] = $roleAndSeparator . $productLabel . ', ' . $newsLabel : $parameters['title'] = $productLabel . ', ' . $newsLabel;
                break;
            case 75:
                ($role) ? $parameters['title'] = $roleAndSeparator . $productLabel . ', ' . $eventLabel : $parameters['title'] = $productLabel . ', ' . $eventLabel;
                break;
            case 76:
                ($role) ? $parameters['title'] = $roleAndSeparator . $productLabel . ', ' . $serviceLabel : $parameters['title'] = $productLabel . ', ' . $serviceLabel;
                break;
            case 77:
                ($role) ? $parameters['title'] = $roleAndSeparator . $productLabel . ', ' . $publicationLabel : $parameters['title'] = $productLabel . ', ' . $publicationLabel;
                break;
            case 78:
                ($role) ? $parameters['title'] = $roleAndSeparator . $productLabel . ', ' . $productSymmetricLabel : $parameters['title'] = $productLabel . ', ' . $productSymmetricLabel;
                break;
            case 80:
                ($role) ? $parameters['title'] = $roleAndSeparator . $serviceLabel . ', ' . $personLabel : $parameters['title'] = $serviceLabel . ', ' . $personLabel;
                break;
            case 81:
                ($role) ? $parameters['title'] = $roleAndSeparator . $serviceLabel . ', ' . $projectLabel : $parameters['title'] = $serviceLabel . ', ' . $projectLabel;
                break;
            case 82:
                ($role) ? $parameters['title'] = $roleAndSeparator . $serviceLabel . ', ' . $unitLabel : $parameters['title'] = $serviceLabel . ', ' . $unitLabel;
                break;
            case 83:
                ($role) ? $parameters['title'] = $roleAndSeparator . $serviceLabel . ', ' . $mediumLabel : $parameters['title'] = $serviceLabel . ', ' . $mediumLabel;
                break;
            case 84:
                ($role) ? $parameters['title'] = $roleAndSeparator . $serviceLabel . ', ' . $newsLabel : $parameters['title'] = $serviceLabel . ', ' . $newsLabel;
                break;
            case 85:
                ($role) ? $parameters['title'] = $roleAndSeparator . $serviceLabel . ', ' . $eventLabel : $parameters['title'] = $serviceLabel . ', ' . $eventLabel;
                break;
            case 86:
                ($role) ? $parameters['title'] = $roleAndSeparator . $serviceLabel . ', ' . $publicationLabel : $parameters['title'] = $serviceLabel . ', ' . $publicationLabel;
                break;
            case 87:
                ($role) ? $parameters['title'] = $roleAndSeparator . $serviceLabel . ', ' . $serviceSymmetricLabel : $parameters['title'] = $serviceLabel . ', ' . $serviceSymmetricLabel;
                break;
            case 90:
                ($role) ? $parameters['title'] = $roleAndSeparator . $publicationLabel . ', ' . $personLabel : $parameters['title'] = $publicationLabel . ', ' . $personLabel;
                break;
            case 91:
                ($role) ? $parameters['title'] = $roleAndSeparator . $publicationLabel . ', ' . $projectLabel : $parameters['title'] = $publicationLabel . ', ' . $projectLabel;
                break;
            case 92:
                ($role) ? $parameters['title'] = $roleAndSeparator . $publicationLabel . ', ' . $unitLabel : $parameters['title'] = $publicationLabel . ', ' . $unitLabel;
                break;
            case 93:
                ($role) ? $parameters['title'] = $roleAndSeparator . $publicationLabel . ', ' . $mediumLabel : $parameters['title'] = $publicationLabel . ', ' . $mediumLabel;
                break;
            case 94:
                ($role) ? $parameters['title'] = $roleAndSeparator . $publicationLabel . ', ' . $newsLabel : $parameters['title'] = $publicationLabel . ', ' . $newsLabel;
                break;
            case 95:
                ($role) ? $parameters['title'] = $roleAndSeparator . $publicationLabel . ', ' . $eventLabel : $parameters['title'] = $publicationLabel . ', ' . $eventLabel;
                break;
            case 96:
                ($role) ? $parameters['title'] = $roleAndSeparator . $publicationLabel . ', ' . $publicationSymmetricLabel : $parameters['title'] = $publicationLabel . ', ' . $publicationSymmetricLabel;
                break;
        }

        return $parameters;
    }

}
