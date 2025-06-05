<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('component/header.php');
?>
<div class="card">
    <div class="card-content">
        <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
<?php
function printArchiveBreadcrumb($text, $url = NULL, $isCurrent = FALSE)
{
    if (is_null($url))
        $url = '#';
    
    echo $isCurrent ? '<li class="is-active"><a href="': '<li><a href="';
    echo $url;
    echo $isCurrent ? '" aria-current="page">': '">';
    echo htmlspecialchars($text);
    echo '</a></li>', PHP_EOL;
}
switch ($this->getArchiveType())
{
    case 'category':        printArchiveBreadcrumb(
            '分类', 
            WDCX_Util::urlFor('page', array('slug' => 'categories'))
        );
        if ($curSlug = $this->getArchiveSlug())
        {
            $categories = Typecho_Widget::widget('Widget_Metas_Category_List');
            $categories->execute();
            $categoryFound = FALSE;
            while ($categories->next())
            {
                if ($categories->slug == $curSlug)
                {
                    $categoryFound = TRUE;
                    break;
                }
            }
            if ($categoryFound) 
            {
                $curCategory = $categories->getCategory($categories->mid);
                $categoriesTree = $categories->getAllParents($categories->mid);
        
                if ($categoriesTree) {
                    foreach ($categoriesTree as $category) {
                        printArchiveBreadcrumb($category['name'], $category['permalink']);
                    }
                }
                printArchiveBreadcrumb($curCategory['name'], $curCategory['permalink'], TRUE);
            }
        }
        break;
    case 'search':        printArchiveBreadcrumb('搜索');
        printArchiveBreadcrumb($this->getArchiveSlug(), NULL, TRUE);
        break;
    case 'tag':
        printArchiveBreadcrumb(
            '标签', 
            WDCX_Util::urlFor('page', array('slug' => 'tags'))
        );
        printArchiveBreadcrumb($this->getArchiveSlug(), NULL, TRUE);
        break;
    case 'author':
        printArchiveBreadcrumb('作者');
        printArchiveBreadcrumb($this->getArchiveTitle(), NULL, TRUE);
        break;
    case 'date':
        printArchiveBreadcrumb(
            _IcT('general.archives'), 
            WDCX_Util::urlFor('page', array('slug' => 'archives'))
        );
        extract($this->getPageRow()); // $year, $month, $day
        switch ($this->getArchiveSlug())
        {
            case 'year':
                printArchiveBreadcrumb(_t('%d年', $year), NULL, TRUE);
                break;
            case 'month':
                printArchiveBreadcrumb(_t('%d年', $year), WDCX_Util::urlFor('archive_year', array('year'=>$year)));
                printArchiveBreadcrumb(_t('%d月', $month), NULL, TRUE);
                break;
            case 'day':
                printArchiveBreadcrumb(_t('%d年', $year), WDCX_Util::urlFor('archive_year', array('year' => $year)));
                printArchiveBreadcrumb(_t('%d月', $month), WDCX_Util::urlFor('archive_month', array('year' => $year, 'month' => $month)));
                printArchiveBreadcrumb(_t('%d日', $day), NULL, TRUE);
                break;
        }
        break;
}
?>
        </ul>
        </nav>
    </div>
</div>
<?php
WDCX_Module::load('Single');
$post = new WDCX_Module_Single($this);
if ($this->have()) {
    while ($this->next()) 
    {
        $post->doOutput();
    }
} else {
    switch ($this->getArchiveType())
    {
        case 'category':
        case 'date':
        case 'author':
        case 'search':
        case 'tag':
            $title = _IcT('empty.' . $this->getArchiveType() . '.title');
            $desc = _IcT('empty.' . $this->getArchiveType() . '.desc');
            $jump = _IcT('empty.' . $this->getArchiveType() . '.jump');
            break;
        default:
            $title = _IcT('404.title');
            $desc = _IcT('404.desc');
            $jump = NULL;
            break;
    }
    switch ($this->getArchiveType())
    {
        case 'category':
            $jumpTarget = WDCX_Util::urlFor('page', array('slug' => 'categories'));
            break;
        case 'date':
            $jumpTarget = WDCX_Util::urlFor('page', array('slug' => 'archives'));
            break;
        case 'search':
            $jumpTarget = '#';
?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    (function ($) {
        $('#WDCX-jump-guide').click(function () {
            $('.searchbox').toggleClass('show');
        });
    })(jQuery);
});
</script>
<?php
            break;
        case 'tag':
            $jumpTarget = WDCX_Util::urlFor('page', array('slug' => 'tags'));
            break;
    }
?>
<div class="card">
    <div class="card-content">
        <p class="title has-text-weight-normal"><?php echo $title; ?></p>
        <p class="subtitle"><?php echo $desc; ?></p>
    </div>
    <div class="card-footer">
        <?php if (!empty($jump)): ?>
        <p class="card-footer-item">
            <span><a href="<?php echo $jumpTarget; ?>" id="WDCX-jump-guide"><?php echo $jump; ?></a></span>
        </p>
        <?php endif; ?>
        <p class="card-footer-item">
            <span><a href="<?php WDCX_Util::$options->index(); ?>">回到首页</a></span>
        </p>
    </div>
</div>
<?php
}

WDCX_Module::show('Paginator', $this);

$this->need('component/footer.php');

