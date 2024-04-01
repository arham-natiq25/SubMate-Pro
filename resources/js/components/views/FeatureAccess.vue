<template>
    <AppLayout>
      <main id="main" class="main">
        <div class="pagetitle">
          <h1>Access Features</h1>
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


                  <div v-if="showAllFeaturesAccess">
                    <button class="float-end my-2 btn btn-success" @click="Form">
                      <i class="bi bi-plus-lg"></i> Add new Feature Access
                    </button>
                    <h5 class="card-title">All Plan Features</h5>
                    <!-- ALL FEATURES access -->
                    <div class="row">
                      <div class="col-md-12">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Feature Name</th>
                              <th> Access</th>
                              <th>Limit</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- Iterate over subscriptions and populate table rows -->
                            <tr v-for="(featureAccess, index) in AllFeaturesAccess" :key="featureAccess.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ featureAccess.feature.name }}</td>
                                <td>{{ featureAccess.access === 1 ? 'Yes' : 'No' }}</td>
                                <td>{{ featureAccess.limit }}</td>
                                <td>
                                    <button class="btn btn-danger mx-1 btn-sm" @click="deleteFeatureAccess(featureAccess.id)"><i class="bi bi-trash"></i></button>
                                    <button class="btn btn-warning mx-1 btn-sm" @click="editFeatureAccess(featureAccess)"><i class="bi bi-pencil-square"></i></button>
                                </td>
                              </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <!-- END ALL  FEATURES plans access  -->

                  </div>

                <!-- ACCESS FEATURES FORM -->
                <div v-if="showForm">
                    <h5 class="card-title">Access Features Form</h5>
                    <div>
                      <button
                        class="float-end mt-2 btn btn-warning"
                        @click="All()"
                      >
                        <i class="bi bi-skip-backward"></i> Back to All Features Access
                      </button>
                      <h5 class="card-title">Access Feature Details</h5>
                      <section>
                        <div class="row mt-4">
                          <div class="col-lg-12">
                            <div class="form-group">
                              <div class="row mb-3">
                                <label
                                  class="col-sm-2 col-form-label fw-bold"
                                  >Select a Feature</label
                                >
                                <div class="col-sm-10">
                                  <select
                                    class="form-select"
                                    v-model="selectedFeatureId"
                                    aria-label="Select a Feature"
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
                            </div>
                          </div>
                        </div>
                        <div class="row mt-4">
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="fw-bold">Access</label>
                              <div class="p-2">
                                <input
                                  type="radio"
                                  id="yes"
                                  value="1"
                                  v-model="access"
                                  name="access"
                                />
                                <label for="yes" class="mx-2">Yes</label>

                                <input
                                  type="radio"
                                  id="no"
                                  value="0"
                                  v-model="access"
                                  name="access"
                                />
                                <label for="no" class="mx-2">No</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row mt-4">
                          <div class="col-lg-12">
                            <div class="form-group">
                              <label class="fw-bold">Limit</label>
                              <input
                                type="number"
                                class="form-control"
                                v-model="limit"
                                name="limit"
                              />
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-12">
                            <button
                              class="btn btn-success my-2 float-end"
                              @click="saveAccessFeature"
                            >
                              Save
                            </button>
                          </div>
                        </div>
                      </section>
                    </div>
                  </div>
                  <!-- END ACCESS FEATURES FORM -->

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
  import Swal from "sweetalert2";

  export default {
    components: {
      AppLayout,
    },
    data() {
      return {
        Features: [],
        selectedFeatureId: null,
        access: null,
        limit: null,
        successMessage: "",
        errors: {},
        showAllFeaturesAccess:true,
        showForm:false,
        AllFeaturesAccess : [],
        temp_id:null,
        isEditing:false,
      };
    },
    mounted() {
      this.getAllFeatures();
      this.getAllFeaturesAccess();
    },
    methods: {
        Form()
        {
            this.showForm=true,
            this.showAllFeaturesAccess=false
        },
        All()
        {
            this.showForm=false,
            this.showAllFeaturesAccess=true
            this.selectedFeatureId=null,
            this.limit=null;
            this.access=null;
        },
        getAllFeatures() {
        axios.get("/api/features").then((res) => {
          this.Features = res.data.features;
        });
       },
       getAllFeaturesAccess()
       {
        axios.get('/api/features-access').then((res)=>{
            this.AllFeaturesAccess = res.data.feature_access
        });
       },
       saveAccessFeature() {
    this.errors = {};
    const accessFeatureData = {
        feature_id: this.selectedFeatureId,
        access: this.access,
        limit: this.limit,
    };

    let method = axios.post;
    let url = "/api/features-access ";

    if (this.isEditing) {
        method = axios.put;
        url = `/api/features-access/${this.temp_id}`;
    }

    // Send a POST or PUT request based on the operation (add or edit)
    method(url, accessFeatureData)
        .then((response) => {
            // Reset the form fields after successful submission
            this.selectedFeatureId = null;
            this.access = null;
            this.limit = null;

            if (response.data.status) {
                this.successMessage = response.data.message;
                this.showForm = false;
                this.showAllFeaturesAccess = true;
                this.isEditing=false
                this.getAllFeaturesAccess(); // Refresh the feature access list
            }
        })
        .catch((error) => {
            if (error.response && error.response.data.errors) {
                this.errors = error.response.data.errors;
            } else {
                console.error("Error adding/access feature:", error);
                // Display a generic error message if the server response doesn't contain error details
                alert("Failed to add/access feature. Please try again later.");
            }
            // Handle errors if any
            console.error("Error saving/access feature:", error);
        });
},

      clearMessages() {
        // Clear success and error messages
        this.successMessage = "";
        this.errorMessage = "";
        this.errors = {};
      },
      deleteFeatureAccess(id)
      {
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
            axios.delete(`/api/features-access/${id}`)
                .then((response) => {
                    if (response.data.success) {
                        Swal.fire(
                            'Deleted!',
                            response.data.message,
                            'success'
                        );
                        this.getAllFeaturesAccess();
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
      editFeatureAccess(featureaccess)
      {
        this.selectedFeatureId=featureaccess.feature.id;
        this.limit=featureaccess.limit;
        this.access=featureaccess.access;
        this.showForm=true,
        this.showAllFeaturesAccess=false,
        this.temp_id=featureaccess.id
        this.isEditing=true
      }
    },
  };
  </script>
