<?php
if ($model->hasData(['serverID', 'projectID', 'name', 'fromBranch'], true)) {
  return [
    'success' => $model->inc->vcs->changeServer($model->data['serverID'])->insertBranch(
      $model->data['projectID'],
      $model->data['name'],
      $model->data['fromBranch']
    )
  ];
}
return [
  'success' => false
];
