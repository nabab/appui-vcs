<?php
if ($model->hasData(['serverID', 'projectID', 'issueID'], true)) {
  return [
    'success' => true,
    'data' => $model->inc->vcs->getProjectIssueComments($model->data['serverID'], $model->data['projectID'], $model->data['issueID'])
  ];
}
return [
  'success' => false
];
