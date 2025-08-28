<?php
/**
 * User profile management
 *
 * This file handles user profile display and admin functionality.
 * Allows admins to delete other users and displays profile information.
 *
 * @package    SCXLab
 * @author     Your Name
 * @copyright  2024
 * @license    MIT
 */

require_once 'auth.php';

/**
 * User profile class
 *
 * Represents a user profile with username and admin status.
 *
 * @package    SCXLab
 * @author     Your Name
 * @copyright  2024
 * @license    MIT
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
     * String representation of the profile
     *
     * @return string
     */
    public function __toString(): string
    {
        return "User: {$this->username}, Role: " . ($this->isAdmin ? "Admin" : "User");
    }
}

if (!isset($_COOKIE['profile'])) {
    die("Profile cookie tidak ditemukan. Silakan login ulang.");
}

// ✅ safer cookie handling (avoid unserialize)
try {
    $profileData = base64_decode($_COOKIE['profile']);
    $profileArray = json_decode($profileData, true, 512, JSON_THROW_ON_ERROR);
    
    if (!isset($profileArray['username']) || !isset($profileArray['isAdmin'])) {
        throw new Exception('Invalid profile data');
    }
    
    $profile = new Profile($profileArray['username'], $profileArray['isAdmin']);
} catch (Exception $e) {
    die("Profile data corrupted. Silakan login ulang.");
}

// ✅ jika admin, boleh hapus user lain dengan prepared statement
if ($profile->isAdmin && isset($_POST['delete_user'])) {
    $target = trim($_POST['delete_user']);
    
    // ✅ input validation
    if (preg_match('/^[a-zA-Z0-9_]+$/', $target) && $target !== $profile->username) {
        $stmt = $GLOBALS['PDO']->prepare("DELETE FROM users WHERE username = :target");
        $stmt->execute([':target' => $target]);
        
        if ($stmt->rowCount() > 0) {
            $msg = "<p style='color:green'>User <b>" . htmlspecialchars($target, ENT_QUOTES, 'UTF-8') . "</b> berhasil dihapus!</p>";
        } else {
            $msg = "<p style='color:red'>User tidak ditemukan atau gagal dihapus.</p>";
        }
    } else {
        $msg = "<p style='color:red'>Invalid username or cannot delete yourself.</p>";
    }
}

require_once '_header.php';
?>
<h2>Profile Page</h2>
<p><?php echo htmlspecialchars($profile->__toString(), ENT_QUOTES, 'UTF-8'); ?></p>

<?php if ($profile->isAdmin) : ?>
    <h3>Admin Panel</h3>
    <form method="post">
        <label>Delete user:
            <select name="delete_user">
                <?php
                // ✅ use prepared statement
                $stmt = $GLOBALS['PDO']->prepare("SELECT username FROM users WHERE username != :current_user");
                $stmt->execute([':current_user' => $profile->username]);
                $users = $stmt->fetchAll();
                
                foreach ($users as $u) {
                    echo "<option value='" . htmlspecialchars($u['username'], ENT_QUOTES, 'UTF-8') . "'>" . 
                         htmlspecialchars($u['username'], ENT_QUOTES, 'UTF-8') . "</option>";
                }
                ?>
            </select>
        </label>
        <button type="submit">Delete</button>
    </form>
    <?php if (!empty($msg)) : ?>
        <?php echo $msg; ?>
    <?php endif; ?>
<?php else : ?>
    <p style="color:red">You are a regular user. You do not have admin panel access.</p>
<?php endif; ?>

<?php require_once '_footer.php'; ?>