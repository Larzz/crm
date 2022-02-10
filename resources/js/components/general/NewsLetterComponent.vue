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
                                    rows="10"></textarea>
                            </div>
                             <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <file-upload ref="upload" v-model="files" :data="{api_token: api_token }"
                                            post-action="/api/v1/documents/upload/docs" @input-file="inputFile"
                                            @input-filter="inputFilter" @response="uploadResponse">
                                            Upload file
                                        </file-upload>
                                    </div>
                                    <div class="col-md-6">
                                        <button v-show="!$refs.upload || !$refs.upload.active"
                                            @click.prevent="$refs.upload.active = true" class="btn btn-sm btn-primary"
                                            type="button">Start upload</button>
                                    </div>
                                </div>
                                <!-- <small>We only Accept Image and PDF files</small> -->
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
    import FileUpload from 'vue-upload-component'
    export default {
          components: {
            FileUpload,
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
                api_token: window.Laravel.api_token
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
            viewNewsletter: function(newsletter) {
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
             * Has changed
             * @param  Object|undefined   newFile   Read only
             * @param  Object|undefined   oldFile   Read only
             * @return undefined
             */
            inputFile: function (newFile, oldFile) {
                if (newFile && oldFile && !newFile.active && oldFile.active) {
                    // Get response data
                    console.log('response', newFile.response)
                    if (newFile.xhr) {
                        //  Get the response status code
                        // console.log('status', newFile.xhr.status)
                        if (newFile.response.status) {
                            this.$toastr.s('Successfully Uploaded');
                            this.fields.filename = newFile.response.filename
                        }

                    }
                }
            },
            /**
             * Pretreatment
             * @param  Object|undefined   newFile   Read and write
             * @param  Object|undefined   oldFile   Read only
             * @param  Function           prevent   Prevent changing
             * @return undefined
             */
            inputFilter: function (newFile, oldFile, prevent) {
                if (newFile && !oldFile) {
                    // Filter non-image file
                    if (!/\.(jpeg|jpe|jpg|gif|png|pdf|docx|webp)$/i.test(newFile.name)) {
                        return prevent()
                    }
                }

                // Create a blob field
                newFile.blob = ''
                let URL = window.URL || window.webkitURL
                if (URL && URL.createObjectURL) {
                    newFile.blob = URL.createObjectURL(newFile.file)
                }

            },
            /**
             * uploadResponse
             * @param  data
             * @return void
             */
            uploadResponse: function (data) {
                if (data.status) {
                    this.$toastr.s('Successfully Uploaded');
                    this.fields.filename = data.filename
                }
            },
        }
    }

</script>

<style scoped>
    .card {
        height: 590px;
    }

</style>
