# Contao Filemanager File Usage Bundle

![Screenshot Dateliste / screenshot file list](/images/screen2.jpg) \
\
![Screenshot Details / screenshot details](/images/screen1.jpg)

## Deutsche Version

Dieses Bundle zeigt in der Dateiverwaltung ein Icon, welches anzeigt, ob die Datei irgendwo verknüpft ist und zeigt nach einem Klick darauf die konkreten Verwendungsstellen.

Die folgenden Verknüpfungsmöglichkeiten werden geprüft:
* fileTree-Felder in Tabellen, prüft auch die Verknüpfung übergeordneter Ordner
* textarea-Felder in Tabellen, \
  prüft die Nennung es Pfadnamens und image- und picture-Inserttags
* text-Felder in Tabellen, wenn der rgxp auf url gesetzt ist \
  prüft die Nennung es Pfadnamens und image- und picture-Inserttags
* alle css- und scss-Dateien in /files (bezogen aus der Tabelle tl_files), \
  prüft die Nennung es Pfadnamens und image- und picture-Inserttags
* alle Template-Dateien in /templates (bezogen via rekursiver Verzeichnissuche), \
  prüft die Nennung es Pfadnamens und image- und picture-Inserttags

Sie können die Tabellendefinition mit folgendem EIntrag in Ihrer Resources/contao/config/config.php erweitern:

```php
$GLOBALS['FILE_USAGE']['TABELLENNAME'] = [
    // optional: Spalte(n) zur Benennung des Eintrags,
    // wenn eine Spalte keinen Inhalt hat wird die jeweils nächste genutzt
    'labelColumn' => ['title'],
    // optionale Referenz, falls die Spalte 'type' vorhanden ist
    'ref' => &$GLOBALS['TL_LANG']['REFERENZTABELLE'],
    // Name der Elterntabelle
    'parent' => 'ELTERNTABELLE',
    // oder false, wenn es keine Elterntabelle gibt
    'parent' => false,
    // , oder 'dynamic', falls die Elterntabelle anhand der Spalte ptable gewählt werden soll
    'parent' => 'dynamic',
    // optional: Bearbeitungslink
    // %id% und %pid% werden ersetzt
    'href' => '/contao?do=MODULNAME&table=TABELLENNAME&id=%id%&act=edit',
    // für von der Spalte 'ptable' abhängige Links muss ein Array genutzt werden:
    'href' => [
        'ELTERNTABELLE' => '/contao?do=MODULNAME&table=TABELLENNAME&id=%id%&act=edit'
    ]
];
```

Die Beispiel-Deklaration für tl_content lautet ...

```php
$GLOBALS['FILE_USAGE']['tl_content'] = [
    'ref' => &$GLOBALS['TL_LANG']['CTE'],
    'parent' => 'dynamic',
    'href' => [
        'tl_article' => '/contao?do=article&table=tl_content&id=%id%&act=edit',
        'tl_news' => '/contao?do=news&table=tl_content&id=%id%&act=edit',
        'tl_calendar_events' => '/contao?do=calendar&table=tl_content&id=%id%&act=edit',
        'tl_newsletter' => '/contao?do=newsletter&table=tl_content&id=%id%&act=edit'
    ]
];
```

... und die Beispiel-Deklaration für tl_user lautet ...

```php
$GLOBALS['FILE_USAGE']['tl_user'] = [
    'labelColumn' => ['username'],
    'parent' => false,
    'href' => '/contao?do=user&act=edit&id=%id%'
];
```

Zusätzlich sollte der Name der Tabelle in Ihrer Resources/contao/languages/SPRACHE/default.php gesetzt werden:

```php
$GLOBALS['TL_LANG']['FILE_USAGE']['TABELLENNAME'] = 'TABELLENBEZEICHNUNG';
```

z. B.

```php
$GLOBALS['TL_LANG']['FILE_USAGE']['tl_user'] = 'Backend-Nutzer';
```

## English version

This bundles displays an icon, which shows whether an file is used anywhere or not and shows details on where it is used if you click on it.

The following possible usage is checked:
* fileTree fields in tables, also checks if parent folders are used
* textarea fields in tables, \
  looking for usage of the file path and for image and picture insert tags
* text fields in tables, if rgxp is set to url, \
  looking for usage of the file path and for image and picture insert tags
* all css and scss files inside /files (derived from tl_files), \
  looking for usage of the file path and for image and picture insert tags
* all template files inside /templates (derived via directory traversal), \
  looking for usage of the file path and for image and picture insert tags

You can expand the table definitions using the following array in your Resources/contao/config/config.php:

```php
$GLOBALS['FILE_USAGE']['TABLENAME'] = [
    // optional column(s) to use for labelling the item,
    // if one given column is empty, the next one will be used
    'labelColumn' => ['title'],
    // optional reference, if a type field is present
    'ref' => &$GLOBALS['TL_LANG']['REFERENCE TABLE NAME'],
    // parent tables name
    'parent' => 'PARENTTABLE',
    // or false if there is no parent table
    'parent' => false,
    // or 'dynamic' if the parent tables name should be derived from the ptable field
    'parent' => 'dynamic',
    // optional provide an edit link
    // %id% will
    'href' => '/contao?do=MODULENAME&table=TABLENAME&id=%id%&act=edit',
    // for hrefs based on the ptable use an array:
    'href' => [
        'PARENTTABLE' => '/contao?do=MODULENAME&table=TABLENAME&id=%id%&act=edit'
    ]
];
```

The example definition for tl_content would be ...

```php
$GLOBALS['FILE_USAGE']['tl_content'] = [
    'ref' => &$GLOBALS['TL_LANG']['CTE'],
    'parent' => 'dynamic',
    'href' => [
        'tl_article' => '/contao?do=article&table=tl_content&id=%id%&act=edit',
        'tl_news' => '/contao?do=news&table=tl_content&id=%id%&act=edit',
        'tl_calendar_events' => '/contao?do=calendar&table=tl_content&id=%id%&act=edit',
        'tl_newsletter' => '/contao?do=newsletter&table=tl_content&id=%id%&act=edit'
    ]
];
```

... and the example definition for tl_user would be ...

```php
$GLOBALS['FILE_USAGE']['tl_user'] = [
    'labelColumn' => ['username'],
    'parent' => false,
    'href' => '/contao?do=user&act=edit&id=%id%'
];
```

Additionally, you would like to name the table in your Resources/contao/languages/LANGUAGE/default.php:

```php
$GLOBALS['TL_LANG']['FILE_USAGE']['TABLENAME'] = 'ITEMNAME';
```

e.g.

```php
$GLOBALS['TL_LANG']['FILE_USAGE']['tl_user'] = 'Backend-User';
```
