<template>
    <AppLayout>
      <main id="main" class="main">
        <div class="pagetitle">
          <h1>Team Members</h1>
        </div>
        <!-- End Page Title -->

        <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                    <div class="my-2">
                        <a  href="" @click="click" class="text text-primary">Add Member</a>
                    </div>
                </div>

              </div>
            </div>
          </div>

          <div class="row">
            <div class="offset-md-2 col-md-8">
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
                        <h5 class="card-title text-center pb-0 fs-4">Register a User</h5>
                        <p class="text-center small">Enter details to create an account</p>
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
                      </form>
                    </div>
                  </div>
            </div>
          </div>

          <div class="row">
          </div>

          <div class="row">
            <div class="offset-md-2 col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                     </div>
                </div>

            </div>
          </div>

          <div class="row">
            <div class="offset-md-2 col-md-8">
                <div class="card">
                    <div class="card-body">

                    </div>
                  </div>
            </div>
          </div>
        </section>
      </main>
      <!-- End #main -->
    </AppLayout>
  </template>
  <script>
  import axios from "axios";
import AppLayout from "../layouts/AppLayout.vue";

  export default {
    components: {
      AppLayout,
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
        cards: [],

      };
    },
    mounted() {
        this.getUserSubscribedPlan();
    },
    methods: {
        getUserSubscribedPlan()
        {

        const token = localStorage.getItem("token");
        const headers = {
          Authorization: `Bearer ${token}`,
        };
          axios.get('/api/user-subsciption',{headers});
        }
    },
  };
  </script>
