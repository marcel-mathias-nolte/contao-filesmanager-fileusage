<?php



$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{fileusage_legend},fileusageSkipReplaceInsertTags,fileusageSkipTemplates,fileusageSkipDatabase,fileusageSkipCss';
$GLOBALS['TL_DCA']['tl_settings']['fields']['fileusageSkipReplaceInsertTags'] = [
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50')
];
$GLOBALS['TL_DCA']['tl_settings']['fields']['fileusageSkipTemplates'] = [
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50')
];
$GLOBALS['TL_DCA']['tl_settings']['fields']['fileusageSkipDatabase'] = [
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50')
];
$GLOBALS['TL_DCA']['tl_settings']['fields']['fileusageSkipCss'] = [
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50')
];
