<?php
/**
 * Application initialization
 *
 * This file initializes the database connection and creates
 * necessary tables and seed data if they don't exist.
 *
 * @category  Core
 * @package   SCXLab
 * @author    Muham <muham@example.com>
 * @copyright 2024 Muham
 * @license   https://opensource.org/licenses/MIT MIT License
 * @version   1.0.0
 * @link      https://github.com/username/scxlab
 */

$dbFile = __DIR__ . '/data/app.db';
$needSeed = !file_exists($dbFile);

$pdo = new PDO('sqlite:' . $dbFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($needSeed) {
    $pdo->exec(
        "CREATE TABLE users(id INTEGER PRIMARY KEY, username TEXT UNIQUE, " .
        "password TEXT, role TEXT);" .
        "CREATE TABLE articles(id INTEGER PRIMARY KEY, title TEXT, body TEXT);" .
        "CREATE TABLE comments(id INTEGER PRIMARY KEY, author TEXT, " .
        "content TEXT, created_at TEXT);"
    );
    
    // ✅ use password hashing for security
    $alicePassword = password_hash('alice123', PASSWORD_DEFAULT);
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    
    $pdo->exec(
        "INSERT INTO users(username,password,role) VALUES('alice'," . 
        $pdo->quote($alicePassword) . ",'user')"
    );
    $pdo->exec(
        "INSERT INTO users(username,password,role) VALUES('admin'," . 
        $pdo->quote($adminPassword) . ",'admin')"
    );
    $pdo->exec(
        "INSERT INTO articles(title,body) VALUES('PHP','Server side scripting')"
    );
    $pdo->exec(
        "INSERT INTO articles(title,body) VALUES('Java','Programming language')"
    );
}

$GLOBALS['PDO'] = $pdo;