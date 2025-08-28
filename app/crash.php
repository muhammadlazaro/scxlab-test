<?php
/**
 * Crash test page
 *
 * This file demonstrates a simple division operation
 * that can cause crashes when dividing by zero.
 *
 * @package    SCXLab
 * @author     Your Name
 * @copyright  2024
 * @license    MIT
 */

require_once 'auth.php';
require_once '_header.php';
?>
<h2>Crash Test</h2>
<form>
    <input name="factor" type="number" placeholder="Enter divisor..." min="1" max="1000" value="1">
    <button>Calculate</button>
</form>
<?php
$factor = isset($_GET['factor']) ? (int)$_GET['factor'] : 1;

// ✅ input validation and safe division
if ($factor > 0 && $factor <= 1000) {
    $result = 100 / $factor; 
    echo "<p>100 / " . htmlspecialchars($factor, ENT_QUOTES, 'UTF-8') . " = " . 
         htmlspecialchars($result, ENT_QUOTES, 'UTF-8') . "</p>";
} else {
    echo "<p style='color:red'>Please enter a valid divisor between 1 and 1000.</p>";
}
?>
<?php require_once '_footer.php'; ?>