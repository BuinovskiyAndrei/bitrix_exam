<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("MyClass", "OnBeforeIBlockElementUpdateHandler"));

class MyClass
{
    // создаем обработчик события "OnBeforeIBlockElementUpdate"
    function OnBeforeIBlockElementUpdateHandler(&$arFields){
        if($arFields['IBLOCK_ID'] == 2){
            $res = CIBlockElement::GetByID($arFields["ID"]);
            if($ar_res = $res->GetNext())
              $counter = $ar_res['SHOW_COUNTER'];
            if($counter > 2 && $arFields["ACTIVE"] == 'N'){
                global $APPLICATION;
                $APPLICATION->throwException("Товар невозможно деактивировать, у него ".$counter." просмотров");
                return false;
            }
        }
    }
}