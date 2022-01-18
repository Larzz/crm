<template>
    <div>
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">My Documents</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="showPopup=true" class="btn btn-sm btn-primary">Upload</a>
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
                            <tr v-for="(document, index) in documents" :key="index">
                                <th scope="row">
                                    {{ document.name }}
                                </th>
                                <td>
                                    {{ document.expiration_date }}
                                </td>
                                <td>
                                    {{ document.renewal_date }}
                                </td>
                                <td>

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

        <upload-document-popup :showPopup="showPopup" @fetchDocument="getDocuments" @close="showPopup = false">
        </upload-document-popup>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                documents: [],
                showPopup: false
            }
        },
        mounted() {
            this.getDocuments()
        },
        methods: {
            getDocuments() {
                let $this = this
                axios({
                        method: 'get',
                        url: '/api/v1/documents?api_token=' + window.Laravel.api_token,
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.documents = response.data.documents
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});
            },
            close() {
                this.$emit('close', false)
            }
        }
    }

</script>

<style scoped>
    .card {
        min-height: 355px;
    }

</style>
