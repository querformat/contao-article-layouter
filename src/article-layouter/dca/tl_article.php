<?php
$GLOBALS['TL_DCA']['tl_article']['palettes']['default'] = str_replace('{template_legend:hide},','{template_legend:hide},articleLayoutsSelect,',$GLOBALS['TL_DCA']['tl_article']['palettes']['default']);

$GLOBALS['TL_DCA']['tl_article']['fields']['articleLayoutsSelect'] = array
(
    'label'                   => array('Artikel Layout','©querformat GmbH & Co. KG'),
    'filter'                  => true,
    'inputType'               => 'select',
    'options_callback'        => array('querformat\\ArticleLayouter', 'getLayoutOptions'),
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "varchar(32) NOT NULL default ''"
);