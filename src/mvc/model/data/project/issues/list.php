<?php
if ($model->hasData(['serverID', 'projectID'], true)) {
  return [
    'success' => true,
    'data' => $model->inc->vcs->getProjectIssues($model->data['serverID'], $model->data['projectID'])
  ];
}
return [
  'success' => false
];
