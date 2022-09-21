<?php
if ($model->hasData(['serverID', 'projectID', 'userID', 'roleID'], true)) {
  return [
    'success' => !empty($model->inc->vcs->insertProjectUser(
      $model->data['serverID'],
      $model->data['projectID'],
      $model->data['userID'],
      $model->data['roleID']
    ))
  ];
}
return [
  'success' => false
];
