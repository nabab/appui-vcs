<?php
if ($model->hasData(['serverID', 'projectID', 'title'], true)
  && $model->hasData(['description', 'labels', 'private', 'assigned'])
) {
  $issue = $model->inc->vcs->changeServer($model->data['serverID'])->editProjectIssue(
    $model->data['projectID'],
    $model->data['id'],
    $model->data['title'],
    $model->data['description'],
    $model->data['labels'],
    !empty($model->data['assigned']) ? $model->data['assigned']['id'] : 0,
    $model->data['private']
  );
  return [
    'success' => !empty($issue),
    'data' => $issue
  ];
}
return [
  'success' => false
];
