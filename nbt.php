<?php
require __DIR__."/_autoload.php";
use Phpcraft\
{Connection, Phpcraft};
$con = new Connection();
if(empty($argv[1]))
{
	$con->read_buffer = "";
	if(!Phpcraft::isWindows())
	{
		$fh = fopen("php://stdin", "r");
		stream_set_blocking($fh, false);
		$con->read_buffer = stream_get_contents($fh);
	}
	if($con->read_buffer === "")
	{
		echo "Syntax: php nbt.php <file>\n";
		if(!Phpcraft::isWindows())
		{
			echo "or: echo \"...\" | php nbt.php\n";
		}
		exit;
	}
}
else
{
	$con->read_buffer = file_get_contents($argv[1]);
}
try
{
	$tag = $con->readNBT();
}
catch(Exception $e)
{
	$con->read_buffer = @zlib_decode($con->read_buffer);
	if(!$con->read_buffer)
	{
		die("Invalid NBT: ".$e->getMessage()."\nUncompressing failed.\n");
	}
	try
	{
		$tag = $con->readNBT();
	}
	catch(Exception $e_)
	{
		die("Invalid NBT.\nNormal reading threw: ".$e->getMessage()."\nUncompressed reading threw: ".$e_->getMessage()."\n");
	}
}
if($con->hasRemainingData())
{
	$bytes = strlen($con->read_buffer);
	echo "Warning: NBT has been read, but {$bytes} byte".($bytes == 1 ? "" : "s")." remain".($bytes == 1 ? "s" : "").": ".bin2hex($con->getRemainingData())."\n";
}
echo "::: String Dump\n";
echo $tag->__toString()."\n";
echo "::: SNBT\n";
echo $tag->toSNBT(false)."\n";
echo "::: Pretty SNBT\n";
echo $tag->toSNBT(true)."\n";
