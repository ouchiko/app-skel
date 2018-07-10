<?php
/**
 * Database setup.
 */
try {
    if ($_SERVER['MODE'] == "production") {
        $db = $settings['settings']['db']["default"];
    } else {
        $db = $settings['settings']['db']["live"];
    }
    
    $GLOBALS['db'] = new trains\models\database\DBMysql(
        $db['host'],
        $db['user'],
        $db['pass']
    );
} catch (\Exception $dbConnectionException) {
    print "<XMP>";
    print_r($dbConnectionException);
}
