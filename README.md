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
2. Create a file called **test.php** and replace the values in the config for appropriate ones in your installation.  These values can be obtained in your AWS console. If you are a managed install you can obtain these values by contacting support. 
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

3. Run the script

```
sudo docker run -it --env AWS_ACCESS_KEY_ID=???????????????????? --env AWS_SECRET_ACCESS_KEY=???????????????????? --env AWS_DEFAULT_REGION=??????????? --rm --name leoplatform-run leoplatform php test.php
```
The access keys can be found in your aws console or by contacting Leo support if you are running a managed install.


Documentation
-------------

More detailed documentation of how to use the SDK can be found here:

https://docs.leoplatform.io

Or here:

https://github.com/LeoPlatform/PHP
