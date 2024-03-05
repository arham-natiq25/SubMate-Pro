<template>
    <GuestLayout>
      <div class="card mb-3">
        <div class="card-body">
            <p></p>
          <!-- Display success message -->
          <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ successMessage }}
            <button type="button" class="btn-close" @click="clearMessages" aria-label="Close"></button>
          </div>

          <!-- Display error message only if it's not a validation error -->
          <div v-if="errorMessage && !isValidationError(errorMessage)" class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ errorMessage }}
            <button type="button" class="btn-close" @click="clearMessages" aria-label="Close"></button>
          </div>

          <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
            <p class="text-center small">Enter your personal details to create an account</p>
          </div>

          <form @submit.prevent="register" class="row g-3 needs-validation" novalidate>
            <div class="col-6">
              <label for="firstName" class="form-label">First Name</label>
              <input v-model="formData.first_name" type="text" name="first_name" class="form-control" id="firstName" required>
              <div v-if="errors.first_name" class="text-danger text-sm">{{ errors.first_name[0] }}</div>
            </div>

            <div class="col-6">
              <label for="lastName" class="form-label">Last Name</label>
              <input v-model="formData.last_name" type="text" name="last_name" class="form-control" id="lastName" required>
              <div v-if="errors.last_name" class="text-danger text-sm">{{ errors.last_name[0] }}</div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Your Email</label>
              <input v-model="formData.email" type="email" name="email" class="form-control" id="email" required>
              <div v-if="errors.email" class="text-danger text-sm">{{ errors.email[0] }}</div>
            </div>

            <div class="col-12">
              <label for="password" class="form-label">Password</label>
              <input v-model="formData.password" type="password" name="password" class="form-control" id="password" required>
              <div v-if="errors.password" class="text-danger text-sm">{{ errors.password[0] }}</div>
            </div>

            <div class="col-12">
              <label for="passwordConfirmation" class="form-label">Confirm Password</label>
              <input v-model="formData.password_confirmation" type="password" name="password_confirmation" class="form-control" id="passwordConfirmation" required>
              <div v-if="errors.password_confirmation" class="text-danger text-sm">{{ errors.password_confirmation[0] }}</div>
            </div>

            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                <div v-if="errors.terms" class="text-danger text-sm">{{ errors.terms[0] }}</div>
              </div>
            </div>

            <div class="col-12">
              <button class="btn btn-primary w-100" type="submit">Create Account</button>
            </div>

            <div class="col-12">
              <p class="small mb-0">Already have an account? <router-link to="/login">Login</router-link></p>
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
        formData: {
          first_name: '',
          last_name: '',
          email: '',
          password: '',
          password_confirmation: '',
        },
        errors: {},
        successMessage: '',
        errorMessage: '',
      };
    },
    methods: {
      register() {
        // Reset messages and errors
        this.successMessage = '';
        this.errorMessage = '';
        this.errors = {};

        // Call your register API
        axios.post('/api/register', this.formData)
          .then(response => {
            // Check the status field in the response
            if (response.data.status) {
              // Success
              this.successMessage = response.data.message;

              this.formData = {
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirmation: '',
              };
            } else {
              // Error
              this.errorMessage = response.data.message;
              // Set validation errors
              if (response.data.errors) {
                this.errors = response.data.errors;
              }
            }
          })
          .catch(error => {
            // Handle error, show error messages, etc.
            console.error(error.response.data);

            if (error.response && error.response.data) {
              const { data } = error.response;
              if (data.errors) {
                this.errors = data.errors;
              }
            }
            // Display error message to the user
            this.errorMessage = error.response.data.message;
          });
      },
      clearMessages() {
        // Clear success and error messages
        this.successMessage = '';
        this.errorMessage = '';
      },
      isValidationError(message) {
        // Check if the error message contains a validation keyword
        return message.toLowerCase().includes('validation');
      },
    },
  };
  </script>
