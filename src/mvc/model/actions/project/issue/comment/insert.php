<?php
if ($model->hasData(['serverID', 'projectID', 'issueID', 'content'], true)
  && $model->hasData('private')
) {
  $comment = $model->inc->vcs->insertProjectIssueComment(
    $model->data['serverID'],
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
