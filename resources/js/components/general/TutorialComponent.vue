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
                            <textarea name="" id="" v-model="fields.message" cols="30" rows="15"
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
                }
            }
        },
        methods: {
            submit: function () {
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
