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
                            <th>Trasaction ID</th>
                            <th>Price</th>
                            <th>Created At</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- Iterate over subscriptions and populate table rows -->
                         <tr>
                            <td>1</td>
                            <td>Test</td>
                            <td>2oj4hg</td>
                            <td> $ 9.99</td>
                            <td>12-2-2024</td>
                            <td>
                                <buttom class="btn btn-primary">
                                    Refund
                                </buttom>
                            </td>
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
  import AppLayout from "../layouts/AppLayout.vue";

  export default {
    components: {
      AppLayout,
    },
  };
  </script>
