<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class WDCX_Module_Archive
{
    public static function config($form)
    {
        WDCX_Aside::basicConfig($form, 'Archive', WDCX_Aside::ENABLE, 'right', '1');
    }

    public static function output()
    {
?>
<div class="card widget">
    <div class="card-content">
        <div class="menu">
        <h3 class="menu-label">
            <?php _IcTp('general.archives'); ?>
        </h3>
        <ul class="menu-list">
<?php 
$tpl = <<<TPL
<li>
    <a class="level is-marginless" href="{permalink}">
        <span class="level-start">
            <span class="level-item">{date}</span>
        </span>
        <span class="level-end">
            <span class="level-item tag">{count}</span>
        </span>
    </a>
</li>
TPL;
Typecho_Widget::widget(
    'Widget_Contents_Post_Date', 
    array(        'type' => 'month',
        'format' => 'Y&\t\h\i\n\sp;年&\t\h\i\n\sp;n&\t\h\i\n\sp;月'
    ))->parse($tpl);
?>        
        </ul>
        </div>
    </div>
</div>
<?php
    }
}