<?php
if ($model->hasData(['name', 'url', 'type', 'adminToken'], true)
  && ($vcsCls = new \bbn\Appui\Vcs($model->db))
) {
  return [
    'success' => $vcsCls->addServer(
      $model->data['name'],
      $model->data['url'],
      $model->data['type'],
      $model->data['adminToken'],
      !empty($model->data['userToken']) ? $model->data['userToken'] : ''
    )
  ];
}
return ['success' => false];
