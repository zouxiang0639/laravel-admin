<?php

namespace App\Swoole;

use Illuminate\Http\Request;
use SwooleTW\Http\Server\Manager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use SwooleTW\Http\Server\Facades\Server;
use SwooleTW\Http\Websocket\HandlerContract;
use SwooleTW\Http\Websocket\SocketIO\Packet;
use SwooleTW\Http\Server\Facades\Server as ClientServer;
use Swoole\Websocket\Frame;

class WebsocketHandler implements HandlerContract
{

    private $server;

    public function __construct()
    {
        /** @var Manager $manager */
        $this->server = App::make(ClientServer::class);
    }

    /**
     * "onOpen" listener.
     * @param int $fd
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function onOpen($fd, Request $request)
    {
        /**
         * 客户端建立起长链接后，返回客户端fd
         */
        $this->server->push($fd, json_encode(['event' => 'open', 'data' => ['fd' => $fd]]));
        return true;
    }

    /**
     * "onMessage" listener.
     *  only triggered when event handler not found
     */
    public function onMessage(Frame $frame)
    {
        return true;
    }

    /**
     * "onClose" listener.
     * @param int $fd
     * @param int $reactorId
     */
    public function onClose($fd, $reactorId)
    {
        return;
    }
}
