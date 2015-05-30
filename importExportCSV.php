<?php
$c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
$rtrsgrs = oci_parse($c, 'CREATE OR REPLACE DIRECTORY TESTING AS \'C:\SUSU\'/');
$granting=oci_parse($c,' GRANT READ,WRITE ON DIRECTORY TESTING TO sys');

$file = oci_parse($c, 'begin :banana := IMPORT_FROM_CSV(:filename); end;');

oci_close($c)