<?php
if ($model->hasData(['serverID', 'projectID', 'issueID'], true)) {
  $idTask = $model->inc->vcs->importIssueToTask(
    $model->data['serverID'],
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
