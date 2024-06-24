<?php
session_start();
$random_string = mt_rand(1000,9999);
$_SESSION['random_string'] = $random_string;
$font = imageloadfont('anonymous.gdf'); // подставьте сюда имя шрифта который вы будете использовать
$fontWidth = imagefontwidth($font);
$fontHeight = imagefontheight($font);
$width  = strlen($random_string) * $fontWidth;
$height = $fontHeight;
//$img = @ImageCreate ($width, $height) or die ("Cannot Initialize new GD image stream");
$jpeg_file = "cap_base.jpg";
$img = @ImageCreatefromjpeg ($jpeg_file) or die ("Cannot Initialize new GD image stream");
//$background_color = @imagecolorallocate($img, 255, 255, 255);
$text_color = @imagecolorallocate($img,   0,   0, 0);
@imagestring($img, $font, 0, 0, $random_string, $text_color);
$img2 = @ImageCreate ($width, $height) or die ("Cannot Initialize new GD image stream");
$x=1;
$i=0;
// собственно сам алгоритм:
while ($x<$width) { // идем по X-су и копируем кусочки
$xx = mt_rand(1,1);   // c этим промежутком можно поиграть
$yy = mt_rand(5,3); // c этим промежутком можно поиграть
$i=$i+($xx/10);         // шаг для Sin-уса
$y = ceil(sin($i)*$yy);// смещение по Y-ку
@imagecopy ($img2, $img, $x, $y, $x, 0, 1, $height); // копирование кусочка
$x++;
}
// отправляем заголовки для предотвращения кэширования
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header ("Content-type: image/png");
ImagePng ($img2);
@imagedestroy($img2);
@imagedestroy($img);
?>
