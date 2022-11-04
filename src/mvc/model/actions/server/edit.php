<?php
if ($model->hasData(['id', 'name', 'host', 'type', 'engine'], true)
  && ($vcsCls = new \bbn\Appui\Vcs($model->db))
  && ($old = $vcsCls->getServer($model->data['id']))
) {
  $ok1 = true;
  $ok2 = true;
  $ok3 = true;
  if (($old->name !== $model->data['name'])
    || ($old->host !== $model->data['host'])
    || ($old->type !== $model->data['type'])
    || ($old->engine !== $model->data['engine'])
  ) {
    $ok1 = $vcsCls->editServer($model->data['id'], $model->data['name'], $model->data['host'], $model->data['type'], $model->data['engine']);
  }
  if (!empty($model->data['adminAccessToken'])) {
    $ok2 = $vcsCls->setAdminAccessToken($model->data['id'], $model->data['adminAccessToken']);
  }
  if (!empty($model->data['userAccessToken'])) {
    $ok3 = $vcsCls->setUserAccessToken($model->data['id'], $model->data['userAccessToken']);
  }
  return [
    'success' => $ok1 && $ok2 && $ok3
  ];
}
return ['success' => false];
