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
    'table' => 'Table',
    'usage' => 'There are the following references to the file %s:',
    'nousage' => 'There are no references to the file %s',
    'tl_content' => 'Content element',
    'tl_article' => 'Article',
    'tl_page' => 'Page',
    'tl_news' => 'News article',
    'tl_news_archive' => 'News archive',
    'tl_faq' => 'FAQ',
    'tl_faq_category' => 'FAQ category',
    'tl_calendar_events' => 'Event',
    'tl_calendar' => 'Event calendar',
    'tl_newsletter' => 'Newsletter',
    'tl_newsletter_channel' => 'Newsletter archive',
    'tl_form_field' => 'Form field',
    'tl_form' => 'Form',
    'tl_style' => 'Style',
    'tl_style_sheet' => 'Stylesheet',
    'tl_theme' => 'Theme',
    'tl_layout' => 'Layout',
    'tl_member' => 'Member',
    'tl_member_group' => 'Member group',
    'tl_user' => 'User',
    'tl_user_group' => 'User group',
    'tl_comments' => 'Comment',
    'tl_module' => 'Module',
    'tl_news4ward_article' => 'Post',
    'tl_news4ward' => 'Post archive'
];
$GLOBALS['TL_LANG']['FILE_USAGE'] = is_array($GLOBALS['TL_LANG']['FILE_USAGE']) ? array_merge_recursive($GLOBALS['TL_LANG']['FILE_USAGE'], $tmp) : $tmp;
