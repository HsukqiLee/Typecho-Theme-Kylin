<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class WDCX_Plugin_Progressbar
{
    public static function config($form)
    {
        WDCX_Plugin::basicConfig($form, 'Progressbar', WDCX_Plugin::ENABLE);
    }

    public static function header()
    {
        WDCX_Assets::printThemeCss('progressbar.css');
        WDCX_Assets::cdn('js', 'pace', '1.0.2', 'pace.min.js');
    }
}
