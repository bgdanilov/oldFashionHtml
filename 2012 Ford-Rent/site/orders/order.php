<? session_start();
$captcha_check = 0;
if ($_POST['random_string'] == $_SESSION['random_string']) {
$captcha_check = 1;
unset($_SESSION['random_string']);
}
$sid_add_theme = session_id();
// Устанавливаем соединение с базой данных
include ('../admin/config.php');
$error = "";
$action = "";
// Возвращаем значение переменной action, переданной в урле
$action = $HTTP_POST_VARS["action"];
// Если оно не пусто - добавляем сообщение в базу данных
if (!empty($action)) 
{
  // Проверяем совпадает ли идентификатор сессии с
  // переданным в форме - защита а авто-постинга
  if($sid_add_theme != $HTTP_POST_VARS['sid_add_theme'])
  {
    $action = ""; 
    $err_cap = "";
	$err_fio = "";
	$err_birthday = "";
	$err_email = "";
	$err_mphone = "";
	$err_startday = "";
	$err_stopday = "";
  }
 // Проверяем правильность ввода информации в поля формы
  if ($captcha_check == 0)  
  {
    $action = "";
	$error = "1";
    $err_cap = $err_cap."<br /><span class='red'>Защита от спама</span><br /><br />";
  }
  if (empty($HTTP_POST_VARS["fio"])) 
  {
    $action = ""; 
	$error = "1";
    $err_fio = $err_fio."<br /><span class='red'>Пожалуйста, заполните поле</span><br /><br />";
  }
  if (empty($HTTP_POST_VARS["birthday"])) 
  {
    $action = "";
	$error = "1";
    $err_birthday = $err_birthday."<br /><span class='red'>Пожалуйста, заполните поле</span><br /><br />";
  }
  if (empty($HTTP_POST_VARS["mphone"])) 
  {
    $action = "";
	$error = "1";
    $err_mphone = $err_mphone."<br /><span class='red'>Пожалуйста, заполните поле</span><br /><br />";
  }
  if (empty($HTTP_POST_VARS["startday"])) 
  {
    $action = "";
	$error = "1";
    $err_startday = $err_startday."<br /><span class='red'>Пожалуйста, заполните поле</span><br /><br />";
  }
  if (empty($HTTP_POST_VARS["stopday"])) 
  {
    $action = "";
	$error = "1";
    $err_stopday = $err_stopday."<br /><span class='red'>Пожалуйста, заполните поле</span><br /><br />";
  }
// При помощи регулярных выражений проверяем правильность ввода e-mail
  if(!empty($HTTP_POST_VARS["email"]))
  {
    if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $HTTP_POST_VARS["email"]))
    {
      $action = "";
	  $error = "1";
      $err_email = $err_email."<br /><span class='red'>Пожалуйста, введите правильный адрес</span><br /><br />";
    }
  }
// Ограничиваем объём сообщения
  $fio = substr($HTTP_POST_VARS["fio"],0,80);
  $fio = htmlspecialchars(stripslashes($fio));
  $birthday = substr($HTTP_POST_VARS["birthday"],0,32);
  $birthday = htmlspecialchars(stripslashes($birthday));
  $mphone = substr($HTTP_POST_VARS["mphone"],0,32);
  $mphone = htmlspecialchars(stripslashes($mphone));
  $email = substr($HTTP_POST_VARS["email"],0,32);
  $email = htmlspecialchars(stripslashes($email));
  $startday = substr($HTTP_POST_VARS["startday"],0,32);
  $startday = htmlspecialchars(stripslashes($startday));
  $stopday = substr($HTTP_POST_VARS["stopday"],0,32);
  $stopday = htmlspecialchars(stripslashes($stopday));
  $pas_num = substr($HTTP_POST_VARS["pas_num"],0,80);
  $pas_num = htmlspecialchars(stripslashes($pas_num));
  $pas_give = substr($HTTP_POST_VARS["pas_give"],0,80);
  $pas_give = htmlspecialchars(stripslashes($pas_give));
  $pas_adr = substr($HTTP_POST_VARS["pas_adr"],0,80);
  $pas_adr = htmlspecialchars(stripslashes($pas_adr));
  $real_adr = substr($HTTP_POST_VARS["real_adr"],0,80);
  $real_adr = htmlspecialchars(stripslashes($real_adr));
  $vod_num = substr($HTTP_POST_VARS["vod_num"],0,80);
  $vod_num = htmlspecialchars(stripslashes($vod_num));
  $vod_give = substr($HTTP_POST_VARS["vod_give"],0,80);
  $vod_give = htmlspecialchars(stripslashes($vod_give));
  $text = substr($HTTP_POST_VARS["text"],0,1024);
  $text = htmlspecialchars(stripslashes($text));
  
