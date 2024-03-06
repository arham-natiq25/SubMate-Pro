<template>
    <GuestLayout>
      <div class="card mb-3">
        <div class="card-body">
          <p></p>
          <!-- Loading and alert messages go here -->
          <div v-if="isLoading" class="d-flex justify-content-center">
            <div class="spinner-border" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>

          <div v-if="activationMessage" class="alert alert-success" role="alert">
            {{ activationMessage }}
          </div>

          <div v-if="activationError" class="alert alert-danger" role="alert">
            {{ activationError }}
          </div>

          <div class="pt-4 pb-2">
            <p v-if="!isLoading && !activationMessage && !activationError" class="text-center small">Activating your account.</p>
          </div>

          <form v-if="!isLoading" class="row g-3 needs-validation" novalidate>
            <div class="col-12">
                <p class="small mb-0">Have account? <router-link to="/login">Login</router-link></p>
              </div>
          </form>
        </div>
      </div>
    </GuestLayout>
  </template>

  <script>
  import GuestLayout from '../layouts/GuestLayout.vue';
  import axios from 'axios';

  export default {
    components: {
      GuestLayout,
    },
    data() {
      return {
        isLoading: true,
        activationMessage: '',
        activationError: '',
      };
    },
    created() {
      const token = this.$route.params.token;
      console.log('Token from URL:', token);

      // Call the API for activation
      this.activateUser(token);
    },
    methods: {
      activateUser(token) {
        const apiEndpoint = `/api/email/active/${token}`;

        axios.get(apiEndpoint)
          .then(response => {
            // Check the status field in the response
            if (response.data.status) {
              // Success
              this.isLoading = false;
              this.activationMessage = response.data.message;
            } else {
              // Error
              this.isLoading = false;
              this.activationError = response.data.message;
            }
          })
          .catch(error => {
            // Handle error
            this.isLoading = false;
            this.activationError = error.response.data.message;
          });
      },
    },
  };
  </script>
