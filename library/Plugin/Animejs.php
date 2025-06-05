<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class WDCX_Plugin_Animejs
{
    public static function config($form)
    {
        WDCX_Plugin::basicConfig($form, 'Animejs', WDCX_Plugin::ENABLE);
    }

    public static function header()
    {
?>
<style>body>.footer,body>.navbar,body>.section{opacity:0}</style>
<?php
    }

    public static function footer()
    {
        WDCX_Assets::printThemeJs('animation.js');
    }
}
