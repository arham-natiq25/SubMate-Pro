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
                          <h5 class="card-title text-center pb-0 fs-4">Setup Password</h5>
                          <p class="text-center small">Enter new your password</p>
                        </div>

                        <form class="row g-3 needs-validation" novalidate>

                          <div class="col-12">
                            <label for="yourPassword" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="yourPassword" required>
                            <div class="invalid-feedback">Please enter your password!</div>
                          </div>
                          <div class="col-12">
                            <label for="yourPassword" class="form-label">Confirm Password</label>
                            <input type="password" name="password" class="form-control" id="yourPassword" required>
                            <div class="invalid-feedback">Please enter your password!</div>
                          </div>


                          <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Submit</button>
                          </div>
                          <div class="col-12">
                            <p class="small mb-0">Already have an account? <router-link to="/login">
                                Login
                            </router-link>
                            </p>
                          </div>
                        </form>

                      </div>
                    </div>


                </GuestLayout>

</template>
<script>
import GuestLayout from '../layouts/GuestLayout.vue';
export default {
    components: {
        GuestLayout,
    },
}
</script>
