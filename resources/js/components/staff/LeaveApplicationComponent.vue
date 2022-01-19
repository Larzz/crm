<template>
    <div>
        <div class="card">
            <div class="card-header bg-transparent">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="h3 mb-0">Apply for Vacation</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-8" id="date-picker">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>From</h4>
                                <input v-model="field.leave_from" type="date" class="form-control">
                                <h5 v-html="field.leave_from"></h5>
                            </div>

                            <div class="col-md-6">
                                <h4>To</h4>
                                <input v-model="field.leave_to" @change="validate" type="date" class="form-control">
                                <h5 v-html="field.leave_to"></h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="available-section">
                            <h4> Available <span>{{ leave.available_days }} days</span></h4>
                        </div>

                        <div class="used-days-section">
                            <h4> {{ field.used_days }} days</h4>
                        </div>

                        <hr>
                        <div class="remaining-section">
                            <h3>Remaining <span>{{ field.remaining_days }} days</span></h3>
                        </div>

                        <div class="form-group right mt-2">
                            <a href="javascript:;" @click="submitVacation()" class="btn btn-primary">Submit</a>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="row mt-5">
                            <div class="col-xl-4">
                                <h4>Previous Vacation</h4>
                            </div>
                            <div class="col-xl-4">
                                <h4>Pending Vacation</h4>
                            </div>
                            <div class="col-xl-4"></div>
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
                field: {
                    leave_from: '',
                    leave_to: '',
                    total_day_used: 0,
                    remaining_days: 0,
                    used_days: 0,
                    leave_id: null
                },
            }
        },
        props: ['leave'],
        mounted() {
            this.field.remaining_days = this.leave.available_days
            this.field.used_days = this.leave.used_days
            this.field.leave_id = this.leave.id
     
        },
        watch: {

        },
        computed: {
            leave_from: function () {
                const currentDate = new Date(this.field.leave_from);
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                this.field.leave_from = currentDate.toLocaleDateString('en-us', options)
            },
            leave_to: function () {
                const currentDate = new Date(this.field.leave_to);
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                this.field.leave_to = currentDate.toLocaleDateString('en-us', options)
            }
        },
        methods: {

            validate() {



                this.field.remaining_days = this.leave.available_days
                this.field.used_days = this.leave.used_days

                const date1 = new Date(this.field.leave_from);
                const date2 = new Date(this.field.leave_to);

                const oneDay = 1000 * 60 * 60 * 24;

                const diffInTime = date2.getTime() - date1.getTime();
                const diffInDays = diffInTime / oneDay;

                this.field.used_days = diffInDays
                this.field.remaining_days = parseInt(this.field.remaining_days) - parseInt(diffInDays)

                this.formatDate(this.field.leave_from)
                this.formatDate(this.field.leave_to)

            },

            submitVacation() {

                let $this = this

                if (!this.field.leave_from) {
                    $this.$toastr.e('Leave From is Required')
                    return;
                }

                if (!this.field.leave_to) {
                    $this.$toastr.e('Leave to is Required')
                    return;
                }

                JsLoadingOverlay.show(this.$configs);

                axios({
                        method: 'post',
                        url: '/api/v1/leave?api_token=' + window.Laravel.api_token,
                        data: this.field
                    }).then(function (response) {
                        JsLoadingOverlay.hide()
                        if (response.data.status) {
                            $this.$toastr.s('Successfully submitted your request!');
                        }
                    })
                    .catch(function (error) {
                        JsLoadingOverlay.hide()
                        $this.$toastr.e(error);
                    })
                    .then(function () {});

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
    #date-picker h5 {
        margin-top: 11px;
        font-size: 15px;
        font-weight: 400;
    }

    hr {
        margin-top: 6rem;
    }

    .card {
        min-height: 390px;
    }

    .available-section span {
        float: right;
    }

    .used-days-section {
        float: right;
        margin-top: 18px;
    }

    .remaining-section {
        float: right;
    }

    .right {
        float: right;
        position: absolute;
        top: 213px;
        right: 10px;
        z-index: 100;
    }

</style>
