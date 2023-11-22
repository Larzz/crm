<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showPopup" @click.prevent="close"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showPopup">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Sick Leave Creation</h6>
                    <button type="button" @click.prevent="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Employee</label>
                                <select name="" id="" class="form-control" v-model="fields.employee_id">
                                    <option v-for="(employee, index) in employees" :key="index" :value="employee.id">
                                        {{ employee.name }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Date From</label>
                                <input type="date" v-model="fields.date_from" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Date To</label>
                                <input type="date" v-model="fields.date_to" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Notes</label>
                                <textarea name="" v-model="fields.notes" class="form-control" id="" cols="30"
                                    rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="onSubmitLeave()" class="btn btn-primary">Submit</button>
                        <button type="button" @click.prevent="close" class="btn btn-link  ml-auto"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showClientPopup: false,
                fields: {
                    employee_id: null,
                    date_from: null,
                    date_to: null,
                    notes: null,
                    number_of_days: null
                },
                employees: []
            }
        },
        props: {
            showPopup: {
                required: true,
                type: Boolean
            },
            employee: {
                required: false,
                type: Object
            },
        },
        mounted() {
            this.getEmployees()
        },
        methods: {
            beforeCreate() {
                JsLoadingOverlay.show(this.$configs);
            },
            created() {
                JsLoadingOverlay.hide();
            },
            close() {
                this.$emit('close', false)
            },
            onSubmitLeave() {

                let $this = this

                if (!this.fields.employee_id) {
                    $this.$toastr.e('Employee is Required');
                    return false
                }

                if (!this.fields.date_from) {
                    $this.$toastr.e('Date From is Required');
                    return false
                }

                if (!this.fields.date_to) {
                    $this.$toastr.e('Date to is Required');
                    return false
                }

                if (!this.fields.notes) {
                    $this.$toastr.e('Notes is Required')
                    return false
                }
                
                this.fields.number_of_days = this.getDaysBetweenDates(this.fields.date_from, this.fields.date_to)

                JsLoadingOverlay.show(this.$configs);

                axios({
                        method: 'post',
                        url: '/api/v1/leave/sick?api_token=' + window.Laravel.api_token,
                        data: {
                            user_id: this.fields.employee_id,
                            leave_from: this.fields.date_from,
                            leave_to: this.fields.date_to,
                            number_of_days: this.fields.number_of_days
                        }
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$emit('new_employee', true)
                            $this.resetForms()
                            $this.close()
                            $this.$toastr.s('Successfully Added!', 'Success');
                        } else {
                            $this.$toastr.e(response.data.message);
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {
                        JsLoadingOverlay.hide();
                    });

            },

            getDaysBetweenDates(startDate, endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);

                // Calculate the time difference in milliseconds
                const timeDifference = Math.abs(end - start);

                // Convert time difference from milliseconds to days
                const daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

                return daysDifference + 1
            },
            resetForms() {
                this.fields.name = null
                this.fields.email = null
                this.fields.password = null
                this.fields.position = null
                this.fields.date_joined = null
                this.fields.birth_date = null
                this.fields.mobile_number = null
                this.fields.number_of_days = null
                this.fields.notes = null
            },
            getEmployees() {

                let self = this
                axios({
                        method: 'get',
                        url: '/api/v1/employee?api_token=' + window.Laravel.api_token,
                        //   data: this.fields
                    }).then(function (response) {
                        self.employees = response.data.employees
                        console.log('FUCKER ', response.data.employees)
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});

            },
        }
    }

</script>

<style scoped>
    .form-group {
        margin-bottom: 13px;
    }

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }

    .slide-enter-active,
    .slide-leave-active {
        transition: transform .5s;
    }

    .slide-enter,
    .slide-leave-to {
        transform: translateY(-50%) translateX(100vw);
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 900;
        background-color: rgba(0, 0, 0, 0.3);
    }

    .modal-body {
        padding: 9px;
    }

    .modal-footer {
        display: flex;
        padding: 10px;
        border-top: 0 solid #e9ecef;
        border-bottom-right-radius: 0.4375rem;
        border-bottom-left-radius: 0.4375rem;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-end;
    }

    .modal {
        position: fixed;
        top: 2%;
        left: 27%;
        z-index: 1000;
        width: 100%;
        max-width: 50%;
        background-color: #FFF;
        border-radius: 16px;
        padding: 0px;
        display: block;
        height: max-content;
    }

    h1 {
        font-size: 24px;
        line-height: 1px;
    }

    .right {
        float: right;
    }


    .btn {
        font-size: .875rem;
        position: relative;
        transition: all .15s ease;
        letter-spacing: .025em;
        text-transform: none;
        will-change: transform;
    }

    .btn-primary {
        color: #fff;
        border-color: #f26f24;
        background-color: #f26f24;
        box-shadow: 0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%);
    }

</style>
