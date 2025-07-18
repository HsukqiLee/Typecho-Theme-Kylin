<?php
class Icarus_Module_Profile
{
    public static function config($form)
    {
        Icarus_Aside::basicConfig($form, 'profile', Icarus_Aside::ENABLE, 'left', '0');
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
        $avatar = Icarus_Config::get('profile_avatar');
        if (Icarus_Config::tryGet('profile_gravatar', $gravatarEmail))
        {
            echo Icarus_Util::getAvatar($gravatarEmail, 128);
        }
        else
        {
            echo Icarus_Assets::getUrlForAssets(
                Icarus_Config::get('profile_avatar', 'img/avatar.png'));
        }
    }

    private static function getSocialLinks()
    {
        return Icarus_Util::parseMultilineData(Icarus_Config::get('profile_social_links'), 3);
    }

    public static function output()
    {
?>
<div class="card widget">
    <div class="card-content">
        <nav class="level">
            <div class="level-item has-text-centered">
                <div>
                    <img class="avatar image is-128x128 has-mb-6 profile-avatar is-rounded" src="<?php echo Icarus_Assets::getUrlForAssets('/img/default.png'); ?>" 
                        data-original="<?php self::printAvatarUrl(); ?>" 
                        alt="<?php echo Icarus_Config::get('profile_author'); ?>" />
                    <?php if (Icarus_Config::tryGet('profile_author', $profileAuthor)): ?>
                    <p class="is-size-4 is-block">
                        <?php echo htmlspecialchars($profileAuthor, ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    <?php endif; ?>
                    <?php if (Icarus_Config::tryGet('profile_author_title', $profileAuthorTitle)): ?>
                    <p class="is-size-6 is-block hitokoto">
                        <?php echo htmlspecialchars($profileAuthorTitle, ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    <?php endif; ?>
                    <?php if (Icarus_Config::tryGet('profile_location', $profileLocation)): ?>
                    <p class="is-size-6 is-flex is-flex-center has-text-grey">
                        <i class="fas fa-map-marker-alt has-mr-7"></i>
                        <span><?php echo htmlspecialchars($profileLocation, ENT_QUOTES, 'UTF-8'); ?></span>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
        <nav class="level is-mobile">
            <div class="level-item has-text-centered is-marginless">
                <div>
                    <p class="heading">
                        <?php _IcTp('general.posts'); ?>
                    </p>
                    <p class="title has-text-weight-normal">
                        <?php echo Icarus_Util::stat()->publishedPostsNum(); ?>
                    </p>
                </div>
            </div>
            <div class="level-item has-text-centered is-marginless">
                <div>
                    <p class="heading">
                        <?php _IcTp('general.categories'); ?>
                    </p>
                    <p class="title has-text-weight-normal">
                        <?php echo Icarus_Util::stat()->categoriesNum(); ?>
                    </p>
                </div>
            </div>
            <div class="level-item has-text-centered is-marginless">
                <div>
                    <p class="heading">
                        <?php _IcTp('profile.run_days'); ?>
                    </p>
                    <p class="title has-text-weight-normal">
                        <?php echo Icarus_Util::getSiteRunDays(); ?>
                    </p>
                </div>
            </div>
        </nav>
        <?php if (Icarus_Config::tryGet('profile_follow_link', $profileFollowLink)): ?>
        <div class="level">
            <a class="level-item button is-link is-rounded" href="<?php echo htmlspecialchars($profileFollowLink, ENT_QUOTES, 'UTF-8'); ?>">>
                <?php _IcTp('profile.follow'); ?></a>
        </div>
        <?php endif; ?>
        <?php $socialLinks = self::getSocialLinks(); ?>
        <?php if (Icarus_Util::isEmpty($socialLinks) === false): ?>
        <div class="level is-mobile">
            <?php foreach ($socialLinks as $socialLinkItem): ?>
            <a class="level-item button is-white is-marginless" target="_blank"
                title="<?php echo htmlspecialchars($socialLinkItem[0], ENT_QUOTES, 'UTF-8'); ?>" href="<?php echo htmlspecialchars($socialLinkItem[2], ENT_QUOTES, 'UTF-8'); ?>">>
                <?php if (Icarus_Util::isEmpty($socialLinkItem[1]) === true): ?>
                <?php echo htmlspecialchars($socialLinkItem[0], ENT_QUOTES, 'UTF-8'); ?>
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