<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Plugin_Mathjax
{
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'Mathjax', Icarus_Plugin::DISABLE);
        $form->packInput('Mathjax/extensions', '', 'w-100');
        $form->packRadio('Mathjax/messages', array('0', '1'), '1');
        //$form->packRadio('Mathjax/menu', array('0', '1'), '1');
    }
    
    public static function footer()
    {
        Icarus_Config::tryGet('mathjax_extensions', $Extensions);
        $Extension = '"'.implode('","', explode(',', $Extensions)).'"';
?>
<script defer type="text/x-mathjax-config">
MathJax.Hub.Config({
<?php
    if(Icarus_Util::isEmpty($Extension) === false) {
?>
    TeX: {
        extensions: [<?php echo $Extension ?>]
    },
<?php
    }
    if(Icarus_Config::get('mathjax_messages', TRUE) === false) {
?>
    showProcessingMessages: false,
    messageStyle: "none"
<?php
    }
?>
});
</script>
<?php
        Icarus_Assets::cdn('js+defer', 'mathjax', '2.7.5', 'MathJax.js?config=TeX-MML-AM_CHTML');
        //Icarus_Assets::printThemeJs('mathjax.js', TRUE);
    }
}
