<template>
    <div>
        <template v-if="clients">
            <thead class="thead-light">
                <tr>
                    <th width="100%" scope="col">Name</th>
                    <th width="100%" scope="col">Date Joined</th>
                    <th width="100%" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(client, index) in clients" :key="index">
                    <td scope="row" width="100%">
                        {{ client.name }}
                    </td>
                    <td scope="row" width="100%">
                        {{  formatDate(client.date_joined) }}
                    </td>
                    <td scope="row" width="100%">
                        <div class="d-flex ">
                            <ul>
                                <li><a href="#!" @click="editClient(client)" title="Edit Client"><i
                                            class="fa fa-edit"></i></a> </li>
                                <li><a href="#!" @click="viewClient(client.id)" title="View Client"><i
                                            class="fas fa-eye"></i></a> </li>
                                <li><a href="#!" @click="deleteClient(client.id)" title="Update Client"><i
                                            class="fas fa-trash"></i></a> </li>
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
        <edit-client-popup :client="client" :showPopup="showPopup" @close="close()" />
    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    export default {
        data() {
            return {
                client: {},
                clients: {},
                showPopup: false,
            }
        },
        props: {
            newClientAdded: {
                required: true,
                type: Number
            }
        },
        watch: {
            newClientAdded: 'getClients'
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
                window.location.href = '/general/clients/' + client_id
            },
            editClient(client) {
                this.showPopup = true
                this.client = client
                return
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
                    .then(function () {
                        JsLoadingOverlay.hide();
                    });
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
            close() {
                this.showPopup = false
                this.getClients()
            }
        }

    }

</script>
