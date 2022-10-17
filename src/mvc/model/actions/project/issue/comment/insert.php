<?php
if ($model->hasData(['serverID', 'projectID', 'issueID', 'content'], true)
  && $model->hasData('private')
) {
  $comment = $model->inc->vcs->changeServer($model->data['serverID'])->insertProjectIssueComment(
    $model->data['projectID'],
    $model->data['issueID'],
    $model->data['content'],
    $model->data['private']
  );
  return [
    'success' => !empty($comment),
    'data' => $comment
  ];
}
return [
  'success' => false
];
