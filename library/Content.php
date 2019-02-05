<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Content
{
    private static $fieldsInfoOutputed = FALSE;

    private static $shortcodeHandler = array(
        'gallery' => 'processGalleryCallback',
    );

    public static function config($form)
    {
        $form->packTitle('Post');
        $form->packRadio('Post/excerpt_preserve_tags', array('0', '1'), '0');
        $form->packInput('Post/excerpt_length', '100', 'w-20');
    }

    /**
     * Retrieve the shortcode regular expression for searching.
     *
     * The regular expression combines the shortcode tags in the regular expression
     * in a regex class.
     *
     * 1 - An extra [ to allow for escaping shortcodes with double [[]]
     * 2 - The shortcode name
     * 3 - The shortcode argument list
     * 4 - The self closing /
     * 5 - The content of a shortcode when it wraps some content.
     * 6 - An extra ] to allow for escaping shortcodes with double [[]]
     *
     *
     * @param array $tagnames Optional. List of shortcodes to find. Defaults to all registered shortcodes.
     * @return string The shortcode search regular expression
     * 
     * @link https://github.com/WordPress/WordPress/blob/70bc51e46f18a15b2abf9161aa82635f059beb82/wp-includes/shortcodes.php#L230
     */
    private static function getShortcodeRegex( $tagnames ) {
        $tagregexp = join( '|', array_map( 'preg_quote', $tagnames ) );
        return
            '\\['                                // Opening bracket
            . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
            . "($tagregexp)"                     // 2: Shortcode name
            . '(?![\\w-])'                       // Not followed by word character or hyphen
            . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
            .     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
            .     '(?:'
            .         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
            .         '[^\\]\\/]*'               // Not a closing bracket or forward slash
            .     ')*?'
            . ')'
            . '(?:'
            .     '(\\/)'                        // 4: Self closing tag ...
            .     '\\]'                          // ... and closing bracket
            . '|'
            .     '\\]'                          // Closing bracket
            .     '(?:'
            .         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
            .             '[^\\[]*+'             // Not an opening bracket
            .             '(?:'
            .                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
            .                 '[^\\[]*+'         // Not an opening bracket
            .             ')*+'
            .         ')'
            .         '\\[\\/\\2\\]'             // Closing shortcode tag
            .     ')?'
            . ')'
            . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
    }

    private static function processGalleryCallback($matches)
    {
        return '<div class="justified-gallery">' . $matches[5] . '</div>';
    }

    private static function processAllShortcodes($content)
    {
        if (strpos($content, '[') === FALSE) {
            return $content;
        }
        $pattern = self::getShortcodeRegex(array_keys(self::$shortcodeHandler));
        return preg_replace_callback(
            "/$pattern/", array(__CLASS__, 'processShortcodeDispatch'),
            $content
        );
    }

    private static function removeAllShortcodes($content)
    {
        if (strpos($content, '[') === FALSE) {
            return $content;
        }
        $pattern = self::getShortcodeRegex(array_keys(self::$shortcodeHandler));
        return preg_replace("/$pattern/", '', $content);
    }

    private static function processShortcodeDispatch($matches)
    {
        // escaping [[tagName]]
        if ( $matches[1] == '[' && $matches[6] == ']' ) {
            return substr($matches[0], 1, -1);
        } else {
            $tagName = $matches[2];
            return call_user_func(array(__CLASS__, self::$shortcodeHandler[$tagName]), $matches);
        }
    }

    public static function getContent($post)
    {
        $content = $post->content;
        $content = self::processAllShortcodes($content);
        if (Icarus_Module::enabled('Toc'))
        {
            Icarus_Module::load('Toc');
            $content = Icarus_Module_Toc::generate($content);
        }
        return $content;
    }

    public static function getExcerpt($post)
    {
        // hidden post overrided, show the password form
        if ($post->hidden) {
            return $post->text;
        }

        $content = $post->pluginHandle('Widget_Abstract_Contents')->trigger($plugged)->excerpt($post->text, $post);
        
        if (!$plugged) {
            $content = $post->isMarkdown ? $post->markdown($content)
            : $post->autoP($content);
        }
        
        if (FALSE !== ($excerptPos = strpos($content, '<!--more-->'))) {
            $excerpt = substr($content, 0, $excerptPos);
        } else {
            $excerpt = $content;
        }

        // fixHtml func patched
        $excerpt = Icarus_Util::fixHtml($post->pluginHandle('Widget_Abstract_Contents')->excerptEx($excerpt, $post));

        // handle shortcode
        $excerpt = self::removeAllShortcodes($excerpt);

        // user config        
        $truncateLength = intval(Icarus_Config::get('post_excerpt_length', 100));
        $preserveTags = !!Icarus_Config::get('post_excerpt_preserve_tags', FALSE);
        
        // condition flags
        $truncateRequired = $truncateLength > 0 && ($excerptPos === FALSE);

        if (!$preserveTags || $truncateRequired) {
            $excerpt = strip_tags($excerpt);
            if ($truncateRequired) {
                $excerpt = Typecho_Common::subStr($excerpt, 0, $truncateLength, '...');
            }
        }

        return $excerpt;
    }

    public static function hasThumbnail($post)
    {
        return !Icarus_Util::isEmpty($post->fields->thumbnail);
    }

    public static function getThumbnail($post)
    {
        return self::hasThumbnail($post)
            ? $post->fields->thumbnail 
            : Icarus_Assets::getUrlForAssets('img/thumbnail.svg');
    }

    public static function fieldsConfig($form)
    {
        $thumbnail = new Typecho_Widget_Helper_Form_Element_Text(
            'thumbnail', NULL, NULL, 
            _IcT('fields.thumbnail.title'), 
            _IcT('fields.thumbnail.desc')
        );
        $thumbnail->input->class = 'w-100';
        $form->addItem($thumbnail);

        if (defined('__ICARUS_WIDGET_CLASS__') && __ICARUS_WIDGET_CLASS__ == 'Widget_Contents_Page_Edit')
        {
            self::fieldsInfoForPage();
        }
    }

    private static function fieldsInfoForPage()
    {
        if (!self::$fieldsInfoOutputed)
        {
            self::$fieldsInfoOutputed = TRUE;
?>
<style>
#icarus-page-info {
    margin: 1em 0;
    padding: 10px 15px;
    background: #FFF;
}
#icarus-page-info.fold .description {
    display: none;
}
#icarus-page-info .typecho-label {
    margin: 0;
}
#icarus-page-info .typecho-label a {
    display: block;
    color: #444;
}
#icarus-page-info .typecho-label a:hover {
    color: #467B96;
    text-decoration: none;
}
</style>
<section id="icarus-page-info" class="typecho-post-option fold">
    <label id="icarus-page-info-expand" class="typecho-label">
        <a href="#"><i class="i-caret-right"></i> <?php _IcTp('page_special.title'); ?></a>
    </label>
    <div class="description">
        <?php _IcTp('page_special.desc.archives'); ?>
        <?php _IcTp('page_special.desc.categories'); ?>
        <?php _IcTp('page_special.desc.tags'); ?>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#icarus-page-info-expand').click(function() {
        var btn = $('i', this);
        if (btn.hasClass('i-caret-right')) {
            btn.removeClass('i-caret-right').addClass('i-caret-down');
        } else {
            btn.removeClass('i-caret-down').addClass('i-caret-right');
        }
        $(this).parent().toggleClass('fold');
        return false;
    });
    $('.icarus-autofill-slug').click(function() {
        $('#slug').val($(this).text());
        $('#title').val($(this).attr('data-title'));
        $('#slug').trigger('input');
    });
    if (!$('#custom-field').hasClass('fold'))
    {
        $('#custom-field i.i-caret-right').removeClass('i-caret-right').addClass('i-caret-down');
    }
});
</script>
<?php
        }
    }
}