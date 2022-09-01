<?php
if ( !\defined('APPUI_VCS_ROOT') ){
  define('APPUI_VCS_ROOT', $ctrl->pluginUrl('appui-vcs').'/');
}
if (!isset($ctrl->inc->vcs)) {
  $ctrl->addInc('vcs', new \bbn\Appui\Vcs($ctrl->db));
}
return 1;
