<?php
if ($model->hasData(['serverID', 'projectID', 'branch'], true)) {
  return [
    'success' => $model->inc->vcs->changeServer($model->data['serverID'])->deleteBranch(
      $model->data['projectID'],
      $model->data['branch']
    )
    ];
}
return [
  'success' => false
];
