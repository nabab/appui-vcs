<?php
$haders = apache_request_headers();
if (!empty($haders['X-Gitlab-Token'])) {
  $ctrl->inc->vcs->changeServer($haders['X-Gitlab-Token'])->analyzeWebhook($ctrl->post);
}
$ctrl->obj->success = true;