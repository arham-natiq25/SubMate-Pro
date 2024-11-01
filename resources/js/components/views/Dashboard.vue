<template>
    <AppLayout>
      <main id="main" class="main">
        <div class="pagetitle">
          <h1 class="text-dark">Dashboard</h1>
        </div>

        <section class="section ">
          <div class="row ">
            <div class="col-lg-12 ">
              <div class="card" style="background-color: #57def2;">
                <div class="card-body">
                  <h5 class="card-title text-dark">Subscription Details</h5>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card bg-dark">
                        <div class="card-body text-white">
                          <h5 class="card-title text-warning">Package Name</h5>
                          <p class="card-text">{{ subscription.package_name }}</p>
                          <h5 class="card-title text-warning">Days Left in Plan</h5>
                          <p class="card-text">{{ daysLeft }} days</p>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card bg-dark text-white">
                          <div class="card-body">
                            <h5 class="card-title text-white">Days Left in Plan - Graph</h5>
                            <div class="bar-graph">
                              <!-- Adjust the width calculation based on monthly or yearly plan -->
                              <div
                                class="bar"
                                :style="{ width: (daysLeft / (subscription.plan_type === 'Monthly' ? 30 : 365) * 100) + '%' }">
                              </div>
                            </div>
                            <div class="graph-labels">
                              <span>0</span>
                              <span v-if="subscription.plan_type === 'Monthly'">15</span>
                              <span v-else>180</span> <!-- Midpoint for a yearly plan -->
                              <span v-if="subscription.plan_type === 'Monthly'">30</span>
                              <span v-else>365</span> <!-- Max days for a yearly plan -->
                            </div>
                          </div>
                        </div>
                      </div>

                  </div>

                  <div class="row mt-4">
                    <div class="col-md-12">
                      <div class="card bg-dark text-white">
                        <div class="card-body">
                          <h5 class="card-title text-warning">Other Subscription Information</h5>
                          <p class="card-text">Start Date :{{ formattedStartDate }}</p>
                          <p class="card-text">End Date : {{ formattedEndDate }}</p>
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
        subscription: {
          package_name: "",
          days_left: 0,
          other_info: "",
          plan_type: "",
          start_date: "",
          end_date: "",
        },
      };
    },
    computed: {
         formattedStartDate() {
      return this.formatDate(this.subscription.start_date);
    },
    formattedEndDate() {
      return this.formatDate(this.subscription.end_date);
    },
      daysLeft() {
        if (this.subscription.start_date && this.subscription.end_date) {
          const startDate = new Date(this.subscription.start_date);
          const endDate = new Date(this.subscription.end_date);
          const today = new Date();

          // Calculate the total days and days left
          const totalDays = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
          const daysLeft = Math.ceil((endDate - today) / (1000 * 60 * 60 * 24));

          // Ensure `daysLeft` doesn't go below 0
          return daysLeft > 0 ? daysLeft : 0;
        }
        return 0;
      }
    },
    created() {
      const token = localStorage.getItem("token");
      if (!token) {
        console.error("Token is missing in localStorage");
        return;
      }
      const headers = {
        Authorization: `Bearer ${token}`,
      };
      axios.get('/api/active-user-details', { headers }).then((res) => {
        this.subscription.package_name = res.data.subscriptions[0].subscription.plan.name;
        this.subscription.plan_type = res.data.subscriptions[0].subscription.type == 0 ? 'Monthly' : 'Yearly';
        this.subscription.start_date = res.data.subscriptions[0].start_date;
        this.subscription.end_date = res.data.subscriptions[0].end_date;
      }).catch((error) => {
        console.error("Error fetching user details:", error);
      });
    },
    methods :{
        formatDate(dateString) {
      if (!dateString) return "";
      const date = new Date(dateString);
      const day = date.getDate();
      const month = date.toLocaleString("default", { month: "short" });
      const year = date.getFullYear();

      // Suffix logic for day (e.g., 1st, 2nd, 3rd, etc.)
      const suffix =
        day % 10 === 1 && day !== 11
          ? "st"
          : day % 10 === 2 && day !== 12
          ? "nd"
          : day % 10 === 3 && day !== 13
          ? "rd"
          : "th";

      return `${day}${suffix} ${month}, ${year}`;
    },
    }
  };

  </script>

  <style scoped>
  .bar-graph {
    width: 100%;
    height: 30px;
    background-color: #f0f0f0;
    border-radius: 5px;
    position: relative;
  }

  .bar {
    height: 100%;
    background-color: #007bff;
    border-radius: 5px;
    transition: width 0.5s ease-in-out;
  }

  .graph-labels {
    display: flex;
    justify-content: space-between;
    margin-top: 5px;
  }

  .graph-labels span {
    font-size: 12px;
    color: #777;
  }
  </style>
