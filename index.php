<?php
/**
 * A simple, delicate and modern theme, changed from Icarus theme of KeNorizon.
 * 
 * @package Kylin
 * @author HsukqiLee
 * @version 1.0.0
 * @link https://github.com/HsukqiLee/typecho-theme-kylin
 */


if (defined('__TYPECHO_ROOT_DIR__') === false) exit;

$this->need('component/header.php');

Icarus_Module::load('Single');
$post = new Icarus_Module_Single($this);
while ($this->next()) 
{
	$post->doOutput();
}

Icarus_Module::show('Paginator', $this);

$this->need('component/footer.php');
