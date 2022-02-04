<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total Presentations</h5>
                                <span class="h2 font-weight-bold mb-0">2,356</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-orange text-white rounded-circle shadow">
                                    <i class="ni ni-chart-pie-35"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- forms -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <form id="form" action="javascript:;" method="post">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title</label>
                                <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="Enter Title">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <input type="text" name="description" class="form-control" id="exampleInputPassword1"
                                    placeholder="Enter Description">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Meeting Date</label>
                                <input type="date" name="meeting_date" class="form-control" id="exampleInputPassword1"
                                    placeholder="Enter Description">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Client</label>
                                <select class="form-control" name="client_id" id="exampleFormControlSelect2">
                                    <template v-if="clients" >
                                        <option v-for="(client, index) in clients" :key="index">{{ client.name }}</option>
                                    </template>
                                </select> </div>
                            <div class="form-group">
                                <div id="fine-uploader-gallery"></div>
                            </div>
                            <input type="hidden" name="attachment" id="attachment">
                            <button type="submit" class="btn btn-primary" id="save">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- listing -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Client Name</th>
                                        <th scope="col text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="presentations">
                                        <tr v-for="(presentation, index) in presentations" :key="index">
                                            <th scope="row"> {{ presentation.filename }}</th>
                                            <td> {{ presentation.description }} </td>
                                            <td> {{ presentation.client_id }} </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <ul>
                                                        <li><a href="#!" @click="viewPresentation(presentation.id)"
                                                                title="View Presentation"><i class="fas fa-eye"></i></a>
                                                        </li>
                                                        <li> <a href="#!" @click="editPresentation(presentation.id)"
                                                                title="Update Presentation"><i class="fas fa-pen"></i></a>
                                                        </li>
                                                        <li> <a href="#!" @click="deletePresentation(presentation.id)"
                                                                title="Update Presentation"><i class="fas fa-trash"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                presentations: {},
                clients: {}
            }
        },
        mounted() {
            this.getPresentations()
            this.getClients()
        },
        beforeCreate() {
            JsLoadingOverlay.show(this.$configs);
        },
        created() {
            JsLoadingOverlay.hide();
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
                    .then(function () {
                        JsLoadingOverlay.hide();
                    });
            },
            getPresentations: function () {
                JsLoadingOverlay.show(this.$configs);
                let $this = this
                axios({
                        method: 'get',
                        url: '/api/v1/presentations?api_token=' + window.Laravel.api_token,
                    }).then(function (response) {
                        $this.presentations = response.data.presentations
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {
                        JsLoadingOverlay.hide();
                    });
            },
            addPresentation: function () {
                return;
            },
            deletePresentation: function () {
                return;
            },
            viewPresentation: function () {
                return;
            }

        }
    }

</script>

<style>
</style>
