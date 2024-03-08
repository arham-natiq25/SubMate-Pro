<template>
  <AppLayout>
    <main id="main" class="main">
      <div class="pagetitle">
        <h1>Plans</h1>
      </div>
      <section class="section">
        <div class="row">
          <!-- plans start  -->
          <div class="col-lg-12" v-if="showPlans">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Plans</h5>
                <div class="row">
                  <div v-for="plan in plans" :key="plan.id" class="col-5 mt-3">
                    <div class="card text-center">
                      <div class="card-header">
                        <h3>{{ plan.name }}</h3>
                      </div>
                      <div class="card-body">
                        <h5 class="card-title">{{ plan.short_description }}</h5>
                        <p class="card-text">Monthly Price: ${{ plan.monthly_price }}</p>
                        <p class="card-text">Yearly Price: ${{ plan.year_price }}</p>
                        <!-- 0 for monthly , 1 for yearly  -->
                        <button
                          class="btn btn-primary mx-2"
                          @click="subscribe(plan ,0)"
                        >
                          Subscribe Monthly
                        </button>
                        <button
                          class="btn btn-primary"
                          @click="subscribe(plan ,1)"
                        >
                          Subscribe Yearly
                        </button>
                      </div>
                      <div class="card-footer text-muted">
                        {{ plan.trial ? "Trial: Yes" : "Trial: No" }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- plans end  -->

          <!-- payment start -->
          <div class="offset-md-3 col-md-6 p-2 " v-show="showPayment">
            <div class="card">
              <div class="card-body">
                <button class="btn btn-warning my-2" @click="backToPlans()">Back</button>
                <div class="row" v-if="selectedPlan.length > 0">
                    <div class="col-12 py-3">
                      <label for="plan_name">Plan Name : <span class="fw-bold">{{ selectedPlan[0].name }}</span></label>
                    </div>
                    <div class="col-12">
                      <label for="plan_name">Plan Price : <span class="fw-bold">${{ selectedPlan[1] === 1 ? selectedPlan[0].year_price : selectedPlan[0].monthly_price }}</span></label>
                    </div>
                    <div class="col-12 py-3">
                      <label for="plan_name">Duration : <span class="fw-bold">{{ selectedPlan[1] === 1 ? 'Yearly' : 'Monthly' }} ({{ selectedPlan[1] === 1 ? '365' : '30' }} days)</span></label>
                    </div>
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
                      <button class="btn btn-success mt-3" @click="submit()">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- payment end  -->
        </div>
      </section>
    </main>
  </AppLayout>
</template>

<script>
import AppLayout from "../layouts/AppLayout.vue";
import axios from "axios";
import UserInfo from "../user-logged-in/UserInfo";

export default {
  mixins: [UserInfo],
  components: {
    AppLayout,
  },
  created() {
    this.fetchUserInfo();
  },
  data() {
    return {
      plans: [],
    //   stripe elements
      elements: null,
      stripe: null,
      cardNumberElement: null,
      cardExpiryElement: null,
      cardCvcElement: null,
      errorMessage: "",
      successMessage: "",
      cards: [],
      selectedCard: null,
    //   stripe elements ended
      selectedPlan:[],
      showPlans:true,
      showPayment:false

    };
  },
  methods: {
    fetchPlans() {
      axios
        .get("/api/plans") // Adjust the endpoint accordingly
        .then((response) => {
          this.plans = response.data.plans;
          // when we get plans successfully we can load stripe easily
          this.loadStripe();
        })
        .catch((error) => {
          console.error("Error fetching plans:", error);
        });
    },
    // HERE WE CAN FIND WHICH PLAN WE SELECT
    subscribe(plan,type) {
        // if type === 1 -> yearly , if type === 0 ->monthly
        this.selectedPlan = [],
        this.selectedPlan =[plan,type]
        this.showPayment = true,
        this.showPlans=false
    },
    backToPlans()
    {
        this.selectedPlan = [],
        this.showPayment = false,
        this.showPlans=true
        this.fetchPlans()
    },
    // Stripe load function which load stripe components
    loadStripe() {
      // if current windonw has Stripe set primary key
      if (window.Stripe) {
        this.stripe = window.Stripe(
          "pk_test_51NUU03Emu0Ala7lxKFLz0kgK8mfOVQr99wlJMIDW39xzneQ0B6Zb2x9irWjjNuldkUYyDFQG11FE50M6px3wvrVx00A0milkpo"
        );
        this.elements = this.stripe.elements();
        // Create an instance of the card number Element
        this.cardNumberElement = this.elements.create("cardNumber", {
          placeholder: "Card Number",
        });
        this.cardNumberElement.mount("#card-number");
        // Create an instance of the card expiry Element
        this.cardExpiryElement = this.elements.create("cardExpiry", {
          placeholder: "MM / YY",
        });
        this.cardExpiryElement.mount("#card-expiry");
        // Create an instance of the card cvc Element
        this.cardCvcElement = this.elements.create("cardCvc", {
          placeholder: "CVC",
        });
        this.cardCvcElement.mount("#card-cvc");
      } else {
        // Handle the case when Stripe is not available
        console.error("Stripe is not available");
      }
    },
    async submit() {
            this.errorMessage = "";
            const cardElement = this.elements.getElement("cardNumber");
            const { paymentMethod, error } = await this.stripe.createPaymentMethod({
                type: "card",
                card: cardElement,
                billing_details: {
                    name: this.cardholderName,
                    email: this.email,
                },
            });
            console.log("Error from Stripe:", error); // Log Stripe error
            if (error) {
                this.errorMessage = error.message;
            } else {
                this.processPayment(paymentMethod.id);
            }
            console.log("Final error message:", this.errorMessage); // Log final error message
    },
    async processPayment(paymentMethodId) {
            const attr = {
                paymentMethodId,
                type: this.selectedPlan[1],
                plan:this.selectedPlan[0],
                name: this.userName,
                email: this.userEmail,
                method: 0,
            };

            const token = localStorage.getItem('token');

            // Set the Authorization header with the JWT token
            const headers = {
                Authorization: `Bearer ${token}`,
            };
            axios
                .post("/api/buy-subscription ", attr,{ headers })
                .then((response) => {
                    if (response.data.success) {
                        this.successMessage = response.data.message;
                        setTimeout(() => {
                            this.successMessage = "";
                        }, 10000);
                    } else {
                        this.errorMessage = response.data.message;
                    }
                })
                .catch((error) => {
                    this.errorMessage = error.message;

                    setTimeout(() => {
                        this.errorMessage = "";
                    }, 10000);
                });
        },

  },
  mounted() {
    this.fetchPlans();
  },
};
</script>
