<template>
    <AppLayout>
      <main id="main" class="main">
        <div class="pagetitle">
          <h1>All Users</h1>
        </div>
        <!-- End Page Title -->

        <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Subscriptions</h5>
                  <div class="col-12">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>User Name</th>
                          <th>Plan</th>
                          <th>Expiry Date</th>
                          <th>Days Left</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Iterate over subscriptions and populate table rows -->
                        <tr v-for="(user, index) in users" :key="user.id">
                          <th scope="row">{{ index + 1 }}</th>
                          <td>{{ user.first_name }} {{ user.last_name }}</td>
                          <td>{{ user.subscriptions[0].subscription.plan.name }}({{ getSubscriptionType(user.subscriptions[0].subscription.type) }})</td>
                          <td>{{ user.subscriptions[0].end_date }}</td>
                          <td>{{ calculateDaysLeft(user.subscriptions[0].start_date, user.subscriptions[0].end_date) }}</td>
                          <td>
                            <button class="btn btn-success btn-sm mx-2">Renew Subscription</button>
                            <button class="btn btn-warning btn-sm mx-2">Expiration Subscription</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
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
  import axios from 'axios';
  import AppLayout from "../layouts/AppLayout.vue";

  export default {
    components: {
      AppLayout,
    },
    data() {
      return {
        users: [],
      };
    },
    mounted() {
      this.allSubscriptions();
    },
    methods: {
        getSubscriptionType(type) {
      return type === 0 ? 'Monthly' : 'Yearly';
    },
      allSubscriptions() {
        axios.get('api/all-users')
          .then(response => {
            this.users = response.data;
          })
          .catch(error => {
            console.error('Error fetching user subscriptions: ', error);
          });
      },
      calculateDaysLeft(startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays;
      }
    },
  };
  </script>
