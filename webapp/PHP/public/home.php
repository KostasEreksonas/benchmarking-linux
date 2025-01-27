<?php
require_once 'classes/Records.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>FFMPEG benchmark</title>
</head>
<body>
<h1>FFMPEG benchmark</h1>
<?php
$records = new Records();
?>

<h2>CPU results</h2>
<h3>320x180</h3>
<?php
$sql = "SELECT * FROM cpuBench WHERE resolution LIKE '320x180' AND encoder LIKE 'libx264' AND preset LIKE 'ultrafast' AND crf LIKE '53' ORDER BY fastest_seconds";
$records->cpuResults($sql);
?>
<h3>640x360</h3>
<?php
$sql = "SELECT * FROM cpuBench WHERE resolution LIKE '640x360' AND encoder LIKE 'libx264' AND preset LIKE 'ultrafast' AND crf LIKE '53' ORDER BY fastest_seconds";
$records->cpuResults($sql);
?>
<h2>GPU results</h2>
<?php
$records->gpuResults();
?>
<h2>Combined results</h2>
<?php
$records->combinedResults();
?>
<form action="assets/upload.php" method="post" enctype="multipart/form-data">
  Select results file to upload:
  <input type="file" name="results_file" id="results_file">
  <input type="submit" value="Upload results" name="submit">
</form>
</body>
</html>
