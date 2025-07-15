<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Plugin_Tabs
{
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'Tabs', Icarus_Plugin::ENABLE);
    }
    
    public static function header()
    {
        Icarus_Assets::printThemeCSS('tabs.css', true);
    }

    public static function footer()
    {
?>
<script>
function switchTabs(tab){
	var lis = tab.getElementsByTagName('li');
	var divs = tab.getElementsByClassName('tab-div');
	for(var i=0; i<lis.length; i++){ 
		lis[i].index = i;
		lis[i].onclick = function (){
			for(var j=0; j<lis.length; j++) {
				lis[j].className = 'tab-li';
				divs[j].className = 'tab-div';
			}
			this.className = 'selected tab-li';
			divs[this.index].className = 'selected tab-div';
		}
	}
}
(function(){
	var tab = document.getElementsByClassName('my-tabs');
	for(var i=0;i<tab.length;i++){
		switchTabs(tab[i]);
	}
})();
</script>
<?php
    }
}
