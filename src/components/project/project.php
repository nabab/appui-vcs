<div class="appui-vcs-project bbn-overlay bbn-flex-width">
  <!--<div class="appui-vcs-project-menu bbn-padded bbn-alt-background bbn-flex">
    <div class="appui-vcs-project-menu-icon bbn-background bbn-middle bbn-bottom-space bbn-p bbn-reactive"
         :title="_('Information')">
      <i class="nf nf-fa-info"/>
    </div>
    <div class="appui-vcs-project-menu-icon bbn-background bbn-middle bbn-bottom-space bbn-p bbn-reactive"
         :title="_('Branches')">
      <i class="nf nf-pl-branch"/>
    </div>
    <div class="appui-vcs-project-menu-icon bbn-background bbn-middle bbn-bottom-space bbn-p bbn-reactive"
         :title="_('Users')">
      <i class="nf nf-fa-users"/>
    </div>
  </div>-->
  <div class="bbn-flex-fill">
    <!--<bbn-scroll>
      <div class="bbn-padded">ciao</div>
    </bbn-scroll>-->
    <bbn-router :nav="true"
                :master="true"
                orientation="left"
                ref="router">
      <bbns-container url="info"
                      :static="true"
                      :load="false"
                      :title="_('Information')"
                      icon="nf nf-fa-info"
                      component="appui-vcs-project-info"
                      :source="source"/>
      <bbns-container url="branches"
                      :static="true"
                      :load="false"
                      :title="_('Branches')"
                      icon="nf nf-pl-branch"
                      component="appui-vcs-project-branches"
                      :source="source"/>
      <bbns-container url="users"
                      :static="true"
                      :load="false"
                      :title="_('Users')"
                      icon="nf nf-fa-users"
                      component="appui-vcs-project-users"
                      :source="source"/>
    </bbn-router>
  </div>
</div>