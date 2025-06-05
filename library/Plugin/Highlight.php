<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class WDCX_Plugin_Highlight
{
    const VERSION = '9.13.1';
    public static function config($form)
    {
        WDCX_Plugin::basicConfig($form, 'Highlight', WDCX_Plugin::ENABLE);

        $form->packInput('Highlight/theme', 'atom-one-light', 'w-40');
    }

    public static function header()
    {
        WDCX_Assets::cdn('css', 'highlight.js', self::VERSION, 'styles/' . WDCX_Config::get('highlight_theme', 'atom-one-light') . '.min.css');
    }

    public static function footer()
    {
        WDCX_Assets::cdn('js+defer', 'highlight.js', self::VERSION, 'highlight.min.js');
    }
}
