<?php
    function clean($string)
    {
        $c       = array (',');
        $string  = str_replace($c, '', $string);
        return $string;
    }

    function clean2($string)
    {
        $c       = array (',','-','_');
        $string  = str_replace($c, ' ', $string);
        return $string;
    }
?>
