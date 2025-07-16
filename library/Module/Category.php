<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Module_Category
{
    public static function config($form)
    {
        Icarus_Aside::basicConfig($form, 'Category', Icarus_Aside::ENABLE, 'left', '3');
    }

    public static function output($showAll = FALSE)
    {
?>
<div class="card widget">
    <div class="card-content">
        <div class="menu">
        <?php if ($showAll === true): ?>
            <h1 class="is-size-4 has-mb-6">
                <?php _IcTp('general.categories'); ?>
            </h1>
        <?php else: ?>
            <h3 class="menu-label">
                <?php _IcTp('general.categories'); ?>
            </h3>
        <?php endif; ?>
<?php 
Typecho_Widget::widget('Widget_Metas_Category_List')->listCategories('wrapTag=ul&wrapClass=menu-list');
?>        
        </div>
    </div>
</div>
<?php
    }
}

function treeViewCategories($widget, $categoryOptions)
{
?>
<li>
    <a class="level is-marginless" href="<?php echo htmlspecialchars($widget->permalink, ENT_QUOTES, 'UTF-8'); ?>">
        <span class="level-start">
            <span class="level-item"><?php echo htmlspecialchars($widget->name, ENT_QUOTES, 'UTF-8'); ?></span>
        </span>
        <span class="level-end">
            <span class="level-item tag"><?php echo intval($widget->count); ?></span>
        </span>
    </a>
<?php
if ($widget->children) {
    $widget->treeViewCategories();
}
?>
</li>
<?php
}