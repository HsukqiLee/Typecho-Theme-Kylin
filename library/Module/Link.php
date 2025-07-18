<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Module_Link
{
    public static function config($form)
    {
        Icarus_Aside::basicConfig($form, 'Link', Icarus_Aside::ENABLE, 'left', '2');

        $form->packTextarea('Link/links', "Typecho,http://typecho.org/\nGitHub,https://github.com/");
    }

    private static function getUrlDomain($url)
    {
        return parse_url($url, PHP_URL_HOST);
    }

    private static function getLinks()
    {
        return Icarus_Util::parseMultilineData(Icarus_Config::get('link_links'), 2);
    }

    public static function output()
    {
        $links = self::getLinks();
        if (Icarus_Util::isEmpty($links) === true)
            return;

?>
<div class="card widget">
    <div class="card-content">
        <div class="menu">
        <h3 class="menu-label">
            <?php _IcTp('link.title'); ?>
        </h3>
        <ul class="menu-list">
<?php foreach ($links as $linkItem): $domain = self::getUrlDomain($linkItem[1]); ?>
            <li>
                <a class="level is-mobile" href="<?php echo htmlspecialchars($linkItem[1], ENT_QUOTES, 'UTF-8'); ?>" target="_blank">>
                    <span class="level-left">
                        <span class="level-item"><?php echo htmlspecialchars($linkItem[0], ENT_QUOTES, 'UTF-8'); ?></span>
                    </span>
                    <?php if (Icarus_Util::isEmpty($domain) === false): ?>
                    <span class="level-right">
                        <span class="level-item tag"><?php echo htmlspecialchars($domain, ENT_QUOTES, 'UTF-8'); ?></span>
                    </span>
                    <?php endif; ?>
                </a>
            </li>
<?php endforeach; ?>     
        </ul>
        </div>
    </div>
</div>
<?php
    }
}