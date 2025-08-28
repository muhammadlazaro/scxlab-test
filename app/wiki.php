<?php
/**
 * Wiki search functionality
 *
 * This file provides a search interface for wiki articles.
 * Allows users to search through article titles and content.
 *
 * @package    SCXLab
 * @author     Your Name
 * @copyright  2024
 * @license    MIT
 */

require_once 'auth.php';
require_once '_header.php';
?>
<h2>Wiki Search</h2>
<form>
    <input name="q" placeholder="Search articles..." maxlength="100">
    <button>Search</button>
</form>
<?php
if (isset($_GET['q'])) {
    $q = trim($_GET['q'] ?? '');
    
    // ✅ input validation
    if ($q !== '' && strlen($q) <= 100) {
        // ✅ use prepared statement
        $stmt = $GLOBALS['PDO']->prepare("SELECT * FROM articles WHERE title LIKE :q");
        $stmt->execute([':q' => '%' . $q . '%']);
        $articles = $stmt->fetchAll();
        
        echo "<p>Query: " . htmlspecialchars("SELECT * FROM articles WHERE title LIKE '%$q%'", ENT_QUOTES, 'UTF-8') . "</p>";
        
        if (empty($articles)) {
            echo "<p>No articles found.</p>";
        } else {
            foreach ($articles as $row) {
                echo "<li>" . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . ": " . 
                     htmlspecialchars($row['body'], ENT_QUOTES, 'UTF-8') . "</li>";
            }
        }
    }
}
?>
<?php require_once '_footer.php'; ?>