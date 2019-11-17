<?php
if(!is_file(__DIR__."/vendor/autoload.php"))
{
	echo "vendor/autoload.php was not found, attempting to generate it...\n";
	passthru("composer install -o -d \"".__DIR__."\" --no-suggest --ignore-platform-reqs");
	if(!is_file(__DIR__."/vendor/autoload.php"))
	{
		die("Welp, that didn't work. Try again as root/administrator.\n");
	}
}
require __DIR__."/vendor/autoload.php";
