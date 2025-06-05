<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
define('__WDCX_ROOT__', dirname(__FILE__) . '/');
define('__WDCX_VERSION__', '1.1.4');
define('__WDCX_CFG_VERSION__', '3');

if (isset($this))
{
    define('__WDCX_WIDGET_CLASS__', get_class($this));
}

function themeInit($widget)
{
    static $inited = FALSE;
    if (!$inited)
    {
        $inited = TRUE;

        require __WDCX_ROOT__ . 'library/Util.php';
        require __WDCX_ROOT__ . 'library/Module.php';
        require __WDCX_ROOT__ . 'library/Aside.php';
        require __WDCX_ROOT__ . 'library/Plugin.php';
        require __WDCX_ROOT__ . 'library/Page.php';
        require __WDCX_ROOT__ . 'library/Assets.php';
        require __WDCX_ROOT__ . 'library/Config.php';
        require __WDCX_ROOT__ . 'library/Content.php';
    
        WDCX_Util::init($widget);
        
        WDCX_Assets::init();
        WDCX_Aside::init();
        WDCX_Page::init();
    }
}

function themeConfig($form)
{
    require __WDCX_ROOT__ . 'library/Util.php';
    require __WDCX_ROOT__ . 'library/.php';
    require __WDCX_ROOT__ . 'library/Module.php';
    require __WDCX_ROOT__ . 'library/Aside.php';
    require __WDCX_ROOT__ . 'library/Plugin.php';
    require __WDCX_ROOT__ . 'library/Page.php';
    require __WDCX_ROOT__ . 'library/Assets.php';
    require __WDCX_ROOT__ . 'library/Config.php';
    require __WDCX_ROOT__ . 'library/Content.php';
    require __WDCX_ROOT__ . 'library/Ajax.php';
    require __WDCX_ROOT__ . 'library/Backup.php';

    WDCX_Util::init(NULL);
    

    WDCX_Ajax::handle();

    $iForm = new WDCX_Config($form);
    
    WDCX_Config::config($iForm);
    WDCX_Page::config($iForm);
    WDCX_Content::config($iForm);
    WDCX_Aside::config($iForm);
    WDCX_Assets::config($iForm);
    WDCX_Module::config($iForm);
    WDCX_Plugin::config($iForm);

    $iForm->toc();
}

/**
 * fix duplicated themeFields() calls made by
 * admin/custom-fields.php
 */
function themeFieldsInit()
{
    static $inited = FALSE;
    if (!$inited)
    {
        require __WDCX_ROOT__ . 'library/Util.php';
        require __WDCX_ROOT__ . 'library/.php';
        require __WDCX_ROOT__ . 'library/Content.php';
        
        WDCX_Util::init(NULL);
        

        $inited = TRUE;
    }
}

function themeFields($form)
{
    themeFieldsInit();
    WDCX_Content::fieldsConfig($form);
}

// WDCX  functions removed - using direct text output now
