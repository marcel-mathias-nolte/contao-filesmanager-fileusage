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

$tmp = [
    'table' => 'Tabelle',
    'usage' => 'Auf die Datei %s wird an folgenden stellen verwiesen:',
    'nousage' => 'Auf die Datei %s wird nicht verwiesen:',
    'tl_content' => 'Inhaltselement',
    'tl_article' => 'Artikel',
    'tl_page' => 'Seite',
    'tl_news' => 'Nachrichten-Beitrag',
    'tl_news_archive' => 'Nachrichten-Archiv',
    'tl_faq' => 'FAQ',
    'tl_faq_category' => 'FAQ-Kategorie',
    'tl_calendar_events' => 'Event',
    'tl_calendar' => 'Event-Kalender',
    'tl_newsletter' => 'Newsletter',
    'tl_newsletter_channel' => 'Newsletter-Archiv',
    'tl_form_field' => 'Formular-Feld',
    'tl_form' => 'Formular',
    'tl_style' => 'Style-Regel',
    'tl_style_sheet' => 'Style-Sheet',
    'tl_theme' => 'Theme',
    'tl_layout' => 'Layout',
    'tl_member' => 'Mitglied',
    'tl_member_group' => 'Mitgliedergruppe',
    'tl_user' => 'Benutzer',
    'tl_user_group' => 'Benutzergruppe',
    'tl_comments' => 'Kommentar',
    'tl_module' => 'Modul',
    'tl_news4ward_article' => 'Beitrag',
    'tl_news4ward' => 'Beitragsarchiv'
];
$GLOBALS['TL_LANG']['FILE_USAGE'] = is_array($GLOBALS['TL_LANG']['FILE_USAGE']) ? array_merge_recursive($GLOBALS['TL_LANG']['FILE_USAGE'], $tmp) : $tmp;
