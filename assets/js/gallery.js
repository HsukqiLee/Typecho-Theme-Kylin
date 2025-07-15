setTimeout(
function() {
    if (typeof ($.fn.lightGallery) === 'function') {
        $('.article').lightGallery({ selector: '.gallery-item' });
    }
    if (typeof ($.fn.justifiedGallery) === 'function') {
        $('.justified-gallery').justifiedGallery();
    }
    $(document).find('img[data-original]').each(function(){
        $(this).parent().attr("href", $(this).attr("data-original"));
    });
},
300);