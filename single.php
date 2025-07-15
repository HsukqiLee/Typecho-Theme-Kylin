<?php

if (defined('__TYPECHO_ROOT_DIR__') === false) exit;

$this->need('component/header.php');

Icarus_Module::show('Single', $this);

$this->need('component/footer.php');
