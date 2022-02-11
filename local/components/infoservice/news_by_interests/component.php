<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;

if (!isset($arParams["CACHE_TIME"])) {
    $arParams["CACHE_TIME"] = 36000000;
}

if (!Loader::includeModule("iblock")) {
    ShowError(GetMessage("INFOSERVICE_NEWS_BY_INTERESTS_MODULE_NONE"));
    return;
}

global $USER;
$arResult["COUNT"] = 0;


if ($USER->IsAuthorized()) {
    $iCurUserId = $USER->GetId();

    
    $iCurUserType = \CUser::GetList(
        ($by = "id"),
        ($order = "asc"),
        ["ID" => $USER->GetId()],
        ["SELECT" => [$arParams["FIELD_AUTHOR_CODE"]]]
    )->Fetch()[$arParams["FIELD_AUTHOR_CODE"]];

    
    if ($this->startResultCache(false, $iCurUserType) && !empty($iCurUserType)) {
        
        $resUsers = \CUser::GetList(
            ($by = "id"),
            ($order = "desc"),
            [
                
                $arParams["FIELD_AUTHOR_CODE"] => $iCurUserType,
                
                "!ID"                          => $iCurUserId,
            ],
            ["SELECT" => ["LOGIN", "ID"]]
        );
        while ($arUser = $resUsers->Fetch()) {
            $arUserList[$arUser["ID"]] = ["LOGIN" => $arUser["LOGIN"]];
            $arUserIds[] = $arUser["ID"];
        }

        if (!empty($arUserIds)) {
            $arNewsList = [];

            
            $resNews = \CIBlockElement::GetList(
                [],
                [
                    "IBLOCK_ID"                                      => $arParams["NEWS_IBLOCK_ID"],
                
                    "!PROPERTY_" . $arParams["PROPERTY_AUTHOR_CODE"] => $iCurUserId,
                    "PROPERTY_" . $arParams["PROPERTY_AUTHOR_CODE"]  => $arUserIds,
                ],
                false,
                false,
                [
                    "NAME",
                    "ACTIVE_FROM",
                    "ID",
                    "IBLOCK_ID",
                    "PROPERTY_" . $arParams["PROPERTY_AUTHOR_CODE"]
                ]
            );

            while ($arNewsItem = $resNews->Fetch()) {
                
                $iAuthorId = $arNewsItem["PROPERTY_" . $arParams["PROPERTY_AUTHOR_CODE"] . "_VALUE"];
                $arUserList[$iAuthorId]["NEWS"][] = $arNewsItem;

                
                if (empty($arNewsList[$arNewsItem["ID"]])) {
                    $arNewsList[$arNewsItem["ID"]] = $arNewsItem;
                }
            };

            $iNewsCount = count($arNewsList);

            $arResult["AUTHORS"] = $arUserList;
            $arResult["COUNT"] = $iNewsCount;

            $this->SetResultCacheKeys(["COUNT"]);
            $this->IncludeComponentTemplate();
        }
    }

    
    $APPLICATION->SetTitle(GetMessage("COUNT_NEWS", ['#COUNT#' => $arResult["COUNT"]]));
}