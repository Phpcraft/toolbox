# Phpcraft Toolbox

CLI tools all about Minecraft: Java Edition.

## Installation

I recommend you install Phpcraft Toolbox using [Cone](https://getcone.org), as it makes the tools accessable in any directory:

```Bash
cone get phpcraft-toolbox
```

Otherwise, you can also clone this repository, run `composer install` and enjoy your single-directory toolbox.

## The Tools

- `listping <ip[:port]> [method]` displays the server list information of the given server. Optionally, can be forced to use a specific method: 2 = legacy, 1 = modern, 0 = both (default).
- `snbt <snbt>` converts SNBT to pretty SNBT, a string dump, and NBT hex.
- `nbt <file>` converts binary NBT to a string dump, SNBT, and pretty SNBT.
- `hex2bin <hex>` converts hexadecimal strings and files to their binary representation.
- `bin2hex <bin>` converts binary strings and files to their hexadecimal representation.
- `uuid <uuid>` shows the UUID with and without dashes, its hash code, and which skin type that equals.
- `packets <recipient: client or server> <dump file>` prints packets from a recording, e.g. by the WorldSaver plugin for the Phpcraft client.

On Linux and Mac OS, you can use piping to create chains like this:

```Bash
snbt "{Level: 9001}" | tail -n 1 | php hex2bin.php > nbt.bin
```

This turns SNBT into a binary NBT file.
