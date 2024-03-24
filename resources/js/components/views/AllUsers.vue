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
                          <tr>
                            <th scope="row">1</th>
                            <td>Arham Natiq</td>
                            <td>Basic</td>
                            <td>12-10-2024</td>
                            <td>12</td>
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

    mounted() {
        this.allSubscriptions()
    },
    methods: {
        allSubscriptions()
        {
            axios.get('api/all-users')
        }
    },
  };
  </script>
