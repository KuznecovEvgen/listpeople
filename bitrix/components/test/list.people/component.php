<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/components/test/list.people/class/main_class.php');

if ($arParams["CHECKBOX"] == "Y") {
  CJSCore::Init(array("jquery"));
}

$component = new ListPeople;
$items = $component->getDataTable();

if ($items['ITEMS']) {
  $arResult = $items;
}

$this->IncludeComponentTemplate();

?>
