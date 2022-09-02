<?php
if (!empty($ctrl->arguments[0]) && !empty($ctrl->arguments[1])) {
  $serverID = $ctrl->arguments[0];
  $projectID = $ctrl->arguments[1];
  $ctrl->setUrl(APPUI_VCS_ROOT . 'page/project/' . $serverID . '/' . $projectID)
    ->combo(true);
}
