<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Application,
	Bitrix\Main\Context,
		Bitrix\Main\Request,
		Bitrix\Main\Server,
		Bitrix\Main\Type\DateTime;

class ListPeople extends CBitrixComponent {

	/*
	get student`s data from table a students
	*/

	public function getDataTable() {

		$connection = \Bitrix\Main\Application::getConnection();
		$result = $connection->query('SELECT * FROM students ORDER BY id ASC');

		$arResult = [];

		while($ar=$result->fetch())
		{
			$arResult['ITEMS'][$ar['ID']]['NAME'] = $ar['FULL_NAME'];
			$arResult['ITEMS'][$ar['ID']]['BIRTH_DAY'] = $ar['DATE_BIRTH'];
			$arResult['ITEMS'][$ar['ID']]['MIDDLE_SCORE'] = $ar['MIDDLE_SCORE'];

			if (!empty($ar['AVATAR'])) {
				$image = imagecreatefromstring($ar['AVATAR']);
				ob_start();
				imagejpeg($image, null, 80);
				$prepData = ob_get_contents();
				ob_end_clean();

				$base64img = base64_encode($prepData);
				$arResult['ITEMS'][$ar['ID']]['AVATAR'] = "data:image/png;base64,".$base64img;
			} else {
				$arResult['ITEMS'][$ar['ID']]['AVATAR'] = "/upload/user_avatar.png";
			}

		}

		return $arResult;
	}

	public function add($post, $files) {
		$name = $this->prepareInput($post['NAME']);
		$birth = $this->prepareInput($post['BIRTH_DAY']);
		$birth = date("Y-m-d H:i:s", strtotime($birth));
		$score = (float) $this->prepareInput($post['MIDDLE_SCORE']);
		$image =  addslashes(file_get_contents($files['FILE']['tmp_name']));

		$connection = \Bitrix\Main\Application::getConnection();
		$result = $connection->queryExecute("INSERT INTO students  (FULL_NAME, DATE_BIRTH, MIDDLE_SCORE, AVATAR) VALUES ('$name', '$birth', '$score', '$image')");

		Event::send(array(
		  "EVENT_NAME" => "ADD_STUDENT",
		  "LID" => "s1",
			"MESSAGE_ID" => 33,
		  "C_FIELDS" => array(
		    "NAME" => $name
		  ),
		));
	}

	public function update($post, $files) {

		$connection = \Bitrix\Main\Application::getConnection();
		foreach ($post['NAME'] as $key => $value) {
			$name = $this->prepareInput($post['NAME'][$key]);
			$birth_day = $this->prepareInput($post['BIRTH_DAY'][$key]);
			$birth_day = date("Y-m-d H:i:s", strtotime($birth_day));
			$middle_score = $this->prepareInput($post['MIDDLE_SCORE'][$key]);
			$id = $this->prepareInput($post['ID'][$key]);
			$image =  addslashes(file_get_contents($files['FILE']['tmp_name'][$key]));
			$query = "UPDATE students SET
									FULL_NAME = '$name',
									DATE_BIRTH = '$birth_day',
									MIDDLE_SCORE = '$middle_score',
									AVATAR = '$image' WHERE ID = '$id'";

									$result = $connection->query($query);
		}
	}

	public function delete($post) {
		$connection = \Bitrix\Main\Application::getConnection();
		$result = $connection->queryExecute("DELETE FROM students WHERE id in ($post)");
	}

	public function prepareInput($input){
		return htmlspecialchars(trim($input));
	}

}
