<template>
    <aside id="sidebar" class="sidebar" style="background-color: #57def2;">
      <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item" :class="{ 'bg-warning': isActive('/dashboard') }">
          <router-link class="nav-link collapsed" to="/dashboard" v-if="isAuthenticated">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
          </router-link>
        </li>
        <li class="nav-item" :class="{ 'bg-warning': isActive('/all-users') }">
          <router-link class="nav-link collapsed" to="/all-users">
            <i class="bi bi-grid"></i>
            <span>All Users</span>
          </router-link>
        </li>
        <li class="nav-item" :class="{ 'bg-warning': isActive('/transaction-records') }">
          <router-link class="nav-link collapsed" to="/transaction-records">
            <i class="bi bi-grid"></i>
            <span>Transaction Record</span>
          </router-link>
        </li>
        <li class="nav-item" :class="{ 'bg-warning': isActive('/features') }">
          <router-link class="nav-link collapsed" to="/features">
            <i class="bi bi-grid"></i>
            <span>Features</span>
          </router-link>
        </li>
        <li class="nav-item" :class="{ 'bg-warning': isActive('/features-access') }">
          <router-link class="nav-link collapsed" to="/features-access">
            <i class="bi bi-grid"></i>
            <span>Features Access</span>
          </router-link>
        </li>
        <li class="nav-item" :class="{ 'bg-warning': isActive('/plan-features') }">
          <router-link class="nav-link collapsed" to="/plan-features">
            <i class="bi bi-grid"></i>
            <span>Plan Features</span>
          </router-link>
        </li>
        <li class="nav-item" :class="{ 'bg-warning': isActive('/plans') }">
          <router-link to="/plans" class="nav-link collapsed">
            <i class="bi bi-amd"></i>
            <span>Plans</span>
          </router-link>
        </li>
        <li class="nav-item" :class="{ 'bg-warning': isActive('/team-members') }">
          <router-link to="/team-members" class="nav-link collapsed">
            <i class="bi bi-people"></i>
            <span>Team Member</span>
          </router-link>
        </li>
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
    methods: {
      isAuthenticated() {
        return isAuthenticated();
      },
      isActive(route) {
        return this.$route.path === route;
      },
      logout() {
        localStorage.removeItem("token");
        this.$router.push("/login");
      },
    },
  };
  </script>
