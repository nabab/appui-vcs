<?php
if (!empty($model->data['data']['server'])) {
  return [
    'success' => true,
    'data' => $model->inc->vcs->getProjectsList($model->data['data']['server'])
  ];
}
return ['success' => false];
