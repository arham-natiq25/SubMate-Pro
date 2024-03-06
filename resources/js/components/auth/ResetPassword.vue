<template>
  <GuestLayout>
    <div class="card mb-3">
      <p></p>
      <div class="card-body">
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
          <h5 class="card-title text-center pb-0 fs-4">Setup Password</h5>
          <p class="text-center small">Enter your new password</p>
        </div>

        <form @submit.prevent="submitForm" class="row g-3 needs-validation" novalidate>
          <div class="col-12">
            <label for="yourPassword" class="form-label">Password</label>
            <input
              v-model="password"
              type="password"
              name="password"
              class="form-control"
              id="yourPassword"
              required
            />
            <div v-if="formErrors.password" class="text text-danger">
              {{ formErrors.password[0] }}
            </div>
          </div>

          <div class="col-12">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input
              v-model="passwordConfirmation"
              type="password"
              name="password_confirmation"
              class="form-control"
              id="confirmPassword"
              required
            />
            <div v-if="formErrors.password_confirmation" class="invalid-feedback">
              {{ formErrors.password_confirmation[0] }}
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
      password: "",
      passwordConfirmation: "",
      formErrors: {},
      successMessage: "",
      errorMessage: "",
    };
  },
  methods: {
    submitForm() {
      this.clearMessages(); // Clear previous messages

      axios
        .post(`/api/update-password/${this.$route.params.token}`, {
          password: this.password,
          password_confirmation: this.passwordConfirmation,
        })
        .then((response) => {
          // Check the status field in the response
          if (response.data.status) {
            // Success
            this.successMessage = response.data.message;
            // Clear password fields
            this.password = "";
            this.passwordConfirmation = "";
            // Redirect to the login page after a short delay
            setTimeout(() => {
              this.$router.push("/login");
            }, 2000); // 2000 milliseconds delay (adjust as needed)
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
