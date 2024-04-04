<template>
  <AppLayout>
    <main id="main" class="main">
      <div class="pagetitle">
        <h1>Features</h1>
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
                <!-- ALL FEATURES  -->
                <div v-if="showAllFeatures">
                  <button class="float-end my-2 btn btn-success" @click="Form">
                    <i class="bi bi-plus-lg"></i> Add new Feature
                  </button>
                  <h5 class="card-title">All Features</h5>
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Feature Name</th>
                            <th>Description</th>
                            <th>Slug</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- Iterate over subscriptions and populate table rows -->
                          <tr v-for="(feature, index) in AllFeatures" :key="index">
                            <td>{{ index + 1 }}</td>
                            <td>{{ feature.name }}</td>
                            <td style="width: 40%">{{ feature.description }}</td>
                            <td>{{ feature.slug }}</td>
                            <td style="width: 10%">
                              <button class="btn btn-danger mx-1 btn-sm"  @click="deleteFeature(feature.id)">
                                <i class="bi bi-trash"></i>
                              </button>
                              <button class="btn btn-warning mx-1 btn-sm" @click="editData(feature)">
                                <i class="bi bi-pencil-square"></i>
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <!-- END  ALL FEATURES  -->

                <!-- INPUT FORM  -->
                <div v-if="showEntryForm">
                  <div>
                    <button class="float-end mt-2 btn btn-warning" @click="Features">
                      <i class="bi bi-skip-backward"></i> Back to All Features
                    </button>
                    <h5 class="card-title">{{isEditing ? 'Update Feature details ' : 'Enter New Feature Details'}}:</h5>
                    <section>
                      <div class="row mt-4">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="name" class="fw-bold"
                              >Enter Name of Feature :
                            </label>
                            <input
                              type="text"
                              name="name"
                              class="form-control"
                              v-model="newFeatureName"
                            />
                            <div v-if="errors.name" class="text-danger text-sm">
                              {{ errors.name[0] }}
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="description" class="fw-bold"
                              >Enter Description of Feature :</label
                            >
                            <textarea
                              name="description"
                              class="form-control"
                              id=""
                              cols="30"
                              rows="4"
                              v-model="newFeatureDescription"
                            ></textarea>
                            <div v-if="errors.description" class="text-danger text-sm">
                              {{ errors.description[0] }}
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12">
                          <button
                            class="btn btn-success my-2 float-end"
                            @click="addFeature"
                          >
                            {{ isEditing ? 'Update' : 'Save' }}
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
import Swal from 'sweetalert2';
import AppLayout from "../layouts/AppLayout.vue";

export default {
  components: {
    AppLayout,
  },
  data() {
    return {
      AllFeatures: [],
      newFeatureName: "",
      newFeatureDescription: "",
      successMessage: "",
      errorMessage: {},
      errors: {},
      showAllFeatures: true,
      showEntryForm: false,
      temp_id:null,
      isEditing:false
    };
  },
  mounted() {
    this.getAllFeatures();
  },
  methods: {
    Form() {
      (this.showEntryForm = true), (this.showAllFeatures = false);
      this.newFeatureName="",
      this.newFeatureDescription=""
    },
    Features() {
      (this.showEntryForm = false), (this.showAllFeatures = true);
      this.isEditing=false
    },
    getAllFeatures() {
      axios.get("/api/features").then((res) => {
        this.AllFeatures = res.data.features;
      });
    },
    addFeature() {
        // Assuming you have input fields bound to data properties
      const newFeature = {
          name: this.newFeatureName,
          description: this.newFeatureDescription,
        };
        let method = axios.post;
            let url = "/api/features";

            if (this.isEditing) {
                method = axios.put;
                url = `/api/features/${this.temp_id}`;
            }

      method(url, newFeature)
        .then((response) => {
          this.errors = {};
          if (response.data.status) {
            this.successMessage = response.data.message;
          }
          this.showAllFeatures=true,
          this.showEntryForm=false,
          // Assuming you want to refresh the list of features after adding a new one
          this.getAllFeatures();
          // Optionally, you can reset input fields after successful addition
          this.newFeatureName = "";
          this.newFeatureDescription = "";
          this.newFeatureSlug = "";
          this.isEditing=false;

          // Optionally, you can display a success message
          // alert('Feature added successfully!');
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
        });
    },
    clearMessages() {
      // Clear success and error messages
      this.successMessage = "";
      this.errorMessage = "";
      this.errors = {};
    },
    editData(data) {
          this.newFeatureName = data.name;
          this.newFeatureDescription = data.description;

          this.temp_id = data.id
          this.isEditing=true
          this.showAllFeatures=false,
          this.showEntryForm=true

    },
    deleteFeature(id) {
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
            axios.delete(`/api/features/${id}`)
                .then((response) => {
                    if (response.data.success) {
                        Swal.fire(
                            'Deleted!',
                            response.data.message,
                            'success'
                        );
                        this.getAllFeatures();
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
                'Your feature is safe :)',
                'error'
            );
        }
    });
}



  },
};
</script>
