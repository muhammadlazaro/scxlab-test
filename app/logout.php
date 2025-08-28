<?php
/**
 * User logout functionality
 *
 * This file handles user logout by destroying the session
 * and redirecting to the login page.
 *
 * @package    SCXLab
 * @author     Your Name
 * @copyright  2024
 * @license    MIT
 */

session_start();
session_destroy();
header("Location: login.php");
exit;