<div class="appui-vcs-project-issues-comment bbn-background bbn-overlay bbn-flex-height">
  <div :class="['bbn-spadding', 'bbn-background', 'bbn-radius', 'bbn-vmiddle', 'bbn-nowrap', {
          'bbn-flex-width': !isMobile,
          'bbn-flex-height': !!isMobile
        }]">
    <div :class="['bbn-upper', 'bbn-b', 'bbn-lg', 'bbn-secondary-text-alt', 'bbn-flex-fill', 'bbn-alt-background', 'bbn-spadding', 'bbn-radius', {
            'bbn-left-sspace bbn-right-space': !isMobile,
            'bbn-top-space bbn-bottom-space': !!isMobile,
          }]"
          v-text="source.title"/>
    <div>
      <bbn-button class="bbn-no-border"
                  icon="nf nf-fa-close bbn-lg"
                  @click="currentPopup.close(currentPopup.items.length - 1, true)"/>
    </div>
  </div>
  <div class="bbn-flex-fill bbn-top-xsspace bbn-xspadding">
    <div class="bbn-100 bbn-radius">
      <bbn-scroll axis="y">
        <pre v-html="source.descriptionHtml"
            class="bbn-padding bbn-w-100 appui-vcs-project-issues-comment-text bbn-no-margin bbn-alt-background bbn-radius"/>
        <appui-vcs-project-issues-comments :source="source"
                                           :fullpage="false"
                                           class="bbn-top-space bbn-radius"/>
      </bbn-scroll>
    </div>
  </div>
</div>