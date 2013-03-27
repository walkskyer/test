<?php
/**
 * Created by JetBrains PhpStorm.
 * User: weijie
 * Date: 13-3-20
 * Time: 上午9:47
 * File: read.php
 * To change this template use File | Settings | File Templates.
 */
$zip = zip_open("test.zip");
if ($zip) {
    while ($zip_entry = zip_read($zip)) {
        echo "Name: " . zip_entry_name($zip_entry) . "<br/>";
        var_dump(pathinfo(zip_entry_name($zip_entry)));
        echo "Actual Filesize: " . zip_entry_filesize($zip_entry) . "<br/>";
        echo "Compressed Size: " . zip_entry_compressedsize($zip_entry) . "<br/>";
        echo "Compression Method: " . zip_entry_compressionmethod($zip_entry) . "<br/>";
        if (zip_entry_open($zip, $zip_entry, "r")) {
            echo "File Contents:" . "<br/>";
            $buf = htmlspecialchars(zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));
            echo "$buf";
            zip_entry_close($zip_entry);
        }
        echo "<br/>";
    }
    zip_close($zip);
}
?>