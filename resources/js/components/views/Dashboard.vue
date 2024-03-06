<template>
  <AppLayout>
    <main id="main" class="main">
      <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Home</a></li>
            <li class="breadcrumb-item">Pages</li>
            <li class="breadcrumb-item active">Blank</li>
          </ol>
        </nav>
      </div>
      <!-- End Page Title -->

      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Example Form</h5>
                <div class="col-6">
                  <form class="row g-3">
                    <div class="col-12">
                      <label for="inputNanme4" class="form-label">Your Name</label>
                      <input type="text" class="form-control" id="inputNanme4" />
                    </div>
                    <div class="col-12">
                      <label for="inputEmail4" class="form-label">Email</label>
                      <input type="email" class="form-control" id="inputEmail4" />
                    </div>
                    <div class="col-12">
                      <label for="inputPassword4" class="form-label">Password</label>
                      <input type="password" class="form-control" id="inputPassword4" />
                    </div>
                    <div class="col-12">
                      <label for="inputAddress" class="form-label">Address</label>
                      <input
                        type="text"
                        class="form-control"
                        id="inputAddress"
                        placeholder="1234 Main St"
                      />
                    </div>
                    <div class="text-left">
                      <button type="reset" class="btn btn-secondary">Reset</button>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form>
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
