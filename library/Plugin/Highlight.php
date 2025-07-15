<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Plugin_Highlight
{
    public const VERSION = '11.9.0';
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'Highlight', Icarus_Plugin::ENABLE);

        $form->packInput('Highlight/theme', 'atom-one-light', 'w-40');
        $form->packInput('Highlight/theme_dark', 'atom-one-dark', 'w-40');
    }

    public static function header()
    {
        Icarus_Assets::cdn('css', 'highlight.js', self::VERSION, 'styles/' . Icarus_Config::get('highlight_theme', 'atom-one-light') . '.min.css');
        echo '<link rel="preload" as="style" href="' . Icarus_Assets::getCdnUrl('highlight.js', self::VERSION, 'styles/' . Icarus_Config::get('highlight_theme_dark', 'atom-one-dark') . '.min.css') . '">' . PHP_EOL;
    }

    public static function footer()
    {
        Icarus_Assets::cdn('js+defer', 'highlight.js', self::VERSION, 'highlight.min.js');
    }
}
