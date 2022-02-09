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
                            <div class="col-md-12">
                                <h4>Date</h4>
                                <!-- <input v-model="field.leave_from" type="date" class="form-control"> -->
                                <!-- <h5 v-html="field.leave_from"></h5> -->
                                <!-- <v-date-picker v-model="field.date" is-range /> -->
                                <v-date-picker 
                                    :available-dates='{ start: new Date(), end: null }'
                                    v-model="field.date" is-range>
                                    <template v-slot="{ inputValue, inputEvents }">
                                        <div class="flex justify-center items-center">
                                        <input
                                            :value="inputValue.start"
                                            v-on="inputEvents.start"
                                            class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
                                        />
                                        <svg
                                            width="25px"
                                            class="w-4 h-4 mx-2"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"
                                            />
                                        </svg>
                                        <input
                                            :value="inputValue.end"
                                            v-on="inputEvents.end"
                                            class="border px-2 py-1 w-32 rounded focus:outline-none focus:border-indigo-300"
                                        />
                                        </div>
                                    </template>
                                </v-date-picker>
                            </div>
                            <!-- <div class="col-md-6">
                                <h4>To</h4>
                                <input v-model="field.leave_to" @change="validate" type="date" class="form-control">
                                <h5 v-html="field.leave_to"></h5>
                            </div> -->
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
    import VCalendar from 'v-calendar';
    export default {
        components: {
            VCalendar: 'v-calendar'
        },
        data() {
            return {
                field: {
                    leave_from: '',
                    leave_to: '',
                    total_day_used: 0,
                    remaining_days: 0,
                    used_days: 0,
                    leave_id: null,
                    date: null,
                },
                range: {
                    start: new Date(2020, 0, 1),
                    end: new Date(2020, 0, 5),

                }
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

            // Expects start date to be before end date
            // start and end are Date objects
            dateDifference(start, end) {

            // Copy date objects so don't modify originals
            var s = new Date(+start);
            var e = new Date(+end);
            
            // Set time to midday to avoid dalight saving and browser quirks
            s.setHours(12,0,0,0);
            e.setHours(12,0,0,0);
            
            // Get the difference in whole days
            var totalDays = Math.round((e - s) / 8.64e7);
            
            // Get the difference in whole weeks
            var wholeWeeks = totalDays / 7 | 0;
            
            // Estimate business days as number of whole weeks * 5
            var days = wholeWeeks * 5;

            // If not even number of weeks, calc remaining weekend days
            if (totalDays % 7) {
                s.setDate(s.getDate() + wholeWeeks * 7);
                
                while (s < e) {
                s.setDate(s.getDate() + 1);

                // If day isn't a Sunday or Saturday, add to business days
                if (s.getDay() != 0 && s.getDay() != 6) {
                    ++days;
                }
                }
            }
            return days + 1;
            },

            validate() {

                this.field.remaining_days = this.leave.available_days
                this.field.used_days = this.leave.used_days

                this.field.leave_from = this.field.date.start
                this.field.leave_to = this.field.date.end

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

                // this.validate()

                console.log(this.dateDifference(this.field.date.start, this.field.date.end))
                console.log(this.field.date)
                
                return;
                let $this = this

                if (!this.field.leave_from) {
                    $this.$toastr.e('Leave From is Required')
                    return;
                }

                if (!this.field.leave_to) {
                    $this.$toastr.e('Leave to is Required')
                    return;
                }

                console.log(this.field)
                return;

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
