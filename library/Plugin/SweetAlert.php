<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Plugin_SweetAlert
{
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'SweetAlert', Icarus_Plugin::ENABLE);
    }

    public static function header()
    {
        Icarus_Assets::cdn('css', 'sweetalert2', '11.10.7', 'sweetalert2.min.css');
?>
<style>
.colored-toast.swal2-icon-success {
  background-color: #a5dc86 !important;
}
.colored-toast.swal2-icon-error {
  background-color: #f27474 !important;
}
.colored-toast.swal2-icon-warning {
  background-color: #f8bb86 !important;
}
.colored-toast.swal2-icon-info {
  background-color: #3fc3ee !important;
}
.colored-toast.swal2-icon-question {
  background-color: #87adbd !important;
}
.colored-toast .swal2-title {
  color: white;
}
.colored-toast .swal2-close {
  color: white;
}
.colored-toast .swal2-html-container {
  color: white;
}
</style>
<?
    }

    public static function footer()
    {
        Icarus_Assets::cdn('js+defer', 'sweetalert2', '11.10.7', 'sweetalert2.min.js');
?>
<script defer>
var Toast;
window.addEventListener('load', () => {
    Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        iconColor: 'white',
        customClass: {
          popup: 'colored-toast',
        },
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });
});
</script>
<?php
        if (Icarus_Config::get('comments_type') == 'internal') {
            Icarus_Assets::printThemeJs('comment.js', TRUE, FALSE);
?>
<script defer>
var commentSuccessTitle = "<?php _IcTp('sweet_alert.comment_success_title') ?>";
var commentErrorTitle = "<?php _IcTp('sweet_alert.comment_error_title') ?>";
var commentSuccessMessage = "<?php _IcTp('sweet_alert.comment_success_message') ?>";
var commentFailedToFetchMessage = "<?php _IcTp('sweet_alert.comment_failed_to_fetch') ?>";
var commentFailedToSubmitMessage = "<?php _IcTp('sweet_alert.comment_failed_to_submit') ?>";

/*$(document).ready(function() {
    function serializeFormData(form) {
        return $(form).serialize().replace(/%20/g, '+');
    }
    function postComment(url, data, successCallback, errorCallback) {
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            },
            success: function(response) {
                successCallback(response);
            },
            error: function(xhr, status, error) {
                errorCallback(xhr, status, error);
            }
        });
    }
    function showSuccessModal(message) {
        Toast.fire({
            icon: 'success',
            title: commentSuccessTitle,
            text: message,
        });
    }
    function showErrorModal(message) {
        Toast.fire({
            icon: 'error',
            title: commentErrorTitle,
            text: message,
        });
    }
    $('#comment-form').submit(function(e) {
        e.preventDefault();
        var $form = $(this);
        var url = $form.attr('action');
        var formData = serializeFormData($form);
        postComment(url, formData,
        function(response) {
            handleCommentInsertion(response);
            resetTurnstile();
        },
        function(xhr, status, error) {
            showErrorModal(commentFailedToSubmitMessage);
            resetTurnstile();
        });
    });
    function getCommentParent() {
        var $input = $('input[type="hidden"][name="parent"][id="comment-parent"]');
        if ($input.length > 0) {
            var value = $input.val();
            var number = value.match(/\d+/)[0];
            return number
        }
        return false
    }
    function getNewestCommentHTML(response) {
        var regex = /<div class="media comment">[\s\S]*?id="comment-(\d+)"[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/g;
        var matches;
        var maxId = -1;
        var newestCommentHTML = '';
        while ((matches = regex.exec(response)) !== null) {
            var commentId = parseInt(matches[1]);
            if (commentId > maxId) {
                maxId = commentId;
                newestCommentHTML = matches[0];
            }
        }
        return newestCommentHTML;
    }
    function getCommentNum(response) {
        var $parsedHTML = $(response);
        var commentText = null;
        $parsedHTML.find('.tk-comments-count').each(function() {
            var $innerSpan = $(this).find('span');
            if ($innerSpan.length > 0) {
                var text = $innerSpan.text();
                commentText = text;
                return false;
            }
        });
        return commentText;
    }
    function getCommentChildren(responseHTML) {
        var response = new DOMParser().parseFromString(responseHTML, 'text/html');
        var comments = Array.from(response.querySelectorAll('[id^="comment-"]')).filter(comment => {
            return /^comment-\d+$/.test(comment.id);
        });
        var maxId = Math.max(...comments.map(comment => parseInt(comment.id.split('-')[1], 10)));
        var maxCommentElement = response.querySelector('#comment-' + maxId);
        if (maxCommentElement === null) {
            return false;
        }
        var maxComment = maxCommentElement.closest('.media.comment');
        if (maxComment) {
            return maxComment;
        }
        return false;
    }
    function handleCommentInsertion(responseHTML) {
        var commentParent = getCommentParent();
        var newCommentNum = getCommentNum(responseHTML);
        if (newCommentNum) {
            $('.tk-comments-count > span').text(newCommentNum);
        }
        if (commentParent) {
            commentChildren = getCommentChildren(responseHTML);
            if (commentChildren) {
                $('div#comment-' + commentParent + '>div.content').after('<div class="comment-children">' + commentChildren.outerHTML + '</div>');
                TypechoComment.cancelReply();
                resetCommentForm();
                showSuccessModal(commentSuccessMessage);
            }
            else {
                showErrorModal(commentFailedToFetchMessage);
            }
        }
        else {
            var newCommentHTML = getNewestCommentHTML(responseHTML);
            if (newCommentHTML) {
                $('.comment-list').prepend(newCommentHTML);
                resetCommentForm();
                showSuccessModal(commentSuccessMessage);
            } else {
                showErrorModal(commentFailedToFetchMessage);
            }
        }
    }
    function resetCommentForm() {
        $('#comment-form').find('textarea[name="text"]').val('');
        $('div.comment img.lazyload').lazyload();
        if (typeof moment === 'function') {
            $('.comment time').each(function() {
                var datetime = $(this).attr('datetime');
                $(this).text(moment(datetime).fromNow());
            });
        }
        
    }
    function resetTurnstile() {
        if (typeof window.onloadTurnstileCallback === 'function') {
            window.onloadTurnstileCallback();
        }
    }
});*/
</script>
<?php
        }
?>
<script defer>
$(".protected").submit(function() {
    var surl=$(".protected").attr("action");
    $.ajax({
        type: "POST",
        url:surl,
        data:$('.protected').serialize(),
        async:true,
        error: function(request) {
            if( (request.responseText.indexOf("密码错误") >= 0 || (request.responseText.indexOf("Sorry, the entered password is wrong.") >= 0) && request.status == 403)) {
                Toast.fire({
                    title: "<?php _IcTp('sweet_alert.wrong_password') ?>",
                    text: "<?php _IcTp('sweet_alert.please_check_again') ?>",
                    icon: "warning"
                });
            }else{
                Toast.fire({
                    title: "<?php _IcTp('sweet_alert.internet_error') ?>",
                    text: "<?php _IcTp('sweet_alert.please_refresh') ?>",
                    icon: "warning"
                });
            }
        },
        success: function(data) {
            location.reload();
        }
    });
return false;
});
</script>
<?php
    }
}
