<?php
if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Module_Comments
{
    public static function config($form)
    {
        $form->packTitle('Comments');

        $form->packRadio('Comments/type', array('internal', 'custom'), 'internal');
        $form->packInput('Comments/default_avatar', 'identicon');
        
        $form->packTextarea('Comments/custom_content', '');

    }

    public static function header()
    {
        if (Icarus_Config::get('comments_type') == 'internal')
            Icarus_Assets::printThemeCSS('comment.css', true);
    }
    
    public static function footer()
    {
        if (Icarus_Config::get('comments_type') == 'internal'):
?>
<script defer>  
(function () {
    responseId = document.getElementsByClassName("respond")[0]?.id;
    window.TypechoComment = responseId ? {
        dom : function (id) {
            return document.getElementById(id);
        },
        create : function (tag, attr) {
            var el = document.createElement(tag);
            for (var key in attr) {
                el.setAttribute(key, attr[key]);
            }
            return el;
        },
        reply : function (cid, coid) {
            var comment = this.dom(cid), parent = comment.parentNode,
                response = this.dom(responseId),
                input = this.dom('comment-parent'),
                form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                textarea = response.getElementsByTagName('textarea')[0];
            if (null == input) {
                input = this.create('input', {
                    'type' : 'hidden',
                    'name' : 'parent',
                    'id'   : 'comment-parent'
                });
                form.appendChild(input);
            }
            input.setAttribute('value', coid);
            this.dom('cancel-comment-reply-link').style.display = '';
            if (null != textarea && 'text' == textarea.name) {
                textarea.focus();
            }
            return false;
        },
        cancelReply : function () {
            var response = this.dom(responseId),
            input = this.dom('comment-parent');
            if (null != input) {
                input.parentNode.removeChild(input);
            }
            this.dom('cancel-comment-reply-link').style.display = 'none';
            return false;
        }
    } : undefined;
})();
</script>
<?php
        endif;
    }
    
    public static function output($widget)
    {
        if (Icarus_Config::get('comments_type') == 'internal')
            self::outputInternal($widget);
        else
            self::outputCustom($widget);
    }

    public static function printCommentAuthor($comment, $autoLink = NULL, $noFollow = NULL)
    {
        $autoLink = (NULL === $autoLink) ? Icarus_Util::$options->commentsShowUrl : $autoLink;
        $noFollow = (NULL === $noFollow) ? Icarus_Util::$options->commentsUrlNofollow : $noFollow;

        if ($comment->url && $autoLink) {
            echo '<a href="' , htmlspecialchars($comment->url, ENT_QUOTES, 'UTF-8') , '"' , ($noFollow ? ' rel="external nofollow noopener"' : ' rel="noopener"') , ' target="_blank">' , htmlspecialchars($comment->author, ENT_QUOTES, 'UTF-8') , '</a>';
        } else {
            echo htmlspecialchars($comment->author, ENT_QUOTES, 'UTF-8');
        }
    }

    private static function outputInternal($widget)
    {
        $widget->comments()->to($comments);
        $options = Icarus_Util::$options;
        $user = Typecho_Widget::widget('Widget_User');
        $mail = empty($user->mail)?$widget->remember('mail',true):$user->mail;
        //$security = Typecho_Widget::widget('Widget_Security');
        
        if ($comments->have() || $widget->allow('comment')):
?>
<div class="card">
    <div class="card-content comment-container">
        <div class="field is-grouped">
            <div class="control">
                <h3 class="title is-5 has-text-weight-normal"><?php _IcTp('general.comments'); ?></h3>
            </div>
        </div>

        <?php if ($widget->allow('comment')): ?>
        <div id="<?php $widget->respondId(); ?>" class="respond">
            <form method="post" action="<?php $widget->commentUrl(); ?>" id="comment-form">
                <div class="tk-submit">
                    <div class="tk-row">
                        <div class="tk-avatar">
                            <div class="tk-avatar-img"><img title="Comment avatar" src="<?php echo htmlspecialchars(Icarus_Assets::getUrlForAssets('/img/default.png'), ENT_QUOTES, 'UTF-8'); ?>"<?php if(!empty($mail)) echo ' class="lazyload" data-original="'.htmlspecialchars(Icarus_Util::getAvatar($mail, 128), ENT_QUOTES, 'UTF-8').'"'; ?>><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm0 96c48.6 0 88 39.4 88 88s-39.4 88-88 88-88-39.4-88-88 39.4-88 88-88zm0 344c-58.7 0-111.3-26.6-146.5-68.2 18.8-35.4 55.6-59.8 98.5-59.8 2.4 0 4.8.4 7.1 1.1 13 4.2 26.6 6.9 40.9 6.9 14.3 0 28-2.7 40.9-6.9 2.3-.7 4.7-1.1 7.1-1.1 42.9 0 79.7 24.4 98.5 59.8C359.3 421.4 306.7 448 248 448z"></path></svg></div>
                        </div>
                        <div class="tk-col">
                            <div class="tk-meta-input">
                                <div class="el-input el-input--small el-input-group el-input-group--prepend"><div class="el-input-group__prepend"><?php _IcTp('comments.input.name'); ?></div><input <?php echo ($user->hasLogin())?'disabled="disabled" ':''; ?>type="text" name="author" placeholder="<?php _IcTp('comments.input.required'); ?>" value="<?php ($user->hasLogin())?$user->screenName():$widget->remember('author'); ?>" class="el-input__inner" title="<?php _IcTp('comments.guide.name'); ?>"></div>
                                <?php if(!$user->hasLogin()): ?>
                                <div  class="el-input el-input--small el-input-group el-input-group--prepend"><div class="el-input-group__prepend"><?php _IcTp('comments.input.email'); ?></div><input avatar-url-tpl="<?php echo Icarus_Assets::getGravatarUrl().'/{md5}?size={size}&d='.urlencode(Icarus_Config::get('comments_default_avatar')); ?>" id="email" type="email" name="mail" placeholder="<?php _IcTp($options->commentsRequireMail?'comments.input.required':'comments.input.optional'); ?>" value="<?php $widget->remember('mail'); ?>" class="el-input__inner" title="<?php _IcTp('comments.guide.email'.($options->commentsRequireMail?'_required':'')); ?>"></div>
                                <div  class="el-input el-input--small el-input-group el-input-group--prepend"><div class="el-input-group__prepend"><?php _IcTp('comments.input.url'); ?></div><input type="url" name="url" placeholder="<?php _IcTp($options->commentsRequireURL?'comments.input.required':'comments.input.optional'); ?>" value="<?php $widget->remember('url'); ?>" class="el-input__inner" title="<?php _IcTp('comments.guide.url'.($options->commentsRequireMail?'_required':'')); ?>"></div>
                                <?php endif; ?>
                                
                            </div>
                            <div class="tk-input el-textarea">
                                <textarea placeholder="<?php _IcTp('comments.input.text'); ?>" maxlength="200" class="el-textarea__inner" name="text" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tk-row actions">
                        <div class="tk-row-actions-start">
                        <a title="Markdown is supported" alt="Markdown is supported" href="https://guides.github.com/features/mastering-markdown/" target="_blank" rel="noopener noreferrer" class="tk-action-icon __markdown"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M593.8 59.1H46.2C20.7 59.1 0 79.8 0 105.2v301.5c0 25.5 20.7 46.2 46.2 46.2h547.7c25.5 0 46.2-20.7 46.1-46.1V105.2c0-25.4-20.7-46.1-46.2-46.1zM338.5 360.6H277v-120l-61.5 76.9-61.5-76.9v120H92.3V151.4h61.5l61.5 76.9 61.5-76.9h61.5v209.2zm135.3 3.1L381.5 256H443V151.4h61.5V256H566z"></path></svg></a>
                        </div>
                        <?php if($user->hasLogin()): ?>
                        <button type="button" onclick="window.location.href='<?php echo htmlspecialchars($options->logoutUrl(), ENT_QUOTES, 'UTF-8'); ?>'" class="el-button tk-preview el-button--default el-button--small"><span><?php _IcTp('general.logout'); ?></span></button>
                        <button type="button" onclick="window.location.href='<?php echo htmlspecialchars($options->adminUrl(), ENT_QUOTES, 'UTF-8'); ?>'" class="el-button tk-preview el-button--default el-button--small"><span><?php _IcTp('general.usercenter'); ?></span></button>
                        <?php elseif ($options->allowRegister): ?>
                        <button type="button" onclick="window.location.href='<?php $options->registerUrl(); ?>'" class="el-button tk-preview el-button--default el-button--small"><span><?php _IcTp('general.register'); ?></span></button>
                        <button type="button" onclick="window.location.href='<?php $options->loginUrl(); ?>'" class="el-button tk-preview el-button--default el-button--small"><span><?php _IcTp('general.login'); ?></span></button>
                        <?php endif; ?>
                        <button type="button" onclick="return TypechoComment.cancelReply();" id="cancel-comment-reply-link" style="display:none;" class="el-button tk-preview el-button--default el-button--small"><span><?php _IcTp('general.cancel'); ?></span></button>
                        <button type="submit" class="el-button tk-send el-button--primary el-button--small"><span><?php _IcTp('comments.do_comment'); ?></span></button>

                    </div>
                    <div class="captcha-container">
                    <?php
                    if (!$user->hasLogin()) {
                        if(array_key_exists('CaptchaPlus', Typecho_Plugin::export()['activated'])) CaptchaPlus_Plugin::output();
                        elseif(array_key_exists('GrCv3Protect', Typecho_Plugin::export()['activated'])) GrCv3Protect_Plugin::OutputCode();
                        elseif(array_key_exists('reCAPTCHA', Typecho_Plugin::export()['activated'])) reCAPTCHA_Plugin::output();
                        elseif(array_key_exists('reCAPTCHAv3', Typecho_Plugin::export()['activated'])) reCAPTCHAv3_Plugin::output();
                        elseif(array_key_exists('SimpleCommentCaptcha', Typecho_Plugin::export()['activated'])) SimpleCommentCaptcha_Plugin::outputSimpleCommentCaptchaField();
                    }
                    ?>
                    </div>
                </div>
            </form>
        </div>
        <div class="tk-comments-title">
            <span class="tk-comments-count"><span><?php $widget->commentsNum(_IcT('comments.num.0'), _IcT('comments.num.1'), _IcT('comments.num.more')); ?></span></span> <span><a href="javascript:location.reload();" title="Reload"><span class="tk-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M440.65 12.57l4 82.77A247.16 247.16 0 0 0 255.83 8C134.73 8 33.91 94.92 12.29 209.82A12 12 0 0 0 24.09 224h49.05a12 12 0 0 0 11.67-9.26 175.91 175.91 0 0 1 317-56.94l-101.46-4.86a12 12 0 0 0-12.57 12v47.41a12 12 0 0 0 12 12H500a12 12 0 0 0 12-12V12a12 12 0 0 0-12-12h-47.37a12 12 0 0 0-11.98 12.57zM255.83 432a175.61 175.61 0 0 1-146-77.8l101.8 4.87a12 12 0 0 0 12.57-12v-47.4a12 12 0 0 0-12-12H12a12 12 0 0 0-12 12V500a12 12 0 0 0 12 12h47.35a12 12 0 0 0 12-12.6l-4.15-82.57A247.17 247.17 0 0 0 255.83 504c121.11 0 221.93-86.92 243.55-201.82a12 12 0 0 0-11.8-14.18h-49.05a12 12 0 0 0-11.67 9.26A175.86 175.86 0 0 1 255.83 432z"></path></svg></span></a></span></div>
        <div class="comment-list" data-no-instant>
        <?php $comments->listComments(array('before' => '', 'after' => '')); ?>
        </div>
        
        <?php Icarus_Module::show('Paginator', $comments); ?>
        
        <?php else: ?>
        <div class="respond">
            <h3 class="title is-5 has-text-weight-normal"><?php _IcTp('comments.disabled'); ?></h3>
        </div>
        <?php endif; ?>
        
    </div>
</div>
    

<?php
        endif;
    }

    private static function outputCustom($widget)
    {
        $identifier = $widget->getArchiveType() . '-' . $widget->getArchiveSlug();
?>
<div class="card">
    <div class="card-content comment-container">
        <?php echo str_replace('{identifier}', $identifier, Icarus_Config::get('comments_custom_content', '')); ?>
    </div>
</div>
<?php
    }
}

