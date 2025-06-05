<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class WDCX_Module_Tag
{
    public static function config($form)
    {
        WDCX_Aside::basicConfig($form, 'Tag', WDCX_Aside::ENABLE, 'right', '2');

        $form->packInput('Tag/limit', '20', 'w-20');
    }

    private static function getLimit()
    {
        $limit = intval(WDCX_Config::get('tag_limit', 20));
        if ($limit < 0)
            $limit = 20;
        return $limit;
    }

    public static function output($showAll = FALSE)
    {
        $tags = Typecho_Widget::widget(
            'Widget_Metas_Tag_Cloud', 
            $showAll ? NULL : ('limit=' . self::getLimit())
        );
?>
<div class="card widget">
    <div class="card-content">
        <div class="menu">
        <?php if ($showAll): ?>            <h1 class="is-size-4 has-mb-6">
                标签
            </h1>
        <?php else: ?>
            <h3 class="menu-label">
                标签
            </h3>
        <?php endif; ?>
            <div class="field is-grouped is-grouped-multiline">
<?php while ($tags->next()): ?>
                <div class="control">
                    <a class="tags has-addons" href="<?php $tags->permalink(); ?>">
                        <span class="tag"><?php $tags->name(); ?></span>
                        <span class="tag is-grey"><?php $tags->count(); ?></span>
                    </a>
                </div>
<?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<?php
    }
}