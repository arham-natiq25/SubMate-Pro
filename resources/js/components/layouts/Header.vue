<template>
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center">
        <img :src="`${baseUrl}/backend/assets/img/logo.png`" alt="Logo" />
        <span class="d-none d-lg-block">S.M SYSTEM</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->


    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <!-- End Search Icon-->


        <!-- End Notification Nav -->


        <!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3" v-if="isAuthenticated">
          <a
            class="nav-link nav-profile d-flex align-items-center pe-0"
            href="#"
            data-bs-toggle="dropdown"
          >
            <!-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> -->
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ userName }}</span> </a
          ><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ userName }}</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" @click="logout" style="cursor: pointer">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul>
          <!-- End Profile Dropdown Items -->
        </li>
        <!-- End Profile Nav -->
      </ul>
    </nav>
    <!-- End Icons Navigation -->
  </header>
</template>

<script>
import UserInfo from "../user-logged-in/UserInfo";
import { BASE_URL } from "../../config";
export default {
  mixins: [UserInfo],
  created() {
    this.fetchUserInfo();
  },
  data() {
    return {
      baseUrl: BASE_URL,
      isAuthenticated: false,
    };
  },
  mounted() {
        // Check if authentication token is present in local storage
        this.isAuthenticated = !!localStorage.getItem("token");
    },
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
