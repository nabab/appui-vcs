<div class="appui-vcs-project-info bbn-alt-background bbn-overlay">
  <bbn-scroll axis="y">
    <div class="bbn-padding">
      <div class="appui-vcs-project-info-header bbn-background bbn-radius bbn-padding bbn-bottom-space appui-vcs-box-shadow">
        <div class="bbn-flex-width bbn-vmiddle"
             style="flex-wrap: wrap; justify-content: center">
          <div :class="['appui-vcs-project-info-header-icon', 'bbn-middle', 'bbn-spadding', 'bbn-white', 'bbn-right-space', {
                 'appui-vcs-project-info-header-icon-git': isGit,
                 'appui-vcs-project-info-header-icon-svn': !isGit
               }]">
            <i :class="['bbn-xxxxl', {
                  'nf nf-fa-git': isGit,
                  'nf nf-dev-sublime': !isGit
                }]"/>
          </div>
          <div class="bbn-flex-fill">
          <div class="bbn-tertiary-text-alt">
            <span v-text="source.server.name"/>
            <span> - </span>
            <span v-text="source.server.host"/>
          </div>
            <div class="bbn-b bbn-xxxl bbn-primary-text-alt"
                 v-text="source.name"/>
            <div class="bbn-top-sspace bbn-lg bbn-secondary-text-alt"
                 v-text="source.fullpath"/>
          </div>
          <div>
            <div class="bbn-c bbn-m">
              <span v-text="_('Project ID: %d', source.id)"/>
            </div>
            <div class="bbn-flex">
              <div class="bbn-c bbn-right-space bbn-p"
                   style="color: cornflowerblue"
                   :title="_('Users')"
                   @click="goToUsersPage">
                <i class="nf nf-fa-users bbn-xxxl"/>
                <div class="bbn-b"
                     v-text="source.members.length"/>
              </div>
              <div class="bbn-c bbn-right-space"
                   style="color: gold"
                   :title="_('Stars')">
                <i class="nf nf-fa-star bbn-xxxl"/>
                <div class="bbn-b"
                     v-text="source.noStars"/>
              </div>
              <div class="bbn-c"
                   style="color: lightseagreen"
                   :title="_('Forks')">
                <i class="nf nf-md-source_fork bbn-xxxl"/>
                <div class="bbn-b"
                     v-text="source.noForks"/>
              </div>
            </div>
          </div>
        </div>
        <div v-text="source.description"
              v-if="source.description.length"
              class="bbn-top-lspace bbn-m"/>
        <div class=" bbn-top-lspace">
          <div class="bbn-grid"
               style="grid-template-columns: repeat(auto-fill, minmax(100px, max-content)); grid-column-gap: 2rem">
            <div class="bbn-right-lspace bbn-no-wrap">
              <i class="nf nf-dev-git_commit"/>
              <span class="bbn-b"
                    v-text="source.noCommits"/>
              <span v-text="_('Commits')"/>
            </div>
            <div class="bbn-no-wrap">
              <i class="nf nf-dev-git_branch"/>
              <span class="bbn-b"
                    v-text="source.branches.length"/>
              <span v-text="_('Branches')"/>
            </div>
            <div class="bbn-no-wrap">
              <i class="nf nf-fa-tags"/>
              <span class="bbn-b"
                    v-text="source.tags.length"/>
              <span v-text="_('Tags')"/>
            </div>
            <div class="bbn-no-wrap">
              <i class="nf nf-md-harddisk"/>
              <span class="bbn-b"
                    v-text="formatBytes(source.size)"/>
              <span v-text="_('Files')"/>
            </div>
          </div>
        </div>
        <div class="bbn-top-lspace bbn-grid-fields"
             style="width: max-content">
          <i class="nf nf-fa-external_link_square bbn-lg"
             :title="_('URL')"/>
          <a class="bbn-no"
             :href="source.url"
             target="_blank"
             v-text="source.url"
             :title="_('URL')"/>
          <i class="nf nf-fa-user bbn-lg"
             :title="_('Creator')"/>
          <div class="bbn-vmiddle"
               :title="_('Creator')">
            <img v-if="creator.avatar"
                 :src="creator.avatar"
                 class="appui-vcs-project-info-useravatar bbn-right-sspace">
            <span v-text="creator.name"
                  class="bbn-right-xsspace"/>
            <span>(<span v-text="creator.username"/>)</span>
          </div>
          <i class="nf nf-fa-calendar bbn-lg"
             :title="_('Created at')"/>
          <div v-text="formatDate(source.created)"
               :title="_('Created at')"/>
          <i class="nf nf-md-source_branch bbn-lg"
             :title="_('Default branch')"/>
          <div :title="_('Default branch')"
               class="bbn-vmiddle">
            <div v-text="source.defaultBranch"/>
            <i class="nf nf-fa-star bbn-lg bbn-primary-text-alt bbn-left-sspace"/>
          </div>
        </div>
      </div>
      <div class="appui-vcs-project-info-body">
        <bbn-masonry :source="widgets"
                     :scrollable="false"
                     :item-width="300"/>
      </div>
    </div>
  </bbn-scroll>
</div>