<?php
//session_start();
//if (isset($_SESSION['ok']))
 //{  // Получаем соединение с базой данных
  include ('../config.php');
  // Формируем SQL-запрос
  $query = "DELETE FROM orders
            WHERE id_order=".$HTTP_GET_VARS["id_order"];
  // Удаляем сообщение с первичным ключом $id_msg
  if(mysql_query($query))
  {
      // После удачного удаления сообщения переходим к
      // дальнейшему администрированию
      print "<HTML><HEAD>\n";
      print "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=admin_page.php?start=".$HTTP_GET_VARS["start"]."'>\n";
      print "</HEAD></HTML>\n";
  }
  // В случае неудачи выводим сообщение об ошибке
  else puterror("Ошибка при обращении системе администрирования");
 //}
?>