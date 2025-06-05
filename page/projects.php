<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('component/header.php');
?>

<div class="card">
    <div class="card-content">
        <div class="content">            <h1 class="title">项目</h1>
            <div class="has-text-grey">
                <p>这里是我们的项目展示...</p>
                
                <div class="columns is-multiline">
                    <div class="column is-half">
                        <div class="card">
                            <div class="card-image">
                                <figure class="image is-4by3">
                                    <img src="<?php echo $this->options->themeUrl('assets/img/thumbnail.svg'); ?>" alt="项目缩略图">
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="media">
                                    <div class="media-content">
                                        <p class="title is-4">项目名称</p>
                                        <p class="subtitle is-6">项目类型</p>
                                    </div>
                                </div>
                                <div class="content">
                                    项目描述...
                                    <br>
                                    <time datetime="2025-06-05">2025年6月5日</time>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php $this->need('component/footer.php'); ?>
