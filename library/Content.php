<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Content
{
    private static $fieldsInfoOutputed = FALSE;

    private static $shortcodeHandler = array(
        'gallery' => 'processGalleryCallback',
        'ruby' => 'processRubyCallback',
        'tip' => 'processTipCallback',
        'tabs' => 'processTabsCallback',
        'bili' => 'processBilibiliCallback',
        'block' => 'processBlockCallback',
    );

    public static function config($form)
    {
        $form->packTitle('Post');
        $form->packRadio('Post/excerpt_preserve_tags', array('0', '1'), '0');
        $form->packInput('Post/excerpt_length', '100', 'w-20');
        $form->packRadio('Post/tiny_item', array('0', '1'), '0');
        $form->packRadio('Post/license', array('0', '1'), '1');
        $form->packTextarea('Post/license_extend', '<a rel="noopener" target="_blank" title="CC BY-NC-ND 4.0" href="https://creativecommons.org/licenses/by-nc-nd/4.0/deed.zh">CC BY-NC-ND 4.0</a>');
        $form->packTextarea('Post/content_extend', '');
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
    
    private static function processBilibiliCallback($matches)
    {
        return '<div class="justified-gallery">' . $matches[5] . '</div>';
    }

    private static function processRubyCallback($matches)
    {
        $attr = self::parseShortcodeAttrs($matches[3], 'title');
        if (isset($attr['title']) === true)
            return '<ruby>' . $matches[5] . '<rp> (</rp><rt>' . $attr['title'] . '</rt><rp>) </rp></ruby>';
        else
            return $matches[5];
    }
    
    private static function processTabsCallback($matches)
    {
        if (Icarus_Module::enabled('Tabs') === false) return;
		$list=$matches[0];
		$regeTab="/\[tab.*?name=(.*?)\](.+?)\[\/tab\]/is";
		preg_match_all($regeTab , $list , $results);
		$name=json_decode(json_encode($results[1]));
		$content=json_decode(json_encode($results[2]));
		$html="<div class='my-tabs'><ul>";
		foreach($name as $key=>$value){
			if($key==0){
				$html.='<li class="selected tab-li">'.str_replace('"',"",$name[$key]).'</li>';
			}else{
				$html.='<li class="tab-li">'.str_replace('"',"",$name[$key]).'</li>';
			}
		}
		$html.='</ul>';
		foreach($content as $key=>$value){
			if($key==0){
				$html.='<div class="selected tab-div">'.$content[$key].'</div>';
			}else{
				$html.='<div class="tab-div">'.$content[$key].'</div>';
			}
		}
		$html.="</div>";
		return $html ;
	}
	
	private static function processTipCallback($matches)
	{
	    preg_match_all("/\[tip.*?type=(.*?)\](.+?)\[\/tip\]/is", $matches[0], $results);
	    return '<article class="message message-immersive is-'.str_replace('"','',$results[1][0]).'">
                <div class="message-body">'.$results[2][0].'</div></article>';
	}
	
	private static function processButtonCallback($matches)
	{
	    preg_match_all("/\[button.*?onclick=(.*?)\](.+?)\[\/button\]/is", $matches[0], $results);
	    return '<button class="button is-'.str_replace('"','',$results[1][0]).'">
                <div class="message-body">'.$results[2][0].'</div></article>';
	}
	
	private static function processBlockCallback($matches)
	{
	    preg_match_all("/\[block.*?type=(.*?)\](.+?)\[\/block\]/is", $matches[0], $results);
	    return '<div class="notification is-'.str_replace('"','',$results[1][0]).'">'.$results[2][0].'</div>';
	}
	
	private static function processCoversourceCallback($matches)
	{
	    preg_match_all("/\[tip.*?type=(.*?)\](.+?)\[\/tip\]/is", $matches[0], $results);
	    return '<article class="message message-immersive is-'.str_replace('"','',$results[1][0]).'">'.$results[2][0].'</div></article>';
	}
    
    private static function parseShortcodeAttrs($attrContent, $attrName)
    {
        if (is_array($attrName) === true)
        {
            $attrRegexp = join('|', array_map('preg_quote', $attrName));;
        }
        else
        {
            $attrRegexp = preg_quote($attrName);
            $attrName = array($attrName);
        }
        preg_match_all('/(' . $attrRegexp . ')="([^"]*?)"/i', $attrContent, $matches, PREG_SET_ORDER);
        $result = array();
        foreach ($matches as $match)
        {
            $result[$match[1]] = $match[2];
        }
        return $result;
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
        return preg_replace("/$pattern/", '\5', $content);
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

    private static function processSpecialSyntax($content)
    {
        return str_replace(['<img src=','<li>[ ]','<li>[x]'],['<img class="lazyload" src="'.Icarus_Assets::getUrlForAssets('/img/default.png').'" data-original=','<li><input type="checkbox" disabled> ','<li><input type="checkbox" disabled checked> '],$content);
    }
    
    public static function getContent($post)
    {
        $content = $post->content;
        $content = self::processAllShortcodes($content);
        $content = self::processSpecialSyntax($content);
        if (Icarus_Module::enabled('Toc') === true)
        {
            Icarus_Module::load('Toc');
            $content = Icarus_Module_Toc::generate($content);
        }
        if (Icarus_Config::tryGet('post_content_extend', $extendTpl) === true && $post->is('post') === true)
        {
            $content .= str_replace(
                array(
                    '{title}',
                    '{author}',
                    '{url}',
                    '{date}',
                ),
                array(
                    $post->title,
                    $post->author->screenName,
                    $post->permalink,
                    $post->date->format(Icarus_Util::$options->postDateFormat),
                ),
                $extendTpl
            );
        }
        return $content;
    }

    public static function getExcerpt($post)
    {
        // hidden post overrided, show the password form
        if ($post->hidden === true) {
            //return $post->text;
            return '';
        }

        // user config        
        $truncateLength = intval(Icarus_Config::get('post_excerpt_length', 100));

        $preserveTags = !!Icarus_Config::get('post_excerpt_preserve_tags', FALSE);

        if (Icarus_Util::isEmpty($post->fields->custom_excerpt) === false) {
            // custom excerpt support

            $excerpt = $post->markdown($post->fields->custom_excerpt);
            $truncateRequired = FALSE;
        } else {
            // original excerpt process

            $content = $post->pluginHandle('Widget_Abstract_Contents')
                            ->trigger($plugged)
                            ->excerpt($post->text, $post);
            
            if ($plugged === false) {
                $content = $post->isMarkdown ? $post->markdown($content)
                : $post->autoP($content);
            }

            if (FALSE !== ($excerptPos = strpos($content, '<!--more-->'))) {
                $excerpt = substr($content, 0, $excerptPos);
            } else {
                $excerpt = $content;
            }

            // fixHtml func patched
            $excerpt = Icarus_Util::fixHtml(
                $post->pluginHandle('Widget_Abstract_Contents')
                     ->excerptEx($excerpt, $post)
                );
    
            // handle shortcode
            $excerpt = self::removeAllShortcodes($excerpt);
    
            // condition flags
            $truncateRequired = $truncateLength > 0 && ($excerptPos === FALSE);
        }
        
        if ($preserveTags === false || $truncateRequired === true) {
            $excerpt = strip_tags($excerpt);
            if ($truncateRequired === true) {
                $excerpt = Typecho_Common::subStr($excerpt, 0, $truncateLength, '...');
            }
        }

        return str_replace(['[hide]','[/hide]'],['',''],$excerpt);
    }

    public static function hasThumbnail($post)
    {
        return !Icarus_Util::isEmpty($post->fields->thumbnail);
        //如果需要显示随机图片，可以改为 return true;
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
        
        $language = new Typecho_Widget_Helper_Form_Element_Text(
            'language', NULL, NULL, 
            _IcT('fields.language.title'), 
            _IcT('fields.language.desc')
        );
        $language->input->class = 'w-100';
        $form->addItem($language);
        
        $translate = new Typecho_Widget_Helper_Form_Element_Text(
            'translate', NULL, NULL, 
            _IcT('fields.translate.title'), 
            _IcT('fields.translate.desc')
        );
        $translate->input->class = 'w-100';
        $form->addItem($translate);

        $blocked = new Typecho_Widget_Helper_Form_Element_Text(
            'blocked_countries', NULL, NULL, 
            _IcT('fields.blocked_countries.title'), 
            _IcT('fields.blocked_countries.desc')
        );
        $blocked->input->class = 'w-100';
        $form->addItem($blocked);
        
        $excerpt = new Typecho_Widget_Helper_Form_Element_Textarea(
            'custom_excerpt', NULL, NULL, 
            _IcT('fields.excerpt.title'), 
            _IcT('fields.excerpt.desc')
        );
        $excerpt->input->class = 'w-100';
        $form->addItem($excerpt);

        if (defined('__ICARUS_WIDGET_CLASS__') === true && __ICARUS_WIDGET_CLASS__ === 'Widget_Contents_Page_Edit')
        {
            self::fieldsInfoForPage();
        }
    }

    private static function fieldsInfoForPage()
    {
        if (self::$fieldsInfoOutputed === false)
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
    var expandCallback = function () {
        var btn = $('i', this);
        if (btn.hasClass('i-caret-right')) {
            btn.removeClass('i-caret-right').addClass('i-caret-down');
        } else {
            btn.removeClass('i-caret-down').addClass('i-caret-right');
        }
        $(this).parent().toggleClass('fold');
        return false;
    };
    $('#icarus-page-info-expand').click(expandCallback);
    
    $('.icarus-autofill-slug').click(function() {
        $('#slug').val($(this).text());
        $('#title').val($(this).attr('data-title'));
        $('#slug').trigger('input');
    });
    
    if (!$('#custom-field').hasClass('fold')) {
        $('#custom-field i.i-caret-right').removeClass('i-caret-right').addClass('i-caret-down');
    }

    if (window.location.hash == '#icarus') {
        $('#icarus-page-info-expand').click();
        expandCallback.call(document.getElementById('custom-field-expand'));
        setTimeout(function (){
            $('#icarus-page-info').effect('highlight', {color : '#FFF6BF', duration: 1000});
        }, 200);
    }
});
</script>
<?php
        }
    }
}