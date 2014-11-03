<?php
$yiit = dirname(__FILE__) . '/../yii/framework/yiit.php';
$config = dirname(__FILE__) . '/config.php';

require_once($yiit);

Yii::createWebApplication($config);
