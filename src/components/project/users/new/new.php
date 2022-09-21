<bbn-form :action="mainPage.root + 'actions/project/user/insert'"
          :source="formSource"
          :data="formData"
          @success="onSuccess">
  <div class="bbn-padded bbn-grid-fields">
    <label class="bbn-label"
           v-text="_('Select an user')"/>
    <bbn-dropdown v-model="formSource.userID"
                  :source="users"
                  :required="true"
                  :clear-html="true"/>
    <label class="bbn-label"
           v-text="_('Select a role')"/>
    <bbn-dropdown v-model="formSource.roleID"
                  :source="roles"
                  :required="true"/>
  </div>
</bbn-form>