<template>
  <div class="page-contact">
    <div class="container top">
      <div class="row">
        <div class="col-md-4 contact-details">
          <div itemscope itemtype="http://schema.org/Organization">
            <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
              <!--CMS needs a collection called contact, with a single entry, with a field called contact_details-->
              <div class="contact-details" v-html="details.contact_details"></div>
            </div>
          </div>
        </div>
        <div class="col-md-8 contact-form-container">
          <form method="post" action="/contact" ref="form" @submit.prevent="sendPayload">
            <div class="row">
              <div class="col-md-12"></div>
            </div>
            <!-- Full Name -->
            <div class="form-group">
              <label for="name" class="form-control-label" aria-label="Full Name"></label>
              <input
                type="text"
                id="name"
                class="form-control"
                placeholder="NAME *"
                v-model="input['name']"
              />
              <form-errors :errors="errors" for="name"></form-errors>
            </div>

            <!-- Company -->
            <div class="form-group">
              <label for="company" class="form-control-label" aria-label="Company"></label>
              <input
                type="text"
                id="company"
                class="form-control"
                placeholder="COMPANY"
                v-model="input['company']"
              />
              <form-errors :errors="errors" for="company"></form-errors>
            </div>

            <!-- phone -->
            <div class="form-group" style="width:48%; float:left;">
              <label for="phone" class="form-control-label" aria-label="Phone"></label>
              <input
                type="tel"
                id="phone"
                class="form-control"
                placeholder="PHONE"
                v-model="input['phone']"
              />
              <form-errors :errors="errors" for="phone"></form-errors>
            </div>

            <!-- Email -->
            <div class="form-group" style="clear:both;">
              <label for="email" class="form-control-label" aria-label="Email"></label>
              <input
                type="email"
                id="email"
                class="form-control"
                placeholder="EMAIL *"
                v-model="input['email']"
              />
              <form-errors :errors="errors" for="email"></form-errors>
            </div>

            <!-- Details -->
            <div class="form-group">
              <label for="enquiry" class="form-control-label" aria-label="enquiry"></label>
              <textarea
                class="form-control"
                id="enquiry"
                cols="30"
                rows="10"
                placeholder="ENQUIRY *"
                v-model="input['enquiry']"
              ></textarea>
              <form-errors :errors="errors" for="enquiry"></form-errors>
            </div>
            <br />

            <!-- Recaptcha - see app.blade.php for binding key to window, then passing to vue data -->
            <div class="form-group">
              <label for="g-recaptcha" class="form-control-label" aria-label="g-recaptcha"></label>
              <div class="g-recaptcha" id="recaptcha-container" :data-sitekey="recap"></div>
              <form-errors :errors="errors" for="g-recaptcha-response"></form-errors>
            </div>
            <br />

            <!-- Submission -->
            <div class="form-group block-links">
              <button
                class="btn btn-primary submit-button form-btn"
                type="submit"
                :disabled="thinking"
              >Make your Enquiry</button>
            </div>
          </form>
        </div>
        <gmap></gmap>
      </div>
    </div>
  </div>
</template>

<script>
import gmap from "../components/Maps.vue";
import axios from 'axios';
import swal from "sweetalert2";
import FormErrors from "../components/FormErrors.vue";
import { processMeta } from '../utils/meta';
import { mapState } from "vuex";

export default {
  components: { FormErrors, gmap },

  data: () => ({
    errors: {},
    input: {},
    thinking: false,
    recap: null,
    recaptchaResponse: ""
  }),

  asyncData(store) {
    return store.dispatch('loadCollectionPage', 'contact');
  },

  metaInfo() { return processMeta({
    title: this.details.title,
    description: "Get in touch"
  }) },

  mounted() {
    this.recap = window.recaptchaKey;
    this.clearErrors();
    this.setInput();
    if (window.hasRecaptcha) {
      setTimeout(this.setupRecaptcha, 1);
    } else {
      window.recaptchaCallback = () => {
        window.hasRecaptcha = true;
        this.setupRecaptcha();
      };
    }
  },

  methods: {
    setupRecaptcha() {
      grecaptcha.render("recaptcha-container", {
        siteKey: this.recap,
        callback: r => this.recaptchaCallback(r)
      });
    },

    recaptchaCallback(result) {
      this.recaptchaResponse = result;
    },

    setInput() {
      this.$refs.form.reset();
      this.input = {
        name: "",
        company: "",
        email: "",
        phone: "",
        enquiry: "",
        "g-recaptcha-response": ""
      };
    },

    clearErrors() {
      this.errors = {};
    },

    async sendPayload() {
      this.input["g-recaptcha-response"] = this.recaptchaResponse;
      try {
        await axios.post("/contact", this.input)
        this.clearErrors();

          swal.fire({
            type: "success",
            title: "Thanks!",
            text: "Thanks for your enquiry, we will be in touch shortly."
          });
          grecaptcha.reset();
          this.setInput();
      } catch (error) {
        const response = error.response;

        this.clearErrors();

        if (response.status === 422) {
          this.errors = response.data.errors;
          console.log(this.errors);
          return swal.fire({
            type: "warning",
            title: "Whoops!",
            text:
              "There was something wrong with your input, please check your fields"
          });
        }

        return swal.fire({
          type: "error",
          title: "Oh No!",
          text: "Something went wrong, please try again."
        });
      }
    }
  },

  computed: {
    ...mapState({
      details: 'pageData'
    })
  },

  watch: {
    $route() {
      this.clearErrors();
      this.setInput();
    }
  }
};
</script>