<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showPopup" @click.prevent="close"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showPopup">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Employee Creation</h6>
                    <button type="button" @click.prevent="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" v-model="fields.name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" disabled v-model="fields.email" class="form-control">
                            </div>
                            <div class="form-group d-none">
                                <label for="">Password</label>
                                <input type="text" disabled v-model="fields.password" class="form-control">
                            </div>

                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Date Joined</label>
                                <input type="date" v-model="fields.date_joined" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Birth Date</label>
                                <input type="date" v-model="fields.birth_date" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Mobile Number</label>
                                <input type="text" v-model="fields.mobile_number" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">Position</label>
                                <input type="text" v-model="fields.position" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Number of Annual Leave</label>
                                <input type="text" v-model="fields.annual_leave" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Number of Sick Leave</label>
                                <input type="text" v-model="fields.sick_leave" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">File</label>
                                <vue-dropzone :options="dropzoneOptions" v-on:vdropzone-success="uploadResponse"
                                    id="customdropzone">
                                    <div class="dropzone-custom-content">
                                        <h3 class="dropzone-custom-title">Drag and drop to upload content!</h3>
                                        <div class="subtitle">...or click to select a file from your computer</div>
                                    </div>
                                </vue-dropzone>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="addEmployee()" class="btn btn-primary">Save changes</button>
                    <button type="button" @click.prevent="close" class="btn btn-link  ml-auto"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'

    export default {
        components: {
            vueDropzone: vue2Dropzone
        },
        data() {
            return {
                showClientPopup: false,
                fields: {
                    name: null,
                    email: null,
                    password: null,
                    position: null,
                    date_joined: null,
                    birth_date: null,
                    mobile_number: null,
                    number_of_days: null,
                    notes: null,
                    filename: null,
                    annual_leave: null,
                    sick_leave: null
                },
                dropzoneOptions: {
                    url: `/api/v1/documents/upload/docs?api_token=${window.Laravel.api_token}`,
                    thumbnailWidth: 400,
                    maxFilesize: 100,
                    addRemoveLinks: true,
                    headers: {
                        "api_token": window.Laravel.api_token
                    }
                }
            }
        },
        props: {
            showPopup: {
                required: true,
                type: Boolean
            },
            employee: {
                required: true,
                type: Object
            }
        },
        mounted() {
            this.fields.name = this.employee.name
            this.fields.email = this.employee.email
            this.fields.position = this.employee.position
            this.fields.date_joined = this.employee.date_joined
            this.fields.birth_date = this.employee.birth_date
            this.fields.mobile_number = this.employee.mobile_number
            this.fields.password = this.employee.password
            this.fields.filename = this.employee.filename
            this.fields.annual_leave = this.employee.annual_leave
            this.fields.sick_leave = this.employee.sick_leave
        },
        methods: {
            beforeCreate() {
                JsLoadingOverlay.show(this.$configs);
            },
            created() {
                JsLoadingOverlay.hide();
            },
            close(employee) {
                this.$emit('close', employee)
            },
            addEmployee() {

                let $this = this

                if (!this.fields.name) {
                    $this.$toastr.e('Name is Required');
                    return false
                }

                if (!this.fields.position) {
                    $this.$toastr.e('Position is Required')
                    return false
                }

                if (!this.fields.birth_date) {
                    $this.$toastr.e('Birth Date is Required')
                    return false
                }

                if (!this.fields.mobile_number) {
                    $this.$toastr.e('Mobile Number is Required')
                    return false
                }

                JsLoadingOverlay.show(this.$configs);

                axios({
                        method: 'patch',
                        url: `/api/v1/employee-staff/${this.employee.id}?api_token=${window.Laravel.api_token}`,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$toastr.s('Successfully Update!', 'Success');
                            $this.close(response.data.employee)
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
             * On Response Upload
             * @param  Object|undefined   data   Read only
             * @param  Object|undefined   response   Read only
             * @return void
             */
            uploadResponse: function (data, response) {
                if (response.status) {
                    this.$toastr.s('Successfully Uploaded');
                    this.fields.filename = response.filename
                }
            },
            /**
             * On clear fields
             * @return void
             */
            resetForms() {
                this.fields.name = null
                this.fields.email = null
                this.fields.password = null
                this.fields.position = null
                this.fields.date_joined = null
                this.fields.birth_date = null
                this.fields.mobile_number = null
                this.fields.number_of_days = null
            }
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
