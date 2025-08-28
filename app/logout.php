<?php
/**
 * User logout functionality
 *
 * This file handles user logout by destroying the session
 * and redirecting to the login page.
 *
 * @category  Security
 * @package   SCXLab
 * @author    Muham <muham@example.com>
 * @copyright 2024 Muham
 * @license   https://opensource.org/licenses/MIT MIT License
 * @version   1.0.0
 * @link      https://github.com/username/scxlab
 */

session_start();
session_destroy();
header("Location: login.php");
exit;