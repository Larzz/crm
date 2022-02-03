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
                                <label for="">Active</label>
                                <select name="" v-model="fields.active" class="form-control" id="">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Notes</label>
                                <textarea name="" v-model="fields.content" class="form-control" id="" cols="30"
                                    rows="10"></textarea>
                            </div>
                            <button href="#!" @click="saveDomain()" class="btn btn-primary">Add</button>
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
                fields: {
                    title: null,
                    content: null,
                    active: null
                }
            }
        },
        beforeCreate() {
            JsLoadingOverlay.show(this.$configs);
        },
        created() {
            JsLoadingOverlay.hide();
        },
        methods: {
            saveDomain() {

                if (!this.fields.title) {
                    $this.$toastr.e('Title is Required');
                    return false
                }

                if (!this.fields.content) {
                    $this.$toastr.e('Content is Required');
                    return false
                }

                axios({
                        method: 'post',
                        url: '/api/v1/websites?api_token=' + window.Laravel.api_token,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$toastr.s('Successfully Added Employee');
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {
                        $this.$toastr.e(error);
                    });

                console.log(this.fields)
            }
        }
    }

</script>

<style scoped>
    .card {
        height: 590px;
    }

</style>
