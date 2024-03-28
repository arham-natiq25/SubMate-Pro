<template>
  <AppLayout>
    <main id="main" class="main">
      <div class="pagetitle">
        <h1>Plan Features</h1>
      </div>
      <!-- End Page Title -->

      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div
                v-if="successMessage"
                class="alert alert-success alert-dismissible fade show m-2"
                role="alert"
              >
                {{ successMessage }}
                <button
                  type="button"
                  class="btn-close"
                  @click="clearMessages"
                  aria-label="Close"
                ></button>
              </div>

              <div v-if="showAllFeatures">
                <button class="float-end my-2 btn btn-success" @click="Form">
                  <i class="bi bi-plus-lg"></i> Add new Plan Feature
                </button>
                <h5 class="card-title">All Plan Features</h5>
                <!-- ALL PLANS FEATURES -->
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Feature Name</th>
                          <th>Plan Name</th>
                          <th>Limit type</th>
                          <th>Limit Size</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Iterate over subscriptions and populate table rows -->
                        <tr v-for="(planFeature, index) in AllPlanFeatures" :key="index">
                            <td>{{ index + 1 }}</td>
                            <td>{{ planFeature.feature.name }}</td>
                            <td>{{ planFeature.plan.name }}</td>
                            <td>{{ planFeature.limit_type }}</td>
                            <td>{{ planFeature.limit_value }}</td>
                            <td>
                              <button class="btn btn-danger mx-1" @click="deletePlanFeature(planFeature.id)"><i class="bi bi-trash"></i></button>
                              <button class="btn btn-warning mx-1" @click="editPlanFeature(planFeature)"><i class="bi bi-pencil-square"></i></button>
                            </td>
                          </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- END ALL PLANS FEATURES -->

            </div>
                <!-- INPUT FORM  -->
                <div v-if="showEntryForm">
                  <div>
                    <button
                      class="float-end mt-2 btn btn-warning"
                      @click="PlanFeatures"
                    >
                      <i class="bi bi-skip-backward"></i> Back to All Plan
                      Features
                    </button>
                    <h5 class="card-title">{{ isEditing ? 'Edit Plan Feature' : 'Enter New Plan Feature Details' }}</h5>
                    <section>
                      <div class="row mt-4">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <div class="row mb-3">
                              <label class="col-sm-2 col-form-label fw-bold"
                                >Select a Plan</label
                              >
                              <div class="col-sm-10">
                                <select
                                  class="form-select"
                                  v-model="selectedPlanId"
                                  aria-label="Select a Plan"
                                  name="plan_uuid"
                                >
                                  <option
                                    v-for="plan in Plans"
                                    :value="plan.id"
                                    :key="plan.id"
                                  >
                                    {{ plan.name }}
                                  </option>
                                </select>
                            </div>
                        </div>
                        <div v-if="errors.plan_uuid" class="text-danger text-sm">
                            {{ errors.plan_uuid[0] }}
                          </div>

                          </div>
                        </div>
                      </div>
                      <div class="row mt-4">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <div class="row mb-3">
                              <label class="col-sm-2 col-form-label fw-bold"
                                >Select a Feature</label
                              >
                              <div class="col-sm-10">
                                <select
                                  class="form-select"
                                  aria-label="Select a Feature"
                                  v-model="selectedFeatureId"
                                  name="feature_id"
                                >
                                  <option
                                    v-for="feature in Features"
                                    :value="feature.id"
                                    :key="feature.id"
                                  >
                                    {{ feature.name }}
                                  </option>
                                </select>
                              </div>
                            </div>
                            <div v-if="errors.feature_id" class="text-danger text-sm">
                                {{ errors.feature_id[0] }}
                              </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="fw-bold">Limit Type</label>
                            <input type="text" class="form-control" v-model="limitType" name="limit_type">
                            <div v-if="errors.limit_type" class="text-danger text-sm">
                                {{ errors.limit_type[0] }}
                              </div>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label class="fw-bold">Limit Value</label>
                            <input type="text" class="form-control" v-model="limitValue" name="limit_value">
                            <div v-if="errors.limit_value" class="text-danger text-sm">
                                {{ errors.limit_value[0] }}
                              </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12">
                          <button class="btn btn-success my-2 float-end" @click="savePlanFeature"
                          >
                           {{isEditing ? 'Update' : 'Save'}}
                          </button>
                        </div>
                      </div>
                    </section>
                  </div>
                  <!-- END INPUT FORM  -->
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
import axios from "axios";
import AppLayout from "../layouts/AppLayout.vue";
import Swal from 'sweetalert2';

