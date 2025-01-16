<bbn-context :source="menu"
             :data="source"
             :style="{'pointer-events': disabled ? 'none' : ''}"
             :item-component="$options.components.assignUser">
  <bbn-button class="bbn-background bbn-no-border"
              :title="!!numProperties(source.assigned) ? _('Assigned to') : _('Unassigned')"
              :style="{
                'padding-left': '0.5rem',
                'padding-right': '0.5rem',
                'pointer-events': disabled ? 'none' : ''
              }">
    <div class="bbn-vmiddle">
      <i v-if="icons"
         :class="['bbn-right-sspace', {
            'nf nf-md-account_star bbn-lg': !!numProperties(source.assigned),
            'nf nf-md-account_off': !numProperties(source.assigned)
          }]"/>
      <span v-if="!numProperties(source.assigned)"
            v-text="disabled ? _('Unassigned') : _('Assign')"
            class="bbn-xs bbn-upper"/>
      <div v-else
          class="bbn-vmiddle">
        <bbn-initial :user-name="source.assigned.name"
                      width="1.2rem"
                      height="1.2rem"
                      font-size="0.7rem"/>
        <span class="bbn-left-xsspace bbn-s bbn-unselectable"
              v-text="isYou(source.assigned.id) ? _('You') : source.assigned.name"
              :title="source.assigned.username || source.assigned.name"/>
      </div>
    </div>
  </bbn-button>
</bbn-context>