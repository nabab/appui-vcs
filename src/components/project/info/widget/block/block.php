<div :class="['appui-vcs-project-info-widget-block', 'bbn-alt-background', 'bbn-spadding', 'bbn-radius', {
       'bbn-bottom-space': !!margin
     }]">
  <div class="bbn-flex-width">
    <div class="bbn-vmiddle bbn-flex-fill">
      <bbn-initial :user-name="source.author.name"
                   width="1.2rem"
                   height="1.2rem"
                   font-size="0.7rem"/>
      <span v-if="isYou(source.author.id)"
            class="bbn-left-xsspace bbn-s"
            v-text="_('You')"/>
      <template v-else>
        <span v-text="source.author.name"
              class="bbn-hxsmargin bbn-s"/>
        <span v-if="!!source.author.username"
              class="bbn-s">(@<span v-text="source.author.username"/>)</span>
      </template>
    </div>
    <div v-text="formatDate(source.created)"
        :title="_('Created at')"
        class="bbn-s"/>
  </div>
  <div class="bbn-middle bbn-b bbn-vsmargin bbn-secondary-text-alt"
       v-if="source.title">
    <div v-text="source.title"/>
  </div>
  <div :class="['bbn-middle', {
         'bbn-secondary-text-alt': !source.title,
         'bbn-b': !source.title,
         'bbn-vsmargin': !source.title
       }]"
       v-if="source.branch">
    <i class="nf nf-md-source_branch bbn-lg"
       :title="_('Branch')"/>
    <div :title="_('Branch')"
         v-text="source.branch"
         class="bbn-hxsmargin"/>
    <i :title="_('Default branch')"
       class="nf nf-fa-star bbn-lg bbn-primary-text-alt"
       v-if="!!source.default"/>
  </div>
  <div v-text="source.text"/>
</div>