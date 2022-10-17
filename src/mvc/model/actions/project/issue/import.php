<?php
if ($model->hasData(['serverID', 'projectID', 'issueID'], true)) {
  $idTask = $model->inc->vcs->changeServer($model->data['serverID'])->importIssueToTask(
    $model->data['projectID'],
    $model->data['issueID']
  );
  return [
    'success' => !empty($idTask),
    'data' => $idTask
  ];
}
return [
  'success' => false
];
