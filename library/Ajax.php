<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;

class Icarus_Ajax
{
    public static function handle()
    {
        $security = Helper::security();
        $request = Typecho_Request::getInstance();
        $notice = Typecho_Widget::widget('Widget_Notice');

        if ($request->isPost() && isset($request->icarus_action))
        {
            ob_clean();
            $security->protect();

            $notice->set(_IcT($msgId), $result ? 'success' : 'error');
            Icarus_Util::jsonResponse(array(
                'action' => 'refresh'
            ));
            exit;
            
            $notice->set(_IcT($msgId . '.' . $result), $result == 0 ? 'success' : 'error');
            Icarus_Util::jsonResponse(array(
                'action' => 'refresh'
            ));
            exit;
        }
    }
}
