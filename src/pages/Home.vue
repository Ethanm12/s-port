<template>
  <div class="page-home">
    <div class="container" style="border: 1px solid blue;">
      howd
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
