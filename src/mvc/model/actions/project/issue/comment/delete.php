<?php
if ($model->hasData(['serverID', 'projectID', 'issueID', 'commentID'], true)) {
  return [
    'success' => $model->inc->vcs->insertProjectIssueComment(
      $model->data['serverID'],
      $model->data['projectID'],
      $model->data['issueID'],
      $model->data['commentID']
    )
  ];
}
return [
  'success' => false
];
