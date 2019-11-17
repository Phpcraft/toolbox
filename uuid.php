<?php
if(empty($argv[1]))
{
	die("Syntax: uuid <uuid>\n");
}
require __DIR__."/_autoload.php";
use hellsh\UUID;
$uuid = new UUID($argv[1]);
echo "With Dashes: ".$uuid->toString(true)."\nWithout Dashes: ".$uuid->toString(false)."\nHash Code: ".$uuid->hashCode()." (".($uuid->hashCode() & 1 ? "Odd number = Alex" : "Even number = Steve")."-type skin)\n";
