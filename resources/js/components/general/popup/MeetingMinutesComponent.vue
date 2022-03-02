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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" v-model="fields.name" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Meeting Date</label>
                                <input type="date" class="form-control" v-model="fields.meeting_date">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="" class="form-control" id="" v-model="fields.description" cols="30"
                                    rows="2"></textarea>
                            </div>

                            <template  v-if="!isEdit">
                                <div class="form-group">
                                    <label for="">File</label>
                                    <a href="" class="btn btn-primary">View File</a>
                                </div>
                            </template>

                            <div class="form-group" v-if="isEdit">
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
                    <button type="button" @click="postMeeting" class="btn btn-primary">Save changes</button>
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
    //    import FileUpload from 'vue-upload-component'
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
                    name: null,
                    description: null,
                    meeting_date: null,
                    filename: null
                },
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
            meeting: {
                required: true,
                type: Object
            },
            time: {
                required: true,
                type: Number
            }
        },
        mounted() {},
        watch: {
            time() {
                console.log(this.time)
                this.fields.name = this.meeting.name 
                this.fields.description = this.meeting.description
                this.fields.meeting_date = this.meeting.meeting_date
                this.fields.filename = this.meeting.attachment

                this.path = `${this.path}/${this.meeting.attachment}`
            }
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
            /**
             * On Submit Data
             * @param  Object|undefined   newFile   Read only
             * @return undefined
             */
            postMeeting: function () {

                if (!this.fields.name) {
                    return this.$toastr.e('Name is Required');
                }

                if (!this.fields.meeting_date) {
                    return this.$toastr.e('Meeting Date is Required');
                }

                if (!this.fields.filename) {
                    return this.$toastr.e('File is Required');
                }

                let $this = this

                axios({
                        method: 'post',
                        url: `/api/v1/meetings/${this.user.id}?api_token=${window.Laravel.api_token}`,
                        data: $this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$toastr.s('Successfully added your document');
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
            downloadpdf() {
                window.open(
                    `${this.path}`,
                    '_blank'
                )
            }
        }
    }

</script>

<style scoped>
    .customdropzone {
        width: 100%;
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
