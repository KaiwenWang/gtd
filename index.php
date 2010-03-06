<?php

require_once('utility/Timer.php');
Timer::start('Page Request');

require_once('include/bootstrap.php');
$f = new FrontController();
echo $f->execute();

Timer::stop();