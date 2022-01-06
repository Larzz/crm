<template>
    <div>
        <div class="card">
            <div class="card-header bg-transparent">
                <div class="row align-items-center">
                    <div class="col">
                        <!-- <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6> -->
                        <h5 class="h3 mb-0">Apply for Vacation</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Chart -->
                <div class="row">
                    <div class="col-xl-8" id="date-picker">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>From</h4>
                                <input v-model="field.leave_from" type="date" class="form-control">
                                <h5>August 5, 2021</h5>
                            </div>

                            <div class="col-md-6">
                                <h4>To</h4>
                                <input v-model="field.leave_to" type="date" class="form-control">
                                <h5>August 5, 2021</h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                            <div class="available-section">
                                <h4> Available <span>24 days</span></h4>
                            </div>

                            <div class="used-days-section">
                                <h4> {{ field.total_day_used }} days</h4>
                            </div>

                            <hr>
                            <div class="remaining-section">
                                <h3>Remaining <span>23 days</span></h3>
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
                }
            }
        },
        mounted() {

        },
        methods: {
            submitVacation() {
                console.log(this.field)
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
