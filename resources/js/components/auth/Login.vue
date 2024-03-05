<template>
    <GuestLayout>
      <div class="card mb-3">
        <div class="card-body">
            <p></p>
          <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ successMessage }}
            <button type="button" class="btn-close" @click="clearMessages" aria-label="Close"></button>
          </div>

          <div v-if="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ errorMessage }}
            <button type="button" class="btn-close" @click="clearMessages" aria-label="Close"></button>
          </div>
          <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
            <p class="text-center small">Enter your email & password to login</p>
        </div>

          <form @submit.prevent="login" class="row g-3 needs-validation" novalidate>
            <div class="col-12">
              <label for="yourUsername" class="form-label">Email</label>
              <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input v-model="formData.email" type="text" name="email" class="form-control" id="yourUsername" required>
                <div class="invalid-feedback">Please enter your email.</div>
              </div>
            </div>

            <div class="col-12">
              <label for="yourPassword" class="form-label">Password</label>
              <input v-model="formData.password" type="password" name="password" class="form-control" id="yourPassword" required>
              <div class="invalid-feedback">Please enter your password!</div>
            </div>

            <div class="col-12">
              <button class="btn btn-primary w-100" type="submit">Login</button>
            </div>
          </form>
          <div class="col-12">
            <p class="small mb-0">Forget Password? <router-link to="/forget-password"> Forget Password
                </router-link></p>
            <p class="small mb-0">Don't have account? <router-link to="/register">
                    Create an account
                </router-link>
            </p>
        </div>
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
          email: '',
          password: '',
        },
        successMessage: '',
        errorMessage: '',
      };
    },
    methods: {
      login() {
        // Reset messages
        this.successMessage = '';
        this.errorMessage = '';

        // Call your login API
        axios.post('/api/login', this.formData)
          .then(response => {
            // Handle successful login
            if (response.data.status) {
              // Show success message
              this.successMessage = response.data.message;

              localStorage.setItem('token', response.data.token);
              // redirect to dashboard on successful login
              this.$router.push('/dashboard');
            } else {
              // Show error message
              this.errorMessage = response.data.message;
            }
          })
          .catch(error => {

            // Display error message to the user
            this.errorMessage = error.response.data.message;
          });
      },
      clearMessages() {
        // Clear success and error messages
        this.successMessage = '';
        this.errorMessage = '';
      },
    },
  };
  </script>
