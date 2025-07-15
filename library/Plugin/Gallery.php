<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Plugin_Gallery
{
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'Gallery', Icarus_Plugin::ENABLE);
    }

    public static function header()
    {
        Icarus_Assets::cdn('css', 'lightgallery', '1.6.8', 'css/lightgallery.min.css');
    }

    public static function footer()
    {
        Icarus_Assets::cdn('js+defer', 'lightgallery', '1.6.8', 'js/lightgallery.min.js');
    }
}
