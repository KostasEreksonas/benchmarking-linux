<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/classes/Parser.php';

$target_dir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/";

$target_file = $target_dir . basename($_FILES["results_file"]["name"]);

$files = scandir($target_dir);

# Parse uploaded file
$parser = new Parser();

$path = pathinfo($target_file);
$name = $path['filename'];
$extension = $path['extension'];

if(isset($_POST["submit"])) {
	// Only results.txt is allowed to be uploaded
	if ($_FILES["results_file"]["name"] !== "results.txt") {
		echo 'Not a valid file.';
	} else {
		// Append a date to a filename
		$target_file = $target_dir . $name . '_' . date("Y-m-d_H:i:s") . '.' . $extension;
		$parser->setResultFile($target_file);

		// Save a file
		if (move_uploaded_file($_FILES["results_file"]["tmp_name"], $target_file)) {
			echo "The file ". htmlspecialchars(basename($parser->getResultFile())) . " has been uploaded.<br>";
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}

	$file = $parser->getResultFile();

	$iterations = trim($parser->getParameter($file, "Iterations:"));
	$resolution = trim($parser->getParameter($file, "Resolution:"));
	$os = trim($parser->getParameter($file, "OS:"));
	$memory = trim($parser->getParameter($file, "Memory:"));
	$bench = trim($parser->getParameter($file, "Benchmark:"));
	$encoder = trim($parser->getParameter($file, "Encoder:"));
	$preset = trim($parser->getParameter($file, "Preset:"));
	$total = trim($parser->getParameter($file, "Total time:"));
	$average = trim($parser->getParameter($file, "Average iteration time:"));
	$fps = trim($parser->getParameter($file, "Average iteration fps:"));
	$fastest = trim($parser->getParameter($file, "Fastest time:"));
	$fastest_seconds = trim($parser->getParameter($file, "Fastest time \(seconds\):"));

	if ($bench === "CPU") {
		$arch = trim($parser->getParameter($file, "Architecture:"));
		$cpu = trim($parser->getParameter($file, "CPU:"));
		$frequency = trim($parser->getParameter($file, "Max frequency:"));
		$crf = trim($parser->getParameter($file, "CRF:"));
		$sql = "INSERT INTO cpuBench VALUES (NULL, \"$bench\", \"$resolution\", \"$os\", \"$iterations\", \"$cpu\", \"$arch\", \"$frequency\", \"$memory\", \"$encoder\", \"$preset\", \"$crf\", \"$total\", \"$average\", \"$fps\", \"$fastest\", \"$fastest_seconds\", DEFAULT)";
		$parser->addData($sql);
	} elseif ($bench === "GPU") {
		$gpu = trim($parser->getParameter($file, "GPU:"));
		$tune = trim($parser->getParameter($file, "Tune:"));
		$level = trim($parser->getParameter($file, "Level:"));
		$sql = "INSERT INTO gpuBench VALUES (NULL, \"$bench\", \"$resolution\", \"$os\", $iterations, \"$gpu\", \"$encoder\", \"$preset\", \"$tune\", \"$level\", \"$total\", \"$average\", \"$fps\", \"$fastest\", \"$fastest_seconds\", DEFAULT)";
		$parser->addData($sql);
	}
}
