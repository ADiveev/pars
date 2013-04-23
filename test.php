<?php
// Класс с модулями проверка1234арпар
class Export
{

    // логирование
    public function _log($user_id,$kol_voo)
    {
        $fps = fopen("config/log.txt", "a"); // Открываем файл в режиме записи
        $mytext = 'ShareExport_mod id: '.$user_id.' products: '.$kol_voo.' '.date('l jS \of F Y h:i:s A').' '."\n";
        $test = fwrite($fps, $mytext); // Запись в файл
        fclose($fps);
    }

    // выгрузка результатов в файл
    public function _export_csv($user_id,$stroka)
    {
        $orders_sql = "select * from user_export where user='$user_id'";
        $orders_result = mysql_query($orders_sql);

        $ct = mysql_num_rows($orders_result);
        if ($ct <> 0 )
        {
            $file = "data/export/".$user_id."price.csv";
            $fp = fopen($file, 'w');

            while ($order = mysql_fetch_array($orders_result))
            {
                fwrite($fp, $stroka);
            }
            fclose($fp);
        }
    }

    //Cтандартный модуль экспорта
    //@return $ret['link'], $ret['kol-vo']
    public function shareExport()
    {
        // Очищаем таблицу user_export
        $user_id=$_COOKIE['id'];// id пользователя
        $query_del="DELETE FROM user_export WHERE user='$user_id'";
        mysql_query($query_del);
        //----------------------------------------------------------

        $query="SELECT * FROM user_exit WHERE user='$user_id'";
        $result=mysql_query($query);

        $ret['rol-vo']=mysql_num_rows($result);// количество товаров

        $this->_log($user_id,$ret['rol-vo']);// Логируем

        while($exit=mysql_fetch_array($result))
        {
            $exit['id'];
            $id=$exit['nomber_exit'];

            $query_2="SELECT * FROM main_products WHERE id='$id'";
            $result_2=mysql_query($query_2);
            $product=mysql_fetch_array($result_2);

            //------------------------
            $id_ex=$product['id']; // id товара
            $name_ex=$product['name']; // имя товара
            $brief_description_ex=$product['bref_description']; // краткое описание
            //-------------------------

            $id_man=$product['manufacturer'];
            $query_5="SELECT name FROM main_manufacturer WHERE id='$id_man'";
            $result_5=mysql_query($query_5);
            $manufacturer=mysql_fetch_array($result_5);

            //-------------------------
            $manufacturer_ex=$manufacturer['name']; // Производитель
            //-------------------------

            $id_kat=$product['kategory_1'];
            $query_6="SELECT name FROM main_kategory_product WHERE id='$id_kat'";
            $result_6=mysql_query($query_6);
            $kategory=mysql_fetch_array($result_6);

            //-------------------------
            $kategory_ex=$kategory['name']; // категория товара
            $big_ex=$product['big']; // ссылка на картинку
            //-------------------------


            $feat_name=explode(",",$product['features_name']);
            $feat=explode(",",$product['features']);

            $compl_des='';
            for($i=1;$i<count($feat_name);$i++)
            {
                $feat_id=$feat_name[$i];
                $query_3="SELECT * FROM main_feature_name WHERE id='$feat_id'";
                $result_3=mysql_query($query_3);
                $feature_name=mysql_fetch_array($result_3);

                $features=$feat[$i];
                $query_4="SELECT * FROM main_features WHERE id_feature='$feat_id' AND id='$features'";
                $result_4=mysql_query($query_4);
                $feature=mysql_fetch_array($result_4);

                $compl_des=$compl_des.''.$feature_name['name'].' '.$feature['name'].'<br>';
            }
            //------------------------------
            $complet_description_ex=$compl_des; // полное описание
            //------------------------------

            $prew_ex=''; // превьюшка

            // Заполняем выходную таблицу
            $export = "INSERT INTO user_export VALUES ('$id_ex','$name_ex','$prew_ex','$big_ex','$complet_description_ex','$brief_description_ex','$manufacturer_ex','$kategory_ex','$user_id','999','')";
            mysql_query($export) or die(mysql_error());
        }

        // дальше выгрузка в файл
        $stroka = $order['id'].';'.$order['name'].';'.$order['prew'].';'.$order['big'].';'.$order['complet_description'].';'.$order['brief_description'].';'.$order['manufacturer'].';'.$order['kategory']."\n";
        $this->_export_csv($user_id,$stroka);

        $ret['link']='<a title="price.csv" href="http://4rgo.ru/get.php?file=data/export/'.$user_id.'price.csv">Скачать готовый *.CSV</a>';

        return $ret;
    }

