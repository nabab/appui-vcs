<?php
if ($model->hasData(['name', 'host', 'type', 'engine', 'adminAccessToken'], true)
  && ($vcsCls = new \bbn\Appui\Vcs($model->db))
) {
  return [
    'success' => $vcsCls->addServer(
      $model->data['name'],
      $model->data['host'],
      $model->data['type'],
      $model->data['engine'],
      $model->data['adminAccessToken'],
      !empty($model->data['userAccessToken']) ? $model->data['userAccessToken'] : ''
    )
  ];
}
return ['success' => false];
