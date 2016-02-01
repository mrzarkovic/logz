<?php

namespace Tourizm\Model;

if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends Repository {

	protected static $fields = array(
		"id" => "int",
		"username" => "string",
		"password" => "string",
	);

	public function __construct($row = array()) {
		parent::__construct($row = array());

		$this->list = array();
		$this->total = 0;
/*
		$this->id = (int)(isset($row['id']) ? $row['id'] : 0);
		$this->username = (isset($row['username']) ? $row['username'] : "");
		$this->password = (isset($row['password']) ? $row['password'] : "");
*/
	}

	/**
	 * Check to see if user is logged in
	 * @return bool
	 */
	public function user_logged_in() {
		if (isset($_SESSION['username'])) {
			return true;
		}
		return false;
	}

	/**
	 * Log in user to the system
	 * Add username to $_SESSION['username']
	 * @return bool
	 */
	public function login_user($username = "", $password = "") {
		if ($this->_check_credentials($username, $password)) {
			$_SESSION['username'] = $username;
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check user credentials
	 * @param  string $username
	 * @param  string $password
	 * @return bool
	 */
	private function _check_credentials($username = "", $password = "") {
		// Prevent SQL Injection
		$username = $this->connection->real_escape_string($username);
		$password = $this->connection->real_escape_string($password);

		// Encrypt the pasword
		$password = md5($password);

		// Check credentials
		$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

		$result = $this->connection->query($sql);

		if ($result->num_rows > 0) {
			return true;
		}
		return false;
	}

	/**
	 * Log out user from the system
	 * @return HTTP redirect
	 */
	public function logout_user() {
		// Check if user is logged in
		if ($user = $this->user_logged_in()) {
			// Remove all session variables
			session_unset();
		}
		header('Location: /login');
	}
}
