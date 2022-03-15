<template>
    <div>
        <div class="card profile-card-2">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">{{ user.name }}</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="showPopup=true" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                        <a href="#!" @click="showChangePassword=true" class="btn btn-sm btn-primary"><i class="fa-solid fa-align-justify"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="information">
                    <h4>Name: {{ user.name }}</h4>
                    <h4 class="date-joined">Date Added: {{ formatDate(user.created_at) }} <span></span></h4>
                    <h4>Email Address <span class="colon">: {{ user.email  }}</span> <span class="answer"> </span> </h4>
                    <h4>Mobile Number <span class="colon">: {{ user.mobile_number }}</span> <span class="answer"></span> </h4>
                      <h4>Service Type <span class="colon">: {{ user.service_type }}</span> <span class="answer"></span> </h4>
                    <h4>URL <span class="colon">: {{ user.url }}</span> <span class="answer"></span> </h4>
                </div>
                <div class="personal-info">

                </div>
            </div>
        </div>

        <edit-client-popup :client="user" :showPopup="showPopup" @close="close($event)"  />
        <changed-password-popup :client="user" :showPopup="showChangePassword" @close="close($event)" />

    </div>
</template>

<script>
    export default {
        data() {
            return {
                showPopup: false,
                showChangePassword: false
            }
        },
        props: {
            user: {
                required: true,
                type: Object
            }
        },
        methods: {
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
            close(client) {

                console.log(client)
                this.showPopup = false
                this.user.name = client.name
                this.user.email = client.email
                this.user.mobile_number = client.mobile_number
                this.user.service_type = client.service_type
                this.user.url = client.url
            }
        }
    }

</script>

<style scoped>
    .card {
        min-height: 355px !important;
    }

</style>
