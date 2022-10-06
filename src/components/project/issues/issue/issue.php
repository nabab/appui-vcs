<div class="appui-vcs-project-issues-issue bbn-background bbn-overlay bbn-flex-height">
  <div class="bbn-padded">
    <div :class="['bbn-spadded', 'bbn-background', 'bbn-radius', 'appui-vcs-box-shadow', 'bbn-vmiddle', 'bbn-nowrap', {
            'bbn-flex-width': !mainPage.isMobile(),
            'bbn-flex-height': !!mainPage.isMobile()
          }]">
      <div :class="['bbn-upper', 'bbn-b', 'bbn-lg', 'bbn-secondary-text-alt', 'bbn-flex-fill', 'bbn-alt-background', 'bbn-spadded', 'bbn-radius', {
              'bbn-left-sspace bbn-right-space': !mainPage.isMobile(),
              'bbn-top-space bbn-bottom-space': !!mainPage.isMobile(),
            }]"
            v-text="_('New issue')"/>
      <div>
        <bbn-button class="bbn-no-border"
                    icon="nf nf-fa-close bbn-lg"
                    @click="close"/>
      </div>
    </div>
  </div>
  <div class="bbn-flex-fill bbn-padded">
    <div class="bbn-100 bbn-alt-background bbn-radius appui-vcs-box-shadow">
      <bbn-form :source="source"
                :data="formData"
                :action="mainPage.root + 'actions/project/issue/' + (!!source.id ? 'edit' : 'create')"
                :scrollable="true"
                :windowed="false"
                @success="onSuccess"
                :buttons="[{
                  text: _('Cancel'),
                  icon: 'nf nf-fa-times_circle',
                  action: close
                }, 'submit']"
                ref="form">
        <div class="bbn-padded bbn-grid-fields">
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
                  'nf nf-mdi-lock bbn-red': !!source.private,
                  'nf nf-mdi-lock_open bbn-green': !source.private
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