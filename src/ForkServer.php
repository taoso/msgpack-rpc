<?php
namespace Lvht\MsgpackRpc;

class ForkServer implements Server
{
    use AbstractServer;

    /**
     * @var Io
     */
    private $io;

   /**
    * @var Msgpacker
    */
    private $packer;

    public function __construct(Msgpacker $packer, Io $io, Handler $handler)
    {
        $this->packer = $packer;
        $this->io = $io;
        $this->setHandler($handler);

        register_shutdown_function([$this, 'shutdown']);
    }

    public function loop($infinite = true)
    {
        do {
            $buffer = $this->io->read(1024);
            $this->packer->feed($buffer);

            if ($this->packer->execute()) {
                $message = $this->packer->data();

                $pid = pcntl_fork();
                if ($pid == -1) {
                    $this->shutdown();
                    exit(1);
                } elseif ($pid > 0) {
                    pcntl_waitpid($pid, $status);
                } else {
                    $this->onMessage($message);
                    exit(0);
                }
            }
        } while ($infinite);
    }

    public function write(array $message)
    {
        $this->io->write($this->packer->pack($message));
    }
}
