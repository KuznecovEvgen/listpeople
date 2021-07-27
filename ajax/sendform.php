<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/components/test/list.people/class/main_class.php');
$listPeople = new ListPeople;

$type = $_REQUEST['type'];
$post = $_REQUEST;
$files = $_FILES;

switch ($type) {
	case 'add':
		$result = $listPeople->add($post, $files);
		break;

		case 'update':
		$result = $listPeople->update($post, $files);
		break;

	case 'delete':
		$elems = $post['elem'];
		$result = $listPeople->delete($elems);
		break;
}
