<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Погодные условия</title>
    <style type="text/css" media="screen">
        * {
            font-family: Arial, sans-serif;
        }

        table {
            text-align: left;
        }

        tr, th {
            padding-right: 2em;
        }

        tr span {
            display:inline-block;
            font-size: 1.5em;
            line-height: 1em;
        }

    </style>
</head>
<body>
<?php 
    
    $appid = 'e36967ae6b492da14ba5b478d88e1f60';
    $city = 'Tomilino,ru';
    $filename = 'weather.json';

    $url = "http://api.openweathermap.org/data/2.5/weather?q=$city&units=metric&appid=$appid";

    $json = file_get_contents($url);
    $data = json_decode($json, true);

    if ($data['cod'] == 200) { // service works
        file_put_contents($filename, $record);
    }
    else {                     // service unavailable, getting data from local json file
        $json = file_get_contents($filename);
        $data = json_decode($json, true);
    }

    $weather = $data['weather'][0];
    $main = $data['main'];
    $wind = $data['wind'];

?>

    <h1>Погодные условия в <?php echo $data['name'].', '.$data['sys']['country'] ?></h1>
    <p>Данные на <?php echo date('Y-m-d H:i', $data['dt']) ?></p>
    <p>
        <img src="http://openweathermap.org/img/w/<?php echo $weather['icon'] ?>.png" alt="<?php echo $weather['main'] ?>">
        <?php echo $weather['descr'] ?>
    </p>
    <table>
        <tbody>
            <tr>
                <th>Температура</th>
                <td><?php echo $main['temp_min'].'..'.$main['temp_max'] ?> &#8451;</td>
            </tr>
            <tr>
                <th>Атмосферное давление</th>
                <td><?php echo $main['pressure'] ?> гПа</td>
            </tr>
            <tr>
                <th>Влажность воздуха</th>
                <td><?php echo $main['humidity'] ?> %</td>
            </tr>
            <tr>
                <th>Ветер</th>
                <td>
                    <span style=" transform: rotate(<?php echo $wind['deg'] ?>deg);">&uarr;</span> 
                    <?php echo $wind['speed'] ?> м/с
                </td>
            </tr>
            <tr>
                <th>Облачность</th>
                <td><?php echo $data['clouds']['all'] ?> %</td>
            </tr>
            <tr>
                <th>Видимость</th>
                <td><?php echo $data['visibility'] ?> м</td>
            </tr>
        </tbody>
    </table>
    
</body>
</html>