export default {
  components: {
    AppLayout,
  },
  data() {
    return {
      Plans: [],
      Features: [],
      AllPlanFeatures:[],
      selectedPlanId: null,
      selectedFeatureId: null,
      limitType: '',
      limitValue: '',
      successMessage:'',
      errors:{},
      showAllFeatures: true,
      showEntryForm: false,
      temp_id:null,
      isEditing:false
    };
  },
  mounted() {
    this.getAllPlans(), this.getAllFeatures();
    this.getAllPlanFeatures()
  },
  methods: {
    Form() {
      (this.showEntryForm = true), (this.showAllFeatures = false);
    },
    PlanFeatures() {
      (this.showEntryForm = false), (this.showAllFeatures = true);
      this.isEditing=false
    },
    getAllPlans() {
      axios.get("/api/plans").then((res) => {
        this.Plans = res.data.plans;
      });
    },
    getAllFeatures() {
      axios.get("/api/features").then((res) => {
        this.Features = res.data.features;
      });
    },
    getAllPlanFeatures()
    {
        axios.get('/api/plan-features').then((res)=>{
            this.AllPlanFeatures = res.data.plan_features
        });
    },
    savePlanFeature()
    {
        this.errors={};
        const planFeatureData = {
        feature_id: this.selectedFeatureId,
        plan_uuid: this.selectedPlanId,
        limit_type: this.limitType,
        limit_value: this.limitValue
      };

      let method = axios.post;
            let url = "/api/plan-features";

            if (this.isEditing) {
                method = axios.put;
                url = `/api/plan-features/${this.temp_id}`;
            }

      // Send a POST request to save the plan feature
     method(url, planFeatureData)
        .then((response) => {
          // Reset the form fields after successful submission
          this.selectedPlanId = null;
          this.selectedFeatureId = null;
          this.limitType = '';
          this.limitValue = '';

          this.getAllPlanFeatures()
          if (response.data.status) {
            this.successMessage = response.data.message;
            this.showAllFeatures=true,
            this.showEntryForm=false
          }

        })
        .catch((error) => {
            if (error.response && error.response.data.errors) {
            this.errors = error.response.data.errors;
          } else {
            console.error("Error adding feature:", error);
            // Display a generic error message if the server response doesn't contain error details
            // You can customize this message as per your preference
            alert("Failed to add feature. Please try again later.");
          }
          // Handle errors if any
          console.error('Error saving plan feature:', error);
        });
    },
    clearMessages() {
      // Clear success and error messages
      this.successMessage = "";
      this.errorMessage = "";
      this.errors = {};
    },
    deletePlanFeature(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/api/plan-features/${id}`)
                .then((response) => {
                    if (response.data.success) {
                        Swal.fire(
                            'Deleted!',
                            response.data.message,
                            'success'
                        );
                        this.getAllPlanFeatures();
                    } else {
                        Swal.fire(
                            'Error!',
                            response.data.message,
                            'error'
                        );
                    }
                })
                .catch((error) => {
                    console.error('Error deleting feature:', error);
                    Swal.fire(
                        'Error!',
                        'Failed to delete feature. Please try again later.',
                        'error'
                    );
                });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Cancelled',
                'Your feature is safe ',
                'error'
            );
        }
    });
    },
    editPlanFeature(planFeature)
    {
      this.selectedPlanId = planFeature.plan_uuid;
      this.selectedFeatureId = planFeature.feature_id;
      this.limitType = planFeature.limit_type;
      this.limitValue = planFeature.limit_value;
      this.temp_id = planFeature.id;
      this.showEntryForm = true;
      this.showAllFeatures = false;
      this.isEditing = true;
    }
  },
};
</script>
