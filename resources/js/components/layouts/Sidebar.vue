<template>
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <router-link class="nav-link collapsed" to="/dashboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </router-link>
      </li>
      <!-- End Dashboard Nav -->

      <li class="nav-item">
        <a
          class="nav-link collapsed"
          data-bs-target="#components-nav"
          data-bs-toggle="collapse"
          href="#"
        >
          <i class="bi bi-menu-button-wide"></i><span>Authentication</span
          ><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul
          id="components-nav"
          class="nav-content collapse"
          data-bs-parent="#sidebar-nav"
        >
          <li>
            <a href="login.php"> <i class="bi bi-circle"></i><span>Login</span> </a>
          </li>

          <li>
            <a href="signup.php"> <i class="bi bi-circle"></i><span>Sign Up</span> </a>
          </li>

          <li>
            <a href="forget-password.php">
              <i class="bi bi-circle"></i><span>forget-password</span>
            </a>
          </li>

          <li>
            <a href="reset-password.php">
              <i class="bi bi-circle"></i><span>Setup Password</span>
            </a>
          </li>

          <li>
            <a href="activation.php">
              <i class="bi bi-circle"></i><span>Activation</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End Components Nav -->

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li>
      <!-- End Profile Page Nav -->
      <li class="nav-item">
        <router-link to="/plans" class="nav-link collapsed">
          <i class="bi bi-person"></i>
          <span>Plans</span>
        </router-link>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="forms-layouts.php">
          <i class="bi bi-question-circle"></i>
          <span>Form Layouts</span>
        </a>
      </li>
      <!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="forms.php">
          <i class="bi bi-question-circle"></i>
          <span>Form</span>
        </a>
      </li>
      <!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="blank.php">
          <i class="bi bi-envelope"></i>
          <span>Blank</span>
        </a>
      </li>
      <!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.php">
          <i class="bi bi-card-list"></i>
          <span>404</span>
        </a>
      </li>
      <!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.php">
          <i class="bi bi-dash-circle"></i>
          <span>Error 404</span>
        </a>
      </li>
      <!-- End Error 404 Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="blank.php">
          <i class="bi bi-file-earmark"></i>
          <span>Blank</span>
        </a>
      </li>
      <!-- End Blank Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" @click="logout" style="cursor: pointer">
          <i class="bi bi-box-arrow-right"></i>
          <span>Logout</span>
        </a>
      </li>
    </ul>
  </aside>
</template>
<script>
export default {
  methods: {
    logout() {
      // Clear the authentication token from local storage
      localStorage.removeItem("token");

      // Optionally, perform additional cleanup or redirect to the login page
      // For example, you can redirect to the login page after logout
      this.$router.push("/login");
    },
  },
};
</script>
