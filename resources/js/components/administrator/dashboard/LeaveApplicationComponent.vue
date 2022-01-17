<template>
    <div>
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Leave Application</h3>
                    </div>
                    <div class="col text-right">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Employee Name</th>
                            <th scope="col">Leave From</th>
                            <th scope="col">Leave To</th>
                            <th scope="col">Days</th>
                            <th scope="col">Balance</th>
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
                                    {{ leave.leave_from }}
                                </td>
                                <td>
                                    {{ leave.leave_to}}
                                </td>
                                <td>
                                    {{ leave.number_of_day }}
                                </td>
                                <td>
                                    {{ leave.balance }}
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'


    export default {
        data() {
            return {
                leaves: []
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
                        url: '/api/v1/leave?api_token=' + window.Laravel.api_token,
                        data: this.fields
                    }).then(function (response) {
                        $this.leaves = response.data.leaves
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});

            },
            approved(leave_id) {

                let $this = this

                Swal.fire({
                    icon:'question',
                    title: 'Are you sure you want to approved this leave?',
                    showCancelButton: true,
                    confirmButtonText: 'Approved',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {

                        axios({
                                method: 'post',
                                url: '/api/v1/leave/approved?api_token=' + window.Laravel.api_token,
                                data: {
                                    leave_id: leave_id
                                }
                            }).then(function (response) {
                                $this.$toastr.s('Successfully Approved');
                            })
                            .catch(function (error) {
                                $this.$toastr.e(error);
                            })
                            .then(function () {});
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })



            },
            declined(leave_id) {

                Swal.fire({
                    icon:'question',
                    title: 'Are you sure you want to declined this leave?',
                    showCancelButton: true,
                    confirmButtonText: 'Declined',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {

                        axios({
                                method: 'post',
                                url: '/api/v1/leave/declined?api_token=' + window.Laravel.api_token,
                                data: {
                                    leave_id: leave_id
                                }
                            }).then(function (response) {
                                $this.$toastr.s('Successfully Declined');
                            })
                            .catch(function (error) {
                                $this.$toastr.e(error);
                            })
                            .then(function () {});
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })
               
            }

        }
    }

</script>

<style>

</style>
