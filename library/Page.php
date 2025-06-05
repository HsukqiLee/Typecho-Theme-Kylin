<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class WDCX_Page
{
    public static function init()
    {
        self::descMetaPatch();
    }

    private static function descMetaPatch()
    {
        $widget = WDCX_Util::$widget;
        if ($widget->is('single')) {
            if (!WDCX_Util::isEmpty($widget->fields->custom_excerpt)) {
                $excerpt = strip_tags($widget->markdown($widget->fields->custom_excerpt));
                $widget->setDescription($excerpt);
            }
        }
    }    public static function printPageTitle()
    {
        WDCX_Util::$widget->archiveTitle(array(
            'category' => '「%s」分类下的文章',
            'search' => '包含关键字「%s」的文章',
            'tag' => '「%s」标签下的文章',
            'author' => '%s 发布的文章',
            'date' => '%s发布的文章'
        ), '', ' - ');
        WDCX_Util::$options->title();
    }

    public static function printHtmlLang()
    {
        $lang = WDCX_Util::$options->lang;
        if (empty($lang))
            $lang = 'zh-CN';
        else
            $lang = str_replace('_', '-', $lang);

        echo 'lang="', $lang, '"';
    }

    public static function printHeader()
    {
        // favicon
        WDCX_Config::callback('head_favicon', function ($faviconUrl) {
            echo '<link rel="icon" href="', WDCX_Assets::getUrlForAssets($faviconUrl), '" />', PHP_EOL;
        });
        
        // search
        WDCX_Module::load('Search');
        WDCX_Module_Search::header();

        // custom head content
        echo WDCX_Config::get('head_extend');

        // todo: open graph
    }

    public static function printBodyColumnClass()
    {
        echo 'is-', WDCX_Aside::getColumnCount(), '-column';
    }

    public static function printContainerColumnClass()
    {
        switch (WDCX_Aside::getColumnCount()) {
            case 1:
                echo 'is-12';
                break;
            case 2:
                echo 'is-8-tablet is-8-desktop is-8-widescreen';
                break;
            case 3:
                echo 'is-8-tablet is-8-desktop is-6-widescreen';
                break;
        }
    }

    public static function is($archiveType, $archiveSlug = NULL)
    {
        return WDCX_Util::$widget->is($archiveType, $archiveSlug);
    }

    public static function config($form)
    {
        $form->packTitle('Head');

        $form->packInput('Head/favicon', 'img/favicon.svg');
        $form->packTextarea('Head/extend', '');

        $form->packTitle('Logo');

        $form->packInput('Logo/text', '');
        $form->packInput('Logo/img', 'img/logo.svg');

        $form->packTitle('Footer');

        $form->packTextarea('Footer/links', 'Attribution-NonCommercial 4.0 International (CC BY-NC 4.0),fab fa-creative-commons|fab fa-creative-commons-by|fab fa-creative-commons-nc,https://creativecommons.org/licenses/by-nc/4.0/');
        $form->packTextarea('Footer/content_left', '');
        $form->packTextarea('Footer/scripts', '');
    }

    public static function getFooterLinks()
    {
        $result = WDCX_Util::parseMultilineData(WDCX_Config::get('footer_links'), 3);
        if (!empty($result)) {
            foreach ($result as $k => $link) {
                $result[$k][1] = empty($link[1]) ? null : explode('|', $link[1]);
            }
        }
        return $result;
    }
}
