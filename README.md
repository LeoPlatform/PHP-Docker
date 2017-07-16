PHP-Docker
===================

Docker Project for Leo Platform PHP SDK

Documentation: https://docs.leoplatform.io

Usage
=====

1. Pull the docker image

```
$ docker pull leoplatform/php
```

2. Create a project folder, or use an existing project.

```
$ mkdir myproject; cd myproject
```

3. Create a file called **test.php** and replace the values in the config for appropriate ones in your installation.   These values can be obtained in your AWS console. If you are a managed install you can obtain these values by contacting support. 

```
<?php

require_once("../vendor/autoload.php");

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
sudo docker run -it --volume /path/to/your/project:/usr/src/myapp/src --env AWS_ACCESS_KEY_ID=???????????????????? --env AWS_SECRET_ACCESS_KEY=???????????????????? --env AWS_DEFAULT_REGION=??????????? --rm --name leoplatform-run leoplatform php src/test.php
```

NOTE: your current project directory is mapped to the /usr/src/myapp/src/ directory inside the image.

The access keys can be found in your aws console or by contacting Leo support if you are running a managed install.


AWS Credentials
--------------

There are 2 ways to set your AWS credentials:

1. Pass them in on the docker command like the example above.

2. The volume /root/.aws has been exposed within the image for external access. Therefore you can mount the AWS credential file to the container:

```
sudo docker run --rm --volume ./.aws:/root/.aws --name leoplatform-run leoplatform/php php test.php 
```

Documentation
-------------

More detailed documentation of how to use the SDK can be found here:

https://docs.leoplatform.io

Or here:

https://github.com/LeoPlatform/PHP
