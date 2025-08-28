<?php
/**
 * Authentication and session management
 *
 * This file handles user authentication and session validation.
 * It redirects unauthenticated users to the login page.
 *
 * @package    SCXLab
 * @author     Your Name
 * @copyright  2024
 * @license    MIT
 */

session_start();
require_once __DIR__ . '/init.php';

if (!isset($_SESSION['user']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header("Location: login.php");
    exit;
}
