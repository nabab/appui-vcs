<?php
if ($model->hasData(['serverID', 'projectID', 'name', 'color'], true)) {
  $label = $model->inc->vcs->createProjectLabel(
    $model->data['serverID'],
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
