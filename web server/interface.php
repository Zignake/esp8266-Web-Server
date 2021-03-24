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

$sql = "SELECT id, LED, Sensor FROM ESP_1 order by id desc limit 40";
//grab the table out of the database
$result = $con->query($sql);

while ($data = $result->fetch_assoc()){
    $sensor_data[] = $data;
}

// $readings_time = array_column($sensor_data, 'reading_time');

// ******* Uncomment to convert readings time array to your timezone ********
/*$i = 0;
foreach ($readings_time as $reading){
    // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
    $readings_time[$i] = date("Y-m-d H:i:s", strtotime("$reading - 1 hours"));
    // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
    //$readings_time[$i] = date("Y-m-d H:i:s", strtotime("$reading + 4 hours"));
    $i += 1;
}*/

$id = json_encode(array_reverse(array_column($sensor_data, 'id')), JSON_NUMERIC_CHECK);
$LED = json_encode(array_reverse(array_column($sensor_data, 'LED')), JSON_NUMERIC_CHECK);
$Sensor = json_encode(array_reverse(array_column($sensor_data, 'Sensor')), JSON_NUMERIC_CHECK);
// $reading_time = json_encode(array_reverse($readings_time), JSON_NUMERIC_CHECK);

/*echo $LED;
echo $Sensor;
echo $reading_time;*/

$result->free();
$con->close();
?>

<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <title>Visualizing the Data</title>

  <style type="text/css">
    .highcharts-figure,
    .highcharts-data-table table {
      min-width: 360px;
      max-width: 800px;
      margin: 1em auto;
    }

    .highcharts-data-table table {
      font-family: Verdana, sans-serif;
      border-collapse: collapse;
      border: 1px solid #EBEBEB;
      margin: 10px auto;
      text-align: center;
      width: 100%;
      max-width: 500px;
    }

    .highcharts-data-table caption {
      padding: 1em 0;
      font-size: 1.2em;
      color: #555;
    }

    .highcharts-data-table th {
      font-weight: 600;
      padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
      padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
      background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
      background: #f1f7ff;
    }
  </style>
</head>

<body>
  <figure class="highcharts-figure">
    <div id="container1"></div>
    <br>
    <br>
    <div id="container2"></div>
    <p class="highcharts-description">
      Basic line chart showing trends in a dataset. This chart includes the
      <code>series-label</code> module, which adds a label to each line for
      enhanced readability.
    </p>
  </figure>
  <script type="text/javascript">

var id = <?php echo $id; ?>;
var LED = <?php echo $LED; ?>;
var Sensor = <?php echo $Sensor; ?>;

    Highcharts.chart('container1', {

      title: {
        text: 'Temperature'
      },

      subtitle: {
        text: 'in Degrees Celsius'
      },

      yAxis: {
        title: {
          text: 'Celsius'
        }
      },

      xAxis: {
        accessibility: {
          rangeDescription: 'Range: 1 to 10'
        }
      },

      // legend: {
      //   layout: 'vertical',
      //   align: 'right',
      //   verticalAlign: 'middle'
      // },

      plotOptions: {
        series: {
          label: {
            connectorAllowed: false
          },
          pointStart: 1
        }
      },

      series: [{
        name: 'Temperature',
        data: LED,
        showInLegend: false,
      }],

      responsive: {
        rules: [{
          condition: {
            maxWidth: 500
          },
          chartOptions: {
            legend: {
              layout: 'horizontal',
              align: 'center',
              verticalAlign: 'bottom'
            }
          }
        }]
      }

    });

    Highcharts.chart('container2', {

      title: {
        text: 'Humidity'
      },

      subtitle: {
        text: 'in %'
      },

      yAxis: {
        title: {
          text: 'Humidity %'
        }
      },

      xAxis: {
        accessibility: {
          rangeDescription: 'Range: 1 to 10'
        }
      },

      legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
      },

      plotOptions: {
        series: {
          label: {
            connectorAllowed: false
          },
          pointStart: 1
        }
      },

      series: [{
        name: 'Humidity',
        data: Sensor,
        showInLegend: false,
      }],

      responsive: {
        rules: [{
          condition: {
            maxWidth: 500
          },
          chartOptions: {
            legend: {
              layout: 'horizontal',
              align: 'center',
              verticalAlign: 'bottom'
            }
          }
        }]
      }

    });

  </script>
</body>

</html>
    