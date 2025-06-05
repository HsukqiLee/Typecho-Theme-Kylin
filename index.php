<?php
/**
 * Port of Ruipeng Zhang's Hexo theme WDCX to Typecho.
 * 
 * @package WDCX
 * @author Ruipeng Zhang & KeNorizon
 * @version 1.1.4
 * @link https://github.com/KeNorizon/typecho-theme-WDCX
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('component/header.php');

WDCX_Module::load('Single');
$post = new WDCX_Module_Single($this);
while ($this->next()) 
{
	$post->doOutput();
}

WDCX_Module::show('Paginator', $this);

$this->need('component/footer.php');