function threadedComments($comments, $options)
{
?>
<div class="media comment">
    <figure class="media-left">
        <p class="image is-48x48">
        <img data-no-instant class="lazyload image is-rounded" alt="<?php echo $comments->author; ?>" src="<?php echo Icarus_Assets::getUrlForAssets('/img/default.png'); ?>" data-original="
        <?php
            echo Icarus_Util::getAvatar($comments->mail, 128); 
        ?>">
        </p>
    </figure>
    <div class="media-content" id="<?php $comments->theId(); ?>">
        <div class="content">
            <div class="comment-header">
                <span class="comment-author"><?php Icarus_Module_Comments::printCommentAuthor($comments); ?></span>
                <?php if ($comments->authorId && $comments->authorId == $comments->ownerId): ?>
                <span class="tag is-info"><?php _IcTp('comments.is_author'); ?></span>
                <?php endif; ?>
                <?php if ('waiting' == $comments->status): ?>
                <span class="tag is-warning"><?php _IcTp('comments.is_waiting'); ?></span>
                <?php endif; ?>
            </div>
            <div class="comment-content"><?php $comments->content(); ?></div>
            <div class="comment-meta"><time itemprop="commentTime" datetime="<?php $comments->date('c'); ?>"><?php $comments->date(Icarus_Util::$options->commentDateFormat);?></time>&nbsp;&nbsp;<?php $comments->reply(_IcT('comments.reply')); ?></div>
        </div>
        <?php if ($comments->children): ?>
        <div class="comment-children">
            <?php $comments->threadedComments(); ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php
}