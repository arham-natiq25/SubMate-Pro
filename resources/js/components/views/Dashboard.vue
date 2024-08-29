<template>
    <AppLayout>
      <main id="main" class="main">
        <div class="pagetitle">
          <h1>Dashboard</h1>
        </div>
        <!-- End Page Title -->

        <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Subscription Details</h5>
                  <div class="row">
                    <!-- Placeholder for Package Name and Days Left -->
                    <div class="col-md-6">
                      <div class="card bg-danger">
                        <div class="card-body text-white">
                          <h5 class="card-title text-">Package Name</h5>
                          <p class="card-text">{{ subscription.package_name }}</p>
                          <h5 class="card-title text-">Days Left in Plan</h5>
                          <p class="card-text">{{ subscription.days_left }} days</p>
                        </div>
                      </div>
                    </div>

                    <!-- Placeholder for Graph -->
                    <div class="col-md-6">
                      <div class="card bg-dark text-white">
                        <div class="card-body">
                          <h5 class="card-title text-white">Days Left in Plan - Graph</h5>
                          <!-- Simple Bar Graph -->
                          <div class="bar-graph">
                            <div class="bar" :style="{ width: (subscription.days_left / 30 * 100) + '%' }"></div>
                          </div>
                          <div class="graph-labels">
                            <span>0</span>
                            <span>15</span>
                            <span>30</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End row for subscription details -->

                  <!-- Placeholder for Other Subscription Information -->
                  <div class="row mt-4">
                    <div class="col-md-12">
                      <div class="card bg-danger text-white">
                        <div class="card-body">
                          <h5 class="card-title">Other Subscription Information</h5>
                          <p class="card-text">{{ subscription.other_info }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End row for other subscription information -->
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
        subscription: {
          package_name: "Basic Plan Monthly", // Placeholder for package name
          days_left: 17, // Placeholder for days left
          other_info: "Lorem ipsum dolor sit amet, consectetur adipiscing elit.", // Placeholder for other info
        },
      };
    },
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
    background-color: #007bff; /* Blue color for the bar */
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
