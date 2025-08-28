<?php
/**
 * Crash test page
 *
 * This file demonstrates a simple division operation
 * that can cause crashes when dividing by zero.
 *
 * @category  Testing
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
<h2>Crash Test</h2>
<form>
    <input name="factor" type="number" placeholder="Enter divisor..." 
           min="1" max="1000" value="1">
    <button>Calculate</button>
</form>
<?php
$factor = isset($_GET['factor']) ? (int)$_GET['factor'] : 1;

// ✅ input validation and safe division
if ($factor > 0 && $factor <= 1000) {
    $result = 100 / $factor; 
    $factorEscaped = htmlspecialchars($factor, ENT_QUOTES, 'UTF-8');
    $resultEscaped = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
    echo "<p>100 / $factorEscaped = $resultEscaped</p>";
} else {
    echo "<p style='color:red'>Please enter a valid divisor between 1 and 1000.</p>";
}
?>
<?php require_once '_footer.php'; ?>