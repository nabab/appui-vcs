<div class="appui-vcs-project bbn-overlay">
  <bbn-router :nav="true"
              :master="true"
              orientation="left"
              ref="router"
              class="appui-vcs-project-router">
    <bbns-container url="info"
                    :fixed="true"
                    :load="false"
                    :title="_('Information')"
                    icon="nf nf-fa-info bbn-m"
                    component="appui-vcs-project-info"
                    :source="source"
                    :notext="true"
                    :scrollable="false"/>
    <bbns-container url="files"
                    :fixed="true"
                    :load="false"
                    :title="_('Repositories')"
                    icon="nf nf-oct-repo"
                    component="appui-vcs-project-repositories"
                    :source="source"
                    :notext="true"
                    :scrollable="false"/>
    <bbns-container url="branches"
                    :fixed="true"
                    :load="false"
                    :title="_('Branches')"
                    icon="nf nf-mdi-source_branch"
                    component="appui-vcs-project-branches"
                    :source="source"
                    :notext="true"
                    :scrollable="false"/>
    <bbns-container url="users"
                    :fixed="true"
                    :load="false"
                    :title="_('Users')"
                    icon="nf nf-mdi-account_multiple bbn-xxl"
                    component="appui-vcs-project-users"
                    :source="source"
                    :notext="true"
                    :scrollable="false"/>
    <bbns-container url="issues"
                    :fixed="true"
                    :load="false"
                    :title="_('Issues')"
                    icon="nf nf-oct-issue_opened bbn-xxl"
                    component="appui-vcs-project-issues"
                    :source="source"
                    :notext="true"
                    :scrollable="false"/>
  </bbn-router>
</div>