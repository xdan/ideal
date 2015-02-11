<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="<?=app::gi()->config->encode?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title><?=app::gi()->config->sitename?></title>
	<link rel="icon" href="/assets/images/favicon.ico">
</head>
<body>

    <div class="blog-masthead">
      <div class="container">
        <nav class="blog-nav">
          <a class="blog-nav-item <?=app::gi()->uri->controller=='index' ? 'active' :''?>" href="/">Главная</a>
          <a class="blog-nav-item <?=app::gi()->uri->controller=='user' ? 'active' :''?>" href="/user/">Войти</a>
          <a class="blog-nav-item <?=app::gi()->uri->controller=='page' ? 'active' :''?>" href="/about.html">О фреймворке</a>
        </nav>
      </div>
    </div>

    <div class="container">
      <div class="row" style="margin-top:20px;">
        <div class="col-sm-7 blog-main" >
			<?=$content?>
        </div><!-- /.blog-main -->
        <div class="col-sm-4 col-sm-offset-1 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
            <h4>О проекте</h4>
            <p><strong>IDeal framework</strong> (идеальный фреймворк)
			это не заявка на качество. Это лишь означает, что он будет полностю вашим и вы будете знать его устройство.</p>
          </div>
          <div class="sidebar-module">
            <h4>Статьи про фреймворк</h4>
            <ol class="list-unstyled">
              <li><a href="http://xdan.ru/how-to-create-framework-on-php.html">Как написать свой фреймворк на php</a></li>
              <li><a href="http://xdan.ru/kak-napisat-svoj-frejmvork-na-php-chast-2.html">Как написать свой фреймворк на php ч.2</a></li>
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>Наши контакты</h4>
            <ol class="list-unstyled">
              <li><a href="https://github.com/xdan/ideal">GitHub</a></li>
              <li><a href="https://twitter.com/xdanru">Twitter</a></li>
            </ol>
          </div>
        </div><!-- /.blog-sidebar -->
      </div><!-- /.row -->
    </div><!-- /.container -->
    <footer class="blog-footer">
		<p><a href="#">Наверх</a></p>
    </footer>
	<?
	$this->addStyleSheet('/assets/css/blog.css','body');
	?>
  </body>
</html>