// Пытаемся вырезать мат, насколько это возможно ;-)
  $search_bad_words = array("'хуй'si","'пизд'si","'ёб'si",
                          "'сука'si","'суки'si","'дроч'si","'хуя'si","'ссуч'si");
  $replace = array("*","*","*","*","*","*","*","*");
  $text = preg_replace($search_bad_words,$replace,$text);
  $fio = preg_replace($search_bad_words,$replace,$fio);
  $birthday = preg_replace($search_bad_words,$replace,$birthday);
  $mphone = preg_replace($search_bad_words,$replace,$mphone);
  $startday = preg_replace($search_bad_words,$replace,$startday);
  $stopday = preg_replace($search_bad_words,$replace,$stopday);
  $pas_num = preg_replace($search_bad_words,$replace,$pas_num);
  $pas_give = preg_replace($search_bad_words,$replace,$pas_give);
  $pas_adr = preg_replace($search_bad_words,$replace,$pas_adr);
  $real_adr = preg_replace($search_bad_words,$replace,$real_adr);
  $vod_num = preg_replace($search_bad_words,$replace,$vod_num);
  $vod_give = preg_replace($search_bad_words,$replace,$vod_give);
 
if (empty($error)) 
  {
    $text = str_replace("\n"," ",$text);
    $text = str_replace("\r"," ",$text);
    // Заменяем все одинарные кавычки обратными
    // защита от инъекционных запросов
    $fio = str_replace("'","`",$fio);
    $birthday = str_replace("'","`",$birthday);
    $mphone = str_replace("'","`",$mphone);
    $email = str_replace("'","`",$email);
    $startday = str_replace("'","`",$startday);
	$stopday = str_replace("'","`",$stopday);
	$pas_num = str_replace("'","`",$pas_num);
	$pas_give = str_replace("'","`",$pas_give);
	$pas_adr = str_replace("'","`",$pas_adr);
	$real_adr = str_replace("'","`",$real_adr);
	$vod_num = str_replace("'","`",$vod_num);
	$vod_give = str_replace("'","`",$vod_give);
    $text = str_replace("'","`",$text);

// Запрос к базе данных на добавление сообщения
    $query = "INSERT INTO orders VALUES (0,
										 NOW(),
                                        '$fio',
                                        '$birthday',
                                        '$mphone',
                                        '$email',
                                        '$startday',
                                        '$stopday',
                                        '$HTTP_POST_VARS[model]',
										'$pas_num',
										'$pas_give',
										'$pas_adr',
										'$real_adr',
										'$vod_num',
										'$vod_give',
                                        '$HTTP_POST_VARS[giving]',
                                        '$text'
                                        );";

