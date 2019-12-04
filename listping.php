<?php /** @noinspection PhpUnhandledExceptionInspection */
if(empty($argv[1]))
{
	die("Syntax: listping <ip[:port]> [method]\n");
}
require __DIR__."/_autoload.php";
use Phpcraft\
{ChatComponent, Phpcraft, Versions};
echo "Phpcraft Server List Ping Tool\n\nResolving...";
$server = Phpcraft::resolve($argv[1]);
$serverarr = explode(":", $server);
if(count($serverarr) != 2)
{
	die(" Failed to resolve name. Got {$server}\n");
}
echo " Requesting status from {$server}...";
$info = Phpcraft::getServerStatus($serverarr[0], intval($serverarr[1]), 3, $argv[2] ?? 0);
echo "\n\n";
if(empty($info))
{
	die("Failed to get status.\n");
}
if(isset($info["description"]))
{
	echo ChatComponent::cast($info["description"])->toString(ChatComponent::FORMAT_ANSI)."\e[0m\n\n";
}
else
{
	echo "This server has no description/MOTD.\n";
}
if(isset($info["version"]))
{
	if(isset($info["version"]["name"]))
	{
		echo "This server is running ".$info["version"]["name"].".";
	}
	else
	{
		echo "The server did not provide a version name.";
	}
	if(isset($info["version"]["protocol"]))
	{
		echo " The protocol version (".$info["version"]["protocol"].") ";
		if($minecraft_version = Versions::protocolToRange($info["version"]["protocol"]))
		{
			echo "suggests ".$minecraft_version.", which Phpcraft ";
			if(Versions::protocolSupported($info["version"]["protocol"]))
			{
				echo "supports.";
			}
			else
			{
				echo "doesn't support.";
			}
		}
		else
		{
			echo "is invalid.";
		}
	}
	echo "\n";
}
if(isset($info["players"]))
{
	$sample = "";
	if(isset($info["players"]["sample"]))
	{
		foreach($info["players"]["sample"] as $player)
		{
			if(isset($player["name"]))
			{
				if($sample == "")
				{
					$sample = $player["name"];
				}
				else
				{
					$sample .= ", ".$player["name"];
				}
			}
		}
	}
	echo "There are ".($info["players"]["online"] ?? "???")."/".($info["players"]["max"] ?? "???")." players online".(($sample == "") ? "." : ": ".$sample)."\n";
}
echo "The server answered the status request within ".round($info["ping"] * 1000)." ms.\n";
