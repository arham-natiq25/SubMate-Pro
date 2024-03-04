<template>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                  <a href="index.html" class="logo d-flex align-items-center w-auto">
                    <!-- <img src="assets/img/logo.png" alt=""> -->
                    <span class="d-none d-lg-block">Admin</span>
                  </a>
                </div><!-- End Logo -->

              <slot>

              </slot>
              </div>
            </div>
          </div>

        </section>

    </div>
</template>

<script>

</script>
