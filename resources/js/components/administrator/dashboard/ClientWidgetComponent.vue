<template>
    <div>
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Clients</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="showPopup=true" class="btn btn-sm btn-primary">Create</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                    <template v-if="clients">
                        <tbody>
                            <tr v-for="(client, index) in clients" :key="index">
                                <th scope="row">
                                    {{ client.name }}
                                </th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <ul>
                                            <li><a href="#!" :data-id="client.id" @click="viewEmployee(client.id)"
                                                    title="View Employee"><i class="fas fa-eye"></i></a> </li>
                                            <li> <a href="#!" :data-id="client.id" @click="editEmployee(client.id)"
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
        </div>

        <create-client-popup :showPopup="showPopup" @close="showPopup=false"></create-client-popup>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                clients: [],
                showPopup: false
            }
        },
        mounted() {
            this.getClients()
        },
        methods: {
            getClients() {
                let $this = this
                axios({
                        method: 'get',
                        url: '/api/v1/client?api_token=' + window.Laravel.api_token,
                    }).then(function (response) {
                        $this.clients = response.data.clients
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});

            }
        }
    }

</script>

<style>

</style>
