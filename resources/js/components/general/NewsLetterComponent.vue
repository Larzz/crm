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
                            <button href="#!" @click="submit()" class="btn btn-primary">Add</button>
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
                                            <td>{{ formatDate(newsletter.content) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <ul>
                                                        <li><a href="#!" @click="viewTutorial(tutorial.slug)"
                                                                title="View Employee"><i class="fas fa-eye"></i></a>
                                                        </li>
                                                        <li> <a href="#!" @click="editTutorial(tutorial.id)"
                                                                title="Update Employee"><i class="fas fa-pen"></i></a>
                                                        </li>
                                                        <li> <a href="#!" @click="deleteTutorial(tutorial.id)"
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
                files: null,
                newsletters: {}
            }
        },
        beforeCreate() {
            JsLoadingOverlay.show(this.$configs);
        },
        created() {
            JsLoadingOverlay.hide();
        },
        methods: {
            /**
             * Format Date 
             * @param date date
             * @return formatted datetime
             */
            saveNewsletter: function () {

                if (!fields.title) {
                    $this.$toastr.e('Title is Required')
                    return;
                }

                if (!fields.notes) {
                    $this.$toastr.e('Notes is Required')
                    return;
                }

                axios({
                        method: 'post',
                        url: `/api/v1/newsletter?api_token=${window.Laravel.api_token}`,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$toastr.s('Succesfully Added')
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {

                    });
            },
            /**
             * Format Date 
             * @param date date
             * @return formatted datetime
             */
            getAllNewsletter: function () {

            },
            /**
             * Format Date 
             * @param date date
             * @return formatted datetime
             */
            getNewsletter: function () {

            },
            /**
             * Format Date 
             * @param date date
             * @return formatted datetime
             */
            deleteNewsletter: function () {

            }
        }
    }

</script>

<style scoped>
    .card {
        height: 590px;
    }

</style>
