<?php

class DSHelper {

    public static function readContent($file_name) {
        $filename = $file_name;
        $handle = fopen($filename, "rb");
        $fsize = filesize($filename);
        $contents = fread($handle, $fsize);
        // $byteArray = unpack("N*",$contents);
        // $str=implode(array_map("chr", $cont));
        print($str);
        return $contents;
    }

    public static function printPrettyJSON($json) {
        $pp = json_encode($json, JSON_PRETTY_PRINT);
        $pp = str_replace ( '\/' , '/' , $pp );
        printf ("%s\n", $pp);
    }
}

?>