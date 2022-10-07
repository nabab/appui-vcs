<?php
if ($model->hasData(['serverID', 'projectID'], true)) {
  return array_merge(
    $model->inc->vcs->getProject($model->data['serverID'], $model->data['projectID']),
    [
      'server' => $model->inc->vcs->getServer($model->data['serverID']),
      'branches' => $model->inc->vcs->getProjectBranches($model->data['serverID'], $model->data['projectID']),
      'tags' => $model->inc->vcs->getProjectTags($model->data['serverID'], $model->data['projectID']),
      'users' => $model->inc->vcs->getUsers($model->data['serverID']),
      'members' => $model->inc->vcs->getProjectUsers($model->data['serverID'], $model->data['projectID']),
      'usersEvents' => $model->inc->vcs->getProjectUsersEvents($model->data['serverID'], $model->data['projectID']),
      'usersRoles' => $model->inc->vcs->getProjectUsersRoles($model->data['serverID']),
      'events' => $model->inc->vcs->getProjectEvents($model->data['serverID'], $model->data['projectID']),
      'commitsEvents' => $model->inc->vcs->getProjectCommitsEvents($model->data['serverID'], $model->data['projectID']),
      'labels' => $model->inc->vcs->getProjectLabels($model->data['serverID'], $model->data['projectID'])
    ]
  );
}
