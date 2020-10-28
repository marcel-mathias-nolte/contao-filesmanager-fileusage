<?php

/*
 * This file is part of ContaoFilesmanagerFileusageBundle.
 *
 * @package   ContaoFilesmanagerFileusageBundle
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2015-2020
 * @website	  https://marcel.live
 * @license   LGPL-3.0-or-later
 */

namespace MarcelMathiasNolte\ContaoFilesmanagerFileusageBundle;

$GLOBALS['TL_DCA']['tl_files']['list']['operations']['fileusage'] = array(
    'label'               => &$GLOBALS['TL_LANG']['tl_files']['fileusage'],
    'href'                => 'key=fileusage',
    'icon'                => 'bundles/contaofilesmanagerfileusage/icons/link-inactive.svg',
    'button_callback'     => array('\MarcelMathiasNolte\ContaoFilesmanagerFileusageBundle\DcaCallbacks', 'getActiveStateIcon')
);
