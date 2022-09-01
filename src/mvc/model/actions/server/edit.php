<?php
if ($model->hasData(['id', 'name', 'url', 'type'], true)
  && ($vcsCls = new \bbn\Appui\Vcs($model->db))
  && ($old = $vcsCls->getServer($model->data['id']))
) {
  $ok1 = true;
  $ok2 = true;
  $ok3 = true;
  if (($old['name'] !== $model->data['name'])
    || ($old['url'] !== $model->data['url'])
    || ($old['type'] !== $model->data['type'])
  ) {
    $ok1 = $vcsCls->editServer($model->data['id'], $model->data['name'], $model->data['url'], $model->data['type']);
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
