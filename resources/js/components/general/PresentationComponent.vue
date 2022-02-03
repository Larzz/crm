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
                                    <tr>
                                        <th scope="row"> </th>
                                        <td></td>
                                        <td></td>
                                        <td class="">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="#">Delete</a>
                                                    <a class="dropdown-item" href="#">Update</a>
                                                    <a class="dropdown-item" href="#">Download</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
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
            }
        },
        mounted() {
            this.getPresentations()
        },
        beforeCreate() {
           JsLoadingOverlay.show(this.$configs);
        },
        created() {
           JsLoadingOverlay.hide();
        },
        methods: {
            getPresentations: function () {
                return;
            }
        }
    }

</script>

<style>
</style>
