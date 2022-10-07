<div class="appui-vcs-project-issues bbn-alt-background bbn-overlay bbn-flex-height">
  <div class="bbn-alt-background bbn-padded">
    <div :class="['bbn-spadded', 'bbn-background', 'bbn-radius', 'appui-vcs-box-shadow', 'bbn-vmiddle', 'bbn-nowrap', {
            'bbn-flex-width': !mainPage.isMobile(),
            'bbn-flex-height': !!mainPage.isMobile()
          }]">
      <div class="bbn-alt-background bbn-vmiddle bbn-hspadded bbn-radius bbn-flex-fill"
            style="min-height: 2rem; flex-wrap: wrap">
        <div :class="[{
                'bbn-vmiddle bbn-right-lspace': !mainPage.isMobile(),
              }, 'bbn-vxsmargin']">
          <div class="bbn-upper bbn-right-space bbn-b bbn-secondary-text-alt"
                v-text="_('Search')"/>
          <div class="bbn-vmiddle">
            <bbn-input v-model="currentSearch"
                        button-right="nf nf-fa-search"/>
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
            <bbn-button icon="nf nf-mdi-arrow_collapse"
                        :text="_('Collapse all')"
                        @click="collapseAll"
                        class="bbn-right-sspace"/>
            <bbn-button icon="nf nf-mdi-arrow_expand"
                        :text="_('Expand all')"
                        @click="expandAll"/>
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
    <bbn-scroll axis="x">
      <div class="appui-vcs-project-issues-sections bbn-grid bbn-h-100 bbn-padded"
            v-if="ready
            && !!sections
            && sections.length
            && !!filters">
        <div v-for="(sec, idx) in sections"
              :class="[
                'appui-vcs-project-issues-section',
                'bbn-flex-height',
                'bbn-radius',
                'bbn-background',
                'appui-vcs-box-shadow',
                {
                  'collapsed': !!sec.collapsed
                }
              ]"
              :key="idx"
              :style="{backgroundColor: !!sec.backgroundColor ? sec.backgroundColor + '!important' : ''}">
          <div :class="['bbn-spadded', , 'bbn-vmiddle', 'bbn-unselectable', {
                  'bbn-flex-width': !sec.collapsed,
                  'bbn-flex-height': !!sec.collapsed
                }]">
            <bbn-button v-if="sec.collapsed"
                        class="bbn-no-border"
                        :notext="true"
                        :text="_('Expand')"
                        icon="nf nf-mdi-arrow_expand"
                        @click="expand(sec)"
                        style="height: auto; width: 100%; aspect-ratio: 1"/>
            <div :class="['bbn-upper', 'bbn-b', 'bbn-tertiary-text-alt', 'bbn-unselectable', 'bbn-m', {
                    'bbn-left-space': !sec.collapsed,
                    'bbn-top-space': !!sec.collapsed,
                    'bbn-right-lspace': !sec.collapsed,
                    'bbn-bottom-lspace': !!sec.collapsed,
                    'verticaltext': !!sec.collapsed
                  }]"
                  v-text="sec.title"
                  :style="{color: !!sec.fontColor ? sec.fontColor + '!important' : ''}"/>
            <div class="bbn-alt-background bbn-vmiddle bbn-xspadded bbn-radius bbn-flex-fill"
                 :style="{
                   'min-height': '2rem',
                   'justify-content': 'flex-end',
                   'align-items': !!sec.collapsed ? 'flex-end': ''
                 }">
              <bbn-button v-if="!sec.collapsed && sec.canAdd"
                          icon="nf nf-fa-plus"
                          :title="_('Add issue')"
                          class="bbn-no-border bbn-right-sspace"
                          @click="addIssue(sec)"/>
              <div :class="['bbn-radius', 'bbn-background', 'bbn-hspadded', {
                      'bbn-vspadded': !!sec.collapsed,
                      'bbn-vmiddle': !sec.collapsed,
                      'bbn-flex': !!sec.collapsed,
                      'verticaltext': !!sec.collapsed
                    }]"
                    style="min-height: 1.9rem; min-width: 1.9rem; align-items: center">
                <i class="nf nf-oct-issue_opened bbn-m bbn-middle"/>
                <div :class="{'bbn-left-xsspace': !sec.collapsed}"
                      v-text="sec.items.length"/>
              </div>
            </div>
            <bbn-button v-if="!sec.collapsed"
                        class="bbn-no-border bbn-left-space"
                        :notext="true"
                        :text="_('Collapse')"
                        icon="nf nf-mdi-arrow_collapse"
                        @click="collapse(sec)"
                        style="height: 100%; width: auto; aspect-ratio: 1"/>
          </div>
          <div v-if="!sec.collapsed"
                class="bbn-flex-fill bbn-padded">
            <div class="bbn-100">
              <bbn-scroll axis="y">
                <div v-for="(item, sidx) in sec.items"
                      :class="[
                        'appui-vcs-project-issues-item',
                        'bbn-radius',
                        'bbn-alt-background',
                        'bbn-spadded',
                        {
                          'bbn-bottom-space': !!sec.items[sidx+1]
                        }
                      ]">
                  <div class="bbn-flex-width">
                    <div class="bbn-vmiddle bbn-flex-fill">
                      <bbn-initial :user-name="item.author.name"
                                  width="1.2rem"
                                  height="1.2rem"
                                  font-size="0.7rem"/>
                      <span class="bbn-left-xsspace bbn-s bbn-unselectable"
                            v-text="isYou(item.author.id) ? _('You') : item.author.name"
                            :title="item.author.username || item.author.name"/>
                    </div>
                    <div v-if="item.created === item.updated"
                          v-text="mainPage.formatDate(item.created)"
                          :title="_('Created at')"
                          class="bbn-s"/>
                    <div v-else
                          v-text="mainPage.formatDate(item.updated)"
                          :title="_('Updated at')"
                          class="bbn-s"/>
                  </div>
                  <div class="bbn-flex-width">
                    <div class="bbn-middle bbn-vsmargin bbn-background bbn-radius bbn-spadded bbn-flex-fill">
                      <i class="nf nf-mdi-lock bbn-red bbn-right-sspace"
                          :title="_('Private')"
                          v-if="!!item.private"/>
                      <div class="bbn-b bbn-secondary-text-alt bbn-upper"
                            v-text="item.title"/>
                    </div>
                    <div class="bbn-radius bbn-background bbn-left-sspace bbn-middle bbn-xspadded bbn-vsmargin">
                      <bbn-context :source="getMenuSource(item)">
                        <i class="nf nf-mdi-dots_vertical bbn-p"/>
                      </bbn-context>
                    </div>
                  </div>
                  <issue-description v-if="item.descriptionHtml"
                                     :source="item"
                                     @zoom="openComment"/>
                  <div class="bbn-vsmargin bbn-flex-width bbn-w-100">
                    <i class="nf nf-fa-tags bbn-primary-text-alt bbn-lg bbn-right-sspace bbn-top-xsspace"/>
                    <appui-vcs-project-issues-labels :source="item"
                                                     class="bbn-flex-fill"/>
                  </div>
                  <div class="bbn-grid"
                        style="grid-template-columns: repeat(3, 1fr)">
                    <div>
                      <appui-vcs-project-issues-assign :source="item"
                                                       :menu="getAssignmentList"
                                                       :disabled="isClosed(item)"/>
                    </div>
                    <div class="bbn-flex"
                          style="justify-content: center">
                      <bbn-button :title="_('Comments')"
                                  class="bbn-background bbn-no-border"
                                  style="padding-left: 0.5rem; padding-right: 0.5rem"
                                  @click="openComments(item)">
                        <div class="bbn-vmiddle">
                          <i class="nf nf-mdi-comment_multiple_outline bbn-lg"/>
                          <span v-text="item.notes"
                                class="bbn-left-sspace"/>
                        </div>
                      </bbn-button>
                    </div>
                    <div class="bbn-flex"
                         style="justify-content: flex-end">
                      <bbn-button class="bbn-background bbn-no-border"
                                  style="padding-left: 0.5rem; padding-right: 0.5rem"
                                  :title="_('Tasks')">
                        <div class="bbn-vmiddle">
                          <template v-if="item.tasks.count">
                            <i class="nf nf-mdi-playlist_check bbn-xl bbn-green"/>
                            <span v-text="item.tasks.completed"
                                  class="bbn-left-sspace bbn-right-space bbn-green"/>
                            <i class="nf nf-mdi-playlist_remove bbn-lg bbn-red"/>
                            <span v-text="item.tasks.count - item.tasks.completed"
                                  class="bbn-left-sspace bbn-red"/>
                          </template>
                          <template v-else>
                            <i class="bbn-right-sspace nf nf-mdi-format_list_checks bbn-lg"/>
                            <span v-text="_('No tasks')"
                                  class="bbn-upper bbn-xs"/>
                          </template>
                        </div>
                      </bbn-button>
                    </div>
                  </div>
                </div>
              </bbn-scroll>
            </div>
          </div>
        </div>
      </div>
      <div v-else
            class="bbn-100 bbn-alt-background bbn-padded">
        <div class="bbn-100">
          <bbn-loader class="bbn-radius"
                      style="background-color: var(--default-background)"/>
        </div>
      </div>
    </bbn-scroll>
  </div>
</div>