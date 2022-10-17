<?php
if ($model->hasData(['serverID', 'projectID', 'name', 'color'], true)) {
  $label = $model->inc->vcs->changeServer($model->data['serverID'])->createProjectLabel(
    $model->data['projectID'],
    $model->data['name'],
    $model->data['color']
  );
  return [
    'success' => !empty($label),
    'data' => $label
  ];
}
return [
  'success' => false
];
