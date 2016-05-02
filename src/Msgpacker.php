<?php
namespace Lvht\MsgpackRpc;

interface Msgpacker
{
    function feed($data);
    function execute();
    function data();
    function pack($obj);
}
