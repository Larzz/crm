<template>
    <div>
        <div class="card profile-card-2">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">{{ user.name }}</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="showPopup=true" class="btn btn-sm btn-primary">Edit</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="information">
                    <h3>Name: {{ user.name }}</h3>
                    <h4 class="date-joined">Date Added: {{ formatDate(user.created_at) }} <span></span></h4>
                    <h4>Email Address <span class="colon">: {{ user.email  }}</span> <span class="answer"> </span> </h4>
                    <h4>Mobile Number <span class="colon">: {{ user.mobile_number }}</span> <span class="answer"></span>
                    </h4>
                </div>
                <div class="personal-info">

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {

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
            }
        }
    }

</script>

<style scoped>
    .card {
        min-height: 355px !important;
    }
</style>
