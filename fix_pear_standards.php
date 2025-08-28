<?php
/**
 * Script to fix PEAR standards in all PHP files
 *
 * This script automatically fixes doc comment formatting
 * to comply with PEAR coding standards.
 *
 * @category  Tools
 * @package   SCXLab
 * @author    Muham <muham@example.com>
 * @copyright 2024 Muham
 * @license   https://opensource.org/licenses/MIT MIT License
 * @since     PHP 7.4
 * @version   GIT: $Id$
 * @link      https://github.com/username/scxlab
 */

$files = [
    'app/auth.php',
    'app/index.php',
    'app/logout.php',
    'app/crash.php',
    'app/dashboard.php',
    'app/ping.php',
    'app/wiki.php',
    'app/comment.php',
    'app/_header.php',
    'app/_footer.php',
    'app/init.php',
    'app/login.php',
    'app/profile.php'
];

$template = '<?php
/**
 * {DESCRIPTION}
 *
 * {LONG_DESCRIPTION}
 *
 * @category  {CATEGORY}
 * @package   SCXLab
 * @author    Muham <muham@example.com>
 * @copyright 2024 Muham
 * @license   https://opensource.org/licenses/MIT MIT License
 * @since     PHP 7.4
 * @version   GIT: $Id$
 * @link      https://github.com/username/scxlab
 */

';

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "Processing: $file\n";
        
        $content = file_get_contents($file);
        
        // Extract existing description and category
        if (preg_match('/\*\*([^*]+)\*\//s', $content, $matches)) {
            $docBlock = $matches[1];
            
            // Extract description
            if (preg_match('/\*\s*([^*\n]+)/', $docBlock, $descMatches)) {
                $description = trim($descMatches[1]);
            }
            
            // Extract long description
            if (preg_match('/\*\s*([^*\n]+)\n\s*\*\s*([^*\n]+)/', $docBlock, $longDescMatches)) {
                $longDescription = trim($longDescMatches[2]);
            }
            
            // Determine category based on filename
            $category = 'Core';
            if (strpos($file, 'auth') !== false || strpos($file, 'login') !== false || strpos($file, 'profile') !== false) {
                $category = 'Security';
            } elseif (strpos($file, 'ping') !== false) {
                $category = 'Network';
            } elseif (strpos($file, 'wiki') !== false || strpos($file, 'comment') !== false) {
                $category = 'Content';
            } elseif (strpos($file, 'crash') !== false) {
                $category = 'Testing';
            } elseif (strpos($file, '_header') !== false || strpos($file, '_footer') !== false) {
                $category = 'Template';
            }
            
            // Replace doc block
            $newDocBlock = str_replace(
                ['{DESCRIPTION}', '{LONG_DESCRIPTION}', '{CATEGORY}'],
                [$description, $longDescription, $category],
                $template
            );
            
            $newContent = preg_replace(
                '/<\?php\s*\/\*\*[^*]*\*\/\s*/s',
                $newDocBlock,
                $content
            );
            
            file_put_contents($file, $newContent);
            echo "Fixed: $file\n";
        }
    }
}

echo "All files processed!\n";
?>
