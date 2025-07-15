<?php 
if (defined('__TYPECHO_ROOT_DIR__') === false) exit; ?>
                </main>
                <?php 
                Icarus_Aside::$asideLeft->output();
                Icarus_Aside::$asideRight->output();
                ?>
            </div>
        </div>
    </div>
    <footer data-no-instant class="footer">
        <div class="container">
            <div class="level">
                <div class="level-start has-text-centered-mobile">
                    <a class="footer-logo is-block has-mb-6" href="<?php Icarus_Util::$options->index(); ?>">
                    <?php if (Icarus_Config::tryGet('logo_img', $logo_img)): ?>
                        <img src="<?php echo Icarus_Assets::getUrlForAssets($logo_img); ?>" alt="<?php Icarus_Util::$options->title(); ?>">
                    <?php else: ?>
                        <?php echo Icarus_Config::get('logo_text', Icarus_Util::$options->title); ?>
                    <?php endif; ?>
                    </a>
                    <p class="is-size-7">
                    &copy; <?php 
                    $installYear = Icarus_Util::getSiteInstallYear();
                    $curYear = date('Y');
                    if ($installYear != $curYear)
                        echo $installYear, '&nbsp;-&nbsp;';
                    echo $curYear;
                    ?> <?php echo Icarus_Config::get('profile_author', Icarus_Util::$options->title); ?>.&nbsp;
                    All rights reserved.
                    <br>
                    Powered by <a href="https://typecho.org/" rel="noopener" target="_blank">Typecho</a>.&nbsp;Theme <a href="https://github.com/HsukqiLee/Typecho-Theme-Kylin/" rel="noopener" target="_blank">Icarus & Kylin</a>.
                    </p>
                    <?php if (Icarus_Config::tryGet('footer_beian', $footerBeian)): ?>
                    <img class="lazyload" src="<?php echo Icarus_Assets::getUrlForAssets('img/icp.png'); ?>">
                    <a href="<?php echo Icarus_Config::get('footer_beian_code'); ?>"><?php echo $footerBeian; ?></a>
                    <?php endif; ?>
                    <?php if (Icarus_Config::tryGet('footer_icp', $footerIcp)): ?>
                    <a href="https://beian.miit.gov.cn/" rel="noopener" target="_blank"><?php echo $footerIcp; ?></a>
                    <?php endif; ?>
                    <?php echo Icarus_Config::get('footer_content_left'); ?>
                </div>
                <div class="level-end">
                <?php $footerLinks = ICarus_Page::getFooterLinks(); 
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
Icarus_Module::show('Search');
Icarus_Assets::cdn('js', 'jquery', '3.5.0', 'jquery.min.js');
Icarus_Assets::cdn('js', 'jquery_lazyload', '1.9.7', 'jquery.lazyload.min.js', TRUE);
Icarus_Assets::cdn('js', 'instantclick', '3.1.0', 'instantclick.min.js');
?>
<script defer data-no-instant>InstantClick.init();</script>
<?php
Icarus_Module::footerAll();
Icarus_Plugin::footerAll();
Icarus_Assets::printThemeJs('main.js', TRUE, FALSE);
echo Icarus_Config::get('footer_scripts');
?>

</body>
</html>