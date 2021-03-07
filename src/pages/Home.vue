<template>
    <div class="page-home">
        <div class="container-fluid hero-projects">
            <!-- Make these into three Coloumns -->
            <div class="container-fluid hero-slider-container">
                <div class="row">
                    <div class="col-md-2 project-left-container">
                        <div class="project-slide-1">
                            <img
                                src="/images/project-1-100.jpg"
                                alt="Previous Project"
                            />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="container hero-project">
                            <img
                                src="/images/hero-main-project-100.jpg"
                                alt="Featured Project"
                            />
                        </div>
                    </div>
                    <div class="col-md-2 project-right-container">
                        <div class="project-slide-2">
                            <img
                                src="/images/project-2_1-100.jpg"
                                alt="Next Project"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="container hero-project">
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
            </div> -->
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
                    <div class="col-md-12 project-card-border">
                        <div class="project-heading-container">
                            <h1>Bitter Sweet IPA</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 project-card-border">
                        <div class="project-details-container">
                            <div class="project-details-heading">
                                Date:
                                <div class="project-details-heading-specs">
                                    <span>**/**/**</span>
                                </div>
                            </div>
                            <div class="project-details-heading">
                                Client:
                                <div class="project-details-heading-specs">
                                    <span>******** *********</span>
                                </div>
                            </div>
                            <div class="project-details-heading">
                                Team:
                                <div class="project-details-heading-specs">
                                    <span>********</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 project-card-border">
                        <div class="project-description-container">
                            Project Brief: Lorem ipsum dolor sit amet,
                            consectetuer adipiscing elit, sed diam nonummy nibh
                            euismod tincidunt ut tincidunt ut laoreet dolore
                            magna aliquam erat volutpat. Ut wisi enim ad minim
                            veniam.
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid main-content">
                <div class="parallax"></div>
                <!-- <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="main-content-image">
                                    bjhjvu
                                </div>
                            </div>
                            <div class="col-md-6">
                              <div class="main-content-description">
                                Lorem ipsum dolor sit amet, consectetuer
                                adipiscing elit, sed diam nonummy nibh euismod
                                tincidunt ut Lorem ipsum dolor sit amet,
                            </div>
                            </div>
                        </div>
                    </div> -->
                <div class="container">
                    <div class="main-content-image">
                        bjhjvu
                    </div>
                    <div class="main-content-description">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing
                        elit, sed diam nonummy nibh euismod tincidunt ut Lorem
                        ipsum dolor sit amet.
                    </div>
                    <div class="second-content-description">
                        Project Brief: Lorem ipsum dolor sit amet, consectetuer
                        adipiscing elit, sed diam nonummy nibh euismod tincidunt
                        ut Lorem ipsum dolor sit amet, consectetuer adipiscing
                        elit, sed diam nonummy nibh euismod tincidunt ut laoreet
                        dolore magna aliquam erat volutpat. Ut wisi enim ad
                        minim veniam. <br />
                        <br />

                        Lorem ipsum dolor sit amet, consectetuer adipiscing
                        elit, sed diam nonummy nibh euismod tincidunt ut Lorem
                        ipsum dolor sit amet, consectetuer adipiscing elit, sed
                        diam nonummy nibh euismod tincidunt ut laoreet dolore
                        magna aliquam erat volutpat. Ut wisi enim ad minim
                        veniam.
                    </div>
                    <div class="second-content-image">
                        few
                    </div>
                </div>
                <div class="container">
                    <div class="container-fluid second-panel">
                        fnekjwio
                    </div>
                </div>
                <div class="parallax-end"></div>
            </div>

            <div class="container banner-images">
                <div class="project-banner-images">
                    hbjugyhjgvhguyi
                </div>

                <div class="project-banner-images">
                    hbjugyhjgvhguyi
                </div>

                <div class="project-banner-images">
                    hbjugyhjgvhguyi
                </div>
            </div>
        </div>

        <!-- MAIN CONTENT HERE -->

        <!-- <div class="container-fluid main-content">

        </div> -->

        <!-- <div class="container-fluid content-container">
          ddw
        </div> -->
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
