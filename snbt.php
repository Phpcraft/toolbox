<?php
require __DIR__."/_autoload.php";
use Phpcraft\
{Connection, NBT\NBT, Phpcraft};
if(empty($argv[1]))
{
	$in = "";
	if(!Phpcraft::isWindows())
	{
		$fh = fopen("php://stdin", "r");
		stream_set_blocking($fh, false);
		$in = stream_get_contents($fh);
	}
	if($in === "")
	{
		echo "Syntax: snbt <snbt>\n";
		if(!Phpcraft::isWindows())
		{
			echo "or: echo \"...\" | php snbt.php\n";
		}
		exit;
	}
}
else
{
	$in = join(" ", array_slice($argv, 1));
}
$tag = NBT::fromSNBT($in);
echo "::: Pretty SNBT\n";
echo $tag->toSNBT(true)."\n";
echo "::: String Dump\n";
echo $tag->__toString()."\n";
echo "::: NBT Hex\n";
$con = new Connection(-1);
$tag->write($con);
echo preg_replace("/(.{2})/", "$1 ", bin2hex($con->write_buffer))."\n";
