<?php
if ($model->hasData(['serverID', 'projectID', 'userID'], true)) {
  return [
    'success' => $model->inc->vcs->changeServer($model->data['serverID'])->removeProjectUser(
      $model->data['projectID'],
      $model->data['userID']
    )
  ];
}
return [
  'success' => false
];