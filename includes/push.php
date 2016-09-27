<?php

function pushData($data)
{
    $context = new ZMQContext();
    /*$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'my pusher');
    $socket->connect("tcp://localhost:5555");
    $socket->send(json_encode($data));*/

    $requester = new ZMQSocket($context, ZMQ::SOCKET_REQ);
    $requester->connect("tcp://localhost:5555");

    $requester->send(json_encode($data));

    return $requester->recv();
}