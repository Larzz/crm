<template>
    <div>
        <div class="card">
            <div class="card-body">
                <!-- Chart -->
                <div class="form-group">
                    <label for="">Title</label>
                    <input type="text" v-model="forms.title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Message</label>
                    <textarea name="" id="" v-model="forms.message" cols="30" rows="2" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Active</label>
                    <select name="" id="" v-model="forms.active" class="form-control">
                        <option value="Yes" class="form-control">Yes</option>
                        <option value="No" class="form-control">No</option>
                    </select>
                </div>
                <button href="javascript:;" @click="create()" :disabled="isLoading" class="btn btn-primary">
                    <template v-if="isLoading">
                        Please Wait..
                    </template>
                    <template v-else>
                        Add
                    </template>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                forms: {
                    title: null,
                    message: null,
                    active: null,
                },
                errors: [],
                isLoading: false
            }
        },
        props: [],
        methods: {

            create() {

                let $this = this

                if (!this.forms.title) {
                    this.$toastr.e("Sorry, Title is Required");
                    return false;
                }

                if (!this.forms.message) {
                    this.$toastr.e("Sorry, Message is Required");
                    return false;
                }

                $this.isLoading = true 

                axios({
                        method: 'post',
                        url: '/api/v1/bulletin?api_token=' + window.Laravel.api_token,
                        data: this.forms
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$toastr.s('Successfully added bulletin.');
                            $this.$emit('new_record')
                            $this.isLoading = false 
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {
                        $this.$toastr.e();
                    });

            }
        }
    }

</script>

<style scoped>
    .card {
        height: 391px;
        overflow-y: scroll;
    }
</style>
