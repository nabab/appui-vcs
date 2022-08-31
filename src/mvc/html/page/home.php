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
          <bbn-scroll>
            <bbn-list :source="source.servers"
                      :alternate-background="true"
                      uid="value"
                      :selected="selectedServers"/>
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
          <bbn-scroll v-if="selectedServer">
            <bbn-list :source="source.servers"
                      :alternate-background="true"/>
          </bbn-scroll>
          <div v-else
               class="bbn-middle bbn-overlay">
            <i class="nf nf-fa-long_arrow_left bbn-xl bbn-right-space"/>
            <span v-text="_('Select or create a server')"
                 class="bbn-xl bbn-b"/>
          </div>
        </div>
      </div>
    </bbn-pane>
  </bbn-splitter>
</div>