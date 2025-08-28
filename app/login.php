<?php
/**
 * Login handler for Secure Coding Exam Lab
 *
 * This script handles user authentication securely using prepared statements,
 * password hashing, and safer session/cookie handling.
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

require_once 'auth.php';

/**
 * Class Profile
 *
 * Represents user profile data and role.
 *
 * @category  Security
 * @package   SCXLab
 * @author    Muham <muham@example.com>
 * @copyright 2024 Muham
 * @license   https://opensource.org/licenses/MIT MIT License
 * @since     PHP 7.4
 * @version   Release: 1.0.0
 * @link      https://github.com/username/scxlab
 */
class Profile
{
    /**
     * Username of the user
     *
     * @var string
     */
    public string $username;

    /**
     * Whether the user is an admin
     *
     * @var boolean
     */
    public bool $isAdmin = false;

    /**
     * Profile constructor.
     *
     * @param string $u       Username
     * @param bool   $isAdmin Admin status
     */
    public function __construct(string $u, bool $isAdmin = false)
    {
        $this->username = $u;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Convert profile object to string.
     *
     * @return string
     */
    public function __toString(): string
    {
        $role = $this->isAdmin ? "Admin" : "User";
        return "User: {$this->username}, Role: $role";
    }
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? '');
    $p = $_POST['password'] ?? '';

    if ($u !== '' && $p !== '') {
        // ✅ use prepared statements
        $stmt = $GLOBALS['PDO']->prepare(
            "SELECT * FROM users WHERE username = :u LIMIT 1"
        );
        $stmt->execute([':u' => $u]);
        $row = $stmt->fetch();

        if ($row && password_verify($p, $row['password'])) {
            // ✅ session handling
            session_regenerate_id(true);
            $_SESSION['user'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // ✅ safer cookie (avoid serialize)
            $pObj = new Profile($row['username'], $row['role'] === 'admin');
            setcookie(
                'profile',
                base64_encode(json_encode($pObj)),
                [
                    'httponly' => true,
                    'samesite' => 'Strict',
                    'secure'   => isset($_SERVER['HTTPS'])
                ]
            );

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Login failed.";
        }
    } else {
        $error = "Username and password required.";
    }
}
?>

<?php require_once '_header.php'; ?>

<h2>Login</h2>

<?php if (!empty($error)) : ?>
    <p style="color:red"><?php 
        echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); 
    ?></p>
<?php endif; ?>

<form method="post">
    <label>Username <input name="username" required></label>
    <label>Password <input type="password" name="password" required></label>
    <button type="submit">Login</button>
</form>

<?php require_once '_footer.php'; ?>