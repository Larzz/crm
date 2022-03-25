<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showPopup" @click.prevent="close"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showPopup">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Upload document</h6>
                    <button type="button" @click.prevent="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" v-model="fields.name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">Document Type</label>
                                <select v-model="fields.type" name="" id="" class="form-control">
                                    <option value="" selected>Select Document Type</option>
                                    <template v-if="types">
                                        <option v-for="(type, index) in types" :key="index">{{ type.name }}</option>
                                    </template>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Starting Date</label>
                                <input type="date" class="form-control" v-model="fields.expiration_date">
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5">

                                        <label for="">Open Ended</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" v-model="fields.open_ended"
                                                class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Tick if yes</label>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <label for="">Renewal Date</label>
                                        <input type="date" class="form-control" v-model="fields.renewal_date">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <template v-if="!isEdit">
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <a href="javascript:;" @click="downloadpdf()" class="btn btn-primary">View
                                    Attachment</a>
                            </div>
                        </div>
                    </template>


                    <div class="col-md-12" v-if="isEdit">
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
                <div class="modal-footer">
                    <button type="button" @click="postDocument" class="btn btn-primary">Save changes</button>
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
                files: [],
                types: [],
                fields: {
                    id: null,
                    name: null,
                    type: null,
                    renewal_date: null,
                    expiration_date: null,
                    filename: null,
                    open_ended: false
                },
                path: '/documents/',
                api_token: window.Laravel.api_token,
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
            user: {
                required: true,
                type: Object
            },
            isEdit: {
                required: true,
                type: Boolean
            },
            document: {
                required: true,
                type: Object
            },
            time: {
                required: true,
                type: Number
            }
        },
        mounted() {
            this.getDocumentTypes()

        },
        watch: {
            time() {

                this.fields.name = this.document.name
                this.fields.type = this.document.type
                this.fields.renewal_date = this.document.renewal_date
                this.fields.expiration_date = this.document.expiration_date

                this.path = `${this.path}/${this.document.attachment}`

                console.log(this.document)
            }
        },
        methods: {
            /** Close Document
             * 
             * @return Object| list of documents
             * */
            close() {
                this.fields.id = null
                this.fields.name = null
                this.fields.type = null
                this.fields.renewal_date = null
                this.fields.expiration_date = null

                this.$emit('close', false)
                this.$emit('fetchDocument')
            },
            /** Get Document Type
             * 
             * @return Object| list of documents
             * */
            getDocumentTypes: function () {

                let $this = this
                axios({
                        method: 'get',
                        url: '/api/v1/documents/types/docs/get?api_token=' + window.Laravel.api_token,
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.types = response.data.types
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});

            },
            /**
             * On Submit Data
             * @param  Object|undefined   newFile   Read only
             * @return undefined
             */
            postDocument: function () {

                if (!this.fields.name) {
                    return this.$toastr.e('Name is Required');
                }

                if (!this.fields.type) {
                    return this.$toastr.e('Type is Required');
                }

                if (!this.fields.expiration_date) {
                    return this.$toastr.e('Starting Date is Required');
                }

                if (!this.fields.filename) {
                    return this.$toastr.e('File is Required');
                }

                let $this = this

                let url = `/api/v1/documents/${this.user.id}?api_token=${window.Laravel.api_token}`

                if (this.fields.id) {
                    let url =
                        `/api/v1/documents/${this.user.id}/${this.fields.id}?api_token=${window.Laravel.api_token}`
                }

                axios({
                        method: 'post',
                        url: url,
                        data: $this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$toastr.s('Successfully added your document');
                            $this.clearFields()
                            $this.close()
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});
            },
            /**
             * On Response Upload
             * @param  Object|undefined   data   Read only
             * @param  Object|undefined   response   Read only
             * @return void
             */
            uploadResponse: function (data, response) {
                console.log(response.filename)
                if (response.status) {
                    this.fields.filename = response.filename
                    this.$toastr.s('Successfully Uploaded');
                }

                console.log(this.fields)
            },
            /**
             * On clear fields
             * @return void
             */
            clearFields: function () {
                this.fields.name = null
                this.fields.type = null
                this.fields.renewal_date = null
                this.fields.expiration_date = null
                this.fields.filename = null
            },
            downloadpdf: function () {
                window.open(
                    `${this.path}`,
                    '_blank' // <- This is what makes it open in a new window.
                );
            }
        }
    }

</script>

<style scoped>
    .custom-control {
        margin-top: 13px;
        margin-left: 10px;
    }

    .customdropzone {
        width: 100%;
    }

    .dropzone-custom-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .dropzone-custom-title {
        margin-top: 0;
        color: #00b782;
    }

    .subtitle {
        color: #314b5f;
    }

    .form-group {
        margin-bottom: 10px;
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

    .modal {
        position: fixed;
        top: 4%;
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
