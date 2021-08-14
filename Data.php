<?php
$connection=mysqli_connect("localhost","root","","db_2059746");
$query = "select * from weather_data where city='Glasgow' and weather_when >=date_sub(now(),interval 1 hour) order by weather_when desc limit 1;";

$result = mysqli_query($connection,$query);
if ($result->num_rows == 0) {
    $api="https://api.openweathermap.org/data/2.5/weather?q=Glasgow&appid=dda3ed011668408af859bc955891b1aa&units=metric";
$data = file_get_contents($api);
$json_data = json_decode($data, true);

$city_name=$json_data['name'];
$country_name=$json_data["sys"]["country"];
$temp=$json_data["main"]["temp"];
$pressure=$json_data['main']['pressure'];
$wind=$json_data["wind"]["speed"];
$humidity=$json_data['main']['humidity'];
$weather_description=$json_data["weather"][0]["description"];
$id=$json_data["weather"][0]["id"];
date_default_timezone_set('Asia/KATHMANDU');
$weather_when = date("y-m-d H:i:s");
$query="insert into weather_data values('{$city_name}','{$country_name}',$temp,$humidity,$pressure,$wind,'{$weather_description}',$id,'{$weather_when}');";

if (!$connection -> query($query)) {
    echo("<h4>SQL error description: " . $connection -> error . "</h4>");
    }

}

$query = "select * from weather_data where city='Glasgow' and weather_when >=date_sub(now(),interval 1 hour) order by weather_when desc limit 1;";
// Execute SQL query
$result = $connection -> query($query);
// Get data, convert to JSON and print
$row = $result -> fetch_assoc();
print json_encode($row);
// Free result set and close connection
$result -> free_result();
$connection -> close();

?>
