<?php
if (!empty($model->data['data']['server'])
  && isset($model->data['limit'], $model->data['start'])
) {
  return $model->inc->vcs->getProjectsList(
    $model->data['data']['server'],
    $model->data['start'] / $model->data['limit'] + 1,
    $model->data['limit']
  );
}
return ['success' => false];
