--TEST--
Python: Object (read_dimension)
--SKIPIF--
<?php if (!extension_loaded('python')) die("skip\n");
--FILE--
<?php
$py = python_eval('(1, 2, 3)');
var_dump($py[1]);
--EXPECT--
int(2)
