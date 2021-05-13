<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

// Формирование массива параметров
$arComponentParameters = [
    'GROUPS' => [],

    'PARAMETERS' => [

        'DOCS_TABLE_NAME' => [
            'PARENT' => 'BASE',
            'NAME' => GetMessage('DOCS_TABLE_NAME'),
            'TYPE' => 'STRING',
            'DEFAULT' => ''
        ],

        'COMPANIES_TABLE_NAME' => [
            'PARENT' => 'BASE',
            'NAME' => GetMessage('COMPANIES_TABLE_NAME'),
            'TYPE' => 'STRING',
            'DEFAULT' => ''
        ],

    ],
];