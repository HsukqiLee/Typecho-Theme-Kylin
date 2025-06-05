<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class WDCX_Ajax
{
    public static function handle()
    {
        $security = Helper::security();
        $request = Typecho_Request::getInstance();
        $notice = Typecho_Widget::widget('Widget_Notice');

        if ($request->isPost() && isset($request->WDCX_action))
        {
            ob_clean();
            $security->protect();

            switch ($request->WDCX_action)
            {
                case 'backup_save':
                    $result = WDCX_Backup::save();
                    $msgId = 'setting.backup.result.save';
                break;
                case 'backup_delete':
                    $result = WDCX_Backup::delete();
                    $msgId = 'setting.backup.result.delete';
                break;
                case 'backup_restore':
                    $result = WDCX_Backup::restore();
                    $msgId = 'setting.backup.result.restore';
                break;
                default:
                    $notice->set(_IcT($msgId), $result ? 'success' : 'error');
                    WDCX_Util::jsonResponse(array(
                        'action' => 'refresh'
                    ));
                    exit;
                break;
            }
            
            $notice->set(_IcT($msgId . '.' . $result), $result == 0 ? 'success' : 'error');
            WDCX_Util::jsonResponse(array(
                'action' => 'refresh'
            ));
            exit;
        }
    }
}
