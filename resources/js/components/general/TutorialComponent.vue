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
                            <textarea name="" id="" v-model="fields.content" cols="30" rows="15"
                                class="form-control"></textarea>
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
                                                    <li><a href="#!" @click="viewTutorial(tutorial.id)"
                                                            title="View Employee"><i class="fas fa-eye"></i></a> </li>
                                                    <li> <a href="#!" @click="editTutorial(tutorial.id)"
                                                            title="Update Employee"><i class="fas fa-pen"></i></a> </li>
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
</template>

<script>
    export default {
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
        methods: {
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
            getTutorials() {
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
                    .then(function () {});
            },
            viewTutorial: function (id) {
                console.log(id)
            },
            editTutorial: function (id) {
                console.log(id)
            },
            deleteTutorial: function (id) {
                console.log(id)
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
        height: 590px;
    }

</style>
