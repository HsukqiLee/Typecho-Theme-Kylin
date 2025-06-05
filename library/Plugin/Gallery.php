<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class WDCX_Plugin_Gallery
{
    public static function config($form)
    {
        WDCX_Plugin::basicConfig($form, 'Gallery', WDCX_Plugin::ENABLE);
    }

    public static function header()
    {
        WDCX_Assets::cdn('css', 'lightgallery', '1.6.8', 'css/lightgallery.min.css');
        WDCX_Assets::cdn('css', 'justifiedGallery', '3.7.0', 'css/justifiedGallery.min.css');
    }

    public static function footer()
    {
        WDCX_Assets::cdn('js+defer', 'lightgallery', '1.6.8', 'js/lightgallery.min.js');
        WDCX_Assets::cdn('js+defer', 'justifiedGallery', '3.7.0', 'js/jquery.justifiedGallery.min.js');
        WDCX_Assets::printThemeJs('gallery.js', TRUE);
    }
}
