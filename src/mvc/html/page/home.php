<div class="appui-vcs-home bbn-overlay bbn-alt-background">
  <bbn-splitter class="appui-vcs-home-splitter"
                style="grid-gap: 0 !important">
    <bbn-pane>
      <div class="bbn-flex-height bbn-alt-background bbn-padding">
        <div class="bbn-spadding bbn-background bbn-radius bbn-bottom-space appui-vcs-box-shadow bbn-vmiddle bbn-flex-width">
          <div class="bbn-alt-background bbn-vmiddle bbn-xspadding bbn-radius bbn-flex-fill">
            <bbn-button :text="_('Add server')"
                        icon="nf nf-fa-plus"
                        @click="createServer"/>
          </div>
          <div class="bbn-upper bbn-b bbn-lg bbn-tertiary-text-alt bbn-left-lspace bbn-right-space"
              v-text="_('SERVERS LIST')"/>
        </div>
        <div class="bbn-flex-fill bbn-background bbn-radius appui-vcs-box-shadow">
          <bbn-scroll axis="y">
            <bbn-list :source="root + 'data/servers'"
                      :alternate-background="true"
                      uid="id"
                      :selected="selectedServers"
                      ref="serversList"
                      :component="$options.components.server"
                      source-value="id"
                      mode="selection"
                      @select="onServerSelect"/>
          </bbn-scroll>
        </div>
      </div>
    </bbn-pane>
    <bbn-pane size="60%">
    <div class="bbn-flex-height bbn-alt-background bbn-padding">
        <div class="bbn-spadding bbn-background bbn-radius bbn-bottom-space appui-vcs-box-shadow bbn-vmiddle bbn-flex-width">
          <div class="bbn-alt-background bbn-vmiddle bbn-xspadding bbn-radius bbn-flex-fill">
            <bbn-button :text="_('New project')"
                        icon="nf nf-fa-plus"
                        :disabled="!selectedServer"
                        @click="createProject"/>
          </div>
          <div class="bbn-upper bbn-b bbn-lg bbn-tertiary-text-alt bbn-left-lspace bbn-right-space"
              v-text="_('PROJECTS LIST')"/>
        </div>
        <div class="bbn-flex-fill bbn-background bbn-radius appui-vcs-box-shadow">
          <div class="bbn-flex-height">
            <div class="bbn-flex-fill">
              <bbn-scroll v-if="selectedServer"
                          axis="y">
                <bbn-list :source="root + 'data/projects'"
                          :data="{server: selectedServer}"
                          :alternate-background="true"
                          uid="id"
                          ref="projectsList"
                          source-value="id"
                          source-url="link"
                          @ready="setProjectsListWatch"
                          :component="$options.components.project"
                          mode="selection"
                          @select="onProjectSelect"
                          :pageable="true"
                          :limits="[10, 25, 50, 100]"
                          :limit="50"/>
              </bbn-scroll>
              <div v-else
                  class="bbn-middle bbn-overlay">
                <i class="nf nf-fa-long_arrow_left bbn-xl bbn-right-space"/>
                <span v-text="_('Select or create a server')"
                      class="bbn-xl bbn-b bbn-secondary-text-alt"/>
              </div>
              <div v-if="projectsListReady && projectsListLoading"
                  class="bbn-overlay">
                <bbn-loader class="appui-vcs-project-loader"/>
              </div>
            </div>
            <div>
              <bbn-pager v-if="projectsListReady"
                         :element="$refs.projectsList"
                         class="bbn-no-border-left bbn-no-border-bottom bbn-no-border-right"/>
            </div>
          </div>
        </div>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>