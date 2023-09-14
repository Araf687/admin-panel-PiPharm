<?php

$arr=array("A","a","asd","kdl","akk");
$arr2=array();
array_push($arr2,"ksjkj");
print_r($arr2);
print_r(array_search("asdbb",$arr)."|");

echo gettype(array_search("asdbb",$arr));
?>