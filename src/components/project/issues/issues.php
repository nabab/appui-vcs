<div class="appui-vcs-project-issues bbn-alt-background bbn-overlay">
  <div class="bbn-overlay bbn-flex-height">
    <div class="bbn-alt-background bbn-padded">
      <div class="bbn-spadded bbn-background bbn-radius appui-vcs-box-shadow bbn-vmiddle bbn-flex-width">
        <div class="bbn-alt-background bbn-vmiddle bbn-xspadded bbn-radius bbn-flex-fill"
              style="min-height: 2rem">
        </div>
        <div class="bbn-upper bbn-b bbn-lg bbn-tertiary-text-alt bbn-left-lspace bbn-right-space"
              v-text="_('Issues')"/>
      </div>
    </div>
    <div class="bbn-flex-fill">
      <bbn-scroll axis="x">
        <div class="appui-vcs-project-issues-sections bbn-grid bbn-h-100 bbn-padded">
          <div v-for="sec in sections"
                :class="['bbn-flex-height', 'bbn-radius', 'bbn-background', 'appui-vcs-box-shadow', {collapsed: !!sec.collapsed || !sec.items.length}]">
            <div :class="['bbn-spadded', 'bbn-bottom-space', 'bbn-vmiddle', {'bbn-flex-width': !sec.collapsed, 'bbn-flex-height': !!sec.collapsed}]">
              <div class="bbn-upper bbn-b bbn-tertiary-text-alt bbn-left-space bbn-right-lspace"
                   v-text="sec.title"/>
              <div class="bbn-alt-background bbn-vmiddle bbn-xspadded bbn-radius bbn-flex-fill"
                   style="min-height: 2rem; justify-content: flex-end">
                <div class="bbn-radius bbn-background bbn-hspadded bbn-vmiddle"
                     style="min-height: 1.9rem">
                  <i class="nf nf-oct-issue_opened bbn-m"/>
                  <div class="bbn-left-xsspace"
                       v-text="sec.items.length"/>
                </div>
              </div>
              <i :class="['bbn-p', 'bbn-xl', 'bbn-left-xsspace', {
                   'nf nf-fa-angle_down': !sec.collapsed,
                   'nf nf-fa-angle_up': !!sec.collapsed
                 }]"
                 @click="sec.collapsed = !sec.collapsed"/>
            </div>
            <div v-if="!sec.collapsed"
                 class="bbn-flex-fill">
              <bbn-scroll axis="y">

              </bbn-scroll>
            </div>
          </div>
        </div>
      </bbn-scroll>
    </div>
  </div>
</div>