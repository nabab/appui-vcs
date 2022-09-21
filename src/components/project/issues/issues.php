<div class="appui-vcs-project-issues bbn-alt-background bbn-overlay bbn-padded">
  <div class="bbn-100">
    <div class="bbn-overlay bbn-flex-height">
      <div class="bbn-spadded bbn-background bbn-radius bbn-bottom-space appui-vcs-box-shadow bbn-vmiddle bbn-flex-width">
        <div class="bbn-alt-background bbn-vmiddle bbn-xspadded bbn-radius bbn-flex-fill"
             style="min-height: 2rem">
        </div>
        <div class="bbn-upper bbn-b bbn-lg bbn-tertiary-text-alt bbn-left-lspace bbn-right-space"
             v-text="_('Issues')"/>
      </div>
      <div class="bbn-flex-fill">
        <bbn-scroll axis="x">
          <div class="appui-vcs-project-issues-sections bbn-grid bbn-h-100">
            <div v-for="sec in sections"
                 :class="['bbn-flex-height', 'bbn-radius', 'bbn-background', 'appui-vcs-box-shadow', {collapsed: !!sec.collapsed || !sec.items.length}]">
              <div class="bbn-spadded bbn-bottom-space bbn-vmiddle bbn-flex-width">
                <div class="bbn-upper bbn-b bbn-tertiary-text-alt bbn-left-space bbn-right-lspace"
                     v-text="sec.title"/>
                <div class="bbn-alt-background bbn-vmiddle bbn-xspadded bbn-radius bbn-flex-fill"
                     style="min-height: 2rem">
                </div>
              </div>
            </div>
          </div>
        </bbn-scroll>
      </div>
    </div>
  </div>
</div>