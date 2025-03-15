<?php
$ctrl->setUrl($ctrl->pluginUrl('appui-vcs') . '/page')
  ->setColor('lightseagreen', 'white')
  ->setIcon('nf nf-dev-git_branch')
  ->combo(_('VCS'), [
    'engines' => $ctrl->inc->vcs::$engines
  ]);
