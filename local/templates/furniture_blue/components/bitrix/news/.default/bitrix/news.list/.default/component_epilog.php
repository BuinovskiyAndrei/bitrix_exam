<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arResult["SPECIAL_DATE"])){
    $APPLICATION->SetPageProperty("specialdate", $arResult["SPECIAL_DATE"]);
}