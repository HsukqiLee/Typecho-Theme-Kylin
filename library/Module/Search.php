<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Module_Search
{
    public static function config($form)
    {
        $form->packTitle('Search');

        $form->packRadio('Search/enable', array('0', '1'), '1');
        $form->packRadio('Search/type', array('internal', 'exsearch'), 'internal');
    }

    public static function output()
    {
        switch (Icarus_Config::get('search_type', 'internal'))
        {
            case 'internal':
            default:
                self::outputInternal();
                break;
        }
    }


    private static function outputInternal()
    {
        $post_num=0;$tag_num=0;
?>

<div class="searchbox">
    <div class="searchbox-container">
        <div class="searchbox-header">
        <div class="searchbox-input-container">
        <form class="form" action="<?php echo Icarus_Util::$options->siteUrl; ?>index.php/" role="search" method="get">
        <input type="text" class="searchbox-input form-control" name="s" placeholder="<?php _IcTp('search.placeholder'); ?>">
        </form>
        </div>
        <a class="searchbox-close" href="javascript:;">×</a>
        </div>
        
        <div class="searchbox-body">
            <section class="searchbox-result-section">
                <header>Pages</header>
                <?php
                $max_num=5;
                $obj = Typecho_Widget::widget('Widget_Contents_Page_List','');
	            if($obj->have())
	            {
	            	while($obj->next()&&$post_num<$max_num)
	            	{
	            	    if(rand(0,3))
	            	    {
	            	        $post_num++;
	            	?>
	            	    <a class="searchbox-result-item" href="<?php $obj->permalink(); ?>">
                            <span class="searchbox-result-icon">
                                <i class="fa fa-file"></i>
                            </span>
                            <span class="searchbox-result-content">
                                <span class="searchbox-result-title">
                                    <?php $obj->title(); ?>
                                </span>
                                <span class="searchbox-result-preview">
                                    <?php $obj->excerpt(35,'...'); ?>
                                </span>
                                
                            </span>
                        </a>
                    <?php
	            	    }
	            	}
	            	
	            }
		        ?>
		    </section>
		    <section class="searchbox-result-section">
		        <header>Tags</header>
		        <?php
		        $obj= Typecho_Widget::widget('Widget_Metas_Tag_Cloud', '');
		        if($obj->have())
		        {
		            while(($obj->next())&&$tag_num<$max_num)
		            {
		                $tag_num++;
		                ?>
		                <a class="searchbox-result-item" href="<?php $obj->permalink(); ?>">
                            <span class="searchbox-result-icon">
                                <i class="fa fa-tag"></i>
                            </span>
                            <span class="searchbox-result-content">
                                <span class="searchbox-result-title">
                                    <?php $obj->name(); ?>
                                </span>
                                <span class="searchbox-result-preview">
                                    <?php $obj->count();_IcTp('search.tags'); ?>
                                </span>
                            </span>
                        </a>
		                <?php
		            }
		        }
		        ?>
            </section>
        </div>
        
    </div>
</div>
<?php
    }
}