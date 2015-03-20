<a href="/post/create">Добавить запись</a>
<table class="table table-bordered">
<tr>
	<th>ID</th>
	<th>Название</th>
	<th>Текст</th>
	<th>Редактировать</th>
</tr>
<?
foreach($items as $item) {?>
	<tr>
		<td class="col-md-1"><?=$item->id?></td>
		<td class="col-md-4"><?=$item->name?></td>
		<td class="col-md-7"><?=$item->content?></td>
		<td class="col-md-7"><a href="/post/update/<?=$item->id?>" class="glyphicon glyphicon-pencil"></a></td>
	</tr>
<?};?>
</table>