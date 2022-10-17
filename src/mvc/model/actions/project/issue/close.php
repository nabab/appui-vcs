<?php
if ($model->hasData(['serverID', 'projectID', 'issueID'], true)) {
  $issue = $model->inc->vcs->changeServer($model->data['serverID'])->closeProjectIssue(
    $model->data['projectID'],
    $model->data['issueID']
  );
  return [
    'success' => !empty($issue),
    'data' => $issue
  ];
}
return [
  'success' => false
];
