<?php
/**
 * Comment system
 *
 * This file handles posting and displaying user comments.
 * Provides a form for users to submit comments and displays
 * existing comments in reverse chronological order.
 *
 * @package    SCXLab
 * @author     Your Name
 * @copyright  2024
 * @license    MIT
 */

require_once 'auth.php';
require_once '_header.php';
?>
<h2>Post comments</h2>
<form method="post">
    <input name="author" placeholder="Name..." required maxlength="50">
    <textarea name="content" placeholder="Comments..." required maxlength="500"></textarea>
    <button>Post</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $author = trim($_POST['author'] ?? '');
    $content = trim($_POST['content'] ?? '');
    
    // ✅ input validation
    if ($author !== '' && $content !== '' && 
        preg_match('/^[a-zA-Z0-9\s\-_\.]+$/', $author) && 
        strlen($author) <= 50 && strlen($content) <= 500) {
        
        // ✅ use prepared statement
        $stmt = $GLOBALS['PDO']->prepare(
            "INSERT INTO comments(author,content,created_at) VALUES(?,?,datetime('now'))"
        );
        $stmt->execute([$author, $content]);
    }
}
?>
<h3>Comment lists : </h3>
<?php
// ✅ use prepared statement
$stmt = $GLOBALS['PDO']->prepare("SELECT * FROM comments ORDER BY id DESC");
$stmt->execute();
$comments = $stmt->fetchAll();

foreach ($comments as $row) {
    echo "<p><b>" . htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8') . "</b>: " . 
         htmlspecialchars($row['content'], ENT_QUOTES, 'UTF-8') . "</p>";
}
?>
<?php require_once '_footer.php'; ?>