<?php
$GLOBALS['TL_DCA']['tl_article_layouts'] = array
(

// Config
    'config' => array
    (
        'dataContainer' => 'Table',
        'enableVersioning' => true,
        'switchToEdit' => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
            )
        ),
    ),

// List
    'list' => array
    (
        'sorting' => array
        (
            'mode' => 1,
            'fields' => array('title'),
            'flag' => 1,
            'panelLayout' => 'filter;search;',
            'disableGrouping' => true,
        ),
        'label' => array
        (
            'fields' => array('title'),
            'format' => '%s',
            'label_callback' => array('tl_article_layouts', 'setListLabels')
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_article_layouts']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.svg',
            ),
            'copy' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_article_layouts']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.svg'
            ),
            'delete' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_article_layouts']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['tl_article_layouts']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            ),
            'show' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_article_layouts']['show'],
                'href' => 'act=show',
                'icon' => 'show.svg'
            )
        )
    ),

// Palettes
    'palettes' => array
    (
        '__selector__' => array('use_inner'),
        'default' => 'title,css_classes;use_inner;fallback',
    ),
    // Subpalettes
    'subpalettes' => array
    (
        'use_inner' => 'css_classes_inner'
    ),
// Fields
    'fields' => array
    (
        'id' => array
        (
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'sorting' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_article_layouts']['title'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => array(
                'mandatory' => true,
                'tl_class' => 'w50'
            ),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'css_classes' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_article_layouts']['css_classes'],
            'search' => true,
            'inputType' => 'text',
            'eval' => array(
                'tl_class' => 'clr w50'
            ),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'use_inner' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_article_layouts']['use_inner'],
            'filter' => true,
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => array(
                'submitOnChange' => true,
                'tl_class' => 'clr w50'
            ),
            'sql' => "char(1) NOT NULL default ''"
        ),
        'css_classes_inner' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_article_layouts']['css_classes_inner'],
            'inputType' => 'text',
            'eval' => array(
                'tl_class' => 'clr w50'
            ),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'fallback' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_article_layouts']['default'],
            'inputType' => 'checkbox',
            'eval' => array(
                'tl_class' => 'clr'
            ),
            'save_callback' => array(array('tl_article_layouts', 'checkFallbacks')),
            'sql' => "char(1) NOT NULL default ''",
        ),
        'published' => array
        (
            'label' => &$GLOBALS['TL_LANG']['tl_article_layouts']['published'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'sql' => "char(1) NOT NULL default 1"
        ),
    )
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Enrico Schiller
 */
class tl_article_layouts extends Backend
{
    /**
     * label_callback: Ermöglicht individuelle Bezeichnungen in der Listenansicht.
     * @param $row
     * @param $label
     * @return string
     */
    public function setListLabels($row, $label)
    {
        $newLabel = $row['title'] . ($row['fallback'] == 1 ? ' <span style="color: #79cc5c;">(Standardauswahl)</span>' : '');
        if ($row['published'] == 0) {
            $newLabel = '<span style="opacity: .3">' . $newLabel . '</span>';
        }
        return $newLabel;
    }

    /**
     * save_callback: Wird beim Abschicken eines Feldes ausgeführt.
     * @param $varValue
     * @param $dc
     * @return string
     */
    public function checkFallbacks($varValue, DataContainer $dc)
    {
        // unset fallback in all other article_layout options
        if ($varValue == 1) {
            $this->Database->prepare("UPDATE tl_article_layouts %s WHERE id!=?")->set(array('fallback' => 0))->execute($dc->id);
        }
        return $varValue;
    }
}


