<?php
/**
 * Ping server utility
 *
 * This file provides a web interface for pinging network targets.
 * Allows users to test network connectivity to specified hosts.
 *
 * @category  Network
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
<h2>Ping Server</h2>
<form>
    <input name="target" placeholder="Enter hostname or IP..." 
           maxlength="100" required>
    <button>Ping!</button>
</form>
<?php
if (isset($_GET['target'])) {
    $target = trim($_GET['target'] ?? '');
    
    // ✅ input validation - only allow valid hostnames and IPs
    if ($target !== '' && strlen($target) <= 100) {
        // ✅ validate hostname format
        if (filter_var($target, FILTER_VALIDATE_DOMAIN) 
            || filter_var($target, FILTER_VALIDATE_IP)
            || preg_match('/^[a-zA-Z0-9\-\.]+$/', $target)
        ) {
            // ✅ escape shell arguments
            $escapedTarget = escapeshellarg($target);
            $output = shell_exec("ping -c 2 " . $escapedTarget);
            
            $targetEscaped = htmlspecialchars($target, ENT_QUOTES, 'UTF-8');
            $outputEscaped = htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
            echo "<h3>Ping Result for: $targetEscaped</h3>";
            echo "<pre>$outputEscaped</pre>";
        } else {
            echo "<p style='color:red'>Invalid hostname or IP address.</p>";
        }
    } else {
        echo "<p style='color:red'>Missing or invalid target parameter.</p>";
    }
}
?>
<?php require_once '_footer.php'; ?>