# PHP-Docker



PHP-Docker
===================

Docker Project for Leo Platform PHP SDK

Documentation: https://docs.leoplatform.io

Usage
=====

1. Pull the docker image

```
docker pull leoplatform/php
```

3. Edit the **test.php** file

```
<?php

require_once("vendor/autoload.php");

use LEO\Stream;

$config = [
	"enableLogging"	=> true,
	"config"	=> [
		"firehose" => "Leo-BusToS3-??????????",
		"kinesis"  => "Leo-LeoStream-??????????",
		"mass"	   => "leo-s3bus-??????????"
	]
];

$leo = new Stream("BotName", $config);

$stream_options = [];
$checkpoint_function = function ($checkpointData) {
	var_dump($checkpointData);
};

$stream = $leo->createBufferedWriteStream($stream_options, $checkpoint_function);

for($i = 0; $i < 10000; $i++) {
	$event = [
		"id"=>"testing-$i",
		"data"=>"some order data",
		"other data"=>"some more data"
	];
	$meta = ["source"=>null, "start"=>$i];
	
	$stream->write("QueueName", $event, $meta);
}
$stream->end();
```

The config values can be found in your aws console or by contacting Leo support if you are running a managed install.

4. Run the script

```
sudo docker run -it --env AWS_ACCESS_KEY_ID=???????????????????? --env AWS_SECRET_ACCESS_KEY=???????????????????? --env AWS_DEFAULT_REGION=??????????? --rm --name leoplatform-run leoplatform php test.php
```

Documentation
-------------

More detailed documentation of how to use the SDK can be found here:

https://docs.leoplatform.io

Or here:

https://github.com/LeoPlatform/PHP

