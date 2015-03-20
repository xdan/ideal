<form action="/post/<?=App::gi()->uri->action?>" method="post">
  <div class="form-group">
    <label for="name">Название</label>
    <input type="text" class="form-control" id="name" name="form[name]" placeholder="Введите название поста" value="<?=htmlspecialchars($item->name)?>">
  </div>
  <div class="form-group">
    <label for="content">Текст</label>
    <textarea type="password" class="form-control" name="form[content]" id="content"><?=htmlspecialchars($item->content)?></textarea>
  </div>
  <input type="hidden" name="form[id]" value="<?=intval($item->id)?>">
  <button type="submit" class="btn btn-default"><?=($item->id ? 'Сохранить' : 'Создать')?></button>
</form>