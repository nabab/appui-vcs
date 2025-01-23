<div class="appui-vcs-project-issues bbn-alt-background bbn-overlay bbn-flex-height">
  <div class="bbn-alt-background bbn-padding">
    <div :class="['bbn-spadding', 'bbn-background', 'bbn-radius', 'appui-vcs-box-shadow', 'bbn-vmiddle', 'bbn-nowrap', {
           'bbn-flex-width': !mainPage.isMobile(),
           'bbn-flex-height': !!mainPage.isMobile()
         }]">
      <div class="bbn-alt-background bbn-vmiddle bbn-hspadding bbn-radius bbn-flex-fill"
           style="min-height: 2rem; flex-wrap: wrap">
        <div :class="[{
               'bbn-vmiddle bbn-right-lspace': !mainPage.isMobile(),
             }, 'bbn-vxsmargin']">
          <div class="bbn-upper bbn-right-space bbn-b bbn-secondary-text-alt"
               v-text="_('Search')"/>
          <div class="bbn-vmiddle">
            <bbn-input v-model="currentSearch"
                       :button-right="currentSearch.length ? 'nf nf-fa-close' : 'nf nf-fa-search'"
                       :action-right="clearSearch"/>
          </div>
        </div>
        <div :class="[{
               'bbn-vmiddle bbn-right-lspace': !mainPage.isMobile()
             }, 'bbn-vxsmargin']">
          <div class="bbn-upper bbn-right-space bbn-b bbn-secondary-text-alt"
               v-text="_('Filter')"/>
          <div class="bbn-vmiddle">
            <bbn-radiobuttons :source="[{
                                text: _('All'),
                                value: 'all'
                              }, {
                                text: _('Mine'),
                                value: 'mine'
                              }, {
                                text: _('Assigned to me'),
                                value: 'assigned'
                              }]"
                              v-model="currentFilter"/>
          </div>
        </div>
        <div :class="[{'bbn-vmiddle': !mainPage.isMobile()}, 'bbn-vxsmargin']">
          <div class="bbn-upper bbn-right-space bbn-b bbn-secondary-text-alt"
               v-text="_('Cards')"/>
          <div class="bbn-vmiddle">
            <bbn-button icon="nf nf-md-arrow_collapse"
                        :label="_('Collapse all')"
                        @click="getRef('sections').collapseAll()"
                        class="bbn-right-sspace"/>
            <bbn-button icon="nf nf-md-arrow_expand"
                        :label="_('Expand all')"
                        @click="getRef('sections').expandAll()"/>
          </div>
        </div>
      </div>
      <div :class="['bbn-upper', 'bbn-b', 'bbn-lg', 'bbn-tertiary-text-alt', {
             'bbn-left-lspace bbn-right-space': !mainPage.isMobile(),
             'bbn-top-space bbn-bottom-space': !!mainPage.isMobile(),
           }]"
           v-text="_('Issues')"/>
    </div>
  </div>
  <div class="bbn-flex-fill">
    <bbn-kanban v-if="ready && !!sections && sections.length && !!filters"
                             :source="sections"
                             ref="sections"
                             component="appui-vcs-project-issues-issue"
                             toolbar="appui-vcs-project-issues-toolbar"
                             :pageable="true"/>
    <div v-else
         class="bbn-100 bbn-alt-background bbn-padding">
      <div class="bbn-100">
        <bbn-loader class="bbn-radius"
                    style="background-color: var(--default-background)"/>
      </div>
    </div>
  </div>
</div>