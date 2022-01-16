<template>
    <div>
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Employees</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="showPopup=true" class="btn btn-sm btn-primary">Create</a>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                    <template v-if="employees">
                        <tbody>
                            <tr v-for="(employee, index) in employees" :key="index">
                                <th scope="row">
                                    {{ employee.name }}
                                </th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <ul>
                                            <li><a href="#!" :data-id="employee.id" @click="viewEmployee(employee.id)"
                                                    title="View Employee"><i class="fas fa-eye"></i></a> </li>
                                            <li> <a href="#!" :data-id="employee.id" @click="editEmployee(employee.id)"
                                                    title="Update Employee"><i class="fas fa-pen"></i></a> </li>
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

            <create-employee-popup :showPopup="showPopup" @close="showPopup = false"></create-employee-popup>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                employees: [],
                showPopup: false
            }
        },
        mounted() {
             this.getEmployees()
        },
        methods: {
            getEmployees() {

               let $this = this
                
               axios({
                  method: 'get',
                  url: '/api/v1/employee?api_token='+window.Laravel.api_token,
                //   data: this.fields
                }).then(function (response) {
                    $this.employees = response.data.employees
                    // console.log(this.employees)
                    console.log(response.data.employees)
                })
                 .catch(function (error) {
                    $this.$toastr.e(error);
                })
                .then(function () {
                });
               
            }
        }
    }

</script>

<style>
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
