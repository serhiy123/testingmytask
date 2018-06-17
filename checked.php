<?php
if(!empty($_POST['url'])) {
    $getfile = $_POST['url'] . 'robots.txt'; // добавляем имя файла
    $file_headers = @get_headers($getfile); // подготавливаем headers страницы

    if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {

        echo 'Возникла ошибка, при получении файла';

    } else if ($file_headers[0] == 'HTTP/1.1 200 OK') {
        // открываем файл для записи, поехали!
        $file = fopen('robots.txt', 'w');
        // инициализация cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $getfile);
        curl_setopt($ch, CURLOPT_FILE, $file);
        if (!file_exists($resultfile)) {
            // Если файл отсутвует, сообщаем ошибку
            echo "Ошибка обработки файла: $resultfile";

        } else {
            echo "OK";
            curl_exec($ch);
            fclose($file);
            curl_close($ch);

            global $resultfile; // описываем как глобальную переменную
            $resultfile = 'robots.txt'; // файл, который получили


            $textget = file_get_contents($resultfile);
            htmlspecialchars($textget); // при желании, можно вывести на экран через echo

            if (preg_match("/Host/", $textget)) {
                echo "Деректива Host есть";
            } else {
                echo "Дерективы Host нет";
            }

            echo 'Размер файла ' . $resultfile . ': ' . filesize($resultfile) . ' байт';
            $size = $filesize($resultfile);

        }
    }
} else {
    echo "Введите URL сайта. <a href = 'index.php'> Исправить </a> ";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style type="text/css">
        TABLE {
            border-collapse: collapse; /* Убираем двойные линии между ячейками */
            width: 1000px; /* Ширина таблицы */
        }
        TH, TD {
            border: 1px solid black; /* Параметры рамки */
            text-align: center; /* Выравнивание по центру */
            padding: 4px; /* Поля вокруг текста */
        }
        TH {
            background: #fc0; /* Цвет фона ячейки */
            height: 40px; /* Высота ячеек */
            vertical-align: bottom; /* Выравнивание по нижнему краю */
            padding: 0; /* Убираем поля вокруг текста */
        }
    </style>
    <title>Document</title>
</head>
<body>
<table border="1">
    <tr bgcolor="#6495ed">
        <td>№</td>
        <td>Название проверки</td>
        <td>Статус</td>
        <td>GRAY</td>
        <td>Текущее состояние</td>
    </tr>
    <tr>
        <td colspan="5" height="20" bgcolor="silver"></td>
    </tr>
    <tr>
        <td rowspan="2">1</td>
        <td rowspan="2">Проверка наличия файла</td>
        <td rowspan="2">
            <?php
            if (!file_exists($resultfile)) {
                // Если файл отсутвует, сообщаем ошибку
                echo "Ошибка";

            } else {
                echo "OK";
            }
            ?>
        </td>
        <td>Сосотояние</td>
        <td> <?php
            if (!file_exists($resultfile)) {
                // Если файл отсутвует, сообщаем ошибку
                echo "Файл robots.txt отсутствует";

            } else {
                echo "Файл robots.txt присутствует";
            }
            ?></td>
    </tr>
    <tr>
        <td>Рекомендации</td>
        <td><?php
            if (!file_exists($resultfile)) {
                // Если файл отсутвует, сообщаем ошибку
                echo "Программист: Создать файл robots.txt и разместить его на сайте.";

            } else {
                echo "Доработки не требуются";
            }
            ?></td>
    </tr>
    <tr>
        <td colspan="5"  height="20" bgcolor="silver"></td>
    </tr>
    <tr>
        <td rowspan="2">1</td>
        <td rowspan="2">Проверка указания директивы Host</td>
        <td rowspan="2">
            <?php
            if (!file_exists($resultfile)) {
                // Если файл отсутвует, сообщаем ошибку
                echo "Ошибка";

            } else {
                echo "OK";
            }
            ?>
        </td>
        <td>Сосотояние</td>
        <td>
            <?php
            if (preg_match("/Host/", $textget)) {
                echo "Директива Host указана";
            } else {
                echo "В файле robots.txt не указана директива Host";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>Рекомендации</td>
        <td><?php
            if (preg_match("/Host/", $textget)) {
                echo "Доработки не требуются";
            } else {
                echo "Программист: Для того, чтобы поисковые системы знали,
                 какая версия сайта является основных зеркалом, необходимо
                  прописать адрес основного зеркала в директиве Host. 
                  В данный момент это не прописано. Необходимо добавить в файл 
                  robots.txt директиву Host. Директива Host задётся в файле 1 раз,
                   после всех правил.";
            }
            ?></td>
    </tr>
    <tr>
        <td colspan="5" height="20" bgcolor="silver"></td>
    </tr>
    <tr>
        <td rowspan="2">1</td>
        <td rowspan="2">Проверка размера файла файла</td>
        <td rowspan="2">
            <?php
            if (!file_exists($resultfile)) {
                // Если файл отсутвует, сообщаем ошибку
                echo "Ошибка";

            } else {
                echo "OK";
            }
            ?>
        </td>
        <td>Сосотояние</td>
        <td>
            <?php
                if($size <= 32){
                    echo "Размер файла robots.txt составляет $size, что находится в пределах допустимой нормы";
                }
                else{
                    echo "Размера файла robots.txt составляет $size, что превышает допустимую норму";
                }
            ?>
        </td>
    </tr>
    <tr>
        <td>Рекомендации</td>
        <td><?php
            if($size <= 32){
                echo "Доработки не требуются";
            }
            else{
                echo "Программист: Максимально допустимый размер файла
                 robots.txt составляем 32 кб. Необходимо отредактировть
                  файл robots.txt таким образом, чтобы его размер не превышал 32 Кб";
            }
            ?></td>
    </tr>
    <tr>
        <td colspan="5" height="20" bgcolor="silver"></td>
    </tr>
    <tr>
        <td rowspan="2">1</td>
        <td rowspan="2">Проверка указания директивы Sitemap</td>
        <td rowspan="2">
            <?php
            if (!file_exists($resultfile)) {
                // Если файл отсутвует, сообщаем ошибку
                echo "Ошибка";

            } else {
                echo "OK";
            }
            ?>
        </td>
        <td>Сосотояние</td>
        <td> <?php
            if (preg_match("/Sitemap/", $textget)) {
                echo "Директива Sitemap указана";
            } else {
                echo "В файле robots.txt не указана директива Sitemap";
            }
            ?></td>
    </tr>
    <tr>
        <td>Рекомендации</td>
        <td><?php
            if (preg_match("/Sitemap/", $textget)) {
                echo "Доработки не требуются";
            } else {
                echo "Программист: Добавить в файл robots.txt директиву Sitemap";
            }
            ?></td>
    </tr>
    <tr>
        <td colspan="5" height="20" bgcolor="silver"></td>
    </tr>
    <tr>
        <td rowspan="2">1</td>
        <td rowspan="2">Проверка кода ответа сервера для файла</td>
        <td rowspan="2">
            <?php
            if (!file_exists($resultfile)) {
                // Если файл отсутвует, сообщаем ошибку
                echo "Ошибка";

            } else {
                echo "OK";
            }
            ?>
        </td>
        <td>Сосотояние</td>
        <td>
            <?php
            if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {

                echo 'Возникла ошибка, при получении файл';

            } else if ($file_headers[0] == 'HTTP/1.1 200 OK'){
                echo "Файл robots.txt отдаёт код ответа сервера 200";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>Рекомендации</td>
        <td><?php
            if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {

                echo 'Программист: Файл robots.txt должны отдавать код ответа 200,
                 иначе файл не будет обрабатываться. Необходимо настроить сайт таким
                  образом, чтобы при обращении к файлу robots.txt сервер возвращает код ответа 200';

            } else if ($file_headers[0] == 'HTTP/1.1 200 OK'){
                echo "Доработки не требуются";
            }
            ?></td>
    </tr>
</table>
</body>
</html>
