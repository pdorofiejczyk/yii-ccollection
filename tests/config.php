<?php
return array(
    'name' => 'Test',
    'basePath' => dirname(__FILE__) . '/..',
    'components' => array(
        'fixture' => array(
            'class' => 'system.test.CDbFixtureManager',
        ),
    ),
);