<?php
if ($model->hasData(['serverID', 'projectID', 'userID'], true)) {
  return [
    'success' => $model->inc->vcs->removeProjectUser(
      $model->data['serverID'],
      $model->data['projectID'],
      $model->data['userID']
    )
  ];
}
return [
  'success' => false
];