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
                        <button class="btn btn-warning my-2" @click="backToPlans()">Back</button>
                        <p></p>
                        <div class="row mb-3">
                            <label class="fw-bold my-2 col-form-label">Select Plan You want to buy </label>
                            <div class="col-sm-10">
                              <select class="form-select" aria-label="Default select example">
                                <option selected>Select a plan</option>
                                <option value="1">Plan 1 monthly($9.99)</option>
                                <option value="1">Plan 2 Yearly($19.99)</option>
                              </select>
                            </div>
                          </div>
                          <button class="btn btn-primary">Proceed to payment</button>
                    </div>
                </div>

            </div>
          </div>

          <div class="row">
            <div class="offset-md-2 col-md-8">
                <div class="card">
                    <div class="card-body">
                      <button class="btn btn-warning my-2" @click="backToPlans()">Back</button>
                      <div class="row" v-if="selectedPlan.length > 0">
                        <div class="col-12 py-3">
                          <label for="plan_name"
                            >Plan Name :
                            <span class="fw-bold">{{ selectedPlan[0].name }}</span></label
                          >
                        </div>
                        <div class="col-12">
                          <label for="plan_name"
                            >Plan Price :
                            <span class="fw-bold"
                              >${{
                                selectedPlan[1] === 1
                                  ? selectedPlan[0].year_price
                                  : selectedPlan[0].monthly_price
                              }}</span
                            ></label
                          >
                        </div>
                        <div class="col-12 py-3">
                          <label for="plan_name"
                            >Duration :
                            <span class="fw-bold"
                              >{{ selectedPlan[1] === 1 ? "Yearly" : "Monthly" }} ({{
                                selectedPlan[1] === 1 ? "365" : "30"
                              }}
                              days)</span
                            ></label
                          >
                        </div>
                      </div>

                      <!-- Success message -->
                      <div v-if="successMessage" class="alert alert-success mt-3">
                        {{ successMessage }}
                      </div>

                      <h4 class="modal-title mb-2 text-center p-2">Payment for Subscription</h4>
                      <div class="row">
                        <div class="col-md-12">
                          <div v-if="errorMessage" class="alert alert-danger">
                            {{ errorMessage }}
                          </div>
                          <div class="form-group">
                            <label for="card-number">Card Number</label>
                            <div id="card-number" class="form-control"></div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <label for="card-expiry">Expiration Date</label>
                          <div id="card-expiry" class="form-control"></div>
                        </div>
                        <div class="col-md-6">
                          <label for="card-cvc">CVC</label>
                          <div id="card-cvc" class="form-control"></div>
                        </div>
                        <div class="row">
                          <div class="col-md-12 text-end">
                            <button
                              class="btn btn-success mt-3"
                              @click="submit"
                              :disabled="loading"
                            >
                              <span
                                v-if="loading"
                                class="spinner-grow spinner-grow-sm"
                                role="status"
                                aria-hidden="true"
                              ></span>
                              <span v-else>Submit</span>
                            </button>
                          </div>
                        </div>
                      </div>
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
        plans: [],
        elements: null,
        stripe: null,
        cardNumberElement: null,
        cardExpiryElement: null,
        cardCvcElement: null,
        errorMessage: "",
        successMessage: "",
        cards: [],
        selectedCard: null,
        selectedPlan: [],
        showPlans: true,
        showPayment: false,
        loading: false,
      };
    },
    mounted() {
        this.loadStripe();
    },
    methods: {
        click()
        {
            alert('clicked')
        },
        loadStripe() {
        if (window.Stripe) {
          this.stripe = window.Stripe(
            "pk_test_51NUU03Emu0Ala7lxKFLz0kgK8mfOVQr99wlJMIDW39xzneQ0B6Zb2x9irWjjNuldkUYyDFQG11FE50M6px3wvrVx00A0milkpo"
          );
          this.elements = this.stripe.elements();

          this.cardNumberElement = this.elements.create("cardNumber", {
            placeholder: "Card Number",
          });
          this.cardNumberElement.mount("#card-number");

          this.cardExpiryElement = this.elements.create("cardExpiry", {
            placeholder: "MM / YY",
          });
          this.cardExpiryElement.mount("#card-expiry");

          this.cardCvcElement = this.elements.create("cardCvc", {
            placeholder: "CVC",
          });
          this.cardCvcElement.mount("#card-cvc");
        } else {
          console.error("Stripe is not available");
        }
      }
    },
  };
  </script>
