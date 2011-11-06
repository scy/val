#!/usr/bin/env php
<?php

// You can also use this as post-commit and post-checkout Git hook.

define('CSSDIR', 'www/css/2011');

echo "Compiling LESS to CSS …\n";

require_once 'lib/lessphp/lessc.inc.php';

lessc::ccompile(CSSDIR . '/style.less', CSSDIR . '/style.css');
