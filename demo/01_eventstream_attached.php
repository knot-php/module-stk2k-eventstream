<?php
namespace KnotModule\Stk2kEventStream\Demo;

require_once dirname(__DIR__) . '/vendor/autoload.php';

use \Throwable;

use Calgamo\Kernel\EventStream\Channels;
use Calgamo\Kernel\EventStream\Events;

try{
    $app = new Stk2kEventStreamApp(new DemoFileSystem());
    $app
        ->configure()
        ->install();

    $app
        ->eventstream()
        ->channel(Channels::SYSTEM)
        ->listen(Events::EVENTSTREAM_ATTACHED, function(){
            echo 'eventstream is attached.' . PHP_EOL;
        })
        ->flush();
}
catch(Throwable $e){
    echo $e->getMessage();
}
