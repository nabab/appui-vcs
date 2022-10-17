<?php
if ($model->hasData(['serverID', 'projectID', 'issueID', 'commentID'], true)) {
  return [
    'success' => $model->inc->vcs->changeServer($model->data['serverID'])->insertProjectIssueComment(
      $model->data['projectID'],
      $model->data['issueID'],
      $model->data['commentID']
    )
  ];
}
return [
  'success' => false
];
