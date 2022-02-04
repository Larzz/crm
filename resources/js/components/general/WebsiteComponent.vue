<template>
    <div>
        <div>
            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <!-- Chart -->
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" v-model="fields.website" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Notes</label>
                                <textarea name="" v-model="fields.content" class="form-control" id="" cols="30"
                                    rows="10"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Active</label>
                                <select name="" v-model="fields.active" class="form-control" id="">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <button href="#!" @click="saveDomain()" class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Website</th>
                                        <th scope="col">Date Added</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="websites">
                                        <tr v-for="(website, index) in websites" :key="index">
                                            <td>{{ website.domain_name }}</td>
                                            <td>{{ formatDate(website.created_at) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <ul>
                                                        <li> <a href="#!" @click="viewDomain(website.id)"
                                                                title="Update Employee"><i class="fas fa-pen"></i></a>
                                                        </li>
                                                        <li> <a href="#!" @click="deleteDomain(website.id)"
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
    export default {
        data() {
            return {
                fields: {
                    id: null,
                    website: null,
                    content: null,
                    active: null
                },
                websites: {}
            }
        },
        beforeCreate() {
            JsLoadingOverlay.show(this.$configs);
        },
        created() {
            JsLoadingOverlay.hide();
        },
        mounted() {
            this.getDomains()
        },
        methods: {
            /**
             * Save Domain 
             * @param object
             * @return status
             */
            saveDomain() {

                let $this = this

                if (!this.fields.website) {
                    $this.$toastr.e('Website URL is Required');
                    return false
                }

                if (!this.fields.content) {
                    $this.$toastr.e('Content is Required');
                    return false
                }

                axios({
                        method: 'post',
                        url: '/api/v1/website?api_token=' + window.Laravel.api_token,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.getDomains()
                            $this.fields.id = null
                            $this.fields.website = null
                            $this.fields.content = null
                            $this.fields.active = null
                            $this.$toastr.s('Successfully Added Website');
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});

            },
            /**
             * Get Domain 
             * @param 
             * @return status
             */
            getDomains() {
                JsLoadingOverlay.show(this.$configs);
                let $this = this
                axios({
                        method: 'get',
                        url: '/api/v1/website?api_token=' + window.Laravel.api_token,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.websites = response.data.websites
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
             * Delete Domain
             * @param id integer
             * @return status boolean
             */
            deleteDomain: function (id) {
                let $this = this
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure you want to delete this domain?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                        JsLoadingOverlay.show(this.$configs);
                        axios({
                                method: 'delete',
                                url: `/api/v1/website/${id}?api_token=${window.Laravel.api_token}`,
                            }).then(function (response) {
                                if (response.data.status) {
                                    $this.$toastr.s('Successfully Deleted');
                                    $this.getDomains()
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
            /**
             * View Domain
             * @param id integer
             * @return status boolean, data object
             */
            viewDomain: function (id) {
                JsLoadingOverlay.show(this.$configs);
                let $this = this
                axios({
                        method: 'get',
                        url: `/api/v1/website/${id}?api_token=${window.Laravel.api_token}`,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.fields.id = response.data.website.id
                            $this.fields.website = response.data.website.domain_name
                            $this.fields.content = response.data.website.notes
                            $this.fields.is_active = response.data.website.active
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
             * Format Date
             * @param date datetime
             * @return formatted date string
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