    public function continent_export()
    {
        $user_id=$_COOKIE['id'];
        if($user_id==19||$user_id==26||$user_id==25)
        {


            $query_del="DELETE FROM user_export WHERE user='$user_id'";
            mysql_query($query_del);



            $query="SELECT * FROM user_exit WHERE user='$user_id'";
            $result=mysql_query($query);
            echo 'ВСЕГО: '.$kol_voo=mysql_num_rows($result).' товаров<br><br><br>';

            $fps = fopen("config/log.txt", "a"); // Открываем файл в режиме записи
            $mytext = 'ShareExport_mod id: '.$user_id.' products: '.$kol_voo.' '.date('l jS \of F Y h:i:s A').' '."\n";
            $test = fwrite($fps, $mytext); // Запись в файл
            fclose($fps);
            while($exit=mysql_fetch_array($result))
            {
                $exit['id'];
                $id=$exit['nomber_exit'];
                $iddd=$exit['nomber_price'];

                $query_2="SELECT * FROM main_products WHERE id='$id'";
                $result_2=mysql_query($query_2);
                $product=mysql_fetch_array($result_2);
                //------------------------


                // user_price

                //$id_ex=$product['id'];
                $qqq="SELECT id_tov_us,price FROM user_price WHERE id='$iddd'";
                $re=mysql_query($qqq);
                $row=mysql_fetch_row($re);
                $id_ex=$row[0];
                $price_ex=$row[1];


                $name_ex=$product['name'];
                $brief_description_ex=$product['bref_description'];
                //-------------------------

                $id_man=$product['manufacturer'];
                $query_5="SELECT name FROM main_manufacturer WHERE id='$id_man'";
                $result_5=mysql_query($query_5);
                $manufacturer=mysql_fetch_array($result_5);

                //-------------------------
                $manufacturer_ex=$manufacturer['name'];
                //-------------------------

                $id_kat=$product['kategory_1'];
                $query_6="SELECT name FROM main_kategory_product WHERE id='$id_kat'";
                $result_6=mysql_query($query_6);
                $kategory=mysql_fetch_array($result_6);

                //-------------------------
                $kategory_ex=$kategory['name'];
                $big_ex=$product['big'];
                //-------------------------


                $feat_name=explode(",",$product['features_name']);
                $feat=explode(",",$product['features']);

                $compl_des='';
                for($i=1;$i<count($feat_name);$i++)
                {
                    $feat_id=$feat_name[$i];
                    $query_3="SELECT * FROM main_feature_name WHERE id='$feat_id'";
                    $result_3=mysql_query($query_3);
                    $feature_name=mysql_fetch_array($result_3);

                    $features=$feat[$i];
                    $query_4="SELECT * FROM main_features WHERE id_feature='$feat_id' AND id='$features'";
                    $result_4=mysql_query($query_4);
                    $feature=mysql_fetch_array($result_4);

                    $compl_des=$compl_des.''.$feature_name['name'].' '.$feature['name']."\n";
                }
                //------------------------------
                $complet_description_ex=$compl_des;
                //------------------------------

                $prew_ex='';

                //'<br><br>';
                $export = "INSERT INTO user_export VALUES ('$id_ex','$name_ex','$prew_ex','$big_ex','$complet_description_ex','$brief_description_ex','$manufacturer_ex','$kategory_ex','$user_id','999','$price_ex')";
                mysql_query($export) or die(mysql_error());

            }

            $orders_sql = "select * from user_export where user='$user_id'";
            $orders_result = mysql_query($orders_sql);

            $ct = mysql_num_rows($orders_result);
            if ($ct <> 0 )
            {

                $file = "data/export/".$user_id."price.csv";
                $fp = fopen($file, 'w');

                while ($order = mysql_fetch_array($orders_result))
                {
                    $stroka = $order['id'].';'.$order['name'].';'.$order['price'].';'.$order['kol_vo'].';'.$order['kategory'].';'.$order['prew'].';'.$order['big'].';"'.str_replace('</li>',"\n",str_replace('<li>','',$order['brief_description'])).'";"'.$order['complet_description'].'"'."\n";
                    // $stroka=str_replace('','"',$stroka);
                    fwrite($fp, $stroka);
                }


            }
            fclose($fp);

            echo'<a title="price.csv" href="http://4rgo.ru/get.php?file=data/export/'.$user_id.'price.csv">Экспортировать в формат CONTINENT *.CSV</a>';
        }
        else
        {
            echo 'Это не ваш модуль!!!';
        }
    }

}
