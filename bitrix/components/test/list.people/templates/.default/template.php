<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

<div class="wrap">
  <form action="post" action="javascript:;" onsubmit="sendForm(this); return false;" id="upd_form" enctype="multipart/form-data">
    <input type="hidden" value="update" name="type">
    <table class="table-list-people">
      <tr class="tr-title">
        <th>Имя</th>
        <th>Дата рождения</th>
        <th>Средний балл</th>
				<th>Фото</th>
        <th>выбрать</th>
      </tr>
      <? foreach ($arResult['ITEMS'] as $key => $item): ?>
        <tr onclick="" class="item">
          <td>
            <span type="text" name="NAME[]"><?=$item['NAME']?></span>
          </td>
          <td>
            <span type="date" name="BIRTH_DAY[]"><?= date('d.m.Y', strtotime($item['BIRTH_DAY']))?></span>
          </td>
          <td>
            <span type="text" name="MIDDLE_SCORE[]"><?=$item['MIDDLE_SCORE']?></span>
          </td>
					<td>
						<span><img class="img" src="<?=$item['AVATAR']?>"/></span>
					</td>
          <td>
            <input type="checkbox" name="check[]" value="<?=$key?>" class="checkbox">
            <input type="hidden" value="<?=$key?>" class="checkbox" name="ID[]" />
          </td>
        </tr>
      <? endforeach; ?>
    </table>
  </form>

</div>
<? if ($USER->IsAdmin()): ?>
	<div class="admin-panel">
		<a href="javascript:;" class="but add">Добавить</a>
		<a href="javascript:;" class="but update">Изменить</a>
		<a href="javascript:;" class="but save">Сохранить</a>
		<a href="javascript:;" class="but delete">Удалить</a>
	</div>

	<div class="modal-wrap">
		<div class="modal-admin">
			<a href="javascript:;" class="close">x</a>
			<form method="post" action="javascript:;" onsubmit="sendForm(this); return false;" enctype="multipart/form-data">
				<label>Имя</label>
				<div class="input">
					<input type="text" name="NAME" id="name">
				</div>
				<label>Дата рождения</label>
				<div class="input">
					<input type="date" name="BIRTH_DAY" id="bithday">
				</div>
				<label>Средний балл</label>
				<div class="input">
					<input type="text" name="MIDDLE_SCORE" id="middel_score">
				</div>
				<label>Фото</label>
				<div class="input">
					<input type="file" name="FILE" id="file" class="attach_file">
				</div>
				<div class="input">
					<input type="submit" value="Отправить" class="but green">
				</div>
				<input type="hidden" name="type" id="type" value=""/>
			</form>
		</div>
	</div>

<? endif; ?>
