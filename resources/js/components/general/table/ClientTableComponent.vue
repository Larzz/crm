<template>
    <div>
        <template v-if="clients">
            <tbody>
                <tr v-for="(client, index) in clients" :key="index">
                    <td scope="row" width="100%">
                        {{ client.name }}
                    </td>
                    <td width="100%">
                        <div class="d-flex align-items-center">
                            <ul>
                                <li><a href="#!" :data-id="client.id" @click="viewClient(client.id)"
                                        title="View Employee"><i class="fas fa-eye"></i></a> </li>
                                <!-- <li> <a href="#!" :data-id="client.id" @click="editClient(client.id)"
                                        title="Update Employee"><i class="fas fa-pen"></i></a> </li> -->
                                <li> <a href="#!" :data-id="client.id" @click="deleteClient(client.id)"
                                        title="Update Employee"><i class="fas fa-trash"></i></a> </li>
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
    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    export default {
        data() {
            return {
                clients: {}
            }
        },
        beforeCreate() {
            JsLoadingOverlay.show(this.$configs);
        },
        created() {
            JsLoadingOverlay.hide();
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
                        data: this.fields
                    }).then(function (response) {
                        $this.clients = response.data.clients
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});
            },

            viewClient(client_id) {
                JsLoadingOverlay.show(this.$configs);
                window.location.href = '/administrator/clients/' + client_id
            },
            editClient(client_id) {
                let $this = this
                JsLoadingOverlay.show(this.$configs);
                axios({
                        method: 'get',
                        url: '/api/v1/client/' + client_id + '?api_token=' + window.Laravel.api_token,
                    }).then(function (response) {
                        if (response.data.status) {
                            JsLoadingOverlay.hide();
                            $this.editClientdata = response.data.client
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});
            },

            deleteClient(client_id) {
                let $this = this
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure you want to delete this client?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios({
                                method: 'delete',
                                url: '/api/v1/client/' + client_id + '?api_token=' + window.Laravel
                                    .api_token,
                            }).then(function (response) {
                                if (response.data.status) {
                                    $this.$toastr.s('Successfully Deleted');
                                    $this.getClients()
                                }
                            })
                            .catch(function (error) {
                                $this.$toastr.e(error);
                            })
                            .then(function () {});
                    }
                })

            }
        }

    }

</script>

<style>

</style>
