<template>
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <router-link class="nav-link collapsed" to="/dashboard" v-if="isAuthenticated">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link collapsed" to="/all-users">
          <i class="bi bi-grid"></i>
          <span>All Users</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link collapsed" to="/features">
          <i class="bi bi-grid"></i>
          <span>Features</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link collapsed" to="/features-access">
          <i class="bi bi-grid"></i>
          <span>Features Access</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link collapsed" to="/plan-features">
          <i class="bi bi-grid"></i>
          <span>Plan Features</span>
        </router-link>
      </li>
      <!-- End Dashboard Nav -->

      <!-- End Profile Page Nav -->
      <li class="nav-item">
        <router-link to="/plans" class="nav-link collapsed">
          <i class="bi bi-amd"></i>
          <span>Plans</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link to="/team-members" class="nav-link collapsed">
          <i class="bi bi-people"></i>
          <span>Team Member</span>
        </router-link>
      </li>


      <!-- End F.A.Q Page Nav -->


      <li class="nav-item" v-if="isAuthenticated">
        <a class="nav-link collapsed" @click="logout" style="cursor: pointer">
          <i class="bi bi-box-arrow-right"></i>
          <span>Logout</span>
        </a>
      </li>
    </ul>
  </aside>
</template>
<script>
import { isAuthenticated, redirectToLoginPage } from '../auth';
export default {
    data() {
    return {

    };
    },
  methods: {
    isAuthenticated() {
      // Check if the user is authenticated
      return isAuthenticated();
    },
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
