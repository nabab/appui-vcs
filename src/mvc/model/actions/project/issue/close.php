<?php
if ($model->hasData(['serverID', 'projectID', 'issueID'], true)) {
  $issue = $model->inc->vcs->closeProjectIssue(
    $model->data['serverID'],
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