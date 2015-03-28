<html>
<head>
  <title>Результат загрузки файла</title>
  </head>
  <body>
  <?php
  function send_post($post_url,$post_data)
   {
     $ch = curl_init();
       //curl_setopt($ch, CURLOPT_PROXY, «http://192.168.2.600:2323″);
       curl_setopt($ch, CURLOPT_URL, $post_url);
       curl_setopt($ch, CURLOPT_HEADER,1);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
       curl_setopt($ch, CURLOPT_REFERER, " ");
       curl_setopt($ch, CURLOPT_COOKIE," ");
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
       curl_setopt($ch, CURLOPT_USERAGENT, "HTTPTool/1.0");
       curl_setopt($ch, CURLOPT_VERBOSE,1);
       $data = curl_exec($ch);
       $header_size = curl_getinfo($ch,CURLINFO_HEADER_SIZE);
       $result['header'] = substr($data, 0, $header_size);
       echo $result['http_code'] = curl_getinfo($ch,CURLINFO_HTTP_CODE);       
       $result['body'] = substr( $data, $header_size );
  
  
       $output = fopen("outtt.txt", "w+");
       fwrite($output,base64_decode($result['body']));
       fclose($output);

      /* $output = fopen("outtt.txt", "r+");
       $contents = fread($output, filesize("outtt.txt"));
       fclose($output);*/

       $output = fopen("outtt.txt", "r+");
       echo $contents = fgets($output);
       fclose($output);

       curl_close($ch);
       return $type;
   }
 
  $fsz = $_FILES["filename"]["size"];
  if ($fsz > 1024*3*1024)
        {
          echo ("Размер файла превышает три мегабайта");
          exit;
         }
         
    // Проверяем загружен ли файл
      if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
        {
           // Если файл загружен успешно, перемещаем его
        // из временной директории в конечную
          move_uploaded_file($_FILES["filename"]["tmp_name"], "./in/".$_FILES["filename"]["name"]);
        } else {
                  echo("Ошибка загрузки файла");
              }
      $zpr = $_POST["zpr"];
       
       $pd_file = fopen("./in/".$_FILES["filename"]["name"], "r+");
       $pd = fread($pd_file, $fsz);
       fclose($pd_file);

     switch ($zpr) {
           case "ckki":
                 echo "CKKI".$pd;
                 break;
           case "fms":
                echo "http://fms.demo.nbki.ru:8080/FmsService/fms".$pd;
                break;
           case "gibdd":
                echo "http://gibdd.demo.nbki.ru:8080/GibddService/gibdd".$pd;
                break;
           case "zts":
                send_post("https://icrs.nbki.ru/collatauto",$pd);
//                echo "http://collatauto.demo.nbki.ru:8080/CollatAuto/collatauto".$pd;
                break;
             }

  
  ?>
  </body>
</html>