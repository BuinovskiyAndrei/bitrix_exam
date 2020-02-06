<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeModuleLangFile(__FILE__);

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

AddEventHandler('main', 'OnBeforeEventAdd', Array("MyForm", "my_OnBeforeEventSend"));
class MyForm
{
   function my_OnBeforeEventSend(&$event, &$lid, &$arFields)
   {
        if($event == "FEEDBACK_FORM"){
            global $USER;
            if($USER->IsAuthorized()){
               $arFields['AUTHOR'] = GetMessage('AUTHORISE',array("#ID#"=>$USER->GetID(),"#LOGIN#"=>$USER->GetLogin(),"#FULLNAME#"=>$USER->GetFullName(),"#NAME#"=>$arFields['AUTHOR'])); 
            }else{
                $arFields['AUTHOR'] = GetMessage('NOT_AUTHORISE',array("#NAME#"=>$arFields['AUTHOR']));
            }
            
            CEventLog::Add(array(
                "SEVERITY" => "INFO",
                "AUDIT_TYPE_ID" => "CEVENTADD",
                "MODULE_ID" => "main",
                "DESCRIPTION" => GetMessage('LOG_DESCRIPTION',array("#AUTHOR#"=>$arFields['AUTHOR'])),
            ));
       }
   }
}
