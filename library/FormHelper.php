<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;

use Typecho\Widget\Helper\Form\Element;
use Typecho\Widget\Helper\Layout;

class Icarus_Form_Element_Text extends Typecho\Widget\Helper\Form\Element\Text
{
    public function value($value):Element
    {
        if (!is_null($value))
            return parent::value($value);
        else
            return $this;
    }
}

class Icarus_Form_Element_Textarea extends Typecho\Widget\Helper\Form\Element\Textarea
{
    public function value($value):Element
    {
        if (!is_null($value))
            return parent::value($value);
        else
            return $this;
    }
}

class Icarus_Form_Element_Radio extends Typecho\Widget\Helper\Form\Element\Radio
{
    public function value($value):Element
    {
        if (!is_null($value))
            return parent::value($value);
        else
            return $this;
    }
}

class Icarus_Form_Element_Checkbox extends Typecho\Widget\Helper\Form\Element\Checkbox
{
}

class Icarus_Form_VersionField extends Typecho\Widget\Helper\Form\Element\Hidden
{
    public function __construct()
    {
        parent::__construct(Icarus_Config::prefixKey('config_version'), NULL, __ICARUS_CFG_VERSION__);
    }

    public function value($value):Element
    {
        return parent::value(__ICARUS_CFG_VERSION__);
    }
}