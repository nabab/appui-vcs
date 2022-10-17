<?php
if ($model->hasData(['serverID', 'projectID'], true)) {
  return [
    'success' => true,
    'data' => $model->inc->vcs->changeServer($model->data['serverID'])->getProjectIssues($model->data['projectID'])
  ];
}
return [
  'success' => false
];
