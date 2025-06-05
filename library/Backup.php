<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class WDCX_Backup
{
    const THEME_BACKUP_FIELD = 'theme:WDCX:backup';

    public static function exist()
    {
        return !is_null(WDCX_Util::$options->__get(self::THEME_BACKUP_FIELD));
    }

    protected static function getCurrentSerializedConfig()
    {
        return WDCX_Util::$options->__get('theme:' . WDCX_Util::$options->theme);
    }

    public static function save()
    {
        $db = Typecho_Db::get();

        if (self::exist()) {
            $sql = $db->update('table.options')
                ->where('name = ?', self::THEME_BACKUP_FIELD)
                ->rows(array(
                    'value' => self::getCurrentSerializedConfig()
                ));
        } else {
            $sql = $db->insert('table.options')
                ->rows(array(
                    'name'  =>  self::THEME_BACKUP_FIELD,
                    'value' =>  self::getCurrentSerializedConfig(),
                    'user'  =>  0
                ));
        }

        try {
            $db->query($sql);
        } catch (Typecho_Db_Query_Exception $exception) {
            return 1;
        }
        return 0;
    }

    public static function delete()
    {
        $db = Typecho_Db::get();

        if (self::exist()) {
            $sql = $db->delete('table.options')
                ->where('name = ?', self::THEME_BACKUP_FIELD);
        } else {
            return 1;
        }

        try {
            if ($db->query($sql) > 0) {
                return 0;
            } else {
                return 1;
            }
        } catch (Typecho_Db_Query_Exception $exception) {
            return 2;
        }
    }

    public static function restore()
    { 
        $db = Typecho_Db::get();
        
        if (self::exist()) {
            $sql = $db->update('table.options')
                ->where('name = ?', 'theme:' . WDCX_Util::$options->theme)
                ->rows(array(
                    'value' => WDCX_Util::$options->__get(self::THEME_BACKUP_FIELD)
                ));
        } else {
            return 1;
        }

        try {
            $db->query($sql);
        } catch (Typecho_Db_Query_Exception $exception) {
            return 2;
        }
        return 0;
    }
}
