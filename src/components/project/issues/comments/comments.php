<div class="appui-vcs-project-issues-comments bbn-background bbn-overlay bbn-flex-height">
  <div v-if="isLoading"
       class="bbn-flex-fill">
    <bbn-loader class="bbn-radius"
                style="background-color: var(--default-background)"/>
  </div>
  <template v-else>
    <div class="bbn-padded">
      <div :class="['bbn-spadded', 'bbn-background', 'bbn-radius', 'appui-vcs-box-shadow', 'bbn-vmiddle', 'bbn-nowrap', {
              'bbn-flex-width': !mainPage.isMobile(),
              'bbn-flex-height': !!mainPage.isMobile()
            }]">
        <div class="bbn-alt-background bbn-vmiddle bbn-hspadded bbn-radius bbn-flex-fill"
              style="min-height: 2rem; flex-wrap: wrap">
          <div :class="[{
                  'bbn-vmiddle bbn-right-lspace': !mainPage.isMobile(),
                }, 'bbn-vxsmargin']">
            <bbn-button :text="_('New comment')"
                        icon="nf nf-mdi-comment_plus_outline"
                        @click="newComment"/>
          </div>
        </div>
        <div :class="['bbn-upper', 'bbn-b', 'bbn-lg', 'bbn-tertiary-text-alt', {
                'bbn-left-lspace bbn-right-space': !mainPage.isMobile(),
                'bbn-top-space bbn-bottom-space': !!mainPage.isMobile(),
              }]"
              v-text="_('Comments')"/>
        <div>
          <bbn-button class="bbn-no-border"
                      icon="nf nf-fa-close bbn-lg"
                      @click="currentPopup.close(currentPopup.items.length - 1, true)"/>
        </div>
      </div>
    </div>
    <div class="bbn-flex-fill">
      <bbn-scroll axis="y"
                  ref="scroll">
        <div class="bbn-padded bbn-w-100">
          <div v-for="(item, idx) in comments"
                :class="[
                  'bbn-w-100',
                  'bbn-radius',
                  'bbn-spadded',
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
              <i class="nf nf-mdi-lock bbn-red bbn-hsmargin"
                 :title="_('Private')"
                 v-if="item.private"/>
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
              <div class="bbn-vmiddle bbn-top-sspace bbn-background bbn-radius bbn-spadded bbn-flex-fill">
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
              <div class="bbn-radius bbn-background bbn-text bbn-left-sspace bbn-middle bbn-hxspadded bbn-vspadded bbn-vsmargin"
                  style="height: max-content"
                  v-if="!item.auto">
                <bbn-context :source="getMenuSource"
                            :data="item"
                            :sourceIndex="idx">
                  <i class="nf nf-mdi-dots_vertical bbn-p"/>
                </bbn-context>
              </div>
            </div>
          </div>
          <comment-editor v-if="commentForm"
                          class="bbn-w-100 bbn-radius bbn-spadded appui-vcs-box-shadow bbn-alt-background bbn-top-lspace"
                          :source="formSource"/>
          <div v-if="commentForm === 2"
              class="bbn-w-100 bbn-radius bbn-spadded appui-vcs-box-shadow bbn-alt-background bbn-top-lspace">
            <bbn-form :source="formSource"
                      :data="formData"
                      :action="mainPage.root + 'actions/project/issue/comment/insert'"
                      :windowed="false"
                      @success="onSuccess">
              <div class="bbn-bottom-sspace bbn-vmiddle">
                <i :class="{
                     'nf nf-mdi-lock bbn-red': !!formSource.private,
                     'nf nf-mdi-lock_open bbn-green': !formSource.private
                   }"/>
                <bbn-checkbox :label="_('Private')"
                              v-model="formSource.private"
                              :value="true"
                              :novalue="false"
                              class="bbn-left-sspace"/>
              </div>
              <bbn-rte height="30rem"
                      v-model="formSource.content"
                      @ready="scrollEnd"
                      :required="true"/>
            </bbn-form>
          </div>
        </div>
      </bbn-scroll>
    </div>
  </template>
</div>