<bbn-form :action="mainPage.root + 'actions/project/branch/insert'"
          :source="formSource"
          :data="formData"
          @success="onSuccess">
  <div class="bbn-padded bbn-grid-fields">
    <label class="bbn-label"
           v-text="_('Name')"/>
    <bbn-input v-model="formSource.name"
               :required="true"/>
    <label class="bbn-label"
           v-text="_('Create from')"/>
    <bbn-dropdown v-model="formSource.fromBranch"
                  :source="branches"
                  :required="true"/>
  </div>
</bbn-form>