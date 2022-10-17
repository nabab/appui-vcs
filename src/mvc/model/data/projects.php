<?php
if (!empty($model->data['data']['server'])
  && isset($model->data['limit'], $model->data['start'])
) {
  return $model->inc->vcs->changeServer($model->data['data']['server'])->getProjectsList(
    $model->data['start'] / $model->data['limit'] + 1,
    $model->data['limit']
  );
}
return ['success' => false];
