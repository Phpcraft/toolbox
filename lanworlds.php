<?php
require __DIR__."/_autoload.php";
use Asyncore\Asyncore;
use Phpcraft\
{ChatComponent, LanInterface};
if(function_exists("sapi_windows_vt100_support"))
{
	sapi_windows_vt100_support(STDOUT, true);
}
$li = new LanInterface();
Asyncore::add(function() use (&$li)
{
	$li->discover();
	echo "\e[2J\e[H\e[m";
	if(count($li->servers) == 0)
	{
		echo "No LAN worlds found.\n";
	}
	else
	{
		echo count($li->servers)." LAN world".(count($li->servers) == 1 ? "" : "s")." found:\n\n";
		foreach($li->servers as $server)
		{
			echo ChatComponent::cast($server["motd"])->toString(ChatComponent::FORMAT_ANSI)."\e[m\n\e[37m".$server["host"].":".$server["port"]."\e[m\n\n";
		}
	}
}, 1.5, true);
Asyncore::loop();
