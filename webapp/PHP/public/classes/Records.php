<?php
require_once 'Database.php';

class Records {
	protected $db;

	public function __construct()
	{
		/*
		 * Constructor method
		 * Creates database instance
		 */
		$this->db = new Database();
	}

	public function cpuResults(string $sql) : void
	{
		/*
		 * Print CPU benchmark results to a table
		 */
		$this->db->query($sql);
		$this->db->execute();
		$rows = $this->db->resultSet();
		echo "<table>";
		echo "<tr>";
		echo "<td>Resolution</td>";
		echo "<td>OS</td>";
		echo "<td>CPU Name</td>";
		echo "<td>Architecure</td>";
		echo "<td>Frequency</td>";
		echo "<td>Memory</td>";
		echo "<td>Encoder</td>";
		echo "<td>Preset</td>";
		echo "<td>CRF</td>";
		echo "<td>Total</td>";
		echo "<td>Average</td>";
		echo "<td>FPS</td>";
		echo "<td>Fastest</td>";
		echo "<td>Date added</td>";
		echo "</tr>";
		foreach ($rows as $row) {
			echo "<tr>";
			$resolution = $row->resolution;
			echo  '<td>' . $resolution . '</td>';
			$os = $row->os;
			echo  '<td>' . $os . '</td>';
			$cpu = $row->cpu;
			echo  '<td>' . $cpu . '</td>';
			$arch = $row->arch;
			echo  '<td>' . $arch . '</td>';
			$freq = $row->frequency;
			echo  '<td>' . $freq . '</td>';
			$memory = $row->memory;
			echo  '<td>' . $memory . '</td>';
			$encoder = $row->encoder;
			echo  '<td>' . $encoder . '</td>';
			$preset = $row->preset;
			echo  '<td>' . $preset . '</td>';
			$crf = $row->crf;
			echo  '<td>' . $crf . '</td>';
			$total = $row->total;
			echo  '<td>' . $total . '</td>';
			$average = $row->average;
			echo  '<td>' . $average . '</td>';
			$fps = $row->fps;
			echo  '<td>' . $fps . '</td>';
			$fastest = $row->fastest;
			echo  '<td>' . $fastest . '</td>';
			$date = $row->created_at;
			echo  '<td>' . $date . '</td>';
			echo "</tr>";
		}
		echo "</table>";
	}

	public function gpuResults() : void
	{
		/*
		 * Print GPU benchmark results to a table
		 */
		$sql = "SELECT * FROM gpuBench ORDER BY fastest_seconds";
		$this->db->query($sql);
		$this->db->execute();
		$rows = $this->db->resultSet();
		echo "<table>";
		echo "<tr>";
		echo "<td>Bench</td>";
		echo "<td>Resolution</td>";
		echo "<td>OS</td>";
		echo "<td>Iterations</td>";
		echo "<td>GPU Name</td>";
		echo "<td>Encoder</td>";
		echo "<td>Preset</td>";
		echo "<td>Tune</td>";
		echo "<td>Level</td>";
		echo "<td>Total</td>";
		echo "<td>Average</td>";
		echo "<td>FPS</td>";
		echo "<td>Fastest</td>";
		echo "<td>Date added</td>";
		echo "</tr>";
		foreach ($rows as $row) {
			echo "<tr>";
			$bench = $row->bench;
			echo  '<td>' . $bench . '</td>';
			$resolution = $row->resolution;
			echo  '<td>' . $resolution . '</td>';
			$os = $row->os;
			echo  '<td>' . $os . '</td>';
			$iterations = $row->iterations;
			echo  '<td>' . $iterations . '</td>';
			$gpu = $row->gpu;
			echo  '<td>' . $gpu . '</td>';
			$encoder = $row->encoder;
			echo  '<td>' . $encoder . '</td>';
			$preset = $row->preset;
			echo  '<td>' . $preset . '</td>';
			$tune = $row->tune;
			echo  '<td>' . $tune . '</td>';
			$level = $row->level;
			echo  '<td>' . $level . '</td>';
			$total = $row->total;
			echo  '<td>' . $total . '</td>';
			$average = $row->average;
			echo  '<td>' . $average . '</td>';
			$fps = $row->fps;
			echo  '<td>' . $fps . '</td>';
			$fastest = $row->fastest;
			echo  '<td>' . $fastest . '</td>';
			$date = $row->created_at;
			echo  '<td>' . $date . '</td>';
			echo "</tr>";
		}
		echo "</table>";
	}

	public function combinedResults() : void
	{
		/*
		 * Print combined benchmark results to a table
		 */
		$sql = "SELECT bench, resolution, cpu as hardware, os, encoder, preset, iterations, total, average, fps, fastest, fastest_seconds, created_at FROM cpuBench UNION SELECT bench, resolution, gpu, os, encoder, preset, iterations, total, average, fps, fastest, fastest_seconds, created_at FROM gpuBench ORDER BY fastest_seconds";
		$this->db->query($sql);
		$this->db->execute();
		$rows = $this->db->resultSet();
		echo "<table>";
		echo "<tr>";
		echo "<td>Bench</td>";
		echo "<td>Resolution</td>";
		echo "<td>OS</td>";
		echo "<td>Iterations</td>";
		echo "<td>Hardware</td>";
		echo "<td>Encoder</td>";
		echo "<td>Preset</td>";
		echo "<td>Total</td>";
		echo "<td>Average</td>";
		echo "<td>FPS</td>";
		echo "<td>Fastest</td>";
		echo "<td>Date added</td>";
		echo "</tr>";
		foreach ($rows as $row) {
			echo "<tr>";
			$bench = $row->bench;
			echo  '<td>' . $bench . '</td>';
			$resolution = $row->resolution;
			echo  '<td>' . $resolution . '</td>';
			$os = $row->os;
			echo  '<td>' . $os . '</td>';
			$iterations = $row->iterations;
			echo  '<td>' . $iterations . '</td>';
			$hardware = $row->hardware;
			echo  '<td>' . $hardware . '</td>';
			$encoder = $row->encoder;
			echo  '<td>' . $encoder . '</td>';
			$preset = $row->preset;
			echo  '<td>' . $preset . '</td>';
			$total = $row->total;
			echo  '<td>' . $total . '</td>';
			$average = $row->average;
			echo  '<td>' . $average . '</td>';
			$fps = $row->fps;
			echo  '<td>' . $fps . '</td>';
			$fastest = $row->fastest;
			echo  '<td>' . $fastest . '</td>';
			$date = $row->created_at;
			echo  '<td>' . $date . '</td>';
			echo "</tr>";
		}
		echo "</table>";
	}
}
