<div class="appui-vcs-project-issues-issue-form bbn-background bbn-overlay bbn-flex-height">
  <div :class="['bbn-spadding', 'bbn-background', 'bbn-radius', 'bbn-vmiddle', 'bbn-nowrap', {
          'bbn-flex-width': !isMobile,
          'bbn-flex-height': !!isMobile
        }]">
    <div :class="['bbn-upper', 'bbn-b', 'bbn-lg', 'bbn-secondary-text-alt', 'bbn-flex-fill', 'bbn-alt-background', 'bbn-spadding', 'bbn-radius', {
            'bbn-left-sspace bbn-right-space': !isMobile,
            'bbn-top-space bbn-bottom-space': !!isMobile,
          }]"
          v-text="_('New issue')"/>
    <div>
      <bbn-button class="bbn-no-border"
                  icon="nf nf-fa-close bbn-lg"
                  @click="close"/>
    </div>
  </div>
  <div class="bbn-flex-fill bbn-top-sspace bbn-radius">
    <div class="bbn-100 bbn-alt-background bbn-radius">
      <bbn-form :source="source"
                :data="formData"
                :action="root + 'actions/project/issue/' + (!!source.id ? 'edit' : 'create')"
                :scrollable="true"
                :windowed="false"
                @success="onSuccess"
                :buttons="[{
                  text: _('Cancel'),
                  icon: 'nf nf-fa-times_circle',
                  action: close
                }, 'submit']"
                ref="form">
        <div class="bbn-padding bbn-grid-fields">
          <label class="bbn-label"
                 v-text="_('Title')"/>
          <bbn-input class="bbn-w-100"
                     v-model="source.title"
                     :required="true"/>
          <label class="bbn-label"
                 v-text="_('Description')"/>
          <bbn-rte v-model="source.description"
                   height="40rem"/>
          <label class="bbn-label"
                 v-text="_('Assigned')"/>
          <appui-vcs-project-issues-assign :source="source"
                                           :menu="getAssignmentList"
                                           :icons="false"/>
          <label class="bbn-label"
                 v-text="_('Labels')"/>
          <appui-vcs-project-issues-labels :source="source"
                                           :edit-mode="false"/>
          <label class="bbn-label"
                 v-text="_('Private')"/>
          <div class="bbn-vmiddle"
               style="height: 100%">
            <i :class="{
                  'nf nf-md-lock bbn-red': !!source.private,
                  'nf nf-md-lock_open bbn-green': !source.private
                }"/>
            <bbn-checkbox v-model="source.private"
                          :value="true"
                          :novalue="false"
                          class="bbn-left-sspace"/>
          </div>
        </div>
      </bbn-form>
    </div>
  </div>
</div>