<template>
    <div>
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Clients</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="$emit('show-client-popup', true)" class="btn btn-sm btn-primary">Create</a>
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
                    <template v-eles>
                        <div class="container">
                            <div class="alert alert-warning" role="alert">
                                <strong>Sorry!</strong> No Record Found
                            </div>
                        </div>
                    </template>
                </table>
            </div>
        </div>

      
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
            this.clients = this.getClients
        },
        methods: {
            getClients() {
                return
            },
            OpenClientPopup(status) {
                console.log(status)
            }
          
        }
    }

</script>

<style scoped>

    .card {
        min-height: 355px;
    }

</style>
