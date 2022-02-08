<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showPopup" @click.prevent="close"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showPopup">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Upload Meeting Minutes</h6>
                    <button type="button" @click.prevent="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" v-model="fields.name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Meeting Date</label>
                        <input type="date" class="form-control" v-model="fields.expiration_date">
                    </div>

                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea name="" class="form-control" id="" cols="30" rows="10"></textarea>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <file-upload ref="upload" v-model="files" :data="{api_token: api_token }"
                                    post-action="/api/v1/documents/upload/docs" @input-file="inputFile"
                                    @input-filter="inputFilter" @response="uploadResponse">
                                    Upload file
                                </file-upload>
                            </div>
                            <div class="col-md-6">
                                <button v-show="!$refs.upload || !$refs.upload.active"
                                    @click.prevent="$refs.upload.active = true" class="btn btn-sm btn-primary"
                                    type="button">Start upload</button>

                            </div>
                        </div>

                        <!-- <small>We only Accept Image and PDF files</small> -->
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
    import { ref } from 'vue'
    import FileUpload from 'vue-upload-component'
    export default {
        components: {
            FileUpload,
        },
        data() {
            return {
                showClientPopup: false,
                files: [],
                types: [],
                fields: {
                    name: null,
                    type: null,
                    renewal_date: null,
                    expiration_date: null,
                    filename: null
                },
                api_token: window.Laravel.api_token
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
            }
        },
        mounted() {
            this.getDocumentTypes()
        },
        methods: {
            /** Close Document
             * 
             * @return Object| list of documents
             * */
            close() {
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
                        url: '/api/v1/documents/type?api_token=' + window.Laravel.api_token,
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

                if (!this.fields.renewal_date) {
                    return this.$toastr.e('Renewal Date is Required');
                }

                if (!this.fields.expiration_date) {
                    return this.$toastr.e('Expiration Date is Required');
                }

                if (!this.fields.filename) {
                    return this.$toastr.e('File is Required');
                }

                let $this = this

                axios({
                        method: 'post',
                        url: '/api/v1/documents?api_token=' + window.Laravel.api_token,
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
             * Has changed
             * @param  Object|undefined   newFile   Read only
             * @param  Object|undefined   oldFile   Read only
             * @return undefined
             */
            inputFile: function (newFile, oldFile) {
                if (newFile && oldFile && !newFile.active && oldFile.active) {
                    // Get response data
                    console.log('response', newFile.response)
                    if (newFile.xhr) {
                        //  Get the response status code
                        // console.log('status', newFile.xhr.status)
                        if (newFile.response.status) {
                            this.$toastr.s('Successfully Uploaded');
                            this.fields.filename = newFile.response.filename
                        }

                    }
                }
            },
            /**
             * Pretreatment
             * @param  Object|undefined   newFile   Read and write
             * @param  Object|undefined   oldFile   Read only
             * @param  Function           prevent   Prevent changing
             * @return undefined
             */
            inputFilter: function (newFile, oldFile, prevent) {
                if (newFile && !oldFile) {
                    // Filter non-image file
                    if (!/\.(jpeg|jpe|jpg|gif|png|pdf|docx|webp)$/i.test(newFile.name)) {
                        return prevent()
                    }
                }

                // Create a blob field
                newFile.blob = ''
                let URL = window.URL || window.webkitURL
                if (URL && URL.createObjectURL) {
                    newFile.blob = URL.createObjectURL(newFile.file)
                }

            },
            uploadResponse: function (data) {
                if (data.status) {
                    this.$toastr.s('Successfully Uploaded');
                    this.fields.filename = data.filename
                }
            },
            clearFields: function () {
                this.fields.name = null
                this.fields.type = null
                this.fields.renewal_date = null
                this.fields.expiration_date = null
                this.fields.filename = null
            }
        }
    }

</script>

<style scoped>
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
        top: 10%;
        left: 27%;
        z-index: 1000;
        width: 100%;
        max-width: 50%;
        background-color: #FFF;
        border-radius: 16px;
        padding: 0px;
        display: block;
        height: 50%;
        min-height: 75%;
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
