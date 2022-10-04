<?php
if ($model->hasData(['serverID', 'projectID', 'issueID', 'commentID', 'content'], true)
  && $model->hasData('private')
) {
  $comment = $model->inc->vcs->editProjectIssueComment(
    $model->data['serverID'],
    $model->data['projectID'],
    $model->data['issueID'],
    $model->data['commentID'],
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
