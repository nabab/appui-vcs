<?php
$ctrl->setUrl(APPUI_VCS_ROOT . 'page')
  ->setColor('lightseagreen', 'white')
  ->setIcon('nf nf-dev-git_branch')
  ->combo(_('VCS'), [
    'engines' => $ctrl->inc->vcs::$engines
  ]);
