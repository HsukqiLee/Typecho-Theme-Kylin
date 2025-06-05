<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class WDCX_Plugin_BackToTop
{
    public static function config($form)
    {
        WDCX_Plugin::basicConfig($form, 'BackToTop', WDCX_Plugin::ENABLE);
    }

    public static function header()
    {
        WDCX_Assets::printThemeCss('back-to-top.css');
    }

    public static function footer()
    {
?>
<a id="back-to-top" title="返回顶部" href="javascript:;">
    <i class="fas fa-chevron-up"></i>
</a>
<?php
        WDCX_Assets::printThemeJs('back-to-top.js', TRUE);
    }
}
