<template>
    <div class="page-home">
        <div class="container-fluid hero-projects">

          <!-- Make these into three Coloumns -->
            <div class="container hero-project">
                <img
                    src="/images/hero-main-project-100.jpg"
                    alt="Featured Project"
                />
            </div>
            <div class="project-slide-1">
                <img src="/images/project-1-100.jpg" alt="Previous Project" />
            </div>
            <div class="project-slide-2">
                <img src="/images/project-2_1-100.jpg" alt="Next Project" />
            </div>
            <div class="container hero-slider-nav">
                <div class="hero-slider-progress">
                    <span></span>
                </div>

                <div class="hero-slider-details">
                    <div class="slide-number">
                        02 - 04
                    </div>
                    <div class="slide-skills">
                        UX/UI | Branding | Photography | Packaging
                    </div>
                </div>
            </div>

            <!-- This is the project card  -->
          <div class="container project-card">
            <div class="row">
              <div class="col-md-12">
                <div class="project-heading-container">
                  PROJECT 1
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="project-details-container">
                  Client #id
                </div>
              </div>
              <div class="col-md-8">
                <div class="project-description-container">
                  Client #id
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="container-fluid content-container">
          ddw
        </div>
        <!-- <div class="container hero-slider-nav">
      <div class="hero-slider-progress">
        <span></span>
      </div>

      <div class="hero-slider-details">
        <div class="slide-number">
          02 - 04
        </div>
        <div class="slide-skills">
          UX/UI | Branding | Photography | Packaging
        </div>
      </div>
    </div> -->
    </div>
</template>
<script>
import Modal from "../components/modal.vue";
import { mapState } from "vuex";
import { processMeta } from "../utils/meta";

export default {
    components: { Modal },

    data: () => ({
        pageName: "home",
        isBoilerplateModalVisible: false
    }),

    asyncData(store) {
        return store.dispatch("loadCollectionPage", "home");
    },

    metaInfo() {
        return processMeta({
            title: this.homepage.title,
            description: "test"
        });
    },

    computed: {
        ...mapState({
            homepage: "pageData"
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
