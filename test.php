<?php

require_once("vendor/autoload.php");

use LEO\Stream;

$config = array(
        "enableLogging" => true,
        "config"        => array(
                "firehose"      => "Leo-BusToS3-1FOX5XNAWUE0Z",
                "kinesis"       => "leo-s3bus-1xm7h7q0my2ip",
                "mass"          => "Leo-LeoStream-JHH72XKEU11N"
        )
);

$leo = new Stream("BotName", $config);

$stream_options = array();

$checkpoint_function = function ($checkpointData) {
        var_dump($checkpointData);
};

$stream = $leo->createBufferedWriteStream($stream_options, $checkpoint_function);

for($i = 0; $i < 10000; $i++) {

        $event = array(
                "id"=>"testing-$i",
                "data"=>"some order data",
                "other data"=>"some more data"
        );

        $meta = array("source"=>null, "start"=>$i);

        $stream->write("QueueName", $event, $meta);
}
$stream->end();
