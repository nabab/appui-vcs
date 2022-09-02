<?php
if ($model->hasData(['name', 'url', 'type', 'adminAccessToken'], true)
  && ($vcsCls = new \bbn\Appui\Vcs($model->db))
) {
  return [
    'success' => $vcsCls->addServer(
      $model->data['name'],
      $model->data['url'],
      $model->data['type'],
      $model->data['adminAccessToken'],
      !empty($model->data['userAccessToken']) ? $model->data['userAccessToken'] : ''
    )
  ];
}
return ['success' => false];
