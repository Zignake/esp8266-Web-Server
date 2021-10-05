<?php
//all of this code used for refreshing the page
$page = $_SERVER['PHP_SELF'];
$sec = "15";
?>
<html>
    <head>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    </head>
    <body>
    
<?php
//connect to database
$con=mysqli_connect("localhost","id15571246_laukik","4#-K1Qk((EITugaM","id15571246_esp8266");// server, user, pass, database

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "SELECT Date_Time,D1,D2,D3,D4 FROM ESP_Dispenser order by id desc limit 2";
//grab the table out of the database
// $result = $con->query($sql);
$result = $conn->query($sql) or die($conn->error);

while ($data = $result->fetch_assoc()){
    $sensor_data[] = $data;
}

$D1 = json_encode(array_reverse(array_column($sensor_data, 'D1')), JSON_NUMERIC_CHECK);
$D2 = json_encode(array_reverse(array_column($sensor_data, 'D2')), JSON_NUMERIC_CHECK);
$D3 = json_encode(array_reverse(array_column($sensor_data, 'D3')), JSON_NUMERIC_CHECK);
$D4 = json_encode(array_reverse(array_column($sensor_data, 'D4')), JSON_NUMERIC_CHECK);

$result->free();
$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <title>Dispenser Manager</title>
  <link rel="stylesheet" type="text/css" href="Style.css">


  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">

    var D1 = <?php echo $D1; ?>;
    var D2 = <?php echo $D2; ?>;
    var D3 = <?php echo $D3; ?>;
    var D4 = <?php echo $D4; ?>;

    google.charts.load("current", { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Dispenser No.", "Quantity", { role: "style" }],
        ["Dispenser 1", D1[0], "#9d0208"],
        ["Dispenser 2", D2[0], "#9d0208"],
        ["Dispenser 3", D3[0], "#9d0208"],
        ["Dispenser 4", D4[0], "#9d0208"]
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
        {
          calc: "stringify",
          sourceColumn: 1,
          type: "string",
          role: "annotation"
        },
        2]);

      var options = {
        title: "Dispenser Fill in %",
        width: 600,
        height: 400,
        bar: { groupWidth: "50%" },
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
    }
  </script>
</head>

<body>
  <header>
    <div class="title">
      <h1>
        Smart Sanitizer Dispenser
      </h1>
    </div>


    <div id="columnchart_values" class="chart"></div>
    <style>
      body {
        overflow-x: hidden;
        position: relative;
      }
    </style>



  </header>
</body>

</html>