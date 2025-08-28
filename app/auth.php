<?php
/**
 * Authentication and session management
 *
 * This file handles user authentication and session validation.
 * It redirects unauthenticated users to the login page.
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
require_once __DIR__ . '/init.php';

if (!isset($_SESSION['user']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header("Location: login.php");
    exit;
}
