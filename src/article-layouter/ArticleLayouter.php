<?php
/**
 * Created by PhpStorm.
 * User: Enrico Schiller
 * Date: 20.08.2018
 * Time: 22:56
 */

namespace querformat;



class ArticleLayouter extends \Frontend {

    public function setTemplate($objTemplate){
        if ($objTemplate->getName() == 'mod_article')
        {
            # issue: https://github.com/querformat/contao-article-layouter/issues/5
            # solution: choose default article layout if no article layout is choosen or not existend
            if(!$objTemplate->articleLayoutsSelect || !$objArticleLayout = \querformat\ArticleLayoutsModel::findBy(array('id=?'),array($objTemplate->articleLayoutsSelect)))
                $objArticleLayout = \querformat\ArticleLayoutsModel::findOneBy(array('fallback=?'),array(1));

            if($objArticleLayout) {
                $objTemplate->class = $objTemplate->class . ' ' . $objArticleLayout->css_classes;
                $objTemplate->use_inner = $objArticleLayout->use_inner;
                $objTemplate->css_classes_inner = $objArticleLayout->css_classes_inner;

                $objTemplate->setName('mod_articleLayouter');
            }
        }
    }

    public function getLayoutOptions(){
        $arrOptions = [];
        $objLayouts = \querformat\ArticleLayoutsModel::findAll(array('order' => 'fallback DESC, title ASC'));
        if($objLayouts) {
            while ($objLayouts->next()) {
                $arrOptions[$objLayouts->id] = $objLayouts->title . ($objLayouts->published == 1 ? '' : ' (inaktiv)');
            }
        }else{
            $arrOptions = array('Legen Sie zuerst ein Layout an');
        }
        return $arrOptions;
    }

}