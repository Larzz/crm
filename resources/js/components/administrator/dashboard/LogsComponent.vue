<template>
    <div>
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Login / Logout</h3>
                    </div>
                    <div class="col text-right">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <!-- <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Employee Name</th>
                            <th scope="col">Leave From</th>
                            <th scope="col">Leave To</th>
                            <th scope="col">Days</th>
                            <th scope="col">Balance</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <template v-if="leaves">
                        <tbody>
                            <tr v-for="(leave, index) in leaves" :key="index">
                                <th scope="row">
                                    {{ leave.name}}
                                </th>
                                <td>
                                    {{ formatDate(leave.leave_from) }}
                                </td>
                                <td>
                                    {{ formatDate(leave.leave_to) }}
                                </td>
                                <td>
                                    {{ leave.number_of_day }}
                                </td>
                                <td>
                                    {{ leave.balance }}
                                </td>
                                <td v-html="getStatus(leave.status)">
                                </td>
                                <td>
                                    <a href="#!" @click="approved(leave.id)" class="btn btn-sm btn-primary">Approved</a>
                                    <a href="#!" @click="declined(leave.id)" class="btn btn-sm btn-primary">Declined</a>
                                </td>
                            </tr>
                        </tbody>
                    </template>
                </table>
                <div class="container mt-3" v-if="!leaves">
                    <div class="alert alert-warning" role="alert">
                        <strong>Sorry!</strong> No Record Found
                    </div>
                </div> -->

                <template v-if="logs">
                    <vue-good-table :columns="columns" :pagination-options="{ enabled: true }" theme="polar-bear"
                        :rows="rows" :sort-options="{ enabled: true, }"
                        :search-options="{ enabled: true, placeholder: 'Search Leaves'}"
                        styleClass="table align-items-center table-flush">
                        <!-- <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'action'">
                                <div class="d-flex align-items-center">
                                     <a href="#!" @click="approved(props.row.id)" :disabled="true" class="btn btn-sm btn-primary">Approved</a>
                                    <a href="#!" @click="declined(props.row.id)" :disabled="true" class="btn btn-sm btn-primary">Declined</a> 
                                </div>
                            </span>
                        </template> -->
                    </vue-good-table>
                </template>
                <template v-if="!logs">
                    <div class="container mt-3">
                        <div class="alert alert-warning" role="alert">
                            <strong>Sorry!</strong> No Record Found
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'

    export default {
        data() {
            return {
                logs: [],
                columns: [{
                        label: 'Employee Name',
                        field: 'name',
                    },
                    {
                        label: 'Date',
                        field: this.setDate,
                    },
                    {
                        label: 'Login',
                        field: 'login',
                    },
                    {
                        label: 'Logout',
                        field: 'logout',
                    },
                    {
                        label: 'Device',
                        field: this.setDevice
                    },
                    {
                        label: 'IP',
                        field: 'ip_address',
                    },
                ],
                rows: [],
            }
        },
        mounted() {
            this.getLeaves()

        },
        methods: {
            getLeaves() {

                let $this = this

                axios({
                        method: 'get',
                        url: '/api/v1/logs?api_token=' + window.Laravel.api_token,
                        data: this.fields
                    }).then(function (response) {
                        $this.logs = response.data.logs
                        $this.rows = response.data.logs
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});

            },
            approved(leave_id) {
                let $this = this
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure you want to approve this leave?',
                    showCancelButton: true,
                    confirmButtonText: 'Approved',
                }).then((result) => {
                    if (result.isConfirmed) {
                        JsLoadingOverlay.show(this.$configs);
                        axios({
                                method: 'post',
                                url: '/api/v1/leave/approved?api_token=' + window.Laravel.api_token,
                                data: {
                                    leave_id: leave_id
                                }
                            }).then(function (response) {
                                if (response.data.status) {
                                    $this.$toastr.s('Successfully Approved');
                                    $this.getLeaves()
                                }
                            })
                            .catch(function (error) {
                                $this.$toastr.e(error);
                            })
                            .then(function () {
                                JsLoadingOverlay.hide();
                            });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })
            },
            declined(leave_id) {
                let $this = this
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure you want to decline this leave?',
                    showCancelButton: true,
                    confirmButtonText: 'Declined',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        JsLoadingOverlay.show(this.$configs);
                        axios({
                                method: 'post',
                                url: '/api/v1/leave/declined?api_token=' + window.Laravel.api_token,
                                data: {
                                    leave_id: leave_id
                                }
                            }).then(function (response) {
                                if (response.data.status) {
                                    $this.$toastr.s('Successfully Declined');
                                    $this.getLeaves()
                                }
                            })
                            .catch(function (error) {
                                $this.$toastr.e(error);
                            })
                            .then(function () {
                                JsLoadingOverlay.hide();
                            });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })

            },
            getStatus(leave) {
                switch (leave.status) {
                    case 0:
                        return '<span style="color:gray;"> <i class="bg-warning"></i> Pending </span>'
                        break;
                    case 1:
                        return '<span style="color:green"> <i class="bg-success"></i> Approved </span>'
                        break;
                    case 2:
                        return '<span style="color:red"> <i class="bg-error"></i> Declined </span>'
                        break;

                }
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
            setDate(log) {
                return this.formatDate(log.date)
            },
            setDevice(log) {
                return JSON.parse(log.device)
                
            }
          

        }
    }

</script>

<style>

</style>
