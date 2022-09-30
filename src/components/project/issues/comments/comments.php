<div class="appui-vcs-project-issues-comments bbn-background bbn-overlay">
  <bbn-scroll axis="y">
    <div class="bbn-padded">
      <div v-for="(item, idx) in comments"
            :class="[
              'bbn-w-100',
              'bbn-radius',
              'bbn-alt-background',
              'bbn-spadded',
              'appui-vcs-box-shadow',
              {
                'bbn-bottom-space': !!comments[idx+1]
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
          <div class="bbn-vmiddle bbn-vsmargin bbn-background bbn-radius bbn-spadded bbn-flex-fill">
            <pre class="bbn-no-margin appui-vcs-project-issues-comments-comment-text"
                 v-html="item.contentHtml"
                 v-if="item.contentHtml"/>
          </div>
          <div v-if="!!item.private"
               class="bbn-radius bbn-background bbn-left-sspace bbn-middle bbn-xspadded bbn-vsmargin">
            <i class="nf nf-mdi-lock bbn-red"
               :title="_('Private')"/>
          </div>
          <div class="bbn-radius bbn-background bbn-left-sspace bbn-middle bbn-hxspadded bbn-vspadded bbn-vsmargin"
               style="height: max-content">
            <bbn-context :source="getMenuSource"
                         :data="item"
                         :sourceIndex="idx">
              <i class="nf nf-mdi-dots_vertical bbn-p"/>
            </bbn-context>
          </div>
        </div>
      </div>
    </div>
  </bbn-scroll>
</div>