<template>
  <AppLayout>
    <main id="main" class="main">
      <div class="pagetitle">
        <h1>Team Members</h1>
      </div>
      <!-- End Page Title -->
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

      <section class="section">
        <div class="row" v-if="Front">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="my-2">
                  <a href="#" @click="showRegistration" class="text text-primary"
                    >Add Member</a
                  >
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Added By</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Days Left</th>
                    <th>Plan Name</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Iterate over teamMembers and populate table rows -->
                  <tr v-for="(member, index) in teamMembers" :key="member.id">

                    <td>{{ index + 1 }}</td>
                    <td>{{ member.user.first_name }} {{ member.user.last_name }}{{ loggedInUser.id === member.user_id  ? '(You)' : '' }}</td>
                    <td>{{ loggedInUser.first_name  }} {{ loggedInUser.last_name }}</td>
                    <td>{{ member.start_date }}</td>
                    <td>{{ member.end_date }}</td>
                    <td>{{ calculateDaysLeft(member.start_date, member.end_date) }}</td>

                    <td>{{ member.subscription.plan.name }}({{member.subscription.type === 0 ? 'Monthly' : 'Yearly'}})</td>
                  </tr>
                </tbody>
              </table>
            </div>
         </div>
        </div>

        <div class="row" v-if="RegistrationForm">
          <div class="offset-md-2 col-md-8">
            <div class="card mb-3">
              <div class="card-body">
                <p></p>
                <!-- Display success message -->

                <!-- Display error message only if it's not a validation error -->
                <div
                  v-if="errorMessage && !isValidationError(errorMessage)"
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
                  <h5 class="card-title text-center pb-0 fs-4">Register a User</h5>
                  <p class="text-center small">Enter details to create an account</p>
                </div>

                <form
                  @submit.prevent="register"
                  class="row g-3 needs-validation"
                  novalidate
                >
                  <div class="col-6">
                    <label for="firstName" class="form-label">First Name</label>
                    <input
                      v-model="formData.first_name"
                      type="text"
                      name="first_name"
                      class="form-control"
                      id="firstName"
                      required
                    />
                    <div v-if="errors.first_name" class="text-danger text-sm">
                      {{ errors.first_name[0] }}
                    </div>
                  </div>

                  <div class="col-6">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input
                      v-model="formData.last_name"
                      type="text"
                      name="last_name"
                      class="form-control"
                      id="lastName"
                      required
                    />
                    <div v-if="errors.last_name" class="text-danger text-sm">
                      {{ errors.last_name[0] }}
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="email" class="form-label">Your Email</label>
                    <input
                      v-model="formData.email"
                      type="email"
                      name="email"
                      class="form-control"
                      id="email"
                      required
                    />
                    <div v-if="errors.email" class="text-danger text-sm">
                      {{ errors.email[0] }}
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="password" class="form-label">Password</label>
                    <input
                      v-model="formData.password"
                      type="password"
                      name="password"
                      class="form-control"
                      id="password"
                      required
                    />
                    <div v-if="errors.password" class="text-danger text-sm">
                      {{ errors.password[0] }}
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="passwordConfirmation" class="form-label"
                      >Confirm Password</label
                    >
                    <input
                      v-model="formData.password_confirmation"
                      type="password"
                      name="password_confirmation"
                      class="form-control"
                      id="passwordConfirmation"
                      required
                    />
                    <div v-if="errors.password_confirmation" class="text-danger text-sm">
                      {{ errors.password_confirmation[0] }}
                    </div>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit" :disabled="loading">
                      <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                      <span v-else>Create Account</span>
                    </button>
                  </div>

                </form>
              </div>
            </div>
          </div>
        </div>

    <div class="row"></div>

        <div class="row" v-if="PaymentOption">
          <div class="offset-md-2 col-md-8">
            <div class="card mb-3">
              <div class="card-body">
                <button class="btn btn-warning my-2">Back</button>
                <h3>Payment for Subscription</h3>
                <p>
                  Plan : <span class="fw-bold">{{ this.plan.name }}</span>
                </p>
                <p>
                  Plan description :
                  <span class="fw-bold">{{ this.plan.short_description }}</span>
                </p>
                <p>
                  Price : <span class="fw-bold">${{ this.price }}</span>
                </p>

                <div class="row mt-2">
                  <div class="col-md-12">
                    <label>Select Card</label>
                    <div v-for="card in cards" :key="card.id">
                      <input
                        type="radio"
                        :id="'card_' + card.id"
                        name="selectedCard"
                        class="m-2"
                        :value="card"
                        v-model="selectedCard"
                      />
                      <label
                        :for="'card_' + card.id"
                        class="m-2 fw-bold"
                        style="font-size: 16px"
                      >
                        **** **** **** {{ card.last_four_digit }} ({{ card.card_brand }})
                      </label>
                    </div>
                  </div>
                </div>
                <button class="btn btn-success float-end" @click="chargeAcustomer">Charge</button>
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
        first_name: "",
        last_name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      selectedCard: "",
      successMessage: "",
      errorMessage: "",
      errors: {},
      cards: [],
      plan: {},
      price: null,
      RegistrationForm: false,
      PaymentOption: false,
      Front: true,
      emailofRegisteredUser:null,
      loading:false,
      teamMembers:[],
      loggedInUser:{}
    };
  },
  mounted() {
    this.getUserSubscribedPlan();
    this.getCustomerCards();
    this.getUserSubscriptions();
  },
  methods: {
    showRegistration() {
      (this.RegistrationForm = true), (this.Front = false);
    },
    getUserSubscribedPlan() {
      const token = localStorage.getItem("token");
      const headers = {
        Authorization: `Bearer ${token}`,
      };
      axios.get("/api/user-subsciption", { headers }).then((res) => {
        if (res.data.success) {
          this.price = res.data.price;
          this.plan = res.data.plan;
        }
      });
    },
    getCustomerCards() {
      const token = localStorage.getItem("token");
      const headers = {
        Authorization: `Bearer ${token}`,
      };
      axios.get("/api/customer-cards", { headers }).then((res) => {
        this.cards = res.data.cards;
      });
    },
    isValidationError(message) {
      // Check if the error message contains a validation keyword
      return message.toLowerCase().includes("validation");
    },
    register() {
        this.loading = true;
      // Reset messages and errors
      this.successMessage = "";
      this.errorMessage = "";
      this.errors = {};

      // Call your register API
      axios
        .post("/api/register", this.formData)
        .then((response) => {
          // Check the status field in the response
          if (response.data.status) {
            // Success
            this.successMessage = response.data.message;
            this.emailofRegisteredUser =this.formData.email

            this.formData = {
              first_name: "",
              last_name: "",
              email: "",
              password: "",
              password_confirmation: "",
            };
            (this.PaymentOption = true), (this.RegistrationForm = false);
          } else {
            // Error
            this.errorMessage = response.data.message;
            // Set validation errors
            if (response.data.errors) {
              this.errors = response.data.errors;
            }
          }
        })
        .catch((error) => {
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
        }).finally(() => {
          // Set loading to false after the request is completed
          this.loading = false;
        })
        ;
    },
    clearMessages() {
      // Clear success and error messages
      this.successMessage = "";
      this.errorMessage = "";
    },
    chargeAcustomer()
    {
        const token = localStorage.getItem("token");
        const headers = {
            Authorization: `Bearer ${token}`,
        };
        const payload = {
            price:this.price,
            plan:this.plan,
            NewUserEmail:this.emailofRegisteredUser,
            card:this.selectedCard,
            method: 1,
            type:this.price < 25 ?  0 : 1

        }
        axios.post('/api/member/buy-subscription',payload,{headers}).then((res)=>{
                this.successMessage = res.data.message;
                this.emailofRegisteredUser="";
                this.PaymentOption=false;
                this.Front=true;
                this.getUserSubscriptions()

        }).catch((error) => {
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
    getUserSubscriptions() {
      const token = localStorage.getItem("token");
      const headers = {
        Authorization: `Bearer ${token}`,
      };
      axios.get("/api/team-members", { headers }).then((res) => {
        if (res.data) {
          this.teamMembers = res.data.team_members;
          this.loggedInUser = res.data.logged_in_user
        }
      }).catch((error) => {
        console.error(error);
        // Handle error, show error messages, etc.
      });
    },
    calculateDaysLeft(startDate, endDate) {
        const start = new Date();
        const end = new Date(endDate);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays;
      }
  },
};
</script>
