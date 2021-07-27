<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("список людей");

$APPLICATION->ShowPanel();

$APPLICATION->IncludeComponent(
	"test:list.people",
	".default",
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"CHECKBOX" => "Y"
	),
	false
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
