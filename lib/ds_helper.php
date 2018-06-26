<?php

class DSHelper {

    public static function readContent($file_name) {

        $filename = realpath($file_name);
        $handle = fopen($filename, "rb");
        $fsize = filesize($filename);
        $contents = fread($handle, $fsize);
        return $contents;
    }

    public static function printPrettyJSON($json) {
        foreach($json as $key => $value) {
            $pp = json_encode($value, JSON_FORCE_OBJECT);
            $pp = str_replace ( '\/' , '/' , $pp );
            printf ("\n%s\n", $pp);
        }
    }

    public static function ensureDirExistance($dirName) {

        if(!file_exists($dirName)) {
            mkdir($dirName, 0777, true);
        }

        return realpath($dirName);
    }

    public static function writeByteArrayToFile($path, $bytesArray) {
        $fp = fopen($bytesArray->getRealPath(),"rb");
        $out = fopen($path,"wb");
        while (!feof($fp)) {
            // Read the file, in chunks of 16 byte
            $data = fread($fp,16);
            fwrite($out, $data);
        }
        fclose($fp);
        fclose($out);
    }

    public static function endsWith($haystack, $needle) {
        $length = strlen($needle);
        return $length === 0 || (substr($haystack, -$length) === $needle);
    }
}

?>