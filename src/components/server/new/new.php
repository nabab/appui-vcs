<bbn-form :action="root + 'actions/server/' + (!!source.id ? 'edit' : 'create')"
          :source="source"
          @success="onSuccess">
  <div class="bbn-grid-fields bbn-padded">
    <label class="bbn-label"><?= _('Name') ?></label>
    <bbn-input v-model="source.name"
               :required="true"/>
    <label class="bbn-label"><?= _('Host') ?></label>
    <bbn-input v-model="source.host"
               :required="true"/>
    <label class="bbn-label"><?= _('Type') ?></label>
    <bbn-dropdown :source="mainPage.enginesTypes"
                  v-model="source.type"
                  :required="true"/>
    <label class="bbn-label"><?= _('Engine') ?></label>
    <bbn-dropdown :source="filteredEngines"
                  v-model="source.engine"
                  ref="engines"
                  :required="true"/>
    <label class="bbn-label"><?= _('Admin access token') ?></label>
    <div class="bbn-flex-width bbn-vmiddle">
      <i v-if="source.hasAdminAccessToken !== undefined"
         :class="['bbn-right-sspace', 'nf', {
           'nf-fa-check bbn-green': !!source.hasAdminAccessToken,
           'nf-fa-times bbn-red': !source.hasAdminAccessToken
         }]"/>
      <bbn-input v-model="source.adminAccessToken"
                 class="bbn-flex-fill"/>
    </div>
    <label class="bbn-label"><?= _('Your access token') ?></label>
    <div class="bbn-flex-width bbn-vmiddle">
      <i v-if="source.hasUserAccessToken !== undefined"
         :class="['bbn-right-sspace', 'nf', {
           'nf-fa-check bbn-green': !!source.hasUserAccessToken,
           'nf-fa-times bbn-red': !source.hasUserAccessToken
         }]"/>
      <bbn-input v-model="source.userAccessToken"
                 class="bbn-flex-fill"
                 :required="true"/>
    </div>
  </div>
</bbn-form>