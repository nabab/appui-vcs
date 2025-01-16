<div class="appui-vcs-project-issues-issue">
  <div class="bbn-flex-width">
    <div class="bbn-vmiddle bbn-flex-fill">
      <bbn-initial :user-name="source.author.name"
                   width="1.2rem"
                   height="1.2rem"
                   font-size="0.7rem"/>
      <span class="bbn-left-xsspace bbn-s bbn-unselectable"
            v-text="isYou(source.author.id) ? _('You') : source.author.name"
            :title="source.author.username || source.author.name"/>
    </div>
    <div v-if="source.created === source.updated"
         v-text="mainPage.formatDate(source.created)"
         :title="_('Created at')"
         class="bbn-s"/>
    <div v-else
         v-text="mainPage.formatDate(source.updated)"
         :title="_('Updated at')"
         class="bbn-s"/>
  </div>
  <div class="bbn-flex-width">
    <div class="bbn-radius bbn-background bbn-right-sspace bbn-middle bbn-xspadding bbn-vsmargin">
      <i v-if="source.collapsed"
         class="nf nf-fa-expand bbn-p"
         :title="_('Expand')"
         @click="source.collapsed = false"/>
      <i v-else
         class="nf nf-fa-compress bbn-p"
         :title="_('Collapse')"
         @click="source.collapsed = true"/>
    </div>
    <div class="bbn-middle bbn-vsmargin bbn-background bbn-radius bbn-spadding bbn-flex-fill">
      <i class="nf nf-md-lock bbn-red bbn-right-sspace"
         :title="_('Private')"
         v-if="!!source.private"/>
      <div class="bbn-b bbn-secondary-text-alt bbn-upper"
           v-text="source.title"/>
    </div>
    <div class="bbn-radius bbn-background bbn-left-sspace bbn-middle bbn-xspadding bbn-vsmargin">
      <bbn-context :source="getMenuSource">
        <i class="nf nf-md-dots_vertical bbn-p"/>
      </bbn-context>
    </div>
  </div>
  <template v-if="!source.collapsed">
    <div class="bbn-vsmargin bbn-w-100"
        ref="description">
      <pre v-html="source.descriptionHtml"
            class="appui-vcs-project-issues-issue-description"/>
      <div class="bbn-c bbn-top-space"
            v-if="showOpenInNewWindowButton">
        <bbn-button class="bbn-no-border bbn-upper bbn-xs"
                    :label="_('Show more content')"
                    @click="openInNewWindow"/>
      </div>
    </div>
    <div class="bbn-vsmargin bbn-flex-width bbn-w-100">
      <i class="nf nf-fa-tags bbn-primary-text-alt bbn-lg bbn-right-sspace bbn-top-xsspace"/>
      <appui-vcs-project-issues-labels :source="source"
                                      class="bbn-flex-fill"/>
    </div>
    <div class="bbn-grid"
          style="grid-template-columns: repeat(3, 1fr)">
      <div>
        <appui-vcs-project-issues-assign :source="source"
                                        :menu="getAssignmentList"
                                        :disabled="isClosed"/>
      </div>
      <div class="bbn-flex"
          style="justify-content: center">
        <bbn-button :title="_('Comments')"
                    class="bbn-background bbn-no-border"
                    style="padding-left: 0.5rem; padding-right: 0.5rem"
                    @click="openComments">
          <div class="bbn-vmiddle">
            <i class="nf nf-md-comment_multiple_outline bbn-lg"/>
            <span v-text="source.notes"
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
            <template v-if="source.tasks.count">
              <i class="nf nf-md-playlist_check bbn-xl bbn-green"/>
              <span v-text="source.tasks.completed"
                    class="bbn-left-sspace bbn-right-space bbn-green"/>
              <i class="nf nf-md-playlist_remove bbn-lg bbn-red"/>
              <span v-text="source.tasks.count - source.tasks.completed"
                    class="bbn-left-sspace bbn-red"/>
            </template>
            <template v-else>
              <i class="bbn-right-sspace nf nf-md-format_list_checks bbn-lg"/>
              <span v-text="_('No tasks')"
                    class="bbn-upper bbn-xs"/>
            </template>
          </div>
        </bbn-button>
      </div>
    </div>
  </template>
</div>