<?php

error_reporting(E_ALL ^ E_STRICT);

require_once('utility/Timer.php');
//Timer::start('Page Request');

require_once('boot/bootstrap.php');

$f = new FrontController();
echo $f->execute();

//Timer::stop();
