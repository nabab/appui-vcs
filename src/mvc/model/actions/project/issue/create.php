<?php
if ($model->hasData(['serverID', 'projectID', 'title'], true)
  && $model->hasData(['description', 'labels', 'private', 'assigned'])
) {
  $issue = $model->inc->vcs->createProjectIssue(
    $model->data['serverID'],
    $model->data['projectID'],
    $model->data['title'],
    $model->data['description'],
    $model->data['labels'],
    !empty($model->data['assigned']) ? $model->data['assigned']['id'] : null,
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
