<template>
    <div>
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">My Documents</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" class="btn btn-sm btn-primary">Upload</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Document</th>
                            <th scope="col">Expiration</th>
                            <th scope="col">Renewal</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <template v-if="documents">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    /argon/
                                </th>
                                <td>
                                    4,569
                                </td>
                                <td>
                                    340
                                </td>
                                <td>
                                    <i class="fas fa-arrow-up text-success mr-3"></i> 46,53%
                                </td>
                            </tr>
                        </tbody>
                    </template>

                </table>

                <template v-if="!documents">
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
    export default {
        data() {
            return {
                documents: []
            }
        },
        mounted() {
            this.documents = this.getDocumentExpires()
        },
        methods: {
            getDocumentExpires() {
                return null
            }
        }
    }

</script>

<style scoped>
    .card {
        min-height: 355px;
    }
</style>
