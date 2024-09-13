<?php
require_once 'Database.php';

class Parser {
	/*
	 * Parse benchmark result data and store it to database
	 */
	protected $db;
	protected $result_file;

	public function __construct()
	{
		/*
		 * Constructor method
		 * Creates database instance
		 */
		$this->db = new Database();
	}

	public function setResultFile($filename)
	{
		/*
		 * Set path to results file
		 */
		$this->result_file = $filename;
	}

	public function getResultFile() : string
	{
		/*
		 * Return results file
		 */
		return $this->result_file;
	}

	public function getParameter(string $file, string $pattern) : string
	{
		/*
		 * Get parameter value from results file based on a given pattern
		 */
		$data = file($file);
		foreach ($data as $key => $value) {
			if (preg_match("/$pattern/", $value)) {
				$result = explode(":", $value);
				break;
			}
		}
		return $result[1];
	}

	public function addData(string $sql) : void
	{
		/*
		 * Add benchmark data to database
		 */
		$this->db->query($sql);
		try {
			$this->db->execute();
			echo 'New record created successfully<br>';
		} catch (PDOException $e) {
			echo $sql . '<br>' . $e->getMessage();
		}
	}
}
