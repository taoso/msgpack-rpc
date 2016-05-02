<?php
namespace Lvht\MsgpackRpc;

class DefaultMsgpacker implements Msgpacker
{
   /**
    * @var \MessagePackUnpacker
    */
    private $unpacker;

    public function __construct()
    {
        $this->unpacker = new \MessagePackUnpacker;
    }

    public function feed($data)
    {
        $this->unpacker->feed($data);
    }

    public function execute()
    {
        return $this->unpacker->execute();
    }

    public function data()
    {
        $data = $this->unpacker->data();
        $this->unpacker->reset();

        return $data;
    }

    public function pack($obj)
    {
        return msgpack_pack($obj);
    }
}
