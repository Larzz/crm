<template>
    <div>
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Documents</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="showPopup=true" class="btn btn-sm btn-primary">Upload</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Document</th>
                            <th scope="col">Expiration</th>
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
                                    {{ formatDate(document.expiration_date)  }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <ul>
                                            <li> <a href="#!" @click="removeDocument(document.id)"
                                                    title="Delete Document"><i class="fas fa-trash"></i></a> </li>
                                        </ul>
                                    </div>
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
        <upload-document-popup :showPopup="showPopup" :user="user" @fetchDocument="getDocuments" @close="showPopup = false"></upload-document-popup>
    </div>
</template>

<script>

    import Swal from 'sweetalert2'
    
    export default {
        data() {
            return {
                documents: [],
                showPopup: false
            }
        },
        props: {
            user: {
                required: true,
                type: Object
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
            },
            removeDocument(document_id) {
                let $this = this
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure you want to delete this document?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    if (result.isConfirmed) {

                        axios({
                                method: 'delete',
                                url: '/api/v1/documents/' + document_id + '?api_token=' + window.Laravel
                                    .api_token,
                            }).then(function (response) {
                                if (response.data.status) {
                                    $this.$toastr.s('Successfully Deleted');
                                    $this.getDocuments()
                                }
                            })
                            .catch(function (error) {
                                $this.$toastr.e(error);
                            })
                            .then(function () {});
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
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
            }
        }
    }

</script>

<style scoped>
    .card {
        min-height: 355px;
    }

</style>
