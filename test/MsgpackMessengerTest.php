<?php namespace Lvht\MsgpackRpc;

use PHPUnit\Framework\TestCase;
use Mockery as m;

class MsgpackMessengerTest extends TestCase
{
    public function testNext()
    {
        $io = m::mock(Io::class);
        $io->shouldReceive('read')->andReturn(msgpack_pack([1,2,3]).msgpack_pack(['a'=>1]));
        $messenger = new MsgpackMessenger($io);
        $msg = $messenger->next();
        self::assertEquals([1,2,3], $msg);
        $msg = $messenger->next();
        self::assertEquals(['a'=>1], $msg);
    }

    public function testSend()
    {
        $io = m::mock(Io::class);
        $io->shouldReceive('write')->andReturnUsing(function ($data) {
            self::assertEquals([1,2,3], msgpack_unpack($data));
        });
        $messenger = new MsgpackMessenger($io);
        $messenger->send([1,2,3]);
    }
}
