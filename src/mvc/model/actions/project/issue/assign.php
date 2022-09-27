<?php
if ($model->hasData(['serverID', 'projectID', 'issueID'], true)
  && $model->hasData('userID')
) {
  $issue = $model->inc->vcs->assignProjectIssue(
    $model->data['serverID'],
    $model->data['projectID'],
    $model->data['issueID'],
    $model->data['userID']
  );
  return [
    'success' => !empty($issue),
    'data' => $issue
  ];
}
return [
  'success' => false
];
