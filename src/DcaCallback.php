<?php

/*
 * This file is part of ContaoFilesmanagerFileusageBundle.
 *
 * @package   ContaoFilesmanagerFileusageBundle
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2020
 * @website	  https://marcel.live
 * @license   LGPL-3.0-or-later
 */

namespace MarcelMathiasNolte\ContaoFilesmanagerFileusageBundle;

class DcaCallbacks extends \Contao\Backend
{
    static $filesCache = false;

    public function getActiveSTateIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if ($row['type'] == 'folder') return '';

        if (self::$filesCache === false) {

        }

        $inUse = isset(self::$filesCache[$row['uuid']]) && self::$filesCache[$row['uuid']]->inUse;
        $icon = 'bundles/filesmanager-fileusage/icons/' . $inUse ? 'link-active.svg' : 'link-inactive.svg';
        if (!$inUse) $title = $GLOBALS['TL_LANG']['tl_files']['fileusage_'][1];
        return '<a href="' . $this->addToUrl($href) . '" title="' . \Contao\StringUtil::specialchars($title) . '" data-tid="cid"' . $attributes . '>' . \Contao\Image::getHtml($icon, $label) . '</a> ';
    }

    public function showUsage() {
        if(!\Input::get('id')) {
            return '';
        }
        return '';
    }
}
