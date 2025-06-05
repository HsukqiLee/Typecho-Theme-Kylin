<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class WDCX_Plugin_Moment
{
    public static function config($form)
    {
        WDCX_Plugin::basicConfig($form, 'Moment', WDCX_Plugin::ENABLE);
    }

    public static function footer()
    {
        WDCX_Assets::cdn('js+defer', 'moment.js', '2.22.2', 'moment-with-locales.min.js');
    }
}