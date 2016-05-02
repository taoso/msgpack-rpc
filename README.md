# Msgpack-RPC

## Install
	composer require lvht/msgpack-rpc

## Usage

```
<?php
require './vendor/autoload.php';

use Lvht\MsgpackRpc\Handler;
use Lvht\MsgpackRpc\Server;
use Lvht\MsgpackRpc\ForkServer;
use Lvht\MsgpackRpc\DefaultMsgpacker;
use Lvht\MsgpackRpc\StdIo;

class DemoHandler implements Handler
{
    /**
     * @var Server
     */
    private $server;

    public function setServer(Server $server)
    {
        $this->server = $server;
    }

    public function echo($data)
    {
        return $data;
    }
}

$server = new ForkServer(new DefaultMsgpacker, new StdIo, new DemoHandler);
$server->loop(false);
```

## TODO
- [ ] Unit Test
- SocketIo
- AsyncServer
- Docs
