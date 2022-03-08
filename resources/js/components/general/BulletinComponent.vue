<template>
    <div>
        <div class="card">
            <div class="card-header bg-transparent">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="h3 mb-0">Bulletin</h4>
                    </div>
                    <div class="col" v-if="user.role === 1">
                        <div class="align-items-right">

                            <div class="col text-right">
                                <a href="#!" @click="showPopup()" class="btn btn-sm btn-primary"><i
                                        class="fa fa-edit"></i></a>
                                <!-- <a href="#!" @click="showPopup()" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                        <template v-if="bulletin">
                            <div class="bulettin-containers">
                                <h4>{{ this.bulletin.title }}</h4>
                                <p>
                                    {{ this.bulletin.message }}
                                </p>
                            </div>
                        </template>

                        <template v-else>
                            <div class="container">
                                <div class="alert alert-warning" role="alert">
                                    <strong>Sorry!</strong> No Record Found
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <div class="card-footer align-items-right" v-if="user.role===1">
                <div class="col-md-12 text-right">
                    <a href="#!" @click="showBulletinPopup()" class="btn btn-sm btn-primary">View Old Post</i></a>
                </div>
            </div>
        </div>

        <edit-bulletin-popup :bulletin="bulletin" :time="time" :showPopup="showPopups" @close="close($event)">
        </edit-bulletin-popup>

        <bulletin-post-popup :showPopup="showBulletin" :times="time" @close="close($event)" />

    </div>
</template>

<script>
    export default {
        data() {
            return {
                bulletin: {},
                bulletinProp: {},
                showPopups: false,
                time: Date.now(),
                showBulletin: false
            }
        },
        props: {
            user: {
                required: false,
                type: Object
            }
        },
        mounted() {
            this.getBulettin()
            console.log(this.user)
        },
        methods: {
            getBulettin() {
                let $this = this
                axios({
                        method: 'get',
                        url: `/api/v1/bulletin?api_token=${window.Laravel.api_token}`,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.bulletin = response.data.bulletins
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {

                    });
            },
            close(bulletin) {
                this.showPopups = false
                this.showBulletin = false
                this.getBulettin()
            },
            showPopup() {
                this.showPopups = true
                this.bulletinProp = this.bulletin
                this.time = Date.now()
            },
            showBulletinPopup() {
                this.showBulletin = true
                this.time = Date.now()
            }
        }
    }

</script>

<style scoped>
    .card {
        height: 393px;
    }

</style>
