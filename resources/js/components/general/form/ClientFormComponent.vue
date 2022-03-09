<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" v-model="fields.name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Contact Email</label>
                    <input type="email" v-model="fields.email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="text" v-model="fields.password" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">URL</label>
                    <input type="text" v-model="fields.url" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Date Joined</label>
                    <input type="date" v-model="fields.date_joined" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Contact Number</label>
                    <input type="text" v-model="fields.mobile_number" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Service type</label>
                    <input type="text" v-model="fields.service_type" class="form-control">
                </div>

            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <button type="button" @click="addClient" class="btn btn-primary">Save changes</button>

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
                    name: null,
                    email: null,
                    password: null,
                    date_joined: null,
                    mobile_number: null,
                    service_type: null,
                    url: null
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
            addClient() {

                let $this = this

                if (!this.fields.name) {
                    $this.$toastr.e('Name is Required')
                    return;
                }

                if (!this.fields.email) {
                    $this.$toastr.e('Email is Required')
                    return;
                }

                if (!this.fields.password) {
                    $this.$toastr.e('Password is Required')
                    return;
                }

                if (!this.fields.date_joined) {
                    $this.$toastr.e('Date Joined is Required')
                    return;
                }

                if (!this.fields.mobile_number) {
                    $this.$toastr.e('Moble Number is Required')
                    return;
                }


                if (!this.fields.service_type) {
                    $this.$toastr.e('Service Type is Required')
                    return;
                }

                if (!this.fields.url) {
                    $this.$toastr.e('URL is Required')
                    return;
                }

                JsLoadingOverlay.show(this.$configs);

                axios({
                        method: 'post',
                        url: '/api/v1/client?api_token=' + window.Laravel.api_token,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$emit('new_client', true)
                            // $this.close()
                            $this.resetForm()
                            $this.$toastr.s('Succesfully Added new Client')
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {
                        JsLoadingOverlay.hide();
                    });

            },
            resetForm() {
                this.fields.name = null
                this.fields.email = null
                this.fields.password = null
                this.fields.date_joined = null
                this.fields.mobile_number = null
                this.fields.service_type = null
                this.fields.url = null
            }
        }
    }

</script>

<style scoped>

</style>
