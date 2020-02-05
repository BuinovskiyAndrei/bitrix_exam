<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arResult["LINK_CANONICAL"])){
    $APPLICATION->SetPageProperty('canonical', $arResult["LINK_CANONICAL"]);
}