<?php
// @TODO: check with 12.4 core and document/explain why necessary

namespace Digicademy\Academy\Xclass\Backend\Form\FormDataProvider;

use TYPO3\CMS\Backend\Form\FormDataProviderInterface;
use TYPO3\CMS\Backend\Form\FormDataProvider\TcaInlineIsOnSymmetricSide;
use TYPO3\CMS\Core\Utility\MathUtility;

/**
 * Determine whether the child is on symmetric side or not.
 *
 * TCA ctrl fields like label and label_alt are evaluated and their
 * current values from databaseRow used to create the title.
 */
class AcademyTcaInlineIsOnSymmetricSide extends TcaInlineIsOnSymmetricSide
{
    /**
     * Enrich the processed record information with the resolved title
     *
     * @param array $result Incoming result array
     * @return array Modified array
     */
    public function addData(array $result): array
    {
        if (!$result['isInlineChild']) {
            return $result;
        }

#\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($result, NULL, 5, FALSE, TRUE, FALSE, array(), array());
#die();

/*
        $result['isOnSymmetricSide'] = MathUtility::canBeInterpretedAsInteger($result['databaseRow']['uid'])
            && ($result['inlineParentConfig']['symmetric_field'] ?? false)
            // non-strict comparison by intention
            && ($result['inlineParentUid'] == $result['databaseRow'][$result['inlineParentConfig']['symmetric_field']][0]
                || (is_array($result['databaseRow'][$result['inlineParentConfig']['symmetric_field']][0])
                    && $result['inlineParentUid'] == $result['databaseRow'][$result['inlineParentConfig']['symmetric_field']][0]['uid']));
*/
        $result['isOnSymmetricSide'] = MathUtility::canBeInterpretedAsInteger($result['databaseRow']['uid'])
            && ($result['inlineParentConfig']['symmetric_field'] ?? false)
            // non-strict comparison by intention
            && ($result['inlineParentUid'] == $result['databaseRow'][$result['inlineParentConfig']['symmetric_field']]
                || (is_array($result['databaseRow'][$result['inlineParentConfig']['symmetric_field']])
                    && $result['inlineParentUid'] == $result['databaseRow'][$result['inlineParentConfig']['symmetric_field']][0]['uid']));

        return $result;
    }
}
