<?php
class model {
	protected $db;

	function __construct() {
		global $db;
		$this->db = $db;
	}
}