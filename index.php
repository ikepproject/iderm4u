<?php

// Check PHP version.
$minPhpVersion = '8.2'; // If you update this, don't forget to update `spark`.
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );

    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo $message;

    exit(1);
}

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
chdir(FCPATH);

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// Load our paths config file
// This is the line that might need to be changed, depending on your folder structure.
require FCPATH . 'app/Config/Paths.php';
// ^^^ Change this line if you move your application folder

$paths = new Config\Paths();

// LOAD THE FRAMEWORK BOOTSTRAP FILE
//
// CodeIgniter 4.5 moved the bootstrap out of system/bootstrap.php into
// system/Boot.php. The old path still exists on 4.5+ but is a dead file
// that returns HTTP 503 and prints "the upgrade is not complete" — it
// does NOT bootstrap anything. Requiring it means every request 503s.
//
// Note the front controller stays at the PROJECT ROOT in this application
// (FCPATH is the project root, not public/ as in the stock appstarter).
// The views hardcode /public/assets/... URLs, so moving index.php into
// public/ would break every asset reference.
require $paths->systemDirectory . '/Boot.php';

exit(\CodeIgniter\Boot::bootWeb($paths));
