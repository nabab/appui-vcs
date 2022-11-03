<?php
$vcsCls = new \bbn\Appui\Vcs($ctrl->db);
$r = $vcsCls->processTasksQueue();
\bbn\X::adump($r);
