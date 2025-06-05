<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('component/header.php');
?>

<div class="card">
    <div class="card-content">
        <div class="content">            <h1 class="title">加入我们</h1>
            <div class="has-text-grey">
                <p>欢迎加入我们的团队！</p>
                <div class="field">
                    <label class="label">姓名</label>
                    <div class="control">
                        <input class="input" type="text" placeholder="请输入您的姓名">
                    </div>
                </div>
                <div class="field">
                    <label class="label">邮箱</label>
                    <div class="control">
                        <input class="input" type="email" placeholder="请输入您的邮箱">
                    </div>
                </div>
                <div class="field">
                    <label class="label">申请理由</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="请告诉我们您为什么想加入我们"></textarea>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button is-primary">提交申请</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->need('component/footer.php'); ?>
