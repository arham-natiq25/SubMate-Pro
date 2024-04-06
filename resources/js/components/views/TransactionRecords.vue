<template>
    <AppLayout>
      <main id="main" class="main">
        <div class="pagetitle">
          <h1>Transaction Records</h1>
        </div>
        <!-- End Page Title -->

        <section class="section">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">List of records</h5>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Transaction ID</th>
                            <th>Price</th>
                            <th>Created At</th>
                            <th>Payment Type</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(trx,index) in trx_records" :key="index">
                                <td>{{ index+1 }}</td>
                                <td>{{ trx.user.first_name }} {{ trx.user.last_name }}</td>
                                <td>{{ trx.transaction_id }}</td>
                                <td>$ {{ trx.payment }}</td>
                                <td>{{ formatDate(trx.created_at) }}</td>
                                <td>{{ trx.type_of_charge === 0 ? 'Charge' : 'Refund' }}</td>
                                <td><button class="btn btn-sm btn-primary">Refund</button></td>
                            </tr>
                       </tbody>
                      </table>
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
  import axios from 'axios';
  import AppLayout from "../layouts/AppLayout.vue";

  export default {
    components: {
      AppLayout,
    },
    data() {
      return {
        trx_records: [],
      };
    },
    mounted() {
      this.fetchTransactions();
    },
    methods: {
        formatDate(dateString) {
      const date = new Date(dateString);
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return date.toLocaleDateString('en-US', options);
    },
      fetchTransactions() {
        // Make an HTTP request to your backend API to fetch transactions
        axios.get('/api/transaction-records')
          .then(response => {
            this.trx_records = response.data;
          })
          .catch(error => {
            console.error('Error fetching transactions: ', error);
          });
      },
      refundTransaction(userId) {
        // Implement logic to refund transaction for the given user
        console.log('Refund transaction for user with ID: ', userId);
      },

    },
  };
  </script>
