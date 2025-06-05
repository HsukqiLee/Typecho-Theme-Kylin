<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class WDCX_Plugin_Mathjax
{
    public static function config($form)
    {
        WDCX_Plugin::basicConfig($form, 'Mathjax', WDCX_Plugin::DISABLE);
    }

    public static function footer()
    {
        WDCX_Assets::cdn('js+defer', 'mathjax', '2.7.5', 'MathJax.js?config=TeX-MML-AM_CHTML');
        WDCX_Assets::printThemeJs('mathjax.js', TRUE);
    }
}
