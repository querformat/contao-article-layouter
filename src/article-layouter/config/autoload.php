<?php
/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'querformat',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'querformat\ArticleLayouter'             => 'system/modules/article-layouter/ArticleLayouter.php',
	// Models
	'querformat\ArticleLayoutsModel'         => 'system/modules/article-layouter/models/ArticleLayoutsModel.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_articleLayouter'         => 'system/modules/article-layouter/templates',
));
