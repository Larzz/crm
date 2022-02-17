<template>
    <div>
        <div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <!-- Chart -->
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" v-model="fields.title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Notes</label>
                                <textarea name="" class="form-control" v-model="fields.notes" id="" cols="30"
                                    rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">File</label>
                                <div class="row">
                                    <vue-dropzone :options="dropzoneOptions" v-on:vdropzone-success="uploadResponse"
                                        id="customdropzone">
                                        <div class="dropzone-custom-content">
                                            <h3 class="dropzone-custom-title">Drag and drop to upload content!</h3>
                                            <div class="subtitle">...or click to select a file from your computer</div>
                                        </div>
                                    </vue-dropzone>
                                </div>
                                <small>We only Accept Image and PDF files</small>
                            </div>
                            <button href="#!" @click="saveNewsletter()" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Date Added</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="newsletters">
                                        <tr v-for="(newsletter, index) in newsletters" :key="index">
                                            <td>{{ newsletter.title }}</td>
                                            <td>{{ formatDate(newsletter.created_at) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <ul>
                                                        <li><a href="#!" @click="viewNewsletter(newsletter)"
                                                                title="View Employee"><i class="fas fa-eye"></i></a>
                                                        </li>

                                                        <li> <a href="#!" @click="deleteNewsletter(newsletter.id)"
                                                                title="Update Employee"><i class="fas fa-trash"></i></a>
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
    import Swal from 'sweetalert2'
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'    
    
    export default {
        components: {
             vueDropzone: vue2Dropzone
        },
        data() {
            return {
                fields: {
                    title: null,
                    notes: null,
                    filename: null
                },
                files: [],
                types: [],
                newsletters: {},
                api_token: window.Laravel.api_token,
                dropzoneOptions: {
                    url: `/api/v1/documents/upload/docs?api_token=${window.Laravel.api_token}`,
                    thumbnailWidth: 400,
                    maxFilesize: 100,
                    addRemoveLinks: true,
                    headers: {
                        "api_token": window.Laravel.api_token
                    }
                }
            }
        },
        mounted() {
            this.getAllNewsletter()
        },
        methods: {
            /**
             * Format Date 
             * @param date date
             * @return formatted datetime
             */
            saveNewsletter: function () {

                let $this = this

                if (!this.fields.title) {
                    $this.$toastr.e('Title is Required')
                    return;
                }

                if (!this.fields.notes) {
                    $this.$toastr.e('Notes is Required')
                    return;
                }

                if (!this.fields.filename) {
                    $this.$toastr.e('Filename is Required')
                    return;
                }

                JsLoadingOverlay.show(this.$configs);

                axios({
                        method: 'post',
                        url: `/api/v1/newsletter?api_token=${this.api_token}`,
                        data: $this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$toastr.s('Succesfully Added')
                            $this.getAllNewsletter()
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {
                        $this.fields.filename = null
                        $this.fields.title = null
                        $this.fields.notes = null
                        JsLoadingOverlay.hide();
                    });
            },
            /**
             * Format Date 
             * @param date date
             * @return formatted datetime
             */
            getAllNewsletter: function () {
                let $this = this
                JsLoadingOverlay.show(this.$configs);

                axios({
                        method: 'get',
                        url: `/api/v1/newsletter?api_token=${this.api_token}`,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.newsletters = response.data.newsletters
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {
                        JsLoadingOverlay.hide();
                    });
            },
            viewNewsletter: function (newsletter) {
                JsLoadingOverlay.show(this.$configs);
                window.location.href = '/documents/' + newsletter.file_url
            },
            /**
             * Format Date 
             * @param date date
             * @return formatted datetime
             */
            deleteNewsletter: function (newsletter_id) {
                let $this = this
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure you want to delete this newsletter?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                        JsLoadingOverlay.show(this.$configs);
                        axios({
                                method: 'delete',
                                url: `/api/v1/newsletter/${newsletter_id}?api_token=${window.Laravel.api_token}`,
                            }).then(function (response) {
                                if (response.data.status) {
                                    $this.$toastr.s('Successfully Deleted');
                                    $this.getAllNewsletter()
                                }
                            })
                            .catch(function (error) {
                                $this.$toastr.e(error);
                            })
                            .then(function () {
                                JsLoadingOverlay.hide();
                            });
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
             /**
             * On Response Upload
             * @param  Object|undefined   data   Read only
             * @param  Object|undefined   response   Read only
             * @return void
             */
            uploadResponse: function (data, response) {
                if (response.status) {
                    this.$toastr.s('Successfully Uploaded');
                    this.fields.filename = response.filename
                }
            },
        }
    }

</script>

<style scoped>

    #customdropzone {
        width: 100%;
    }

   .dropzone {
        min-height: 120px;
        padding: 0px 20px !important;
    }

    .dropzone .dz-message {
        padding: 1rem 1rem !important;
    }

    .card {
        height: max-content;
    }

</style>
