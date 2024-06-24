<? 
   include ('../config.php');
  // Стартовая точка
  $start = $HTTP_GET_VARS["start"];
  if (empty($start)) $start = 0;
  if ($start < 0) $start = 0;
  // Запрашиваем общее число сообщений
  $tot = mysql_query("SELECT count(*) FROM orders;");
  // Запрашиваем сами сообщения
  $ords = mysql_query("SELECT * FROM orders ORDER BY puttime DESC LIMIT $start, $pnumber;");
  if (!$ords || !$tot) puterror("Ошибка при обращении к системе администрирования");
  //include ('../../orders/top.php');
  ?>
   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Форд прокат</title>
<link rel="icon" href="http://www.ford-rent.ru/favicon.ico" 
type="image/x-icon" />
<link rel="shortcut icon" href="http://www.ford-rent.ru/files/favicon.ico"
type="image/x-icon" />
<link href="../../css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="wrap">
 <div class="main" id="admin">
  <div class="header">
   <div class="logo"><a href="../../index.html"><img src="../../images/logo.jpg" title="На главную" alt="Форд прокат" width="304" height="80" /></a></div>
   <p>администрирование</p>
  </div>
 </div>
   <div class="content">
<?  
  // При помощи цикла выбираем из базы данных
  // сообщения
  while($orders = mysql_fetch_array($ords))
  {
    // Выводим таблицу с сообщением
    echo "<table border='0' class='admin_tab'><tbody>";
    echo "<tr><th width='250px'>Заказ ".$orders['id_order']." от ".$orders['puttime']."</th><th>".$orders['fio']."</th></tr>";
	echo "<tr><td>Дата рождения:</td><td>".$orders['birthday']."</td></tr>";
    echo "<tr><td>Мобильный телефон:</td><td>".$orders['mphone']."</td></tr>";
    if ($orders['email']) { echo "<tr><td>Электронная почта:</td><td>".$orders['email']."</td></tr>"; }
    echo "<tr> <td>Дата начала проката:</td><td>".$orders['startday']."</td></tr>";
    echo "<tr><td>Дата окончания проката:</td><td>".$orders['stopday']."</td></tr>";
    echo "<tr><td>Машина:</td><td>".$orders['model']."</td></tr>";
    if ( $orders['pas_num']) { echo "<tr><td>Паспорт:</td><td>".$orders['pas_num']."</td></tr>"; }
    if ( $orders['pas_adr']) { echo "<tr> <td>Адрес прописки:</td><td>".$orders['pas_adr']."</td></tr>"; }
    if ( $orders['real_adr']) { echo "<tr><td>Адрес проживания:</td><td>".$orders['pas_adr']."</td></tr>"; }
    if ( $orders['vod_num']) { echo "<tr><td>Вод.удостоверение:</td><td>".$orders['vod_num']."</td></tr>"; }
    echo "<tr><td>Подача автомобиля:</td><td>".$orders['giving']."</td></tr>";
    if ( $orders['text']) { echo "<tr><td>Дополнительно:</td><td>".$orders['text']."</td></tr>"; }
    echo "</tbody></table>";
	// Ссылка на удаление сообщений
    echo "<p><a href=delorder.php?id_order=".$orders['id_order']."&start=$start title=' ' title='Удалить заявку'>Удалить заявку</a></p>";
   }?>
  <div class="clear"></div>
  <?
  // Выводим ссылки на предыдущие и следующие сообщения
  $total = mysql_fetch_array($tot);
  $count = $total['count(*)'];
  if ($start > 0)  print " <p><A class='silka' href=admin_page.php?start=".($start - $pnumber).">Следующие заявки</A> ";
  if ($count > $start + $pnumber)  print " <p><A class='silka' href=admin_page.php?start=".($start + $pnumber).">Предыдущие заявки</A> \n";
  ?>
 </div>
</div>
<!--- end wrap --->
<div class="footer_body">
 <div class="footer">
  <p class="left_p"><br />
&copy; 2013 &laquo;Форд прокат&raquo;</p>
 <p class="right_p"><br />
        <a href="#">Главная</a> / <a href="#">Услуги</a> / <a href="#">Тарифы</a> / <a href="#">Условия</a> / <a href="#">Автомобили</a> / <a href="#">Заказ On-line</a> / <a href="#">Контактная информация</a><br />
        </p>
 </div>
</div>
</body>
</html>