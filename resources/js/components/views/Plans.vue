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
        })
        .catch((error) => {
          console.error("Error fetching plans:", error);
        });
    },
  },
  mounted() {
    this.fetchPlans();
  },
};
</script>
