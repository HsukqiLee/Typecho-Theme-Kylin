<?php
class WDCX_Module_Profile
{
    public static function config($form)
    {
        WDCX_Aside::basicConfig($form, 'profile', WDCX_Aside::ENABLE, 'left', '0');
        $form->packInput('Profile/author', 'Your name', 'w-40');
        $form->packInput('Profile/author_title', 'Your title', 'w-40');
        $form->packInput('Profile/location', 'Your location', 'w-40');
        $form->packInput('Profile/avatar', 'img/avatar.png');
        $form->packInput('Profile/gravatar', '');
        $form->packInput('Profile/follow_link', 'https://github.com/');
        $form->packTextarea('Profile/social_links', "GitHub,fab fa-github,https://github.com/\nTwitter,fab fa-twitter,https://twitter.com/\nFacebook,fab fa-facebook,https://facebook.com/");
    }

    private static function printAvatarUrl()
    {
        $avatar = WDCX_Config::get('profile_avatar');
        if (WDCX_Config::tryGet('profile_gravatar', $gravatarEmail))
        {
            echo WDCX_Util::getAvatar($gravatarEmail, 128);
        }
        else
        {
            echo WDCX_Assets::getUrlForAssets(
                WDCX_Config::get('profile_avatar', 'img/avatar.png'));
        }
    }

    private static function getSocialLinks()
    {
        return WDCX_Util::parseMultilineData(WDCX_Config::get('profile_social_links'), 3);
    }

    public static function output()
    {
?>
<div class="card widget">
    <div class="card-content">
        <nav class="level">
            <div class="level-item has-text-centered">
                <div>
                    <img class="image is-128x128 has-mb-6 profile-avatar is-rounded" 
                        src="<?php self::printAvatarUrl(); ?>" 
                        alt="<?php echo WDCX_Config::get('profile_author'); ?>" />
                    <?php if (WDCX_Config::tryGet('profile_author', $profileAuthor)): ?>
                    <p class="is-size-4 is-block">
                        <?php echo $profileAuthor; ?>
                    </p>
                    <?php endif; ?>
                    <?php if (WDCX_Config::tryGet('profile_author_title', $profileAuthorTitle)): ?>
                    <p class="is-size-6 is-block">
                        <?php echo $profileAuthorTitle; ?>
                    </p>
                    <?php endif; ?>
                    <?php if (WDCX_Config::tryGet('profile_location', $profileLocation)): ?>
                    <p class="is-size-6 is-flex is-flex-center has-text-grey">
                        <i class="fas fa-map-marker-alt has-mr-7"></i>
                        <span><?php echo $profileLocation; ?></span>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
        <nav class="level is-mobile">
            <div class="level-item has-text-centered is-marginless">
                <div>                    <p class="heading">
                        文章
                    </p>
                    <p class="title has-text-weight-normal">
                        <?php echo WDCX_Util::stat()->publishedPostsNum(); ?>
                    </p>
                </div>
            </div>
            <div class="level-item has-text-centered is-marginless">
                <div>
                    <p class="heading">
                        分类
                    </p>
                    <p class="title has-text-weight-normal">
                        <?php echo WDCX_Util::stat()->categoriesNum(); ?>
                    </p>
                </div>
            </div>
            <div class="level-item has-text-centered is-marginless">
                <div>
                    <p class="heading">
                        天数
                    </p>
                    <p class="title has-text-weight-normal">
                        <?php echo WDCX_Util::getSiteRunDays(); ?>
                    </p>
                </div>
            </div>
        </nav>
        <?php if (WDCX_Config::tryGet('profile_follow_link', $profileFollowLink)): ?>
        <div class="level">            <a class="level-item button is-link is-rounded" href="<?php echo $profileFollowLink; ?>">
                关注我</a>
        </div>
        <?php endif; ?>
        <?php $socialLinks = self::getSocialLinks(); ?>
        <?php if (!empty($socialLinks)): ?>
        <div class="level is-mobile">
            <?php foreach ($socialLinks as $socialLinkItem): ?>
            <a class="level-item button is-white is-marginless" target="_blank"
                title="<?php echo $socialLinkItem[0]; ?>" href="<?php echo $socialLinkItem[2]; ?>">
                <?php if (empty($socialLinkItem[1])): ?>
                <?php echo $socialLinkItem[0]; ?>
                <?php else: ?>
                <i class="<?php echo $socialLinkItem[1]; ?>"></i>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php
    }
}
