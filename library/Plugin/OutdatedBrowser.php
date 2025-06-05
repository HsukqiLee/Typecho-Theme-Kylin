<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class WDCX_Plugin_OutdatedBrowser
{
    public static function config($form)
    {
        WDCX_Plugin::basicConfig($form, 'OutdatedBrowser', WDCX_Plugin::ENABLE);
    }

    public static function header()
    {
        WDCX_Assets::cdn('css', 'outdated-browser', '1.1.5', 'outdatedbrowser.min.css');
    }

    public static function footer()
    {
        WDCX_Assets::cdn('js+defer', 'outdated-browser', '1.1.5', 'outdatedbrowser.min.js');
?>
<div id="outdated"></div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        outdatedBrowser({
            bgColor: '#f25648',
            color: '#ffffff',
            lowerThan: 'flex'
        });
    });
</script>
<?php
    }
}
