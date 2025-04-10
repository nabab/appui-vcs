<div class="appui-vcs-project-issues-toolbar bbn-vmiddle"
     :style="{'flex-direction': !source.opened ? 'column': ''}">
  <template v-if="!!source.opened">
    <bbn-button v-if="!!source.data.canAdd"
                icon="nf nf-fa-plus"
                :title="_('Add issue')"
                class="bbn-no-border bbn-right-sspace"
                @click="addIssue"/>
    <bbn-button icon="nf nf-fa-compress"
                :title="_('Collapse all')"
                class="bbn-no-border bbn-right-sspace"
                @click="collapseAll"/>
    <bbn-button icon="nf nf-fa-expand"
                :title="_('Expand all')"
                class="bbn-no-border bbn-right-sspace"
                @click="expandAll"/>
  </template>
  <div :class="['bbn-radius', 'bbn-background', 'bbn-hspadding', {
          'bbn-vspadding': !source.opened,
          'bbn-vmiddle': !!source.opened,
          'bbn-flex': !source.opened,
          'verticaltext': !source.opened
        }]"
        style="min-height: 1.9rem; min-width: 1.9rem; align-items: center">
    <i class="nf nf-oct-issue_opened bbn-m bbn-middle"/>
    <div :class="{'bbn-left-xsspace': !!source.opened}"
          v-text="source.data?.items ? source.data.items.length : '0'"/>
  </div>
</div>
