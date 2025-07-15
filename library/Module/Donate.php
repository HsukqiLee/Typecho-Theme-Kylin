<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;
class Icarus_Module_Donate
{
    public static function config($form)
    {
        $form->packTitle('Donate');

        $form->packTextarea('Donate/buttons', "type=wechat,image=https://example.com/weixin.jpg\ntype=afdian,image=https://example.com/afdian.jpg,url=https://afdian.com\ntype=paypal,business=paypal@paypal.com,currency=USD");
    }
    
    private static function getButtons()
    {
        return Icarus_Config::get('donate_buttons');
    }
    
    public static function output()
    {
        $buttons=explode(PHP_EOL,self::getButtons());
        if(empty(self::getButtons())) return;
        $font_awesome=array(
            'qq' => 'fab fa-qq',
            'wechat' => 'fab fa-weixin',
            'alipay' => 'fab fa-alipay',
            'afdian' => 'fas fa-charging-station',
            'paypal' => 'fab fa-paypal',
            'buymeacoffee' => 'fas fa-coffee',
        );
        foreach ($buttons as &$line)
        {
            $param=explode(',',$line);
            $line=array();
            foreach ($param as $obj)
            {
                $obj_list=explode('=',$obj);
                $line[$obj_list[0]]=$obj_list[1];
            }
        }
        
?>
        <div class="card">
            <div class="card-content">
                <h3 class="menu-label has-text-centered"><?php _IcTp('donate.words'); ?></h3>
                <div class="buttons is-centered" data-no-instant>
                <?php
                    foreach ($buttons as $arr)
                    {
                        if($arr['type']=='paypal') {
                ?>
                    <a class="button donate" data-type="paypal" onclick="document.getElementById('paypal-donate-form').submit()"><span class="icon is-small"><i class="fab fa-paypal"></i></span><span>Paypal</span></a><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" rel="noopener" id="paypal-donate-form"><input type="hidden" name="cmd" value="_donations"><input type="hidden" name="business" value="<?php echo $arr['business']; ?>"><input type="hidden" name="currency_code" value="<?php echo $arr['currency']; ?>"></form>
                <?php
                       }
                       else {
                ?>
                <a class="button donate" <?php echo ((isset($arr['url']))?'href="'.$arr['url'].'" target="_blank" rel="noopener"':''); ?> data-type="<?php echo $arr['type']; ?>">
                    <span class="icon is-small">
                        <i class="<?php echo $font_awesome[$arr['type']]; ?>"></i>
                    </span>
                    <span><?php _IcTp('donate.buttons.'.$arr['type']); ?></span>
                    <?php echo (isset($arr['image'])?'<span class="qrcode"><img class="lazyload" src="'./*Icarus_Assets::getUrlForAssets('/img/default.png').'" data-original="'.*/$arr['image'].'" title="'. _IcT('donate.buttons.'.$arr['type']). '"></span>':''); ?>
                </a>
                <?php
                        }
                    }
?>
            </div>
        </div>
    </div>
<?php
    }
}