<div class="appui-vcs-project-issues bbn-alt-background bbn-overlay">
  <div class="bbn-overlay bbn-flex-height">
    <div class="bbn-alt-background bbn-padded">
      <div class="bbn-spadded bbn-background bbn-radius appui-vcs-box-shadow bbn-vmiddle bbn-flex-width">
        <div class="bbn-alt-background bbn-vmiddle bbn-xspadded bbn-radius bbn-flex-fill"
              style="min-height: 2rem">
          <div class="bbn-vmiddle">
            <div class="bbn-upper bbn-hmargin bbn-b bbn-secondary-text-alt"
                  v-text="_('Filter')"/>
            <div class="bbn-right-padded bbn-bordered-right bbn-right-space">
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
          <bbn-button icon="nf nf-mdi-arrow_collapse"
                      :text="_('Collapse all')"
                      @click="collapseAll"
                      class="bbn-right-sspace"/>
          <bbn-button icon="nf nf-mdi-arrow_expand"
                      :text="_('Expand all')"
                      @click="expandAll"/>
        </div>
        <div class="bbn-upper bbn-b bbn-lg bbn-tertiary-text-alt bbn-left-lspace bbn-right-space"
              v-text="_('Issues')"/>
      </div>
    </div>
    <div class="bbn-flex-fill">
      <bbn-scroll axis="x">
        <div class="appui-vcs-project-issues-sections bbn-grid bbn-h-100 bbn-padded"
             v-if="ready">
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
                  <div v-for="(item, idx) in sec.items"
                        :class="['bbn-radius', 'bbn-alt-background', 'bbn-spadded', {'bbn-bottom-space': !!sec.items[idx+1]}]">
                    <div class="bbn-flex-width">
                      <div class="bbn-vmiddle bbn-flex-fill">
                        <bbn-initial :user-name="item.author.name"
                                    width="1.2rem"
                                    height="1.2rem"
                                    font-size="0.7rem"/>
                        <span v-if="isYou(item.author.id)"
                              class="bbn-left-xsspace bbn-s"
                              v-text="_('You')"/>
                        <template v-else>
                          <span v-text="item.author.name"
                                class="bbn-hxsmargin bbn-s"/>
                          <span v-if="!!item.author.username"
                                class="bbn-s">(@<span v-text="item.author.username"/>)</span>
                        </template>
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
                    <div class="bbn-middle bbn-b bbn-vsmargin bbn-secondary-text-alt"
                        v-if="item.title">
                      <div v-text="item.title"/>
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
</div>