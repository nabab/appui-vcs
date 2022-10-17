<?php
if ($model->hasData(['serverID', 'projectID', 'issueID'], true)) {
  return [
    'success' => true,
    'data' => $model->inc->vcs->changeServer($model->data['serverID'])->getProjectIssueComments(
      $model->data['projectID'],
      $model->data['issueID']
    )
  ];
}
return [
  'success' => false
];
