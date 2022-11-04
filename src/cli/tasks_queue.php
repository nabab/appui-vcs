<?php
$vcsCls = new \bbn\Appui\Vcs($ctrl->db);
$r = $vcsCls->processTasksQueue();
if (!empty($r['processed']) || !empty($r['failed'])) {
  echo _('Processed') . ": $r[processed]" . PHP_EOL . _('Failed') . ": $r[failed]" . PHP_EOL;
}
