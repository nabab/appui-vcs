<?php
if ($model->hasData(['serverID', 'projectID', 'userID', 'roleID'], true)) {
  return [
    'success' => !empty($model->inc->vcs->changeServer($model->data['serverID'])->insertProjectUser(
      $model->data['projectID'],
      $model->data['userID'],
      $model->data['roleID']
    ))
  ];
}
return [
  'success' => false
];
