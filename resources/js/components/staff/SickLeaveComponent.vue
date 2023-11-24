<template>
    <div>
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Sick Leaves</h3>
                    </div>
                    <div class="col text-right">
                        <!-- <a href="#!" @click="showPopup=true" class="btn btn-sm btn-primary">Upload</a> -->
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Dates</th>
                            <th scope="col">Day</th>
                        </tr>
                    </thead>
                    <template v-if="leaves">
                        <tbody>
                            <tr v-for="(leave, index) in leaves" :key="index">
                                <td>
                                    {{ formatDate(leave.leave_from)  }} to  {{ formatDate(leave.leave_to)  }}
                                   

                                </td>
                                <td>
                                    {{ leave.number_of_days }}
                                </td>
                            </tr>
                        </tbody>
                    </template>

                </table>

                <template v-if="!leaves">
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
                leaves: [],
                showPopup: false,
                timess: Date.now(),
                document: {}
            }
        },
        props: {
            user: {
                required: true,
                type: Object
            }  
        },
        mounted() {
            this.getSickLeaves()
        },
        methods: {
            getSickLeaves() {
                let $this = this
                axios({
                        method: 'get',
                        url: `/api/v1/leave/sick/${this.user.id}?api_token=${window.Laravel.api_token}`,
                }).then(function (response) {
                    if (response.data.status) {
                        $this.leaves = response.data.sick_leaves
                    }
                })
                .catch(function (error) {
                    $this.$toastr.e(error);
                })
                .then(function () {});
            },
            formatDate(date) {
                const currentDate = new Date(date);
                const options = { year: 'numeric', month: 'short', day: 'numeric' };       
                return currentDate.toLocaleDateString('en-us', options)
            }
        }
    }

</script>

<style scoped>
    .card {
        min-height: 355px;
    }

</style>
