<template>
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
                            <label for="">Message</label>
                            <vue-editor v-model="fields.content"> </vue-editor>
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
                                <template v-if="tutorials">
                                    <tr v-for="(tutorial, index) in tutorials" :key="index">
                                        <td>{{ tutorial.title }}</td>
                                        <td>{{ formatDate(tutorial.created_at) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <ul>
                                                    <li><a href="#!" @click="viewTutorial(tutorial.slug)"
                                                            title="View Tutorial"><i class="fas fa-eye"></i></a> </li>
                                                    <li> <a href="#!" @click="editTutorial(tutorial.id)"
                                                            title="Update Tutorial"><i class="fas fa-pen"></i></a> </li>
                                                    <li> <a href="#!" @click="deleteTutorial(tutorial.id)"
                                                            title="Delete Tutorial"><i class="fas fa-trash"></i></a>
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
</template>

<script>
    import {
        VueEditor
    } from "vue2-editor";
    import Swal from 'sweetalert2'

    export default {
        components: {
            VueEditor
        },
        data() {
            return {
                fields: {
                    title: null,
                    content: null
                },
                tutorials: []
            }
        },
        mounted() {
            this.getTutorials()
        },
        beforeCreate() {
            JsLoadingOverlay.show(this.$configs);
        },
        created() {
            JsLoadingOverlay.hide();
        },
        methods: {
            /**
             * Save Tutorial 
             * @param fields array
             * @return status boolean
             */
            submit: function () {

                let $this = this

                if (!this.fields.title) {
                    $this.$toastr.e('Title is Required')
                    return;
                }

                if (!this.fields.content) {
                    $this.$toastr.e('Content is Required')
                    return;
                }

                axios({
                        method: 'post',
                        url: '/api/v1/tutorials?api_token=' + window.Laravel.api_token,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$toastr.s('Succesfully Added new Tutorial')
                            $this.fields.title = null
                            $this.fields.content = null
                            $this.getTutorials()
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});
            },
            /**
             * Get Tutorial 
             * @param 
             * @return data object
             */
            getTutorials() {
                            JsLoadingOverlay.show(this.$configs);
                let $this = this
                axios({
                        method: 'get',
                        url: '/api/v1/tutorials?api_token=' + window.Laravel.api_token,
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.tutorials = response.data.tutorials
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {
                       JsLoadingOverlay.hide();
                    });
            },
            /**
             * View Tutorial 
             * @param 
             * @return void
             */
            viewTutorial: function (slug) {
                JsLoadingOverlay.show(this.$configs);
                window.location.href = `/general/tutorials/${slug}`
            },
            /**
             * Edit Tutorial 
             * @param id string
             * @return void
             */
            editTutorial: function (id) {
                console.log(id)
            },
            /**
             * Delete Tutorial 
             * @param id string
             * @return status bollean
             */
            deleteTutorial: function (id) {
                let $this = this
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure you want to delete this tutorial?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        // JsLoadingOverlay.show(this.$configs);
                        axios({
                                method: 'delete',
                                url: `/api/v1/tutorials/${id}?api_token=${window.Laravel.api_token}`,
                            }).then(function (response) {
                                if (response.data.status) {
                                    $this.$toastr.s('Successfully Deleted');
                                    $this.getTutorials()
                                }
                            })
                            .catch(function (error) {
                                $this.$toastr.e(error);
                            })
                            .then(function () {});
                    }
                })

            },
            /**
             * Format Date 
             * @param date date
             * @return formatted datetime
             */
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
        height: 590px;
    }

</style>
