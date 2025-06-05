<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
                </main>
                <?php 
                WDCX_Aside::$asideLeft->output();
                WDCX_Aside::$asideRight->output();
                ?>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="level">
                <div class="level-start has-text-centered-mobile">
                    <a class="footer-logo is-block has-mb-6" href="<?php WDCX_Util::$options->index(); ?>">
                    <?php if (WDCX_Config::tryGet('logo_img', $logo_img)): ?>
                        <img src="<?php echo WDCX_Assets::getUrlForAssets($logo_img); ?>" alt="<?php WDCX_Util::$options->title(); ?>" height="28">
                    <?php else: ?>
                        <?php echo WDCX_Config::get('logo_text', WDCX_Util::$options->title); ?>
                    <?php endif; ?>
                    </a>
                    <p class="is-size-7">
                    &copy; <?php 
                    $installYear = WDCX_Util::getSiteInstallYear();
                    $curYear = date('Y');
                    if ($installYear != $curYear)
                        echo $installYear, '&nbsp;-&nbsp;';
                    echo $curYear;
                    ?> <?php echo WDCX_Config::get('profile_author', WDCX_Util::$options->title); ?>&nbsp;
                    Powered by <a href="http://typecho.org/" target="_blank" ref="nofollow noreferrer noopener">Typecho</a> & <a
                            href="https://github.com/KeNorizon/typecho-theme-WDCX">WDCX</a>
                    </p>
                    <?php echo WDCX_Config::get('footer_content_left'); ?>
                </div>
                <div class="level-end">
                <?php $footerLinks = WDCX_Page::getFooterLinks(); 
                if (!empty($footerLinks)): ?>
                    <div class="field has-addons is-flex-center-mobile has-mt-5-mobile is-flex-wrap is-flex-middle">
                    <?php foreach ($footerLinks as $linkItem): ?>
                    <p class="control">
                        <a class="button is-white <?php if (!empty($linkItem[1])) echo 'is-large'; ?>" rel="noopener noreferrer" target="_blank" title="<?php echo $linkItem[0]; ?>" href="<?php echo $linkItem[2]; ?>">
                            <?php if (empty($linkItem[1])):
                                echo $linkItem[0];
                            else: foreach ($linkItem[1] as $iconItem): ?>
                            <i class="<?php echo $iconItem; ?>"></i>
                            <?php endforeach; endif; ?>
                        </a>
                    </p>
                    <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </footer>
<?php
WDCX_Module::show('Search');

WDCX_Assets::cdn('js', 'jquery', '3.3.1', 'jquery.min.js');

WDCX_Plugin::footerAll();

WDCX_Assets::printThemeJs('main.js', TRUE);

echo WDCX_Config::get('footer_scripts');
?>
</body>
</html>