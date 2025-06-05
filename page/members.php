<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('component/header.php');
?>

<div class="card">
    <div class="card-content">
        <div class="content">            <h1 class="title">成员</h1>
            <div class="has-text-grey">
                <p>这里是我们的团队成员...</p>
                <div class="columns is-multiline">
                    <div class="column is-one-third">
                        <div class="card">
                            <div class="card-content">
                                <div class="media">
                                    <div class="media-left">
                                        <figure class="image is-48x48">
                                            <img src="<?php echo $this->options->themeUrl('assets/img/avatar.png'); ?>" alt="成员头像">
                                        </figure>
                                    </div>
                                    <div class="media-content">
                                        <p class="title is-4">成员姓名</p>
                                        <p class="subtitle is-6">职位</p>
                                    </div>
                                </div>
                                <div class="content">
                                    成员介绍...
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
