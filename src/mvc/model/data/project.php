<?php
if ($model->hasData(['serverID', 'projectID'], true)) {
  $model->inc->vcs->changeServer($model->data['serverID']);
  return array_merge(
    $model->inc->vcs->getProject($model->data['projectID']),
    [
      'server' => $model->inc->vcs->getServer(),
      'branches' => $model->inc->vcs->getProjectBranches($model->data['projectID']),
      'tags' => $model->inc->vcs->getProjectTags($model->data['projectID']),
      'users' => $model->inc->vcs->getUsers(),
      'members' => $model->inc->vcs->getProjectUsers($model->data['projectID']),
      'usersEvents' => $model->inc->vcs->getProjectUsersEvents($model->data['projectID']),
      'usersRoles' => $model->inc->vcs->getProjectUsersRoles(),
      'events' => $model->inc->vcs->getProjectEvents($model->data['projectID']),
      'commitsEvents' => $model->inc->vcs->getProjectCommitsEvents($model->data['projectID']),
      'labels' => $model->inc->vcs->getProjectLabels($model->data['projectID'])
    ]
  );
}
