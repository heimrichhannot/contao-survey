<?php

/*
 * @copyright  Helmut Schottmüller 2005-2018 <http://github.com/hschottm>
 * @author     Helmut Schottmüller (hschottm)
 * @package    contao-survey
 * @license    LGPL-3.0+, CC-BY-NC-3.0
 * @see	      https://github.com/hschottm/survey_ce
 */

use Contao\DataContainer;

$GLOBALS['TL_DCA']['tl_content']['palettes']['survey'] = '{type_legend},type,headline;{survey_legend},survey;{template_legend:hide},surveyTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_content']['palettes']['survey_result_element'] =  '{type_legend},type,headline;{survey_legend},survey,evaluateCurrentUser;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['fields']['survey'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['survey'],
    'exclude' => true,
    'inputType' => 'radio',
    'foreignKey' => 'tl_survey.title',
    'eval' => ['mandatory' => true],
    'sql' => "smallint(5) unsigned NOT NULL default '0'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['surveyTpl'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['surveyTpl'],
    'default' => 'ce_survey',
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['tl_content_survey', 'getSurveyTemplates'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['evaluateCurrentUser'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

class tl_content_survey extends tl_content
{
    /**
     * Return all survey templates as array.
     *
     * @param object
     *
     * @return array
     */
    public function getSurveyTemplates(DataContainer $dc)
    {
        return $this->getTemplateGroup('ce_survey');
    }
}
