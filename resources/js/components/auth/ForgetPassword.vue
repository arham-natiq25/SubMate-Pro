<template>
    <GuestLayout>
      <p></p>
      <div class="card mb-3">
        <div class="card-body">
        <p></p>
          <div
            v-if="successMessage"
            class="alert alert-success alert-dismissible fade show"
            role="alert"
          >
            {{ successMessage }}
            <button
              type="button"
              class="btn-close"
              @click="clearMessages"
              aria-label="Close"
            ></button>
          </div>

          <div
            v-if="errorMessage"
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
          >
            {{ errorMessage }}
            <button
              type="button"
              class="btn-close"
              @click="clearMessages"
              aria-label="Close"
            ></button>
          </div>

          <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Forget Password</h5>
            <p class="text-center small">Enter your email to reset your password</p>
          </div>

          <form @submit.prevent="submitForm" class="row g-3 needs-validation" novalidate>
            <div class="col-12">
              <label for="yourUsername" class="form-label">Email</label>
              <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input
                  v-model="email"
                  type="email"
                  name="email"
                  class="form-control"
                  id="yourUsername"
                  required
                />
                <div v-if="formErrors.email" class="invalid-feedback">
                  {{ formErrors.email[0] }}
                </div>
              </div>
            </div>

            <div class="col-12">
              <button class="btn btn-primary w-100" type="submit">Submit</button>
            </div>

            <div class="col-12">
              <p class="small mb-0">
                Already have an account? <router-link to="/login">Login</router-link>
              </p>
            </div>
          </form>
        </div>
      </div>
    </GuestLayout>
  </template>

  <script>
  import GuestLayout from "../layouts/GuestLayout.vue";
  import axios from "axios";

  export default {
    components: {
      GuestLayout,
    },
    data() {
      return {
        email: "",
        formErrors: {},
        successMessage: "",
        errorMessage: "",
      };
    },
    methods: {
      submitForm() {
        this.clearMessages(); // Clear previous messages
        axios
          .post("/api/reset-password", { email: this.email })
          .then((response) => {
            // Check the status field in the response
            if (response.data.status) {
              // Success
              this.successMessage = response.data.message;
            } else {
              // Error
              this.errorMessage = response.data.message;
              // Set validation errors
              if (response.data.errors) {
                this.formErrors = response.data.errors;
              }
            }
          })
          .catch((error) => {
            // Handle error, show error messages, etc.
            console.error(error.response.data);
            this.errorMessage = error.response.data.message;
          });
      },
      clearMessages() {
        // Clear success and error messages
        this.successMessage = "";
        this.errorMessage = "";
        this.formErrors = {};
      },
    },
  };
  </script>
