<?php
if ($model->hasData(['serverID', 'projectID'], true)) {
  return array_merge(
    (array)$model->inc->vcs->getProject($model->data['serverID'], $model->data['projectID']),
    [
      'branches' => $model->inc->vcs->getProjectBranches($model->data['serverID'], $model->data['projectID']),
      'users' => $model->inc->vcs->getProjectUsers($model->data['serverID'], $model->data['projectID'])
    ]
  );
}
