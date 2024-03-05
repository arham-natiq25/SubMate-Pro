<template>
   <GuestLayout>
    <div class="card mb-3">

        <div class="card-body">
          <p></p>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            A simple success alert—check it out!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            A simple danger alert—check it out!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

          <div class="pt-4 pb-2">
            <p class="text-center small">Activating your account.</p>
          </div>

          <form class="row g-3 needs-validation" novalidate>

            <div class="col-12">
              <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </div>


            <div class="col-12">
            </div>
            <div class="col-12">
              <p class="small mb-0">Have account? <a href="login.html">Login</a></p>
            </div>
          </form>

        </div>
      </div>

   </GuestLayout>

</template>

<script>
import GuestLayout from '../layouts/GuestLayout.vue'
export default {
components:{
    GuestLayout
},
created() {
    // Access the token from the route parameters
    const token = this.$route.params.token;
    console.log('Token from URL:', token);

    // Now you can use the token as needed, e.g., send it to an API for activation
    // Example: this.activateUser(token);
  },


}
</script>
