<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
return array(
    'general' => array(
        'enable' => '启用',
        'disable' => '不启用',
        'catalog' => 'Catalog',
        'posts' => 'Posts',
        'categories' => 'Categories',
        'archives' => 'Archives',
        'tags' => 'Tags',
        'toc' => 'Table of Contents',
        'year_tpl' => '%dYear',
        'month_tpl' => '%dMonth',
        'author' => 'Author',
        'search' => 'Search',
        'comments' => 'Comments',
        'logout' => 'Log out',
        'login'=>'Log In',
        'register'=>'Sign In',
        'usercenter' => 'Console',
        'cancel' => 'Cancel',
    ),
    'empty' => array(
        'category' => array(
            'title' => 'Articles under this category cannot be found. ;-)',
            'desc' => 'Empty Category',
            'jump' => 'View other categories',
        ),
        'tag' => array(
            'title' => 'No posts published with the tag.',
            'desc' => 'Empty Tag',
            'jump' => 'View all tags',
        ),
        'search' => array(
            'title' => 'Cannot find any posts related to the keyword.',
            'desc' => 'Empty Search Result',
            'jump' => 'Search again',
        ),
        'author' => array(
            'title' => 'No posts published.',
            'desc' => 'Empty Author Page.',
        ),
        'date' => array(
            'title' => 'No posts published during the time.',
            'desc' => 'Empty Archive',
            'jump' => 'View all archives',
        ),
    ),
    '404' => array(
        'title' => '404 Not found.',
        'desc' => '<p class="subtitle">If you came from search engines：</p><p> - The page may be encrypted or hidden.</p><br /><br /><p class="subtitle">If you came from other websites：</p><p> - This website may plagiarize this article.</p>',
        'back' => 'Go back home',
    ),
    'title' => array(
        'category' => 'Posts in category「%s」',
        'search' => 'Posts including keyword「%s」',
        'tag' => 'Posts with tag 「%s」',
        'author' => '%s\' post',
        'date' => 'Posts published in %s',
        'page' => array(
            'before' => 'Page ',
            'after' => '',
        )
    ),
    'search' => array(
        'title' => 'Search',
        'placeholder' => 'Type something...',
        'tags' => ' posts',
    ),
    'article' => array(
        'more' => 'Read more',
    ),
    'profile' => array(
        'follow' => 'Subscribe',
        'run_days' => 'days',
    ),
    'archive' => array(
        'date_format' => 'F, Y',
    ),
    'link' => array(
        'title' => 'Links',
    ),
    'donate' => array(
        'words' => 'Buy me a cup of coffee,'.PHP_EOL.'if u like the blog post!',
        'buttons' => array(
            'qq' => 'QQ',
            'wechat' => 'WeChat',
            'alipay' => 'Alipay',
            'afdian' => 'Afdian',
            'paypal' => 'PayPal',
            'buymeacoffee' => 'Buymeacoffee',
        ),
    ),
    'recent_post' => array(
        'title' => 'Recent Posts',
    ),
    'back_to_top' => array(
        'title' => 'Back to top',
    ),
    'darkmode' => array(
        'title' => 'Dark Mode',
        'mode' => array(
            'auto' => 'Auto',
            'light' => 'Light',
            'dark' => 'Dark',
        ),
    ),
    'comments' => array(
        'do_comment_title' => 'Add a comment',
        'do_comment' => 'Send',
        'logined' => '登录身份：',
        'disabled' => 'No comments allowed.',
        'is_author' => 'Author',
        'is_waiting' => 'Awaiting approval...',
        'reply' => 'Reply',
        'num' => array(
            '0' => 'None yet',
            '1' => '1 Comment',
            'more' => '%d Comments',
        ),
        'input' => array(
            'name' => 'Name',
            'email' => 'Mail',
            'url' => 'Site',
            'text' => 'Markdown supported, 50 words at most.',
            'required'=>'Required',
            'optional'=>'Optional',
        ),
        'guide' => array(
            'name' => 'Type your name.',
            'email' => '（Optional）Type your email.',
            'email_required' => 'Type your email.',
            'url' => '（Optional）Type the URL of your site.',
            'url_required' => 'Type the URL of your site.',
        ),
    ),
    'sweet_alert' => array(
        'internet_error' => 'Internet Error',
        'please_refresh' => 'Please refresh and retry',
        'wrong_password' => 'Password Incorrect',
        'please_check_again' => 'Please check your input',
        'comment_success_title' => 'Success',
        'comment_error_title' => 'Error',
        'comment_success_message' => 'If the status is \"Pending\", please wait for manual review of this comment; otherwise, it is automatically reviewed and passed, and you can refresh the page to view the visible content of the comment.',
        'comment_failed_to_fetch' => 'This comment may not pass the automatic review. Possible reasons: nickname violation, email address is illegal, or the comment is excluded by the anti-spam system.',
        'comment_failed_to_submit' => 'This comment may be incomplete or failed to pass automatic review. Please check whether your nickname, email address and comment body are filled in.',
    ),
    'setting' => array(
        'general' => array(
            'title' => '基本',
            'desc' => '
<p><b>注意事项</b></p>
<ul class="icaurs-general-desc-list">
<li>资源文件的相对路径是指相对于 <code> %s/assets/</code> 目录的相对路径。</li>
<li>更换主题会导致本主题的设置项丢失，如有需要请手动<b>备份相关设置</b>。</li>
<li><b>归档页面</b>、<b>分类页面</b>和<b>标签页面</b>，需要手动<a href="%s">创建相应的独立页面</a>才能显示。</li>
</ul>
',
            'install_time' => array(
                'title' => '站点建立日期',
                'desc' => '用于计算站点运行时间，显示 Copyright 年份等。格式：2018-12-31',
            ), 
        ),
        'head' => array(
            'title' => '页头',
            'favicon' => array(
                'title' => 'Favicon',
                'desc' => 'Favicon 图标的相对路径或 URL。',
            ),
            'extend' => array(
                'title' => '&lt;head&gt; 标签内追加内容',
            ),
        ),
        'navbar' => array(
            'title' => '导航栏',
            'menu' => array(
                'title' => '菜单',
                'desc' => '导航栏菜单链接。一行一个，格式：<code>链接文字,链接URL</code>',
            ),
            'top' => array(
                'title' => '置顶',
                'options' => array(
                    '0' => '不启用',
                    '1' => '启用',
                ),
                'desc' => '固定顶部导航栏。注意：在启用固定侧边栏后，固定导航栏会导致侧边栏被部分遮挡。',
            ),
            'background' => array(
                'title' => '背景图片',
                'desc' => '自定义网站背景图片，留空则为白色背景。开启后建议设置90%-95%的卡片透明度。',
            ),
            'transparency' => array(
                'title' => '卡片透明度',
                'desc' => '卡片布局的透明度。单位：%。'
            ),
            'icons' => array(
                'title' => '图标',
                'desc' => '导航栏右上角图标链接。一行一个，格式：<code>链接文字,链接图标,链接URL</code><br />链接图标请参考 <a href="https://fontawesome.com/icons?d=gallery&m=free" rel="noopener noreferrer" target="_blank">Font Awesome Icons</a>',
            ),
            'default_value' => "首页,%s\n归档,%s\n分类,%s",
        ),
        'logo' => array(
            'title' => 'Logo',
            'desc' => '站点的 Logo，显示在导航栏最左侧以及页脚左侧。',
            'text' => array(
                'title' => 'Logo 文字',
                'desc' => '留空则显示站点名称。',
            ),
            'img' => array(
                'title' => 'Logo 图片（优先显示）',
                'desc' => 'Logo 图片的相对路径或 URL。',
            ),
            'img_dark' => array(
                'title' => 'Logo 图片（深色模式）',
                'desc' => '深色模式 Logo 图片的相对路径或 URL。',
            ),
        ),
        'post' => array(
            'title' => '文章',
            'excerpt_preserve_tags' => array(
                'title' => '摘要保留样式',
                'options' => array(
                    '0' => '不保留',
                    '1' => '保留',
                ),
                'desc' => '在文章列表中的摘要部分保留原文样式（段落、代码高亮等）',
            ),
            'excerpt_length' => array(
                'title' => '摘要长度',
                'desc' => '指定自动生成的摘要部分的最大长度。参数值为 <code>-1</code> 则不限制最大长度。<br />需要设置 <code>摘要保留样式</code> 为 <code>不保留</code>才能生效。<br />原文中已指定摘要部分时本参数将被忽略（即包含 <code>&lt;!--more--&gt;</code> 标签）',
            ),
            'tiny_item' => array(
                'title' => '简洁文章条目',
                'options' => array(
                    '0' => '不启用',
                    '1' => '启用',
                ),
                'desc' => '使用简洁风格的文章条目展示（隐藏摘要）。',
            ),
            'license' => array(
                'title' => '文章末尾版权声明',
                'options' => array(
                    '0' => '不启用',
                    '1' => '启用',
                ),
                'desc' => '显示一个版权声明。',
                'author' => 'Author',
                'date' => 'Posted on',
                'modified' => 'Edited on',
                'under' => 'Licensed under',
            ),
            'license_extend' => array(
                'title' => '版权附加CC协议',
                'desc' => '版权声明显示的协议，支持HTML。协议参考 <a href="https://creativecommons.org/" rel="noopener noreferrer" target="_blank">Creative Commons</a>',
            ),
            'content_extend' => array(
                'title' => '文章末尾追加内容',
                'desc' => '在文章末尾追加指定内容。支持以下变量替换 <code>{author}</code> <code>{title}</code> <code>{url}</code> <code>{date}</code>',
            ),
        ),
        'search' => array(
            'title' => '搜索',
            'enable' => array(
                'title' => '站内搜索开关',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'type' => array(
                'title' => '搜索引擎',
                'options' => array(
                    'internal' => '内置搜索',
                ),
            ),
        ),
        'dark_mode' => array(
            'title' => '黑暗模式',
            'enable' => array(
                'title' => '黑暗模式切换开关',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
        ),
        'aside_common' => array(
            'enable' => array(
                'title' => 'Widget 开关',
                'desc' => '只有启用的 Widget 才会显示在页面中。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'seq' => array(
                'title' => '顺序',
                'desc' => '输入一个整数以指定本 Widget 在一列中显示的先后顺序，数字越小位置越靠前。',
            ),
            'position' => array(
                'title' => '位置',
                'desc' => '指定本 Widget 显示在左边栏还是右边栏。',
                'options' => array(
                    'left' => '左',
                    'right' => '右',
                ),
            ),
        ),
        'plugin_common' => array(
            'enable' => array(
                'title' => '插件开关',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
        ),
        'profile' => array(
            'title' => '简介 Widget',
            'desc' => '显示头像、昵称、社交网络链接、博客基本信息等。',
            'author' => array(
                'title' => '作者昵称',
                'desc' => '留空则不显示。',
            ),
            'author_title' => array(
                'title' => '作者头衔',
                'desc' => '位置上是作者昵称的下一行。留空则不显示。',
            ),
            'location' => array(
                'title' => '作者坐标',
                'desc' => '位置上是作者头衔的下一行。留空则不显示。',
            ),
            'avatar' => array(
                'title' => '头像 URL',
                'desc' => '头像图片的相对路径或 URL。留空则显示主题默认头像。',
            ),
            'gravatar' => array(
                'title' => '调用 Gravatar 头像',
                'desc' => '填写你的邮箱，调用 Gravatar 显示邮箱对应的头像。优先于本地头像显示。',
            ),
            'follow_link' => array(
                'title' => '「关注我」按钮链接',
                'desc' => '留空则不显示「关注我」按钮。',
            ),
            'social_links' => array(
                'title' => '社交网络链接',
                'desc' => '留空则不显示。水平排列，一行一个，格式：<code>链接文字,链接图标,链接URL</code><br />链接图标请参考 <a href="https://fontawesome.com/icons?d=gallery&m=free" rel="noopener noreferrer" target="_blank">Font Awesome Icons</a>',
            ),
        ),
        'aside' => array(
            'title' => '侧边栏',
            'left_sticky' => array(
                'title' => '固定左边栏',
                'desc' => '固定左边栏，使其不随页面滚动。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'right_sticky' => array(
                'title' => '固定右边栏',
                'desc' => '固定右边栏，使其不随页面滚动。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'left_post_hide' => array(
                'title' => '文章页隐藏左边栏',
                'desc' => '在文章和独立页面隐藏左边栏。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'right_post_hide' => array(
                'title' => '文章页隐藏右边栏',
                'desc' => '在文章和独立页面隐藏右边栏。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'non_post_hide_widget' => array(
                'title' => '非文章页面隐藏 Widget',
                'desc' => '指定在首页和独立页面隐藏部分 Widget。',
                'options' => array(
                    'Profile' => '@setting.profile.title', 
                    'Category' => '@setting.category.title', 
                    'Link' => '@setting.link.title', 
                    'RecentPost' => '@setting.recent_post.title', 
                    'Archive' => '@setting.archive.title', 
                    'Tag' => '@setting.tag.title', 
                    'Toc' => '@setting.toc.title'
                ),
            ),
            'post_hide_widget' => array(
                'title' => '文章页面隐藏 Widget',
                'desc' => '指定在文章页面隐藏部分 Widget。',
                'options' => array(
                    'Profile' => '@setting.profile.title', 
                    'Category' => '@setting.category.title', 
                    'Link' => '@setting.link.title', 
                    'RecentPost' => '@setting.recent_post.title', 
                    'Archive' => '@setting.archive.title', 
                    'Tag' => '@setting.tag.title', 
                    'Toc' => '@setting.toc.title'
                ),
            ),
        ),
        'archive' => array(
            'title' => '归档 Widget',
            'desc' => '显示按月份列出的归档链接。',
        ),
        'category' => array(
            'title' => '分类 Widget',
            'desc' => '列出各个分类及其子分类。',
        ),
        'link' => array(
            'title' => '链接 Widget',
            'desc' => '显示指定链接。',
            'links' => array(
                'title' => '链接',
                'desc' => '显示在 Widget 中的链接。一行一个，格式：<code>链接文字,链接URL</code>',
            ),
        ),
        'donate' => array(
            'title' => '赞助 Widget',
            'desc' => '显示赞助按钮。',
            'buttons' => array(
                'title' => '按钮',
                'desc' => '一行一个，格式：<code>type=平台缩写,image=二维码URL,url=付款URL,business=PayPal账号,currency=PayPal币种</code><br />平台支持：<code>腾讯QQ(qq)，微信(wechat)，爱发电(afdian)，支付宝(alipay)，赏我一杯咖啡(buymeacoffee)，PayPal(paypal)</code><br />type：必需配置，image：QQ、微信、赏我一杯咖啡、支付宝、爱发电支持，url：支付宝、爱发电，business/currency：PayPal商户',
            ),
        ),
        'recent_post' => array(
            'title' => '最新文章 Widget',
            'desc' => '列出指定数目的最新文章。',
            'limit' => array(
                'title' => '数目',
                'desc' => '最多显示的文章数。留空或非正数则默认为显示5篇。',
            ),
            'thumbnail' => array(
                'title' => '缩略图',
                'desc' => '在文章标题旁显示缩略图。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
        ),
        'tag' => array(
            'title' => '标签 Widget',
            'limit' => array(
                'title' => '数目',
                'desc' => '最多显示的标签数。为0则显示所有标签。负数或为空默认为显示20个。',
            ),
        ),
        'toc' => array(
            'title' => 'TOC Widget',
            'desc' => 'Table of Contents：文章目录',
        ),
        'footer' => array(
            'title' => '页脚',
            'links' => array(
                'title' => '链接',
                'desc' => '显示在页脚的链接。一行一个，格式：<code>链接文字,链接图标,链接URL</code><br />链接图标请参考 <a href="https://fontawesome.com/icons?d=gallery&m=free" rel="noopener noreferrer" target="_blank">Font Awesome Icons</a>',
            ),
            'content_left' => array(
                'title' => '页脚左侧追加内容',
                'desc' => '显示位置在 Copyright 以后。',
            ),
            'scripts' => array(
                'title' => '页末追加脚本',
                'desc' => '用于在页面末尾追加统计脚本等不可见内容。',
            ),
        ),
        'moment' => array(
            'title' => 'Moment 插件',
            'desc' => '将具体的时间（如：2022-07-08）转换为更人性化的显示格式（如：1小时前）',
        ),
        'animejs' => array(
            'title' => 'Animejs 插件',
            'desc' => '为页面添加动画效果。',
        ),
        'tabs' => array(
            'title' => 'Tabs 插件',
            'desc' => '为Markdown解析提供选项卡支持。语法：<code>[tabs] [tab name="名称1"]内容1[/tab] [tab name="名称2"]内容2[/tab] [/tabs]</code>',
        ),
        'highlight' => array(
            'title' => 'highlight.js 插件',
            'desc' => '提供代码高亮功能。',
            'theme' => array(
                'title' => '主题名称',
                'desc' => '可以选用的主题名称请参考 <a href="https://highlightjs.org/static/demo/" rel="noreferrer noopener" target="_blank">highlight.js demo</a><br />默认主题：<code>atom-one-light</code>',
            ),
            'theme_dark' => array(
                'title' => '深色模式主题名称',
                'desc' => '如果启用深色模式，切换到深色模式时将使用此主题。可以选用的主题名称请参考 <a href="https://highlightjs.org/static/demo/" rel="noreferrer noopener" target="_blank">highlight.js demo</a><br />默认主题：<code>atom-one-dark</code>',
            ),
        ),
        'copyleft' => array(
            'title' => '禁止转载插件',
            'desc' => '禁止右键，显示一个自定义提示。不影响剪贴板插件的复制。',
            'text' => array(
                'title' => '右键时显示的提示'
            ),
        ),
        'sweet_alert' => array(
            'title' => 'SweetAlert 插件',
            'desc' => '使用 Ajax 替换部分原生请求，用 SweetAlert 提示框替换原生错误页面。',
        ),
        'back_to_top' => array(
            'title' => '返回顶部插件',
            'desc' => '显示一个「返回顶部」按钮。',
        ),
        'clipboard'  => array(
            'title' => '剪贴板插件',
            'desc' => '在代码块上提供一个「复制」按钮。',
        ),
        'gallery' => array(
            'title' => 'Gallery 插件',
            'desc' => '利用 lightGallery 提供单张图片的灯箱效果，以及 Justified Gallery 实现图集显示。<br />图集调用方式：使用下述标签包围多张图片作为一个图集进行显示。<code>[gallery]</code><code>[/gallery]</code>',
        ),
        'mathjax' => array(
            'title' => 'Mathjax 插件',
            'desc' => '提供数学公式显示支持。修改 <code>assets/js/mathjax.js</code> 文件以进行具体配置。',
        ),
        'outdated_browser' => array(
            'title' => 'Outdated Browser 插件',
            'desc' => '向使用过时的浏览器的用户显示一个友好的提示。',
        ),
        'progressbar' => array(
            'title' => '进度条插件',
            'desc' => '在页面顶部显示一个加载进度条。',
        ),
        'comments' => array(
            'title' => '评论',
            'desc' => '文章、独立页面评论的相关设置',
            'type' => array(
                'title' => '评论系统',
                'desc' => '决定使用何种评论系统提供评论功能。',
                'options' => array(
                    'internal' => '内置评论',
                    'custom' => '自定义',
                ),
            ),
            'default_avatar' => array(
                'title' => '评论默认头像',
                'desc' => '指定当评论者没有设定 Gravatar 头像时显示的默认头像。<a href="https://cn.gravatar.com/site/implement/images/#default-image" rel="noopener noreferrer nofollow" target="_blank">参考</a>',
            ),
            'custom_content' => array(
                'title' => '自定义评论区代码',
                'desc' => '设定评论系统为 自定义 时，请将评论区相关代码填入此文本框内，<code>{identifier}</code> 将被替换为当前页面的标识符。',
            ),
        ),
        'assets' => array(
            'title' => '资源与 CDN',
            'desc' => '合理配置主题所需的资源文件的加载路径以提高页面加载速度。',
            'theme_assets_base' => array(
                'title' => '主题资源 CDN',
                'desc' => '留空则默认为主题目录下的 assets 目录。设置本设置项后请将主题目录下的 assets 目录内的文件复制到 CDN 的对应位置。',
            ),
            'public_assets' => array(
                'title' => '公共资源 CDN',
                'options' => array(
                    'jsdelivr' => 'JSDelivr',
                    'cdnjs' => 'CloudFlare',
                    'loli' => 'CSS.net',
                    'unpkg' => 'UNPKG',
                    'bootcdn' => 'BootCDN',
                ),
            ),
            'public_icon' => array(
                'title' => '公共图标资源 CDN',
                'options' => array(
                    'fontawesome' => 'FontAwesome',
                    'jsdelivr' => 'JSDelivr',
                    'cdnjs' => 'CloudFlare',
                    'loli' => 'CSS.net',
                    'unpkg' => 'UNPKG',
                    'bootcdn' => 'BootCDN',
                ),
            ),
            'public_font' => array(
                'title' => '公共字体资源 CDN',
                'options' => array(
                    'google' => 'GoogleFonts',
                    'loli' => 'CSS.net',
                ),
            ),
            'public_gravatar' => array(
                'title' => '公共 Gravatar CDN',
                'options' => array(
                    'v2ex' => 'V2EX',
                    'gravatar' => 'Gravatar',
                    'loli' => 'CSS.net',
                    'cravatar' => 'Cravatar',
                ),
            ),
        ),
        'cfg_version_notice' => 'Kylin 主题已更新至版本 %s，请点击保存设置按钮使新的设置项生效。',
    ),
    'fields' => array(
        'thumbnail' => array(
            'title' => '缩略图 URL',
            'desc' => '文章缩略图的 URL。缩略图会显示在文章列表、文章正文页以及最新文章 Widget 中。',
        ),
        'excerpt' => array(
            'title' => '自定义文章摘要',
            'desc' => '填写此文本框则使用其中内容作为本文章的摘要。（支持 Markdown 解析）',
        ),
        'language' => array(
            'title' => '翻译版本的语言',
            'prefix' => 'This article is also available in ',
            'desc' => '此文章翻译版本的语言。如无翻译版本可不填。',
        ),
        'blocked_countries' => array(
            'title' => '屏蔽的国家或地区',
            'desc' => '限制特定国家或地区访问。填入二字码，留空代表无限制。',
            'text' => array(
                'title' => 'Access Denied',
                'subtitle' => 'This content is not available in your area.',
                'ip' => 'Your IP: ',
                'ray' => 'Event ID: ',
                'loc' => 'Region Code: ',
                'colo' => 'Node Code: ',
                'back' => 'Back',
                'reload' => 'Try again',
            ),
        ),
        'translate' => array(
            'title' => '翻译链接',
            'desc' => '此文章翻译版本的链接。如无翻译版本可不填。',
        ),
    ),
    'page_special' => array(
        'title' => 'Icarus 内置页面说明',
        'desc' => array(
            'archives' => '<p>归档页面展示要求：新建一个缩略名为 <code><a href="javascript:;" class="icarus-autofill-slug" data-title="归档" title="点击自动填入">archives</a></code> 的独立页面。</p>',
            'categories' => '<p>分类页面展示要求：新建一个缩略名为 <code><a href="javascript:;" class="icarus-autofill-slug" data-title="分类" title="点击自动填入">categories</a></code> 的独立页面。</p>',
            'tags' => '<p>标签页面展示要求：新建一个缩略名为 <code><a href="javascript:;" class="icarus-autofill-slug" data-title="标签" title="点击自动填入">tags</a></code> 的独立页面。</p>',
        ),
    ),
);