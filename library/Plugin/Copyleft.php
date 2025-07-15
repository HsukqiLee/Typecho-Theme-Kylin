<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Plugin_Copyleft
{
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'Copyleft', Icarus_Plugin::ENABLE);
        $form->packInput('Copyleft/text', 'CC BY', 'w-40');
    }
    
    public static function footer()
    {
?>
<div id="copyleft" style="display:none;z-index:999;"><span><?php echo Icarus_Config::get('copyleft_text'); ?></span></div>
<script>
	var licenses = document.getElementById('copyleft');
	document.oncontextmenu = function(ev) {
		var ev = ev || event;
		var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
		licenses.style.display = 'block';
		licenses.style.left = ev.clientX + 15 + 'px';
		licenses.style.top = ev.clientY + scrollTop + 'px';
		return false;
	};
	document.onclick = function() {
		licenses.style.display = 'none';
	}
</script>
<?php
    }
}