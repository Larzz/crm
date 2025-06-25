<template>
    <div>
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Sick Leave</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="showPopup=true" class="btn btn-sm btn-primary">Create</a>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <template v-if="sickLeaves.length">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Days</th>
                                <th scope="col">Date</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(leave, index) in sortedSickLeaves" :key="index">
                                <th scope="row">
                                    {{ leave.name }}
                                </th>
                                <th scope="row">
                                    {{ leave.number_of_days }}
                                </th>
                                <th scope="row">
                                    {{ formatDate(leave.created_at) }}
                                </th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <ul>
                                            <li><a href="#!" @click="viewSickLeave(leave)" title="View Employee"><i
                                                        class="fas fa-eye"></i></a> </li>
                                            <li> <a href="#!" :data-id="leave.id" @click="deleteSickLeave(leave.id)"
                                                    title="Delete Employee"><i class="fas fa-trash"></i></a> </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </template>
                    <template v-else>
                        <div class="container">
                            <div class="alert alert-warning" role="alert">
                                <strong>Sorry!</strong> No Record Found
                            </div>
                        </div>
                    </template>
                </table>
            </div>
            <create-leave-popup @new_employee="getSickLeaves" :showPopup="showPopup" @close="showPopup = false">
            </create-leave-popup>
            <view-leave-popup @close="showViewPopup = false" :sickLeave="sickLeave" :showPopup="showViewPopup">
            </view-leave-popup>

        </div>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'

    export default {
        data() {
            return {
                sickLeaves: [],
                showPopup: false,
                showViewPopup: false,
                sickLeave: {},
            }
        },
        computed: {
            sortedSickLeaves() {
                return [...this.sickLeaves].sort((a, b) => {
                    return new Date(b.created_at) - new Date(a.created_at);
                });
            }
        },
        beforeMount() {
            this.getSickLeaves()
        },
        methods: {
            getSickLeaves() {
                let self = this
                axios({
                        method: 'get',
                        url: '/api/v1/leave/sick/leve?api_token=' + window.Laravel.api_token,
                    }).then(function (response) {
                        self.sickLeaves = response.data.sick_leaves
                    })
                    .catch(function (error) {
                        self.$toastr.e(error);
                    })
                    .then(function () {});
            },
            deleteSickLeave(leave_id) {
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure you want to delete this leave?',
                    showCancelButton: true,
                    confirmButtonText: 'Remove',
                }).then((result) => {
                    if (result.isConfirmed) {
                        JsLoadingOverlay.show(this.$configs);
                        let self = this
                        axios({
                                method: 'delete',
                                url: `/api/v1/leave/sick/leve/${leave_id}?api_token=` + window.Laravel
                                    .api_token,
                            }).then(function (response) {
                                JsLoadingOverlay.hide();
                                self.getSickLeaves()
                            })
                            .catch(function (error) {
                                self.$toastr.e(error);
                            })
                            .then(function () {});
                    }
                })
            },
            viewSickLeave(leave) {
                this.showViewPopup = true
                this.sickLeave = leave
            },
            formatDate(date) {
                const currentDate = new Date(date);
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                return currentDate.toLocaleDateString('en-us', options)
            },
        }
    }

</script>

<style>
    .card {
        height: 357px;
        overflow-y: scroll;
    }

    .table-flush th {
        font-size: 15px;
    }

    .table-flush ul {
        display: contents;
        list-style: none;
    }

    .table-flush ul li {
        margin-right: 10px;
    }

    .table-flush ul li a {
        color: #525f7f;
    }

</style>
