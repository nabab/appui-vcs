<?php
if ($model->hasData(['serverID', 'projectID', 'issueID', 'label'], true)) {
  return [
    'success' => $model->inc->vcs->changeServer($model->data['serverID'])->removeLabelFromProjectIssue(
      $model->data['projectID'],
      $model->data['issueID'],
      $model->data['label']
    )
  ];
}
return [
  'success' => false
];
