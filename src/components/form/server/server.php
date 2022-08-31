<bbn-form :action="root + 'actions/server/create'"
          :source="source"
          @success="onSuccess">
  <div class="bbn-grid-fields bbn-padded">
    <label class="bbn-label"><?=_('Name')?></label>
    <bbn-input v-model="source.text"/>
    <label class="bbn-label"><?=_('Code')?></label>
    <bbn-input v-model="source.code"/>
    <label class="bbn-label"><?=_('Type')?></label>
    <bbn-dropdown :source="types"
                  v-model="source.type"/>
    <label class="bbn-label"><?=_('Admin Token')?></label>
    <bbn-input v-model="source.adminToken"/>
    <label class="bbn-label"><?=_('User Token')?></label>
    <bbn-input v-model="source.userToken"/>
  </div>
</bbn-form>