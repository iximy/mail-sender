
<?php
date_default_timezone_set('Etc/GMT-3');
//Замените настройки на нужные.
$mail_to = 'google@gmail.com'; //Вам потребуется указать здесь адрес, куда должно будет прийти письмо.
$mail_from = 'from@gmail.ru'; //Ваш адрес 
$replyto = 'from@gmail.ru'; 
$type = 'html'; 
$charset = 'UTF-8';
include('smtp-func.php');
$fn = fopen("num.txt", 'r+');
$fd = "datauser.txt";
$num = fgets($fn);	
fclose($fn);	
$iend  =  2 +  $num;   //количество рассылаемых писем
$fdr = file($fd);		
for ($num =  $num  ; $num <= $iend; $num++) {
	$mail_to = $fdr[$num];	
	list($obr,$mail_to) = explode(",", $mail_to);	
	$mail_to = substr($mail_to,0,-2);
	echo $num,$mail_to,$obr,$num,' '	;//вывод прогресса
	echo "<br />\	n";
	$name = substr_replace($obr, null, 0, 19).'текст - обращение темы';
	$message = '<html>HTML Текст письма может включать имя '.$obr.'и адрес почты '.$mail_to.'</html>'; 
	$headers = "To: \"".substr_replace($obr, null, 0, 19)."\" <$mail_to>\r\n".
              "From: \"Имя почты\" <$mail_from>\r\n".
              "Reply-To: $replyto\r\n".
			  "List-Unsubscribe: <mailto:unsubscribe@gmail.ru>\r\n".
              "Content-Type: text/$type; charset=\"$charset\"\r\n";
	$sended = smtpmail($mail_to, $name, $message, $headers);//отправка
}
$iend=$iend+1;
$fn = fopen("num.txt", 'r+');
fwrite($fn, $iend);
fclose($fn);	
?>