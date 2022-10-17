<?php
$haders = apache_request_headers();
if (!empty($haders['X-Gitlab-Token'])) {
  $idServer = $haders['X-Gitlab-Token'];
  $ctrl->inc->vcs->changeServer($idServer)->analyzeWebhook($ctrl->post);
}
$ctrl->obj->success = true;