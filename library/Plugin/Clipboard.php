<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class WDCX_Plugin_Clipboard
{
    public static function config($form)
    {
        WDCX_Plugin::basicConfig($form, 'Clipboard', WDCX_Plugin::ENABLE);
    }

    public static function footer()
    {
        WDCX_Assets::cdn('js+defer', 'clipboard.js', '2.0.4', 'clipboard.min.js');
        WDCX_Assets::printThemeJs('clipboard.js', TRUE);
    }
}
