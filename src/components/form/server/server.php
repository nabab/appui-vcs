<bbn-form :action="root + 'actions/server/' + (!!source.id ? 'edit' : 'create')"
          :source="source"
          @success="onSuccess">
  <div class="bbn-grid-fields bbn-padded">
    <label class="bbn-label"><?=_('Name')?></label>
    <bbn-input v-model="source.name"/>
    <label class="bbn-label"><?=_('URL')?></label>
    <bbn-input v-model="source.url"/>
    <label class="bbn-label"><?=_('Type')?></label>
    <bbn-dropdown :source="types"
                  v-model="source.type"/>
    <label class="bbn-label"><?=_('Admin access token')?></label>
    <div class="bbn-flex-width bbn-vmiddle">
      <i v-if="source.hasAdminAccessToken !== undefined"
         :class="['bbn-right-sspace', 'nf', {
           'nf-fa-check bbn-green': !!source.hasAdminAccessToken,
           'nf-fa-times bbn-red': !source.hasAdminAccessToken
         }]"/>
      <bbn-input v-model="source.adminAccessToken"
                 class="bbn-flex-fill"/>
    </div>
    <label class="bbn-label"><?=_('Your access token')?></label>
    <div class="bbn-flex-width bbn-vmiddle">
      <i v-if="source.hasUserAccessToken !== undefined"
         :class="['bbn-right-sspace', 'nf', {
           'nf-fa-check bbn-green': !!source.hasUserAccessToken,
           'nf-fa-times bbn-red': !source.hasUserAccessToken
         }]"/>
      <bbn-input v-model="source.userAccessToken"
                 class="bbn-flex-fill"/>
    </div>
  </div>
</bbn-form>