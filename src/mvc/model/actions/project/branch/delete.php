<?php
if ($model->hasData(['serverID', 'projectID', 'branch'], true)) {
  return [
    'success' => $model->inc->vcs->deleteBranch(
      $model->data['serverID'],
      $model->data['projectID'],
      $model->data['branch']
    )
    ];
}
return [
  'success' => false
];
