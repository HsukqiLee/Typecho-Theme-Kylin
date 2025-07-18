<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Module_Navbar
{
    public static function config($form)
    {
        $form->packTitle('Navbar');

        $form->packTextarea('Navbar/menu', 
            sprintf(
                _IcT('setting.navbar.default_value'),
                Icarus_Util::$options->index,
                Icarus_Util::urlFor('page', array('slug' => 'archives')),
                Icarus_Util::urlFor('page', array('slug' => 'categories'))
            )
        );
        $form->packTextarea('Navbar/icons', "Download on GitHub,fab fa-github,http://github.com/HsukqiLee/Typecho-Theme-Kylin");
        
        $form->packRadio('Navbar/top', array('0', '1'), '0');
    }

    private static function getMenu()
    {
        return Icarus_Util::parseMultilineData(Icarus_Config::get('navbar_menu'), 2);
    }

    private static function getIcons()
    {
        return Icarus_Util::parseMultilineData(Icarus_Config::get('navbar_icons'), 3);
    }

    private static function isCurLink($uri)
    {
        return Typecho_Request::getInstance()->getRequestUri() == $uri;
    }

    public static function output()
    {
?>
<nav class="navbar navbar-main">
    <div class="container">
        <div class="navbar-brand is-flex-center">
            <a class="navbar-item navbar-logo" href="<?php Icarus_Util::$options->index(); ?>">
            <?php if (Icarus_Config::tryGet('logo_img', $logo_img)): ?>
                <img src="<?php echo Icarus_Assets::getUrlForAssets($logo_img); ?>" alt="<?php Icarus_Util::$options->title(); ?>">
            <?php else: ?>
                <?php echo Icarus_Config::get('logo_text', Icarus_Util::$options->title); ?>
            <?php endif; ?>
            </a>
        </div>
        <div class="navbar-menu">
            <?php if (Icarus_Config::has('navbar_menu')): $menu = self::getMenu(); ?>
            <div class="navbar-start">
                <?php foreach ($menu as $menuItem): ?>
                <a class="navbar-item<?php if (self::isCurLink($menuItem[1])) { ?> is-active<?php } ?>"
                href="<?php echo htmlspecialchars($menuItem[1], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($menuItem[0], ENT_QUOTES, 'UTF-8'); ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div class="navbar-end">
            <?php if (Icarus_Config::has('navbar_icons')): $icons = self::getIcons(); ?>
                <?php foreach ($icons as $iconItem): ?>
                <a class="navbar-item" target="_blank" title="<?php echo htmlspecialchars($iconItem[0], ENT_QUOTES, 'UTF-8'); ?>" href="<?php echo htmlspecialchars($iconItem[2], ENT_QUOTES, 'UTF-8'); ?>">>
                    <?php if (Icarus_Util::isEmpty($iconItem[1]) === true): ?>
                    <?php echo htmlspecialchars($iconItem[0], ENT_QUOTES, 'UTF-8'); ?>
                    <?php else: ?>
                    <i class="<?php echo htmlspecialchars($iconItem[1], ENT_QUOTES, 'UTF-8'); ?>"></i>
                    <?php endif; ?>
                </a>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (Icarus_Module::enabled('Toc') && Icarus_Page::is('post')): ?>
                <a class="navbar-item is-hidden-tablet catalogue" title="<?php _IcTp('general.catalog'); ?>" href="javascript:;">
                    <i class="fas fa-list-ul"></i>
                </a>
            <?php endif; ?>
            <?php if (Icarus_Module::enabled('DarkMode')): ?>
                <a class="navbar-item dark-adjust" href="javascript:;" title="<?php _IcTp('search.title'); ?>">
                    <i class="fas fa-adjust" id="darkModeIcon"></i>
                </a>
            <?php endif; ?>
            <?php if (Icarus_Module::enabled('Search')): ?>
                <a class="navbar-item search search-form-input" href="javascript:;" title="<?php _IcTp('search.title'); ?>">
                    <i class="fas fa-search"></i>
                </a>
            <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<?php
    }
}