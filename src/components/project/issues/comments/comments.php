<div :class="['appui-vcs-project-issues-comments', 'bbn-background', {
       'bbn-overlay bbn-flex-height': fullpage,
       'bbn-w-100': !fullpage
     }]">
  <div v-if="isLoading"
       :class="{'bbn-flex-fill': fullpage}">
    <bbn-loader class="bbn-radius"
                style="background-color: var(--default-background)"/>
  </div>
  <template v-else>
    <div :class="['bbn-spadding', 'bbn-background', 'bbn-radius', 'bbn-vmiddle', 'bbn-nowrap', {
           'bbn-flex-width': !isMobile,
           'bbn-flex-height': !!isMobile
         }]">
      <div class="bbn-alt-background bbn-vmiddle bbn-hspadding bbn-radius bbn-flex-fill"
           style="min-height: 2rem; flex-wrap: wrap">
        <div :class="[{
               'bbn-vmiddle bbn-right-lspace': !isMobile,
             }, 'bbn-vxsmargin']">
          <bbn-button :label="_('New comment')"
                      icon="nf nf-md-comment_plus_outline"
                      @click="newComment"/>
        </div>
      </div>
      <div :class="['bbn-upper', 'bbn-b', 'bbn-lg', 'bbn-tertiary-text-alt', {
             'bbn-left-lspace bbn-right-space': !isMobile,
             'bbn-top-space bbn-bottom-space': !!isMobile,
           }]"
           v-text="_('Comments')"/>
      <div v-if="fullpage">
        <bbn-button class="bbn-no-border"
                    icon="nf nf-fa-close bbn-lg"
                    @click="currentPopup.close(currentPopup.items.length - 1, true)"/>
      </div>
    </div>
    <div :class="{'bbn-flex-fill': fullpage}">
      <component :is="fullpage ? 'bbn-scroll' : 'div'"
                  axis="y"
                  ref="scroll">
        <div class="bbn-padding bbn-w-100">
          <div v-for="(item, idx) in comments"
                :class="[
                  'bbn-w-100',
                  'bbn-radius',
                  'bbn-spadding',
                  'appui-vcs-box-shadow',
                  {
                    'bbn-alt-background': !item.auto && !item.private,
                    'bbn-secondary': !!item.private,
                    'bbn-tertiary': !!item.auto,
                    'bbn-bottom-lspace': !!comments[idx+1]
                  }
                ]">
            <div class="bbn-flex-width bbn-vmiddle">
              <div class="bbn-vmiddle bbn-flex-fill">
                <bbn-initial :user-name="item.author.name"
                              width="1.2rem"
                              height="1.2rem"
                              font-size="0.7rem"/>
                <span class="bbn-left-xsspace bbn-s bbn-unselectable"
                      v-text="isYou(item.author.id) ? _('You') : item.author.name"
                      :title="item.author.username || item.author.name"/>
              </div>
              <i class="nf nf-md-lock bbn-red bbn-hsmargin"
                 :title="_('Private')"
                 v-if="item.private"/>
              <div v-if="item.created === item.updated"
                    v-text="formatDate(item.created)"
                    :title="_('Created at')"
                    class="bbn-s"/>
              <div v-else
                    v-text="formatDate(item.updated)"
                    :title="_('Updated at')"
                    class="bbn-s"/>
            </div>
            <div class="bbn-flex-width">
              <div class="bbn-vmiddle bbn-top-sspace bbn-background bbn-radius bbn-spadding bbn-flex-fill">
                <comment-editor v-if="item.id === currentEdit"
                                :source="item"/>
                <pre v-else
                     :class="['bbn-no-margin', 'appui-vcs-project-issues-comments-comment-text', {
                       'appui-vcs-project-issues-comments-capitalize': !!item.auto,
                       'bbn-secondary-text-alt': !!item.private,
                       'bbn-tertiary-text-alt': !!item.auto
                     }]"
                     v-html="item.contentHtml"/>
              </div>
              <div class="bbn-radius bbn-background bbn-text bbn-left-sspace bbn-middle bbn-hxspadding bbn-vspadding bbn-vsmargin"
                  style="height: max-content"
                  v-if="!item.auto">
                <bbn-context :source="getMenuSource"
                            :data="item"
                            :sourceIndex="idx">
                  <i class="nf nf-md-dots_vertical bbn-p"/>
                </bbn-context>
              </div>
            </div>
          </div>
          <comment-editor v-if="commentForm"
                          class="bbn-w-100 bbn-radius bbn-spadding appui-vcs-box-shadow bbn-alt-background bbn-top-lspace"
                          :source="formSource"/>
        </div>
      </component>
    </div>
  </template>
</div>