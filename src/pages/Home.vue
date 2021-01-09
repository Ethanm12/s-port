<template>
  <div class="page-home">
    <div class="container-fluid">
      <div class="page-container">
          <div class="logo">
              <img src="/images/boilerplate_logo.png" alt="boilerplate logo">
          </div>
        <div class="text-heading">
          <h2 class="py-2">BOILERPLATE COPY</h2>
        </div>
        <div class="paragraph" v-html="homepage.boiler_copy"></div>
        <button type="button" class="btn view-modal" @click="showBoilerplateModal">View Modal</button>
          <modal v-show="isBoilerplateModalVisible" @close="closeBoilerplateModal">
            <h2 slot="header">Boilerplate Modal</h2>
            <div slot="body" class="px-4 py-4">
              <ul>
                <li>Leaving</li>
                <li>Modal</li>
                <li>Here</li>
                <li>Just</li>
                <li>In</li>
                <li>Case</li>
              </ul>Available for use in any project
            </div>
          </modal>
      </div>
    </div>
  </div>
</template>
<script>
import Modal from "../components/modal.vue";
import { mapState } from 'vuex';
import { processMeta } from '../utils/meta';

export default {
  components: {Modal},

  data: () => ({
    pageName: "home",
    isBoilerplateModalVisible: false,
  }),

  asyncData(store) {
    return store.dispatch('loadCollectionPage', 'home');
  },

  metaInfo() { return processMeta({
    title: this.homepage.title,
    description: 'test'
  }) },

  computed: {
    ...mapState({
      homepage: 'pageData'
    })
  },

  methods: {
    showBoilerplateModal() {
      this.isBoilerplateModalVisible = true;
    },
    closeBoilerplateModal() {
      this.isBoilerplateModalVisible = false;
    }
  }

};
</script>
