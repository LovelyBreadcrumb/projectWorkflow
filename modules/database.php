<!-- Database connection module -->
<?php
    class MyDB extends SQLite3
        {
            function __construct()
            {
                $this->open($_SERVER['DOCUMENT_ROOT'] . '/data/workflow.db'); 
            }
        }
        $db = new MyDB();
        if(!$db)
        {
            echo    '<div id="alert" class="alert bad" onclick="document.getElementById(\'alert\').style.display=\'none\';">
                        <span><strong>Database Error:</strong> ' . $db->lastErrorMsg() . '</span>
                    </div>';
        }

    $my_username = get_current_user();
    $my_name = $db->query('SELECT USER_NAME FROM users WHERE USER_USERNAME="' . $my_username . '"');
    $my_name = $my_name->fetchArray()[0];

    function stringToColorCode($str) {
        $code = dechex(crc32($str));
        $code = substr($code, 0, 6);
        return $code;
    }

?>