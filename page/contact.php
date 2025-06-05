<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('component/header.php');
?>

<div class="card">
    <div class="card-content">
        <div class="content">            <h1 class="title">联系我们</h1>
            <div class="has-text-grey">
                <p>这里是联系我们的页面内容...</p>
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
                    <label class="label">消息</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="请输入您的消息"></textarea>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button is-primary">发送</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->need('component/footer.php'); ?>
