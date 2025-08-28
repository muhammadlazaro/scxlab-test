<?php
/**
 * Wiki search functionality
 *
 * This file provides a search interface for wiki articles.
 * Allows users to search through article titles and content.
 *
 * @category  Content
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
        $stmt = $GLOBALS['PDO']->prepare(
            "SELECT * FROM articles WHERE title LIKE :q"
        );
        $stmt->execute([':q' => '%' . $q . '%']);
        $articles = $stmt->fetchAll();
        
        $queryText = "SELECT * FROM articles WHERE title LIKE '%$q%'";
        $queryEscaped = htmlspecialchars($queryText, ENT_QUOTES, 'UTF-8');
        echo "<p>Query: $queryEscaped</p>";
        
        if (empty($articles)) {
            echo "<p>No articles found.</p>";
        } else {
            foreach ($articles as $row) {
                $titleEscaped = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
                $bodyEscaped = htmlspecialchars($row['body'], ENT_QUOTES, 'UTF-8');
                echo "<li>$titleEscaped: $bodyEscaped</li>";
            }
        }
    }
}
?>
<?php require_once '_footer.php'; ?>