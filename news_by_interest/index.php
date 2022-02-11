<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

?><?$APPLICATION->IncludeComponent(
	"infoservice:news_by_interests", 
	"", 
	array(
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"FIELD_AUTHOR_CODE" => "UF_AUTHOR_TYPE",
		"NEWS_IBLOCK_ID" => "14",
		"PROPERTY_AUTHOR_CODE" => "AUTHOR_CODE",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false
);?><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>