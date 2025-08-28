<?php
/**
 * User dashboard page
 *
 * This file displays the main dashboard for authenticated users.
 * Shows user information and navigation options.
 *
 * @category  Core
 * @package   SCXLab
 * @author    Muham <muham@example.com>
 * @copyright 2024 Muham
 * @license   https://opensource.org/licenses/MIT MIT License
 * @since     PHP 7.4
 * @version   GIT: $Id$
 * @link      https://github.com/username/scxlab
 */

require_once 'auth.php';
require_once '_header.php';
?>
<h2>Dashboard</h2>
<p>Welcome <b><?php 
    echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); 
?></b>!</p>
<p>Use the menu above to access the web page.</p>
<?php require_once '_footer.php'; ?>
