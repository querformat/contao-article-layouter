<?php
array_insert($GLOBALS['BE_MOD']['design'], 1, array
	(
		'articleLayouter' => array
		(
			'tables' => array('tl_article_layouts')
		)
	)
);
$GLOBALS['TL_HOOKS']['parseTemplate'][] = array('\querformat\ArticleLayouter', 'setTemplate');
