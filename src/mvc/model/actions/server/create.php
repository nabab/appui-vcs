<?php
use bbn\Appui\Vcs;
/** @var bbn\Mvc\Model $model */
if ($model->hasData(['name', 'host', 'type', 'engine', 'adminAccessToken'], true)
  && ($vcsCls = new Vcs($model->db))
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
