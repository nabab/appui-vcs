<div class="appui-vcs-project-info-widget appui-vcs-box-shadow bbn-radius">
  <div class="bbn-background bbn-radius bbn-padding">
    <div class="bbn-b bbn-lg bbn-tertiary-text-alt bbn-upper"
          v-text="source.title"/>
    <div class="bbn-top-sspace">
      <template v-if="!!source.items && source.items.length">
        <appui-vcs-project-info-widget-block v-for="(it, idx) in source.items"
                                            :key="idx"
                                            :source="it"
                                            :margin="!!source.items[idx+1]"/>
      </template>
      <div v-else
           class="bbn-alt-background bbn-spadding bbn-radius bbn-c"
           v-text="_('No data')"/>
    </div>
  </div>
</div>