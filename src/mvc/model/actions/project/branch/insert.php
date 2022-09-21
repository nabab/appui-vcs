<?php
if ($model->hasData(['serverID', 'projectID', 'name', 'fromBranch'], true)) {
  return [
    'success' => $model->inc->vcs->insertBranch(
      $model->data['serverID'],
      $model->data['projectID'],
      $model->data['name'],
      $model->data['fromBranch']
    )
  ];
}
return [
  'success' => false
];
