<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showPopup" @click.prevent="close"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showPopup">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Bulletin Post</h6>
                    <button type="button" @click.prevent="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="moday-body">
                    <table class="table align-items-center table-flush" id="">
                        <thead class="thead-light">
                            <tr>
                                <th width="100%" scope="col">Title</th>
                                <th width="100%" scope="col">Status</th>
                                <th width="100%" scope="col">Date Addded</th>
                                <th width="100%" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(bulletin, index) in bulletins" :key="index">
                                <td scope="row" width="100%">
                                    {{ bulletin.title }} <br>
                                    {{ bulletin.message }}
                                </td>
                                <td scope="row" width="100%">
                                   {{ formatStatus(bulletin.status) }}
                                </td>
                                <td scope="row" width="100%">
                                    {{  formatDate(bulletin.created_at) }}
                                </td>
                                <td scope="row" width="100%">
                                    <div class="d-flex ">
                                        <ul>
                                            <li><a href="#!" @click="postBulletin(bulletin)" title="Post bulletin"><i
                                                        class="fa fa-edit"></i></a> </li>
                                            <li><a href="#!" @click="deleteBulletin(bulletin)"
                                                    title="Delete bulletin"><i class="fas fa-trash"></i></a> </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" @click.prevent="close" class="btn btn-link  ml-auto"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                clients: {},
                bulletins: {}
            }
        },
        props: {
            showPopup: {
                required: true,
                type: Boolean
            },
            times: {
                required: true,
                type: Number
            }
        },
        watch: {
            times: 'getBulletins'
        },
        methods: {
            close() {
                this.$emit('close', false)
            },
            getBulletins() {
                let $this = this
                axios({
                        method: 'get',
                        url: `/api/v1/bulletin/all-bulletin?api_token=${window.Laravel.api_token}`,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.bulletins = response.data.bulletins
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {

                    });
            },
            postBulletin(bulletin) {
                let $this = this
                axios({
                        method: 'post',
                        url: `/api/v1/bulletin/${bulletin.id}/post?api_token=${window.Laravel.api_token}`,
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$toastr.s('Successfully Posted!');
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {

                    });
            },
            deleteBulletin(bulletin) {
              let $this = this
                axios({
                        method: 'delete',
                        url: `/api/v1/bulletin/${bulletin.id}?api_token=${window.Laravel.api_token}`,
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$toastr.s('Successfully deleted bulletin!');
                            $this.getBulletins()
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {

                    });
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
            },
            formatStatus(bulletin) {
               if (bulletin) {
                  return 'Posted'
               } else {
                 return 'Draft'
               }
            }
        }
    }

</script>

<style scoped>
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

    .modal-footer {
        padding: 10px;
    }

    .modal-body {
        padding: 10px;
        height: 422px;
        overflow-y: scroll;
    }

    .table {
        height: 200px;
        overflow-y: scroll;
    }

</style>