if(mysql_query($query))
    {
      // Если в конфигурационном файле $sendmail = true отправляем уведомление
      if($sendmail)
      {
        $thm = "$fio";
        $over = "from $startday to $stopday $mphone";
        mail($valmail, $thm, $over, "From: zakaz@ford-rent.ru");
      }
     // Показываем, что все удачно.
     include ('top.php');
	 print "<div class='content'><h2>Ваш заказ принят!</h2><div class='left_col_half' style='padding: 0px 0px 0px 20px; width: 408px;'>";
     print "<h4>$fio</h4>";
	 print "<p>Дата рождения:&nbsp;<i>$birthday</i></p>";
	 print "<p>Мобильный телефон:&nbsp;<i>$mphone</i></p>";
	 if (!empty($email)) {print "<p>Электронная почта:&nbsp;<i>$email</i></p>";}
	 print "<p>Дата начала проката:&nbsp;<i>$startday</i></p>";
	 print "<p>Дата окончания проката:&nbsp;<i>$stopday</i></p>";
	 //print "<p>Машина:&nbsp;<i>$HTTP_POST_VARS[model]</i></p>";
         print "<p>Подача автомобиля:&nbsp;<i>$HTTP_POST_VARS[giving]</i></p>";
         if (!empty($pas_num)) 
	  {
	   print "<h4>Паспортные данные</h4>";
	   print "<p>Серия и номер:&nbsp;<i>$pas_num</i></p>";
	   if (!empty($pas_give)) {print "<p>Выдан:&nbsp;<i>$pas_give</i></p>";}
	   if (!empty($pas_adr)) {print "<p>Адрес прописки:&nbsp;<i>$pas_adr</i></p>";}
	   if (!empty($real_adr)) {print "<p>Адрес проживания:&nbsp;<i>$real_adr</i></p>";}
	  }
         print "</div><div class='right_col_half'>";
	 if (!empty($vod_num)) 
	  {
	   print "<h4>Водительское удостоверение</h4>";
	   print "<p>Серия и номер:&nbsp;<i>$vod_num</i></p>";
	   if (!empty($vod_give)) {print "<p>Выдано:&nbsp;<i>$vod_give</i></p>";}
	  }
	 if (!empty($text)) {print "<h4>Дополнительно:</h4><p><i>$text</i></p>";}
	 
     print "</div><div class='clear'></div></div>";
	 include ('bottom.php');
     exit();
	 
	 if (!empty($err_fio)) {print "class=alert";}
	 
	 
    }
    else
    {
      // Выводим сообщение об ошибке в случае неудачи
      print "<DIV align=center>";
      print "<P class=zag>Ошибка при добавлении сообщения</P>";
      print "<BR><BR>";
      print "<P class=field><A class=silka href='addrec.php'>Повторить</A></P>";
      print "<P class=field> $query</P>";
      print "</DIV>";
      exit();
    }
  }
}
if (empty($action)) 
{
 include ('top.php'); ?>
 <div class="content">
    <h1>Просто заполните форму!</h1>
   <form style="padding: 0px 0px 0px 20px" action=order.php method=post>
   <INPUT type=hidden name=sid_add_theme value='<?php echo $sid_add_theme; ?>'>
   <INPUT type=hidden name=action value=post>
   <p>* &mdash; обязательные для заполнения поля</p>
   <h4>Основное</h4>
   <table class="form" cellpadding="0" cellspacing="0">
   <tr>
    <td width="200px"><p>Фамилия, имя, отчество:*</p></td>
    <td><INPUT type=text <? if (!empty($err_fio)) {print "class=alert";}?> name=fio maxlength=80 size=80 value='<? echo $fio; ?>'><? if (!empty($err_fio)) {print $err_fio;}?></td>
   </tr>
   <tr>
    <td width="200px"><p>Дата рождения:*</p></td>
    <td><INPUT type=text <? if (!empty($err_birthday)) {print "class=alert";}?> name=birthday maxlength=32 size=40 value='<? echo $birthday; ?>'><? if (!empty($err_birthday)) {print $err_birthday;}?></td>
   </tr>
   <tr>
    <td width="200px"><p>Мобильный телефон:*</p></td>
    <td><INPUT type=text <? if (!empty($err_mphone)) {print "class=alert";}?> name=mphone maxlength=32 size=40 value='<? echo $mphone; ?>'><? if (!empty($err_mphone)) {print $err_mphone;}?></td>
   </tr>
   <tr>
    <td width="200px"><p>Электронная почта:</p></td>
    <td><INPUT type=text <? if (!empty($err_email)) {print "class=alert";}?> name=email maxlength=32 size=40 value='<? echo $email; ?>'><? if (!empty($err_email)) {print $err_email;}?></td>
   </tr>
   <tr>
    <td width="200px"><p>Дата начала проката:*</p></td>
    <td><INPUT type=text <? if (!empty($err_startday)) {print "class=alert";}?> name=startday maxlength=32 size=40 value='<? echo $startday; ?>'><? if (!empty($err_startday)) {print $err_startday;}?></td>
   </tr>
   <tr>
    <td width="200px"><p>Дата окончания проката:*</p></td>
    <td><INPUT type=text <? if (!empty($err_stopday)) {print "class=alert";}?> name=stopday maxlength=32 size=40 value='<? echo $stopday; ?>'><? if (!empty($err_stopday)) {print $err_stopday;}?></td>
   </tr>
   <!--<tr>
    <td width="200px"><p>Машина:</p></td>
    <td><p><input type=radio name=model value='Седан' checked>&nbsp;&nbsp;cедан&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio class=form name=model value='Хэтчбек'>&nbsp;&nbsp;хетчбек</p></td>
   </tr>-->
   </table>
   <h4>Паспортные данные</h4>
   <table class="form" cellpadding="0" cellspacing="0" width="500px">
   <tr>
    <td width="200px"><p>Серия и номер:</p></td>
    <td><INPUT type=text name=pas_num maxlength=80 size=80 value='<? echo $pas_num; ?>'></td>
   </tr>
   <tr>
    <td width="200px"><p>Кем и когда выдан:</p></td>
    <td><INPUT type=text name=pas_give maxlength=80 size=80 value='<? echo $pas_give; ?>'></td>
   </tr>
   <tr>
    <td width="200px"><p>Адрес прописки:</p></td>
    <td><INPUT type=text name=pas_adr maxlength=80 size=80 value='<? echo $pas_adr; ?>'></td>
   </tr>
   <tr>
    <td width="200px"><p>Адрес проживания:</p></td>
    <td><INPUT type=text name=real_adr maxlength=80 size=80 value='<? echo $real_adr; ?>'></td>
   </tr>
   </table>
   <h4>Водительское удостоверение</h4>
   <table class="form" cellpadding="0" cellspacing="0" width="500px">
   <tr>
    <td width="200px"><p>Серия и номер:</p></td>
    <td><INPUT type=text name=vod_num maxlength=32 size=40 value='<? echo $vod_num; ?>'></td>
   </tr>
   <tr>
    <td width="200px"><p>Кем и когда выдано:</p></td>
    <td><INPUT type=text name=vod_give maxlength=80 size=80 value='<? echo $vod_give; ?>'></td>
   </tr>
   </table>
   <h4>Дополнительно</h4>
   <table class="form" cellpadding="0" cellspacing="0" width="500px">
   <tr>
    <td width="200px"><p>Подача автомобиля:</p></td>
    <td><p><input type=radio name=giving value='Нужна'>&nbsp;&nbsp;нужна&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio class=form name=giving value='Не нужна' checked>&nbsp;&nbsp;не нужна</p></td>
   </tr>
   <tr>
    <td width="200px"><p>Комментарии:</p></td>
    <td><textarea cols=60 rows=7 value='<? echo $text; ?>' name=text></textarea><br /><br /></td>
   </tr>
   <tr>
    <td width="200px"></td>
    <td>
    <p>Введите цифры с картинки:*</p>
    <input type="text" <? if (!empty($err_cap)) {print "class=alert";}?> name="random_string" maxlength=9 size=9><? if (!empty($err_cap)) {print $err_cap;}?>
    <p><img id="CaptchaImage" src='captcha.php' border=0><br />
    <a href="#" onclick="return UpdateCaptchaImage();">показать другие цифры</a></p>
    </td>
   </tr>
   <tr>
    <td width="200px"></td>
    <td><INPUT class="short_btn" type="submit" value="Заказать" onclick="return CheckTyreParams()"/></td>
   </tr>
   </table>
   </form>
  <div class="clear"></div>
 </div>
<? include ('bottom.php'); 
}
?>