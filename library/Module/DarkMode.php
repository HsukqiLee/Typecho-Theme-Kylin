<?php
if (!defined('__TYPECHO_ROOT_DIR__'))
  exit;
class Icarus_Module_DarkMode
{
  public static function config($form)
  {
    $form->packTitle('DarkMode');
    $form->packRadio('DarkMode/enable', array('0', '1'), '1');
  }

  public static function header()
  {

    if (Icarus_Config::tryGet('logo_img', $logo_img)) {
      $logoUrl = htmlspecialchars(Icarus_Assets::getUrlForAssets($logo_img), ENT_QUOTES);
      echo '<link rel="preload" as="image" href="' . $logoUrl . '">' . PHP_EOL;
    }

    if (Icarus_Config::tryGet('logo_img_dark', $logo_img_dark)) {
      $logoDarkUrl = htmlspecialchars(Icarus_Assets::getUrlForAssets($logo_img_dark), ENT_QUOTES);
      echo '<link rel="preload" as="image" href="' . $logoDarkUrl . '">' . PHP_EOL;
    }
    //echo '<link rel="stylesheet" href="' . Icarus_Assets::getUrlForAssets('/css/dark.css') . '" media="(prefers-color-scheme: dark)">';
  }

  public static function footer()
  {
    ?>
    <div class="dark-mode-menu" id="darkModeMenu">
      <a class="dark-mode-menu-item" data-mode="auto">
        <span class="icon"><i class="fas fa-magic"></i></span>
        <span><?php _IcTp('darkmode.mode.auto'); ?></span>
      </a>
      <a class="dark-mode-menu-item" data-mode="light">
        <span class="icon"><i class="fas fa-sun"></i></span>
        <span><?php _IcTp('darkmode.mode.light'); ?></span>
      </a>
      <a class="dark-mode-menu-item" data-mode="dark">
        <span class="icon"><i class="fas fa-moon"></i></span>
        <span><?php _IcTp('darkmode.mode.dark'); ?></span>
      </a>
    </div>
    <script>
      window.DARK_MODE_CONFIG = {
        <?php if (Icarus_Config::tryGet('logo_img', $logo_img) && Icarus_Config::tryGet('logo_img_dark', $logo_img_dark) && !Icarus_Util::isEmpty($logo_img_dark)): ?>
                          hasLogos: true,
          lightSrc: "<?php echo Icarus_Assets::getUrlForAssets($logo_img); ?>",
          darkSrc: "<?php echo Icarus_Assets::getUrlForAssets($logo_img_dark); ?>",
        <?php else: ?>
                          hasLogos: false,
          lightSrc: null,
          darkSrc: null,
        <?php endif; ?>
                      highlightLightTheme: "<?php echo Icarus_Assets::getCdnUrl('highlight.js', Icarus_Plugin_Highlight::VERSION, 'styles/' . Icarus_Config::get('highlight_theme', 'atom-one-light') . '.min.css'); ?>",
        highlightDarkTheme: "<?php echo Icarus_Assets::getCdnUrl('highlight.js', Icarus_Plugin_Highlight::VERSION, 'styles/' . Icarus_Config::get('highlight_theme_dark', 'atom-one-dark') . '.min.css'); ?>",
      };
    </script>
    <?php
    Icarus_Assets::printThemeJs('dark.js', TRUE, FALSE);
    ?>
    <script defer data-no-instant>
      InstantClick.on('change', function () {
        if (typeof window.initDarkMode === 'function') {
          window.initDarkMode();
        }
      });
    </script>
    <?php
  }
}