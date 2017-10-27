<?php

return [
    '<folder:\w+>/<parentRelation:\d+>/<controller:\w+>/<action:\w+>' => '<folder>-<controller>/<action>',
    '<folder:\w+>/<parentRelation:\d+>/<controller:\w+>' => '<folder>-<controller>/index',

    '<controller:\w+>/<id:\d+>' => '<controller>/update',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    '<controller:\w+>' => '<controller>/index',
];
