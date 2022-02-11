<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$arComponentDescription = [
    
    "NAME"        => GetMessage('INFOSERVICE_NEWS_BY_INTERESTS_NAME'),
    
    "DESCRIPTION" => GetMessage('INFOSERVICE_NEWS_BY_INTERESTS_NAME'),
    "CACHE_PATH"  => "Y",
    "SORT"        => 1,
    "PATH"        => [
    
        "ID"   => GetMessage('INFOSERVICE_NEWS_BY_INTERESTS_PATH_NAME'),
    
        "NAME" => GetMessage('INFOSERVICE_NEWS_BY_INTERESTS_PATH_NAME'),
    ],
];
?>