<div class="appui-vcs-home bbn-overlay">
  <bbn-splitter class="appui-vcs-home-splitter">
    <bbn-pane>
      <div class="bbn-flex-height">
        <div class="bbn-spadded bbn-c bbn-upper bbn-b bbn-m"><?=_('SERVERS LIST')?></div>
        <bbn-toolbar class="bbn-no-border bbn-spadded">
          <bbn-button :text="_('New server')"
                      icon="nf nf-fa-plus"
                      @click="createServer"/>
        </bbn-toolbar>
        <div class="bbn-flex-fill">
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
    <div class="bbn-flex-height">
        <div class="bbn-spadded bbn-c bbn-upper bbn-b bbn-m"><?=_('PROJECTS LIST')?></div>
        <bbn-toolbar class="bbn-no-border bbn-spadded">
          <bbn-button :text="_('New project')"
                      icon="nf nf-fa-plus"
                      :disabled="!selectedServer"
                      @click="createProject"/>
        </bbn-toolbar>
        <div class="bbn-flex-fill">
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
                    class="bbn-xl bbn-b"/>
              </div>
              <div v-if="projectsListReady && projectsListLoading"
                  class="bbn-overlay">
                <bbn-loader/>
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