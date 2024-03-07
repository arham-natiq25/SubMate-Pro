<template>
  <AppLayout>
    <main id="main" class="main">
      <div class="pagetitle">
        <h1>Plans</h1>
      </div>

      <section class="section">
        <div class="row">
          <div class="col-lg-12">
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
                        <button
                          class="btn btn-primary mx-2"
                          @click="subscribe(plan.name + ' Monthly')"
                        >
                          Subscribe Monthly
                        </button>
                        <button
                          class="btn btn-primary"
                          @click="subscribe(plan.name + ' Yearly')"
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
          <div class="offset-md-3 col-md-6 p-2">
            <div class="card">
              <div class="card-body">
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
                    <div class="col-md-3">
                      <button class="btn btn-danger mt-3" @click="submit">Cancel</button>
                    </div>
                    <div class="col-md-9 text-end">
                      <button class="btn btn-success mt-3" @click="submit">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </AppLayout>
</template>

<script>
import AppLayout from "../layouts/AppLayout.vue";
import axios from "axios";
export default {
  components: {
    AppLayout,
  },
  data() {
    return {
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
    };
  },
  methods: {
    subscribe(planName) {
      // Add your subscription logic here
      alert(`Subscribed to ${planName} plan!`);
    },
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
  },
  mounted() {
    this.fetchPlans();
  },
};
</script>
