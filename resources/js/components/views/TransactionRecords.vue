<template>
    <AppLayout>
        <main id="main" class="main">
            <div class="pagetitle">
                <h1>Transaction Records</h1>
            </div>
            <!-- End Page Title -->

            <section class="section">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">List of records</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>User Name</th>
                                                    <th>Transaction ID</th>
                                                    <th>Price</th>
                                                    <th>Created At</th>
                                                    <th>Payment Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(trx, index) in trx_records" :key="index">
                                                    <td>{{ index + 1 }}</td>
                                                    <td>{{ trx.user.first_name }} {{ trx.user.last_name }}</td>
                                                    <td>{{ trx.transaction_id }}</td>
                                                    <td>$ {{ trx.payment }}</td>
                                                    <td>{{ formatDate(trx.created_at) }}</td>
                                                    <td>{{ trx.type_of_charge === 0 ? 'Charge' : 'Refund' }}</td>
                                                    <td class=" text-center">
                                                        <button v-if="trx.type_of_charge === 0" class="btn btn-sm btn-primary text-center" @click="openRefundModal(trx)">
                                                            Refund
                                                        </button>
                                                        <a v-else class="text-danger" disabled>
                                                            Your payment is refunded
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- End #main -->

        <!-- Refund Modal -->
        <div class="modal" v-if="isRefundModalOpen" style="display: block;">
            <div class="modal-dialog">
                <div class="modal-content bg-light">
                    <div class="modal-header">
                        <h4 class="modal-title">Refund Transaction</h4>
                        <button type="button" class="close" @click="closeRefundModal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <p>User: {{ selectedTransaction.user.first_name }} {{ selectedTransaction.user.last_name }}
                            </p>
                            <p>Transaction ID: {{ selectedTransaction.transaction_id }}</p>
                            <p>Total Amount: $ {{ selectedTransaction.payment }}</p>
                        </div>
                        <div class="form-group">
                            <label for="refundAmount">Enter Refund Amount ($)</label>
                            <input type="number" class="form-control" v-model="refundAmount">
                        </div>
                        <div class="form-group">
                            <label for="refundNotes">Notes (Reason for Refund)</label>
                            <textarea class="form-control" rows="3" v-model="refundNotes"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-danger" @click="closeRefundModal">Cancel</button>
                        <button type="button" class="btn btn-outline-dark" @click="refundTransaction">Refund</button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="isRefundModalOpen" class="modal-backdrop fade show"></div>
        <!-- End Refund Modal -->
    </AppLayout>
</template>

<script>
import axios from 'axios';
import AppLayout from "../layouts/AppLayout.vue";
import Swal from 'sweetalert2';

export default {
    components: {
        AppLayout,
    },
    data() {
        return {
            trx_records: [],
            isRefundModalOpen: false,
            refundAmount: 0,
            refundNotes: '',
            selectedTransaction: null
        };
    },
    mounted() {
        this.fetchTransactions();
    },
    methods: {
        formatDate(dateString) {
            const date = new Date(dateString);
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        },
        fetchTransactions() {
            // Make an HTTP request to your backend API to fetch transactions
            axios.get('/api/transaction-records')
                .then(response => {
                    this.trx_records = response.data;
                })
                .catch(error => {
                    console.error('Error fetching transactions: ', error);
                });
        },
        openRefundModal(trx) {
            this.selectedTransaction = trx
            // Open refund modal and set transaction data
            this.isRefundModalOpen = true;
            // You can set additional data related to the transaction if needed
        },
        closeRefundModal() {
            // Close refund modal
            this.isRefundModalOpen = false;
            // Reset refund amount and notes
            this.selectedTransaction = null
            this.refundAmount = 0;
            this.refundNotes = '';
        },
        refundTransaction() {
    // Retrieve the token from localStorage
    const token = localStorage.getItem("token");

    // Create headers object with Authorization header
    const headers = {
        Authorization: `Bearer ${token}`,
    };

    // Specify a valid reason for the refund (e.g., "requested_by_customer")
    const reason = "requested_by_customer";

    // Perform refund using Axios with headers included
    axios.post('/api/refund', {
        transaction_id: this.selectedTransaction.transaction_id,
        amount: this.refundAmount,
        notes: this.refundNotes,
        reason: reason // Include a valid reason for the refund
    }, {
        headers: headers // Pass headers object as the third argument
    })
    .then(response => {
        // Display success message using SweetAlert
        Swal.fire({
            icon: 'success',
            title: 'Refund Successful',
            text: 'Refund has been processed successfully!',
            confirmButtonText: 'OK'
        });

        this.fetchTransactions();

        // After refunding, close the modal
        this.closeRefundModal();
    })
    .catch(error => {
        // Display error message using SweetAlert
        Swal.fire({
            icon: 'error',
            title: 'Refund Failed',
            text: 'An error occurred while processing the refund. Please try again later.',
            confirmButtonText: 'OK'
        });
    });
},


    },
};
</script>
