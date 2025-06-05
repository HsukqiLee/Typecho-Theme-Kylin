<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html <?php WDCX_Page::printHtmlLang(); ?>>
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php WDCX_Page::printPageTitle(); ?></title>
    
    <?php 
    WDCX_Assets::cdn('css', 'bulma', '0.7.2', 'css/bulma.css');
    WDCX_Assets::cdn('css', 'icon');
    WDCX_Assets::cdn('css', 'font', 'Ubuntu:400,600|Source+Code+Pro');
    
    WDCX_Plugin::headerAll();
    
    WDCX_Assets::printThemeCss('style.css');
    
    $this->header(); 
    WDCX_Page::printHeader();
    ?>
</head>
<body class="<?php WDCX_Page::printBodyColumnClass(); ?>">
    <?php WDCX_Module::show('Navbar'); ?>
    <div class="section">
        <div class="container">
            <div class="columns">
                <main class="column <?php WDCX_Page::printContainerColumnClass(); ?> has-order-2 column-main">
    
