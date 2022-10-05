<div class="appui-vcs-project-issues-comment bbn-background bbn-overlay bbn-flex-height">
  <div class="bbn-padded">
    <div :class="['bbn-spadded', 'bbn-background', 'bbn-radius', 'appui-vcs-box-shadow', 'bbn-vmiddle', 'bbn-nowrap', {
            'bbn-flex-width': !mainPage.isMobile(),
            'bbn-flex-height': !!mainPage.isMobile()
          }]">
      <div :class="['bbn-upper', 'bbn-b', 'bbn-lg', 'bbn-secondary-text-alt', 'bbn-flex-fill', 'bbn-alt-background', 'bbn-spadded', 'bbn-radius', {
              'bbn-left-sspace bbn-right-space': !mainPage.isMobile(),
              'bbn-top-space bbn-bottom-space': !!mainPage.isMobile(),
            }]"
            v-text="source.title"/>
      <div>
        <bbn-button class="bbn-no-border"
                    icon="nf nf-fa-close bbn-lg"
                    @click="currentPopup.close(currentPopup.items.length - 1, true)"/>
      </div>
    </div>
  </div>
  <div class="bbn-flex-fill bbn-padded">
    <div class="bbn-100 bbn-alt-background bbn-radius">
      <bbn-scroll axis="y">
        <pre v-html="source.descriptionHtml"
            class="bbn-padded bbn-w-100 appui-vcs-project-issues-comment-text bbn-no-margin"/>
      </bbn-scroll>
    </div>
  </div>
</div>