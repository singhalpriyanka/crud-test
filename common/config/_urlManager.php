<?php
return [
    'class'=>'yii\web\UrlManager',
    'showScriptName' => false,
            // Disable r= routes
    'enablePrettyUrl' => true,

    'rules' => array(
                    '<controller:\w+>/<id:\d+>'              => '<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
    )
];
