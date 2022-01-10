<?php

/*
 * This file is part of ContaoFilesmanagerFileusageBundle.
 *
 * @package   ContaoFilesmanagerFileusageBundle
 * @author    Marcel Mathias Nolte
 * @copyright Marcel Mathias Nolte 2015-2020
 * @website	  https://github.com/marcel-mathias-nolte
 * @license   LGPL-3.0-or-later
 */

namespace MarcelMathiasNolte\ContaoFilesmanagerFileusageBundle;

class DcaCallbacks extends \Contao\Backend
{

    static $filesCache = false;

    protected $strTemplate = 'be_filemanager_fileusage';

    public function getActiveStateIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if ($row['type'] == 'folder') return '';
        $this->buildUsageCache();
        $inUse = isset(self::$filesCache[urldecode($row['id'])]);
        $icon = 'bundles/contaofilesmanagerfileusage/icons/' . ($inUse ? 'link-active.svg' : 'link-inactive.svg');
        $title = $inUse ? $GLOBALS['TL_LANG']['tl_files']['fileusage'][2] : $GLOBALS['TL_LANG']['tl_files']['fileusage'][3];
        $href .= '&id=' . urlencode($row['id']);
        return '<a href="' . $this->addToUrl($href) . '" title="' . \Contao\StringUtil::specialchars($title) . '" data-tid="cid"' . $attributes . '>' . \Contao\Image::getHtml($icon, $label, '') . '</a> ';
    }

    protected function buildUsageCache() {
        if (self::$filesCache === false) {
            self::$filesCache = [];
            $db = \Database::getInstance();
            if (!isset($GLOBALS['TL_CONFIG']['fileusageSkipDatabase']) || !$GLOBALS['TL_CONFIG']['fileusageSkipDatabase']) {
                $tables = $db->prepare("SHOW TABLES")->execute();
                $skip_tables = array('tl_version', 'tl_undo', 'tl_files', 'tl_search', 'tl_search_index');
                while ($tables->next()) {
                    $row = $tables->row();
                    $table = array_shift($row);
                    if (in_array($table, $skip_tables)) {
                        continue;
                    }
                    \Controller::loadDataContainer($table);
                    if (is_array($GLOBALS['TL_DCA'][$table]['fields']) && count($GLOBALS['TL_DCA'][$table]['fields']) > 0) foreach ($GLOBALS['TL_DCA'][$table]['fields'] as $field => $column) {
                        if (!isset($column['sql']) || !isset($column['inputType'])) {
                            continue;
                        }
                        switch ($column['inputType']) {
                            case 'text':
                                if (isset($column['eval']) && is_array($column['eval']) && isset($column['eval']['rgxp']) && $column['eval']['rgxp'] == 'url') {
                                    $list = $db->execute("SELECT `id`, `$field` FROM `$table`");
                                    while ($list->next()) {
                                        $text = (!isset($GLOBALS['TL_CONFIG']['fileusageSkipReplaceInsertTags']) || !$GLOBALS['TL_CONFIG']['fileusageSkipReplaceInsertTags']) ? \Contao\Controller::replaceInsertTags($list->$field) : $list->$field;
                                        $text = $text ? explode('files/', $text) : array();
                                        if (is_array($text) && count($text) > 1) {
                                            array_shift($text);
                                            foreach ($text as $bit) {
                                                $pos = strpos($bit, "'");
                                                if ($pos !== false) {
                                                    $bit = substr($bit, 0, $pos);
                                                }
                                                $pos = strpos($bit, '"');
                                                if ($pos !== false) {
                                                    $bit = substr($bit, 0, $pos);
                                                }
                                                $bit = substr($bit, 0, $pos);
                                                $pos = strpos($bit, '?');
                                                if ($pos !== false) {
                                                    $bit = substr($bit, 0, $pos);
                                                }
                                                $bit = 'files/' . $bit;
                                                self::$filesCache[urldecode($bit)][] = (object)[
                                                    'table' => $table,
                                                    'id' => $list->id
                                                ];
                                            }
                                        }
                                        $text = $list->$field;
                                        $text = $text ? explode('{{', $text) : [];
                                        if (is_array($text) && count($text) > 1) {
                                            array_shift($text);
                                            foreach ($text as $bit) {
                                                $pos = strpos($bit, "}}");
                                                if ($pos !== false) {
                                                    $bit = substr($bit, 0, $pos);
                                                    if (strpos($bit, '::') !== false) {
                                                        list($tag, $value) = explode('::', $bit);
                                                        $pos = strpos($value, '?');
                                                        if ($pos !== false) {
                                                            $value = substr($value, 0, $pos);
                                                        }
                                                        switch ($tag) {
                                                            case 'image':
                                                            case 'picture':
                                                                if (\Contao\Validator::isUuid($value)) {
                                                                    // Handle UUIDs
                                                                    $objFiles = \Contao\FilesModel::findByUuid($value);
                                                                } elseif (is_numeric($value)) {
                                                                    $objFiles = \Contao\FilesModel::findByPk($value);
                                                                }
                                                                if ($objFiles !== null) {
                                                                    if (file_exists(\Contao\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objFiles->path)) {
                                                                        self::$filesCache[$objFiles->path][] = (object)[
                                                                            'table' => $table,
                                                                            'id' => $list->id
                                                                        ];
                                                                    }
                                                                }
                                                                break;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                break;
                            case 'textarea':
                                $list = $db->execute("SELECT `id`, `$field` FROM `$table`");
                                while ($list->next()) {
                                    $text = (!isset($GLOBALS['TL_CONFIG']['fileusageSkipReplaceInsertTags']) || !$GLOBALS['TL_CONFIG']['fileusageSkipReplaceInsertTags']) ? \Contao\Controller::replaceInsertTags($list->$field) : $list->$field;
                                    $text = $text ? explode('files/', $text) : [];
                                    if (is_array($text) && count($text) > 1) {
                                        array_shift($text);
                                        foreach ($text as $bit) {
                                            $pos = strpos($bit, "'");
                                            if ($pos !== false) {
                                                $bit = substr($bit, 0, $pos);
                                            }
                                            $pos = strpos($bit, '"');
                                            if ($pos !== false) {
                                                $bit = substr($bit, 0, $pos);
                                            }
                                            $bit = substr($bit, 0, $pos);
                                            $pos = strpos($bit, '?');
                                            if ($pos !== false) {
                                                $bit = substr($bit, 0, $pos);
                                            }
                                            $bit = 'files/' . $bit;
                                            self::$filesCache[urldecode($bit)][] = (object)[
                                                'table' => $table,
                                                'id' => $list->id
                                            ];
                                        }
                                    }
                                    $text = $list->$field;
                                    $text = $text ? explode('{{', $text) : [];
                                    if (is_array($text) && count($text) > 1) {
                                        array_shift($text);
                                        foreach ($text as $bit) {
                                            $pos = strpos($bit, "}}");
                                            if ($pos !== false) {
                                                $bit = substr($bit, 0, $pos);
                                                if (strpos($bit, '::') !== false) {
                                                    list($tag, $value) = explode('::', $bit);
                                                    $pos = strpos($value, '?');
                                                    if ($pos !== false) {
                                                        $value = substr($value, 0, $pos);
                                                    }
                                                    switch ($tag) {
                                                        case 'image':
                                                        case 'picture':
                                                            if (\Contao\Validator::isUuid($value)) {
                                                                // Handle UUIDs
                                                                $objFiles = \Contao\FilesModel::findByUuid($value);
                                                            } elseif (is_numeric($value)) {
                                                                $objFiles = \Contao\FilesModel::findByPk($value);
                                                            }
                                                            if ($objFiles !== null) {
                                                                if (file_exists(\Contao\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objFiles->path)) {
                                                                    self::$filesCache[$objFiles->path][] = (object)[
                                                                        'table' => $table,
                                                                        'id' => $list->id
                                                                    ];
                                                                }
                                                            }
                                                            break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                break;
                            case 'fileTree':
                                $list = $db->execute("SELECT `id`, `$field` FROM `$table`");
                                while ($list->next()) {
                                    if (isset($column['eval']) && is_array($column['eval']) && isset($column['eval']['fieldType'])) {
                                        if ($column['eval']['fieldType'] == 'radio' && $list->$field != null) {
                                            $objFiles = \Contao\FilesModel::findByUuid($list->$field);
                                            if ($objFiles !== null) {
                                                if ($objFiles->type == 'file') {
                                                    if (file_exists(\Contao\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objFiles->path)) {
                                                        self::$filesCache[$objFiles->path][] = (object)[
                                                            'table' => $table,
                                                            'id' => $list->id
                                                        ];
                                                    }
                                                } else {
                                                    $objSubfiles = \Contao\FilesModel::findByPid($objFiles->uuid, array('order' => 'name'));
                                                    if ($objSubfiles === null) {
                                                        continue;
                                                    }
                                                    while ($objSubfiles->next()) {
                                                        if (!file_exists(\Contao\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objSubfiles->path)) {
                                                            continue;
                                                        }
                                                        self::$filesCache[$objSubfiles->path][] = (object)[
                                                            'table' => $table,
                                                            'id' => $list->id
                                                        ];
                                                    }
                                                }
                                            }
                                        }
                                        if ($column['eval']['fieldType'] == 'checkbox') {
                                            $src = deserialize($list->$field);
                                            $objFiles = \Contao\FilesModel::findMultipleByUuids($src);
                                            if ($objFiles !== null) {
                                                while ($objFiles->next()) {
                                                    if ($objFiles->type == 'file') {
                                                        if (!file_exists(\Contao\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objFiles->path)) {
                                                            continue;
                                                        }
                                                        self::$filesCache[$objFiles->path][] = (object)[
                                                            'table' => $table,
                                                            'id' => $list->id
                                                        ];
                                                    } else {
                                                        $objSubfiles = \Contao\FilesModel::findByPid($objFiles->uuid, array('order' => 'name'));
                                                        if ($objSubfiles === null) {
                                                            continue;
                                                        }
                                                        while ($objSubfiles->next()) {
                                                            if (!file_exists(\Contao\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objSubfiles->path)) {
                                                                continue;
                                                            }
                                                            self::$filesCache[$objSubfiles->path][] = (object)[
                                                                'table' => $table,
                                                                'id' => $list->id
                                                            ];
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                break;
                        }
                    }
                }
            }
            if (!isset($GLOBALS['TL_CONFIG']['fileusageSkipCss']) || !$GLOBALS['TL_CONFIG']['fileusageSkipCss']) {
                $list = $this->Database->execute("SELECT * FROM tl_files WHERE name LIKE '%.css' OR name LIKE '%.scss'");
                while ($list->next()) {
                    $objFile = \Contao\FilesModel::findByPk($list->id);
                    if (!file_exists(\Contao\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objFile->path)) {
                        continue;
                    }
                    $t = file_get_contents(\Contao\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objFile->path);
                    $text = explode('files/', $t);
                    if (count($text) > 1) {
                        array_shift($text);
                        foreach ($text as $bit) {
                            $pos = strpos($bit, "'");
                            if ($pos !== false) {
                                $bit = substr($bit, 0, $pos);
                            }
                            $pos = strpos($bit, '"');
                            if ($pos !== false) {
                                $bit = substr($bit, 0, $pos);
                            }
                            $pos = strpos($bit, '}');
                            if ($pos !== false) {
                                $bit = substr($bit, 0, $pos);
                            }
                            $pos = strpos($bit, '?');
                            if ($pos !== false) {
                                $bit = substr($bit, 0, $pos);
                            }
                            $bit = 'files/' . $bit;
                            self::$filesCache[urldecode($bit)][] = (object)[
                                'css_file' => $objFile->path
                            ];
                        }
                    }
                    $text = explode('{{', $t);
                    if (count($text) > 1) {
                        array_shift($text);
                        foreach ($text as $bit) {
                            $pos = strpos($bit, "}}");
                            if ($pos !== false) {
                                $bit = substr($bit, 0, $pos);
                                if (strpos($bit, '::') !== false) {
                                    list($tag, $value) = explode('::', $bit);
                                    $pos = strpos($value, '?');
                                    if ($pos !== false) {
                                        $value = substr($value, 0, $pos);
                                    }
                                    switch ($tag) {
                                        case 'image':
                                        case 'picture':
                                            if (\Contao\Validator::isUuid($value)) {
                                                // Handle UUIDs
                                                $objFiles = \Contao\FilesModel::findByUuid($value);
                                            } elseif (is_numeric($value)) {
                                                $objFiles = \Contao\FilesModel::findByPk($value);
                                            }
                                            if ($objFiles !== null) {
                                                if (file_exists(\Contao\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objFiles->path)) {
                                                    self::$filesCache[$objFiles->path][] = (object)[
                                                        'css_file' => $objFile->path
                                                    ];
                                                }
                                            }
                                            break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if (!isset($GLOBALS['TL_CONFIG']['fileusageSkipTemplates']) || !$GLOBALS['TL_CONFIG']['fileusageSkipTemplates']) {
                $stack = [\Contao\System::getContainer()->getParameter('kernel.project_dir') . '/templates'];
                while (count($stack) > 0) {
                    $dir = array_pop($stack);
                    $f = @opendir($dir);
                    if ($f) {
                        while (($file = readdir($f)) !== false) {
                            if ($file == '.' || $file == '..') {
                                continue;
                            }
                            $full = $dir . '/' . $file;
                            if (is_dir($full)) {
                                array_push($stack, $full);
                            } else if (is_file($full)) {
                                $t = file_get_contents($full);
                                $text = (!isset($GLOBALS['TL_CONFIG']['fileusageSkipReplaceInsertTags']) || !$GLOBALS['TL_CONFIG']['fileusageSkipReplaceInsertTags']) ? \Contao\Controller::replaceInsertTags($t) : $t;
                                $text = explode('files/', $text);
                                if (count($text) > 1) {
                                    array_shift($text);
                                    foreach ($text as $bit) {
                                        $pos = strpos($bit, "'");
                                        if ($pos !== false) {
                                            $bit = substr($bit, 0, $pos);
                                        }
                                        $pos = strpos($bit, '"');
                                        if ($pos !== false) {
                                            $bit = substr($bit, 0, $pos);
                                        }
                                        $bit = substr($bit, 0, $pos);
                                        $pos = strpos($bit, '?');
                                        if ($pos !== false) {
                                            $bit = substr($bit, 0, $pos);
                                        }
                                        $bit = 'files/' . $bit;
                                        self::$filesCache[urldecode($bit)][] = (object)[
                                            'template' => str_replace(\Contao\System::getContainer()->getParameter('kernel.project_dir'), '', $full)
                                        ];
                                    }
                                }
                                if (!isset($GLOBALS['TL_CONFIG']['fileusageSkipReplaceInsertTags']) || !$GLOBALS['TL_CONFIG']['fileusageSkipReplaceInsertTags']) {
                                    $text = explode('{{', $t);
                                    if (count($text) > 1) {
                                        array_shift($text);
                                        foreach ($text as $bit) {
                                            $pos = strpos($bit, "}}");
                                            if ($pos !== false) {
                                                $bit = substr($bit, 0, $pos);
                                                if (strpos($bit, '::') !== false) {
                                                    list($tag, $value) = explode('::', $bit);
                                                    $pos = strpos($value, '?');
                                                    if ($pos !== false) {
                                                        $value = substr($value, 0, $pos);
                                                    }
                                                    switch ($tag) {
                                                        case 'image':
                                                        case 'picture':
                                                            if (\Contao\Validator::isUuid($value)) {
                                                                // Handle UUIDs
                                                                $objFiles = \Contao\FilesModel::findByUuid($value);
                                                            } elseif (is_numeric($value)) {
                                                                $objFiles = \Contao\FilesModel::findByPk($value);
                                                            }
                                                            if ($objFiles !== null) {
                                                                if (file_exists(\Contao\System::getContainer()->getParameter('kernel.project_dir') . '/' . $objFiles->path)) {
                                                                    self::$filesCache[$objFiles->path][] = (object)[
                                                                        'template' => str_replace(\Contao\System::getContainer()->getParameter('kernel.project_dir'), '', $full)
                                                                    ];
                                                                }
                                                            }
                                                            break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        @closedir($f);
                    }
                }
            }
        }
    }

    public function showUsage() {
        if(!\Input::get('id')) {
            return '';
        }
        $GLOBALS['TL_CSS'][] = 'bundles/contaofilesmanagerfileusage/css/fileusage.css';
        $this->Template = new \BackendTemplate($this->strTemplate);
        $this->Template->filename = urldecode(\Input::get('id'));
        $this->buildUsageCache();
        $db = \Database::getInstance();
        if (!isset(self::$filesCache[urldecode(\Input::get('id'))])) {
            $this->Template->usage = [];
            return $this->Template->parse();
        }
        $usage = self::$filesCache[urldecode(\Input::get('id'))];
        $known = [];
        if (count($usage) > 0) {
            foreach ($usage as $u) {
                if (isset($u->table)) {
                    $items = [];
                    $table = $u->table;
                    $id = $u->id;
                    $hasParent = false;
                    do {
                        $hasParent = false;
                        $tmp = '';
                        $item = $db->prepare("SELECT * FROM `" . $table . "` WHERE `id` = ?")->execute($id)->next();
                        if (isset($GLOBALS['FILE_USAGE'][$table])) {
                            if ($item) {
                                if (isset($GLOBALS['TL_LANG']['FILE_USAGE'][$table])) {
                                    if (is_array($GLOBALS['TL_LANG']['FILE_USAGE'][$table])) {
                                        if (count($GLOBALS['TL_LANG']['FILE_USAGE'][$table]) > 1) {
                                            $tmp = $GLOBALS['TL_LANG']['FILE_USAGE'][$table][1];
                                        } else {
                                            $tmp = $GLOBALS['TL_LANG']['FILE_USAGE'][$table][0];
                                        }
                                    } else {
                                        $tmp = $GLOBALS['TL_LANG']['FILE_USAGE'][$table];
                                    }
                                } else {
                                    $tmp = $GLOBALS['TL_LANG']['FILE_USAGE']['table'] . ' ' . $table;
                                }
                                if (is_array($GLOBALS['FILE_USAGE'][$table]['ref']) && $item->type && isset($GLOBALS['FILE_USAGE'][$table]['ref'][$item->type])) {
                                    $tmp .= ' &bdquo;' . $GLOBALS['FILE_USAGE'][$table]['ref'][$item->type][0] . '&ldquo;';
                                }
                                if (is_array($GLOBALS['FILE_USAGE'][$table]['labelColumn']) && count($GLOBALS['FILE_USAGE'][$table]['labelColumn']) > 0) {
                                    $hasLabel = false;
                                    foreach ($GLOBALS['FILE_USAGE'][$table]['labelColumn'] as $column) {
                                        if ($item->$column && !$hasLabel) {
                                            $tmp .= ' &bdquo;' . htmlspecialchars(html_entity_decode(\Contao\Controller::replaceInsertTags($item->$column))) . '&ldquo;';
                                            $hasLabel = true;
                                        }
                                    }
                                }
                                $tmp .= ' ID ' . $id;
                            } else {
                                $tmp = isset($GLOBALS['TL_LANG']['FILE_USAGE'][$table]) ? $GLOBALS['TL_LANG']['FILE_USAGE'][$table] : $GLOBALS['TL_LANG']['FILE_USAGE']['table'] . ' ' . $table;
                                $tmp .= ' ID ' . $id;
                            }
                            $href = false;
                            if ($GLOBALS['FILE_USAGE'][$table]['href']) {
                                $href = is_array($GLOBALS['FILE_USAGE'][$table]['href']) ? $GLOBALS['FILE_USAGE'][$table]['href'][$item->ptable] : $GLOBALS['FILE_USAGE'][$table]['href'];
                            }
                            if ($href) {
                                $tmp = '<a href="' . str_replace('%id%', $id, str_replace('%pid%', isset($item->pid) ? $item->pid : '', $href)) . '&rt='.\Controller::replaceInsertTags('{{request_token}}') . '">' . $tmp . '</a>';
                            }
                            if ($item && $GLOBALS['FILE_USAGE'][$table]['parent']) {
                                if ($GLOBALS['FILE_USAGE'][$table]['parent'] == 'dynamic') {
                                    $table = $item->ptable;
                                } else {
                                    $table = $GLOBALS['FILE_USAGE'][$table]['parent'];
                                }
                                $id = $item->pid;
                                $hasParent = true;
                            }
                        } else {
                            if ($item) {
                                $tmp = isset($GLOBALS['TL_LANG']['FILE_USAGE'][$table]) ? $GLOBALS['TL_LANG']['FILE_USAGE'][$table] : $GLOBALS['TL_LANG']['FILE_USAGE']['table'] . ' ' . $table;
                                // assume title column exists
                                if ($item->title) {
                                    $tmp .= ' &bdquo;' . htmlspecialchars(html_entity_decode(\Contao\Controller::replaceInsertTags($item->column))) . '&ldquo;';
                                }
                                $tmp .= ' ID ' . $id;
                            } else {
                                $tmp = isset($GLOBALS['TL_LANG']['FILE_USAGE'][$table]) ? $GLOBALS['TL_LANG']['FILE_USAGE'][$table] : $GLOBALS['TL_LANG']['FILE_USAGE']['table'] . ' ' . $table;
                                $tmp .= ' ID ' . $id;
                            }
                        }
                        $items[] = $tmp;
                    } while ($hasParent);
                    $res = implode (' &gt; ', array_reverse($items));
                } else if (isset($u->css_file)) {
                    $res = 'CSS-Datei: ' . $u->css_file;
                } else if (isset($u->template)) {
                    $res = 'Template-Datei: ' . $u->template;
                }
                if (!in_array($res, $known)) {
                    $known[] = $res;
                }
            }
        }
        $this->Template->usage = $known;
        return $this->Template->parse();
    }
}
