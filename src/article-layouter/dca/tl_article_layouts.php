<?php
$GLOBALS['TL_DCA']['tl_article_layouts'] = array
(

// Config
    'config' => array
    (
        'dataContainer' => 'Table',
        'enableVersioning' => true,
        'switchToEdit'      => true,
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
            'mode' => 0,
            'flag' => 11,
            'fields' => array('title'),
            'panelLayout' => 'filter,search,limit',
        ),
        'label' => array
        (
            'fields' => array('title','fallback'),
            'format' => '',
            'label_callback' => array('tl_article_layouts', 'setListLabels')
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_dma_eg']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif',
                'attributes'          => 'class="edit"'
            ),
            'delete' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_dma_eg_fields']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
            ),
            'show' => array
            (
                'label' => &$GLOBALS['TL_LANG']['tl_dma_eg_fields']['show'],
                'href' => 'act=show',
                'icon' => 'show.gif'
            )
        )
    ),

// Palettes
    'palettes' => array
    (
        'default' => '{Name},title,css_classes,use_inner,fallback,published',
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
            'inputType' => 'text',
            'exclude' => true,
            'eval' => array('mandatory'=>true,'rgxp' => 'alnum', 'doNotCopy' => true, 'maxlength' => 128),
            'sql' => "varchar(255) NOT NULL default ''"
        ),
        'css_classes' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_article_layouts']['css_classes'],
            'search'                  => true,
            'inputType'               => 'text',
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'use_inner' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_article_layouts']['use_inner'],
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'fallback' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_article_layouts']['default'],
            'filter'                  => true,
            'inputType'               => 'checkbox',
            'save_callback'           => array(array('tl_article_layouts', 'checkFallbacks')),
            'sql'                     => "char(1) NOT NULL default ''",
        ),
        'published' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_article_layouts']['published'],
            'exclude'                 => true,
            'filter'                  => true,
            'flag'                    => 1,
            'inputType'               => 'checkbox',
            'eval'                    => array('doNotCopy'=>true),
            'sql'                     => "char(1) NOT NULL default 1"
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
    public function setListLabels($row, $label){
        $newLabel = $row['title'] . ($row['fallback'] == 1?' <span style="opacity: .6;">(default)</span>':'');
        if($row['published'] == 0){
            $newLabel = '<span style="opacity: .5">'.$newLabel.'</span>';
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
        if ($varValue == 1)
        {
            $this->Database->prepare("UPDATE tl_article_layouts %s WHERE id!=?")->set(array('fallback' => 0))->execute($dc->id);
        }
        return $varValue;
    }
}


