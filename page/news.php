<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('component/header.php');
?>

<div class="card">
    <div class="card-content">
        <div class="content">            <h1 class="title">新闻</h1>
            <div class="has-text-grey">
                <p>这里是最新新闻...</p>
                
                <article class="media">
                    <div class="media-content">
                        <div class="content">
                            <p>
                                <strong>新闻标题</strong>
                                <br>
                                新闻内容摘要...
                                <br>
                                <small><time datetime="2025-06-05">2025年6月5日</time></small>
                            </p>
                        </div>
                    </div>
                </article>
                
            </div>
        </div>
    </div>
</div>

<?php $this->need('component/footer.php'); ?>
