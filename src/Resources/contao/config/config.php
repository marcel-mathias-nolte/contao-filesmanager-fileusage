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

$section = 'system';
if(!array_key_exists('files', $GLOBALS['BE_MOD']['system'])) {
	$section = 'content';
}
$GLOBALS['BE_MOD'][$section]['files']['fileusage'] = array('\MarcelMathiasNolte\ContaoFilesmanagerFileusageBundle\DcaCallbacks', 'showUsage');

$tmp = [
    'tl_content' => [
        'ref' => &$GLOBALS['TL_LANG']['CTE'],
        'parent' => 'dynamic',
        'href' => [
            'tl_article' => '/contao?do=article&table=tl_content&id=%id%&act=edit',
            'tl_news' => '/contao?do=news&table=tl_content&id=%id%&act=edit',
            'tl_calendar_events' => '/contao?do=calendar&table=tl_content&id=%id%&act=edit',
            'tl_newsletter' => '/contao?do=newsletter&table=tl_content&id=%id%&act=edit',
            'tl_news4ward_article' => '/contao?do=news4ward&table=tl_content&id=%id%&act=edit'
        ]
    ],
    'tl_article' => [
        'labelColumn' => ['title'],
        'parent' => 'tl_page',
        'href' => '/contao?do=article&table=tl_content&id=%id%'
    ],
    'tl_page' => [
        'labelColumn' => ['title'],
        'parent' => false,
        'href' => '/contao?do=page&act=edit&id=%id%'
    ],
    'tl_news' => [
        'labelColumn' => ['title'],
        'parent' => 'tl_news_archive',
        'href' => '/contao?do=news&table=tl_news&act=edit&id=%id%'
    ],
    'tl_news_archive' => [
        'labelColumn' => ['title'],
        'parent' => false,
        'href' => '/contao?do=news&act=edit&id=%id%'
    ],
    'tl_faq' => [
        'labelColumn' => ['question'],
        'parent' => 'tl_faq_category',
        'href' => '/contao?do=faq&table=tl_faq&act=edit&id=%id%'
    ],
    'tl_faq_category' => [
        'labelColumn' => ['question'],
        'parent' => false,
        'href' => '/contao?do=faq&act=edit&id=%id%'
    ],
    'tl_calendar_events' => [
        'labelColumn' => ['title'],
        'parent' => 'tl_calendar',
        'href' => '/contao?do=calendar&table=tl_calendar_events&act=edit&id=%id%'
    ],
    'tl_calendar' => [
        'labelColumn' => ['title'],
        'parent' => false,
        'href' => '/contao?do=calendar&act=edit&id=%id%'
    ],
    'tl_newsletter' => [
        'labelColumn' => ['title'],
        'parent' => 'tl_calendar',
        'href' => '/contao?do=newsletter&table=tl_newsletter&act=edit&id=%id%'
    ],
    'tl_newsletter_channel' => [
        'labelColumn' => ['title'],
        'parent' => false,
        'href' => '/contao?do=newsletter&act=edit&id=%id%'
    ],
    'tl_form_field' => [
        'labelColumn' => ['name', 'label'],
        'parent' => 'tl_form',
        'href' => '/contao?do=form&table=tl_form_field&act=edit&id=%id%'
    ],
    'tl_form' => [
        'labelColumn' => ['title'],
        'parent' => false,
        'href' => '/contao?do=form&act=edit&id=%id%'
    ],
    'tl_style' => [
        'labelColumn' => ['selector'],
        'parent' => 'tl_style_sheet',
        'href' => '/contao?do=themes&table=tl_style&act=edit&id=%id%'
    ],
    'tl_style_sheet' => [
        'labelColumn' => ['name'],
        'parent' => 'tl_theme',
        'href' => '/contao?do=themes&table=tl_style_sheet&act=edit&id=%id%'
    ],
    'tl_theme' => [
        'labelColumn' => ['name'],
        'parent' => false,
        'href' => '/contao?do=themes&act=edit&id=%id%'
    ],
    'tl_layout' => [
        'labelColumn' => ['name'],
        'parent' => 'tl_theme',
        'href' => '/contao?do=themes&table=tl_layout&act=edit&id=%id%'
    ],
    'tl_module' => [
        'labelColumn' => ['name'],
        'parent' => 'tl_theme',
        'ref' => &$GLOBALS['TL_LANG']['FMD'],
        'href' => '/contao?do=themes&table=tl_module&act=edit&id=%id%'
    ],
    'tl_member' => [
        'labelColumn' => ['email'],
        'parent' => false,
        'href' => '/contao?do=member&act=edit&id=%id%'
    ],
    'tl_member_group' => [
        'labelColumn' => ['name'],
        'parent' => false,
        'href' => '/contao?do=mgroup&act=edit&id=%id%'
    ],
    'tl_user' => [
        'labelColumn' => ['username'],
        'parent' => false,
        'href' => '/contao?do=user&act=edit&id=%id%'
    ],
    'tl_user_group' => [
        'labelColumn' => ['name'],
        'parent' => false,
        'href' => '/contao?do=group&act=edit&id=%id%'
    ],
    'tl_news4ward_article' => [
        'labelColumn' => ['title'],
        'parent' => 'tl_news4ward',
        'href' => '/contao?do=news4ward&table=tl_news4ward_article&act=edit&id=%id%'
    ],
    'tl_news4ward' => [
        'labelColumn' => ['title'],
        'parent' => false,
        'href' => '/contao?do=news4ward&act=edit&id=%id%'
    ],
];
$GLOBALS['FILE_USAGE'] = isset($GLOBALS['FILE_USAGE']) && is_array($GLOBALS['FILE_USAGE']) ? array_merge_recursive($GLOBALS['FILE_USAGE'], $tmp) : $tmp;
