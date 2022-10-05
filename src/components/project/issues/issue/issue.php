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
      <bbn-form :source="formSource"
                :data="formData"
                :action="mainPage.root + 'actions/project/issue/create'"
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
                      v-model="formSource.title"/>
          <label class="bbn-label"
                 v-text="_('Description')"/>
          <bbn-rte v-model="formSource.description"
                   height="30rem"/>
          <label class="bbn-label"
                 v-text="_('Labels')"/>
          <div class="bbn-vmiddle bbn-w-100">
            <div v-for="(label, i) in formSource.labels"
                  :class="['bbn-radius', 'bbn-xspadded', 'bbn-iblock ', 'bbn-bottom-sspace', 'bbn-s', 'appui-vcs-project-issues-issue-label', {
                    'bbn-right-sspace': !!formSource.labels[i+1]
                  }]"
                  :style="{
                    backgroundColor: getLabelBackground(label),
                    color: getLabelColor(label)
                  }">
              <span v-text="label"/>
              <i class="nf nf-fa-close bbn-left-sspace bbn-p appui-vcs-project-issues-issue-labelx"
                 @click="removeLabel(label)"
                 :title="_('Remove label')"/>
            </div>
            <bbn-context>
              <bbn-button :class="['bbn-no-border', 'bbn-bottom-sspace', {'bbn-left-sspace': formSource.labels.length}]"
                          :title="_('Add label')"
                          icon="nf nf-fa-plus"/>
            </bbn-context>
          </div>
        </div>
      </bbn-form>
    </div>
  </div>
</div>