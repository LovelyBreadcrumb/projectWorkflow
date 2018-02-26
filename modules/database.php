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

    function stringToColorCode($str) {
        $code = dechex(crc32($str));
        $code = substr($code, 0, 6);

        $code = rgbToHsl(hexToRgb($code));
        $str_code = 'hsl(' . $code[0] . ', ' . $code[1] . '%, ' . $code[2] . '%)';
        return $str_code;
    }

    function hexToRgb($hex) {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
        return array($r, $g, $b);
    }

    function rgbToHsl($rgb){
    $clrR = ($rgb[0]);
    $clrG = ($rgb[1]);
    $clrB = ($rgb[2]);
     
    $clrMin = min($clrR, $clrG, $clrB);
    $clrMax = max($clrR, $clrG, $clrB);
    $deltaMax = $clrMax - $clrMin;
     
    $L = ($clrMax + $clrMin) / 510;
     
    if (0 == $deltaMax){
        $H = 0;
        $S = 0;
    }
    else{
        if (0.5 > $L){
            $S = $deltaMax / ($clrMax + $clrMin);
        }
        else{
            $S = $deltaMax / (510 - $clrMax - $clrMin);
        }

        if ($clrMax == $clrR) {
            $H = ($clrG - $clrB) / (6.0 * $deltaMax);
        }
        else if ($clrMax == $clrG) {
            $H = 1/3 + ($clrB - $clrR) / (6.0 * $deltaMax);
        }
        else {
            $H = 2 / 3 + ($clrR - $clrG) / (6.0 * $deltaMax);
        }

        if (0 > $H) $H += 1;
        if (1 < $H) $H -= 1;
    }
    $H = $H*100;
    $S = $S*100;
    $L = $L*100;
    return array($H, $S, $L);
}
?>