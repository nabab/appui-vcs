<div class="appui-vcs-project-issues-labels bbn-w-100">
  <div v-for="(label, i) in source.labels"
        :class="['bbn-radius', 'bbn-xspadding', 'bbn-iblock ', 'bbn-bottom-sspace', 'bbn-s', 'appui-vcs-project-issues-labels-label', {
          'bbn-right-sspace': !!source.labels[i+1]
        }]"
        :style="{
          backgroundColor: getLabelBackground(label),
          color: getLabelColor(label)
        }">
    <span v-text="label"/>
    <i class="nf nf-fa-close bbn-left-sspace bbn-p appui-vcs-project-issues-labels-x"
        @click="removeLabel(label)"
        :title="_('Remove label')"/>
  </div>
  <bbn-context tag="div"
               class="bbn-iblock bbn-bottom-sspace"
               :source="getMenuSource"
               :item-component="$options.components.label">
    <bbn-button :class="['bbn-no-border', {'bbn-left-sspace': source.labels.length}]"
                :title="_('Add label')"
                icon="nf nf-fa-plus"/>
  </bbn-context>
</div>