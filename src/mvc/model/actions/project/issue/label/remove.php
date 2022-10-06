<?php
if ($model->hasData(['serverID', 'projectID', 'issueID', 'label'], true)) {
  return [
    'success' => $model->inc->vcs->removeLabelFromProjectIssue(
      $model->data['serverID'],
      $model->data['projectID'],
      $model->data['issueID'],
      $model->data['label']
    )
  ];
}
return [
  'success' => false
];
