<template>
    <AppLayout>
      <main id="main" class="main">
        <div class="pagetitle">
          <h1>Access Features</h1>
        </div>
        <!-- End Page Title -->

        <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div
                    v-if="successMessage"
                    class="alert alert-success alert-dismissible fade show m-2"
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

                  <div>
                    <h5 class="card-title">All Plan Features</h5>
                    <!-- ALL FEATURES access -->
                    <div class="row">
                      <div class="col-md-12">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Feature Name</th>
                              <th>Access</th>
                              <th>Limit Type</th>
                              <th>Limit Value</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(feature, index) in subscribedFeatures" :key="index">
                              <td>{{ index + 1 }}</td>
                              <td>{{ feature.feature.name }}</td>
                              <td>{{ 'Yes' }}</td>
                              <td>{{ feature.limit_type === 1 ?  'Count' : 'Size' }}</td>
                              <td>{{ feature.limit_value }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <!-- END ALL  FEATURES plans access  -->
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
  import axios from "axios";
  import AppLayout from "../layouts/AppLayout.vue";
  import Swal from "sweetalert2";

  export default {
    components: {
      AppLayout,
    },
    data() {
      return {
        subscribedFeatures: [], // Array to store subscribed features
      };
    },
    mounted() {
      this.getSubscribedFeatures(); // Fetch subscribed features when component is mounted
    },
    methods: {
      getSubscribedFeatures() {
        const token = localStorage.getItem("token");
        const headers = {
            Authorization: `Bearer ${token}`,
        };
        axios
          .get("/api/features-access",{headers}) // Adjust the API endpoint according to your routes
          .then((response) => {
            this.subscribedFeatures = response.data.user.subscription.plan.plan_feature;
          })
          .catch((error) => {
            console.error("Error fetching subscribed features:", error);
          });
      },
      clearMessages() {
        // Function to clear success messages
        this.successMessage = "";
      },
    },
  };
  </script>
