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
            $condition = (
                BE_USER_LOGGED_IN ?
                    ($objArticleLayout = \querformat\ArticleLayoutsModel::findById($objTemplate->articleLayoutsSelect)) :
                    ($objArticleLayout = \querformat\ArticleLayoutsModel::findOneBy(array('id=?','published=1'),array($objTemplate->articleLayoutsSelect,1)))
            );

            if($condition) {
                $objTemplate->class = $objTemplate->class . ' ' . $objArticleLayout->css_classes;
                $objTemplate->use_inner = $objArticleLayout->use_inner;

                $objTemplate->setName('mod_articleLayouter');
            }
        }
    }

    public function getLayoutOptions(){
        $arrOptions = [];
        $objLayouts = ArticleLayoutsModel::findAll(array('order' => 'fallback DESC, title ASC'));
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