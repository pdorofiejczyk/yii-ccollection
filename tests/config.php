<?php
return array(
    'name' => 'Test',
    'basePath' => dirname(__FILE__) . '/..',
    'components' => array(
        'db'=>array(
            'connectionString'=>'sqlite:../yii/demos/blog/protected/data/blog.db',
            'tablePrefix'=>'tbl_',
        ),
        'fixture' => array(
            'class' => 'system.test.CDbFixtureManager',
        ),
    ),
);