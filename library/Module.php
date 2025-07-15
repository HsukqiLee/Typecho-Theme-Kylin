<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Module
{
    private static $_moduleList = array(
        'Single',
        'Navbar',
        'Profile',
        'Archive',
        'Category',
        'Link',
        'RecentPost',
        'Tag',
        'Toc',
        'Search',
        'Comments',
        'Donate',
        'Paginator',
        'DarkMode'
    );
    private static $_moduleLoaded = array();

    public static function load($name)
    {
        if (in_array($name, self::$_moduleList) === false)
            return FALSE;
        if (in_array($name, self::$_moduleLoaded) === false) {
            require __ICARUS_ROOT__ . 'library/Module/' . $name . '.php';
            self::$_moduleLoaded[] = $name;
        }
        return TRUE;
    }
    
    public static function header($moduleName)
    {
        if (self::load($moduleName) === false)
            return;
        
        $moduleClass = 'Icarus_Module_' . $moduleName;
        
        $params = func_get_args();
        array_shift($params);
        
        if (method_exists($moduleClass, 'header') === true)
        {
            call_user_func_array(array($moduleClass, 'header'), $params);
        }
    }
    
    public static function footer($moduleName)
    {
        if (self::load($moduleName) === false)
            return;
        
        $moduleClass = 'Icarus_Module_' . $moduleName;
        
        $params = func_get_args();
        array_shift($params);
        
        if (method_exists($moduleClass, 'footer'))
        {
            call_user_func_array(array($moduleClass, 'footer'), $params);
        }
    }

    public static function show($name)
    {
        if (self::load($name) === false)
            return;
        $params = func_get_args();
        array_shift($params);
        call_user_func_array(array('Icarus_Module_' . $name, 'output'), $params);
    }

    public static function enabled($name)
    {
        return Icarus_Config::get(Icarus_Util::parseName($name) . '_enable', FALSE) == TRUE;
    }
    
    public static function headerAll()
    {
        foreach (self::$_moduleList as $moduleName)
        {
            self::header($moduleName);
        }
    }
    
    public static function footerAll()
    {
        foreach (self::$_moduleList as $moduleName)
        {
            self::footer($moduleName);
        }
    }

    public static function config($form)
    {
        foreach (self::$_moduleList as $moduleName)
        {
            if (self::load($moduleName))
            {
                $moduleClass = 'Icarus_Module_' . $moduleName;
                if (method_exists($moduleClass, 'config'))
                {
                    call_user_func(array($moduleClass, 'config'), $form);
                }
            }
        }
    }
}