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
 * @since     PHP 7.4
 * @version   GIT: $Id$
 * @link      https://github.com/username/scxlab
 */

session_start();
session_destroy();
header("Location: login.php");
exit;