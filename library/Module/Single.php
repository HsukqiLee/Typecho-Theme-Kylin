<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Module_Single
{
    private $_post;

    public function __construct($post)
    {
        $this->_post = $post;
    }

    private function getPrev()
    {
        $content = Typecho_Db::get()->fetchRow($this->_post->select()->where('table.contents.created < ?', $this->_post->created)
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.type = ?', $this->_post->type)
            ->where("table.contents.password IS NULL OR table.contents.password = ''")
            ->order('table.contents.created', Typecho_Db::SORT_DESC)
            ->limit(1));
        if ($content !== null) 
            return $this->_post->filter($content);
        else
            return NULL;
    }

    private function getNext()
    {
        $content = Typecho_Db::get()->fetchRow($this->_post->select()->where('table.contents.created > ? AND table.contents.created < ?',
            $this->_post->created, Icarus_Util::$options->time)
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.type = ?', $this->_post->type)
            ->where("table.contents.password IS NULL OR table.contents.password = ''")
            ->order('table.contents.created', Typecho_Db::SORT_ASC)
            ->limit(1));
        if ($content !== null) 
            return $this->_post->filter($content);
        else
            return NULL;
    }

    private function hasThumbnail()
    {
        return Icarus_Content::hasThumbnail($this->_post);
    }

    private function getThumbnail()
    {
        return Icarus_Content::getThumbnail($this->_post);
    }

    public static function output($post)
    {
        return (new Icarus_Module_Single($post))->doOutput();
    }

    private function printThumbnail($isContent)
    {
        if ($this->hasThumbnail()) {
?>
    <div class="card-image">
        <?php echo !$isContent ? ('<a href="' . htmlspecialchars($this->_post->permalink, ENT_QUOTES, 'UTF-8') . '"') : '<span '; ?> class="image is-7by1">
            <img class="thumbnail lazyload" src="<?php echo Icarus_Assets::getUrlForAssets('/img/default.png'); ?>" data-original="<?php echo htmlspecialchars($this->getThumbnail(), ENT_QUOTES, 'UTF-8'); ?>" alt="<?php $this->_post->title(); ?>">>
        <?php echo !$isContent ? '</a>' : '</span>' ?>
    </div>
<?php 
        }
    }

    private function printCategory()
    {
        if ($this->_post->categories) {
?>
    <div class="level-item">
        <?php 
        $category = $this->_post->categories[0];
        $directory = Typecho_Widget::widget('Widget_Metas_Category_List')->getAllParents($category['mid']);
        $directory[] = $category;

        if (Icarus_Util::isEmpty($directory) === false) {
            $result = array();

            foreach ($directory as $category) {
                $result[] = '<a class="has-link-grey" href="' . htmlspecialchars($category['permalink'], ENT_QUOTES, 'UTF-8') . '">'
                . htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') . '</a>';
            }

            echo implode('&nbsp;/&nbsp;', $result);
        }
        ?>
    </div>
        <?php 
        }
    }

    private function printTags()
    {
        if (!$this->_post->tags)
            return;
?>
        <div class="level is-size-7">
            <div class="level-start">
                <div class="level-item">
                    <span class="is-size-6 has-text-grey has-mr-7">#</span>
                    <span><?php $result = array();
                    foreach ($this->_post->tags as $tag) {
                        $result[] ='<a class="has-link-grey" href="' . htmlspecialchars($tag['permalink'], ENT_QUOTES, 'UTF-8') . '">'
                        . htmlspecialchars($tag['name'], ENT_QUOTES, 'UTF-8') . '</a>';
                    }
                    echo implode('&nbsp;&nbsp;', $result);
                    ?>
                    </span>
                </div>
            </div>
        </div>
<?php
    }

    private function printReadMore()
    {
?>
        <div class="level is-mobile">
            <div class="level-start">
                <div class="level-item">
                <a class="button is-size-7 is-light" href="<?php $this->_post->permalink(); ?>"><?php _IcTp('article.more'); ?></a>
                </div>
            </div>
        </div>
<?php
    }

    public function doOutput()
    {
        $isContent = $this->_post->is('single');
        $isPage = $this->_post->is('page');
        $isPost = $this->_post->is('post');
        
        if (!$isContent)
        {
            $this->doOutputList();
        }
        else if ($isPage)
        {
            $this->doOutputPage();
        }
        else
        {
            $this->doOutputPost();
        }
    }

    public function doOutputList()
    {
        $isContent = $this->_post->is('single');
        $isPage = $this->_post->is('page');
        $isPost = $this->_post->is('post');
?>
<div class="card">
    <?php $this->printThumbnail(FALSE); ?>
    <?php if (!!Icarus_Config::get('post_tiny_item', FALSE)): ?>
    <div class="card-content article article-item article-item-tiny">
        <h1 class="title is-size-3 is-size-4-mobile has-text-weight-normal">
            <a class="has-link-black-ter" href="<?php $this->_post->permalink(); ?>"><?php $this->_post->title(); ?></a>
        </h1>
        <div class="level article-meta is-size-7 is-uppercase is-mobile is-overflow-x-auto">
            <div class="level-left">
                <time class="level-item has-text-grey" datetime="<?php $this->_post->date('c'); ?>"><?php $this->_post->date(); ?></time>
                <?php $this->printCategory(); ?>
            </div>
            <?php $this->printReadMore(); ?>
        </div>
    </div>
    <?php else: ?>
    <div class="card-content article article-item">
        <div class="level article-meta is-size-7 is-uppercase is-mobile is-overflow-x-auto">
            <div class="level-left">
                <time class="level-item has-text-grey" datetime="<?php $this->_post->date('c'); ?>"><?php $this->_post->date(); ?></time>
                <?php $this->printCategory(); ?>
            </div>
        </div>
        <h1 class="title is-size-3 is-size-4-mobile has-text-weight-normal">
            <a class="has-link-black-ter" href="<?php $this->_post->permalink(); ?>"><?php $this->_post->title(); ?></a>
        </h1>
        <div class="content">
            <?php echo Icarus_Content::getExcerpt($this->_post); ?>
        </div>
        <?php $this->printReadMore(); ?>
    </div>
    <?php endif; ?>
</div>
<?php  
    }

    public function doOutputPage()
    {
?>
<div class="card" data-no-instant>
    <?php $this->printThumbnail(TRUE); ?>
    <div class="card-content article article-single">
        <h1 class="title is-size-3 is-size-4-mobile has-text-weight-normal">
            <?php $this->_post->title(); ?>
        </h1>
        <div class="content">
<?php 
global $_SERVER;
if (isset($_SERVER['HTTP_CF_IPCOUNTRY']) && in_array($_SERVER['HTTP_CF_IPCOUNTRY'], explode(',', $this->_post->fields->blocked_countries))) {
    $ray=explode('-', $_SERVER['HTTP_CF_RAY']?$_SERVER['HTTP_CF_RAY']:'UNKNOWM-UNKNOWN');
?>
<style>
.blocked-box {
    margin: 30px 0 30px 0;
    padding: 36px 0 48px 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: #fff;
    border-radius: 6px;
    box-shadow: 0 .5em 1em -0.125em rgba(10,10,10,.1),0 0px 0 1px rgba(10,10,10,.02);
    color: #4a4a4a;
}
.blocked-text {
    padding: 10px 10px 15px 10px;
}
.blocked-button {
    margin: 10px 10px 15px 10px;
}
</style>
<div class="blocked-box">
    <figure class="image is-128x128">
        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><polygon style="fill:#FFCCC3;" points="481.157,466.763 512,466.763 512,137.767 460.594,76.08 "></polygon><polygon style="fill:#FFE6E1;" points="0,137.767 0,466.763 480.129,466.763 480.129,76.08 "></polygon><polygon style="fill:#F85B3F;" points="481.157,45.237 460.594,91.502 481.157,137.767 512,137.767 512,45.237 "></polygon><polygon style="fill:#FF7F67;" points="419.47,45.237 398.908,91.502 419.47,137.767 481.157,137.767 481.157,45.237 "></polygon><rect x="1.028" y="45.237" style="fill:#B6B8B5;" width="418.442" height="92.53"></rect><rect x="31.871" y="76.08" style="fill:#FFFFFF;" width="356.755" height="30.843"></rect><path style="fill:#F85B3F;" d="M256.514,193.285l-20.562,108.98l20.562,108.98c60.091,0,108.98-48.889,108.98-108.98 C365.494,242.173,316.605,193.285,256.514,193.285z"></path><path style="fill:#FF7F67;" d="M147.534,302.265c0,60.091,48.888,108.98,108.98,108.98v-217.96 C196.423,193.285,147.534,242.173,147.534,302.265z"></path><g><path style="fill:#FFE6E1;" d="M299.749,237.22c-12.391-8.263-27.257-13.092-43.235-13.092c-43.084,0-78.137,35.052-78.137,78.137 c0,15.978,4.829,30.844,13.092,43.235L299.749,237.22z"></path><path style="fill:#FFE6E1;" d="M213.279,367.31c12.391,8.263,27.257,13.092,43.235,13.092c43.084,0,78.137-35.052,78.137-78.137 c0-15.978-4.829-30.844-13.092-43.235L213.279,367.31z"></path></g></svg>
    </figure>
    <h2 class="title has-text-weight-bold blocked-text"><?php _IcTp('fields.blocked_countries.text.title'); ?></h2>
    <p class="subtitle blocked-text"><?php _IcTp('fields.blocked_countries.text.subtitle'); ?></p>
    <p class="menu-label">
        <?php echo _IcT('fields.blocked_countries.text.ip').htmlspecialchars($_SERVER['HTTP_X_FORWARDED_FOR'], ENT_QUOTES, 'UTF-8'); ?><br>
        <?php echo _IcT('fields.blocked_countries.text.ray').htmlspecialchars($ray[0], ENT_QUOTES, 'UTF-8'); ?><br>
        <?php echo _IcT('fields.blocked_countries.text.loc').htmlspecialchars($_SERVER['HTTP_CF_IPCOUNTRY'], ENT_QUOTES, 'UTF-8'); ?><br>
        <?php echo _IcT('fields.blocked_countries.text.colo').htmlspecialchars($ray[1], ENT_QUOTES, 'UTF-8'); ?>
    </p>
    <div class="buttons">
        <button class="button is-light blocked-button" onclick="window.history.back()"><?php _IcTp('fields.blocked_countries.text.back'); ?></button>
        <button class="button is-link blocked-button" onclick="window.location.reload()"><?php _IcTp('fields.blocked_countries.text.reload'); ?></button>
    </div>
</div>
<?php  
}
else {
    echo Icarus_Content::getContent($this->_post);
}

?>
        </div>
        <?php $this->printTags(); ?>
    </div>
</div>
<?php  
        Icarus_Module::show('Comments', $this->_post);
    }
    public function doOutputPost()
    {
?>
<div class="card">
    <?php $this->printThumbnail(TRUE); ?>
    <div class="card-content article article-single">
        <div class="level article-meta is-size-7 is-uppercase is-mobile is-overflow-x-auto">
            <div class="level-left">
                <time class="level-item has-text-grey" datetime="<?php $this->_post->date('c'); ?>"><?php $this->_post->date(); ?></time>
                <?php $this->printCategory(); ?>
            </div>
        </div>
        <h1 class="title is-size-3 is-size-4-mobile has-text-weight-normal">
            <?php $this->_post->title(); ?>
        </h1>
        <div class="content">
        <?php
            if(strpos($this->_post->fields->language,'简体中文')!==FALSE) {
                $translate=explode(',',str_replace('.com/archives','.com/tw/archives',$this->_post->fields->translate).','.$this->_post->fields->translate);
                $language=explode(',','正體中文,'.$this->_post->fields->language);
            }
            else {
                $translate=explode(',',str_replace(['.com/archives','.com/en/archives'],['.com/tw/archives','.com/tw/archives'],$this->_post->permalink).','.$this->_post->fields->translate);
                $language=explode(',','正體中文,'.$this->_post->fields->language);
            }
            if (Icarus_Util::isEmpty($this->_post->fields->translate) === false && Icarus_Util::isEmpty($this->_post->fields->language) === false)
            {
        ?>
            <article class="message message-immersive is-primary" data-no-instant>
                <div class="message-body">
                    <i class="fas fa-globe-asia mr-2"></i>
                    <?php
                        _IcTp('fields.language.prefix');
                        for($i=0;$i<count($translate);$i++)
                        {
                    ?>
                    <a href="<?php echo htmlspecialchars($translate[$i], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($language[$i], ENT_QUOTES, 'UTF-8'); ?></a>
                    &nbsp;
                    <?php
                        }
                    ?>
                </div>
            </article>
        <?php
            
            }
            global $_SERVER;
            if (isset($_SERVER['HTTP_CF_IPCOUNTRY']) && in_array($_SERVER['HTTP_CF_IPCOUNTRY'], explode(',', $this->_post->fields->blocked_countries))) {
                $ray=explode('-', $_SERVER['HTTP_CF_RAY']?$_SERVER['HTTP_CF_RAY']:'UNKNOWM-UNKNOWN');
?>
<style>
.blocked-box {
    margin: 30px 0 30px 0;
    padding: 36px 0 48px 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: #fff;
    border-radius: 6px;
    box-shadow: 0 .5em 1em -0.125em rgba(10,10,10,.1),0 0px 0 1px rgba(10,10,10,.02);
    color: #4a4a4a;
}
.blocked-text {
    padding: 10px 10px 15px 10px;
}
.blocked-button {
    margin: 10px 10px 15px 10px;
}
</style>
<div class="blocked-box">
    <figure class="image is-128x128">
        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><polygon style="fill:#FFCCC3;" points="481.157,466.763 512,466.763 512,137.767 460.594,76.08 "></polygon><polygon style="fill:#FFE6E1;" points="0,137.767 0,466.763 480.129,466.763 480.129,76.08 "></polygon><polygon style="fill:#F85B3F;" points="481.157,45.237 460.594,91.502 481.157,137.767 512,137.767 512,45.237 "></polygon><polygon style="fill:#FF7F67;" points="419.47,45.237 398.908,91.502 419.47,137.767 481.157,137.767 481.157,45.237 "></polygon><rect x="1.028" y="45.237" style="fill:#B6B8B5;" width="418.442" height="92.53"></rect><rect x="31.871" y="76.08" style="fill:#FFFFFF;" width="356.755" height="30.843"></rect><path style="fill:#F85B3F;" d="M256.514,193.285l-20.562,108.98l20.562,108.98c60.091,0,108.98-48.889,108.98-108.98 C365.494,242.173,316.605,193.285,256.514,193.285z"></path><path style="fill:#FF7F67;" d="M147.534,302.265c0,60.091,48.888,108.98,108.98,108.98v-217.96 C196.423,193.285,147.534,242.173,147.534,302.265z"></path><g><path style="fill:#FFE6E1;" d="M299.749,237.22c-12.391-8.263-27.257-13.092-43.235-13.092c-43.084,0-78.137,35.052-78.137,78.137 c0,15.978,4.829,30.844,13.092,43.235L299.749,237.22z"></path><path style="fill:#FFE6E1;" d="M213.279,367.31c12.391,8.263,27.257,13.092,43.235,13.092c43.084,0,78.137-35.052,78.137-78.137 c0-15.978-4.829-30.844-13.092-43.235L213.279,367.31z"></path></g></svg>
    </figure>
    <h2 class="title has-text-weight-bold blocked-text"><?php _IcTp('fields.blocked_countries.text.title'); ?></h2>
    <p class="subtitle blocked-text"><?php _IcTp('fields.blocked_countries.text.subtitle'); ?></p>
    <p class="menu-label">
        <?php echo _IcT('fields.blocked_countries.text.ip').htmlspecialchars($_SERVER['HTTP_X_FORWARDED_FOR'], ENT_QUOTES, 'UTF-8'); ?><br>
        <?php echo _IcT('fields.blocked_countries.text.ray').htmlspecialchars($ray[0], ENT_QUOTES, 'UTF-8'); ?><br>
        <?php echo _IcT('fields.blocked_countries.text.loc').htmlspecialchars($_SERVER['HTTP_CF_IPCOUNTRY'], ENT_QUOTES, 'UTF-8'); ?><br>
        <?php echo _IcT('fields.blocked_countries.text.colo').htmlspecialchars($ray[1], ENT_QUOTES, 'UTF-8'); ?>
    </p>
    <div class="buttons">
        <button class="button is-light blocked-button" onclick="window.history.back()"><?php _IcTp('fields.blocked_countries.text.back'); ?></button>
        <button class="button is-link blocked-button" onclick="window.location.reload()"><?php _IcTp('fields.blocked_countries.text.reload'); ?></button>
    </div>
</div>
<?php  
            }
            else {
                echo Icarus_Content::getContent($this->_post);
            }

            if(!!Icarus_Config::get('post_license', FALSE)) :
        ?>
            <div class="article-licensing box">
                <div class="licensing-title"><p><?php $this->_post->title(); ?></p><p><a href="<?php $this->_post->permalink(); ?>"><?php $this->_post->permalink(); ?></a></p></div>
                <div class="licensing-meta level is-mobile">
                    <div class="level-left">
                        <div class="level-item is-narrow">
                            <div>
                                <h6><?php _IcTp('setting.post.license.author'); ?></h6>
                                <a href="<?php $this->_post->author->url(); ?>"><?php $this->_post->author(); ?></a>
                            </div>
                        </div>
                        <div class="level-item is-narrow">
                            <div>
                                <h6><?php _IcTp('setting.post.license.date'); ?></h6>
                                <p><?php $this->_post->date(); ?></p>
                            </div>
                        </div>
                        <div class="level-item is-narrow">
                            <div>
                                <h6><?php _IcTp('setting.post.license.modified'); ?></h6>
                                <p><?php echo date('Y-m-d', $this->_post->modified); ?></p>
                            </div>
                        </div>
                        <div class="level-item is-narrow">
                            <div>
                                <h6><?php _IcTp('setting.post.license.under'); ?></h6>
                                <p><?php echo Icarus_Config::get('post_license_extend', ''); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php
            $this->printTags();    
        ?>
    </div>
</div>
<?php  
if (!in_array($_SERVER['HTTP_CF_IPCOUNTRY'], explode(',', $this->_post->fields->blocked_countries))) Icarus_Module::show('Donate');

if ($this->_post->is('post')):
    $prevPost = $this->getPrev();
    $nextPost = $this->getNext();
    if ($prevPost || $nextPost): 
?>
<div class="card">
    <div class="card-content">
    <div class="level post-navigation is-flex-wrap is-mobile">
        <div class="level-start">
        <?php if ($prevPost !== null): ?>
            <a class="level level-item has-link-grey article-nav-prev" href="<?php echo htmlspecialchars($prevPost['permalink'], ENT_QUOTES, 'UTF-8'); ?>">
                <i class="level-item fas fa-chevron-left"></i>
                <span class="level-item"><?php echo htmlspecialchars($prevPost['title'], ENT_QUOTES, 'UTF-8'); ?></span>
            </a>
        <?php endif;?> 
        </div>
        <div class="level-end">
        <?php if ($nextPost !== null): ?>
            <a class="level level-item has-link-grey article-nav-next" href="<?php echo htmlspecialchars($nextPost['permalink'], ENT_QUOTES, 'UTF-8'); ?>">
                <span class="level-item"><?php echo htmlspecialchars($nextPost['title'], ENT_QUOTES, 'UTF-8'); ?></span>
                <i class="level-item fas fa-chevron-right"></i>
            </a>
        <?php endif; ?>
        </div>
    </div></div>
</div>
<?php
    endif;
endif; 
if (!in_array($_SERVER['HTTP_CF_IPCOUNTRY'], explode(',', $this->_post->fields->blocked_countries)))Icarus_Module::show('Comments', $this->_post);
    }
}