<?php

// Note, the script requires PHP 5.5 or higher
namespace TestProject;

use TestProject\Engine as E;

if (version_compare(PHP_VERSION, '5.5.0', '<'))
    exit('Su versión de PHP es ' . PHP_VERSION . '. Y nuestra aplicación requiere PHP 5.5.0 :(');
if (!extension_loaded('mbstring'))
    exit('Nuestro programa requiere la extención "mbstring" para PHP. Por favor, instale este complemento en su servidor.');


// Set constants (root server path + root URL)
define('PROT', (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://');
define('ROOT_URL', PROT . $_SERVER['HTTP_HOST'] . str_replace('\\', '', dirname(htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES))) . '/'); // Remove backslashes for Windows compatibility
define('URL_FILE', ROOT_URL . "Files/");
define('ROOT_PATH', __DIR__ . '/');
define('PATH_FILE', ROOT_PATH . 'Files/');

try
{
    require ROOT_PATH . 'Engine/Loader.php';
    E\Loader::getInstance()->init(); // Load necessary classes
    $aParams =
    [
      'ctrl' => (!empty($_GET['p']) ? $_GET['p'] : 'blog'),
      'act' => (!empty($_GET['a']) ? $_GET['a'] : 'index')
      //'file_type' => (!empty($_GET['file_type'] ? $_GET['file_type'] : 'none'))
    ]; // I use the new PHP 5.4 short array syntax
    E\Router::run($aParams);
}
catch (\Exception $oE)
{
    echo $oE->getMessage();
}
