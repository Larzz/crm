<template>
    <div>
        <div class="card profile-card-2">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Employee Details</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="showPopup=true" class="btn btn-sm btn-primary">Edit</a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-5">
                <template v-if="employee.filename">
                    <img :src="'/documents/' + employee.filename " width="127px" alt="profile-image" class="profile" />
                </template>
                <template v-else>
                    <img src="/images/profile.png" width="127px" alt="profile-image" class="profile" />
                </template>
                <div class="information">
                    <div class="name-info">
                        <h5 class="personal-name">{{ employee.name }}</h5>
                        <h6 class="position">{{ employee.position }}</h6>
                        <h4 class="date-joined">Date Joined: <span>{{ formatDate(employee.date_joined) }}</span></h4>
                    </div>
                </div>
                <div class="personal-info">
                    <h2>Personal Information: </h2>
                    <p>Birth date <span class="colon">:</span> <span
                            class="answer">{{ formatDate(employee.birth_date) }}</span></p>
                    <!-- <p>Gender <span class="colon">:</span> <span class="answer">Female</span></p> -->
                    <p>Email Address <span class="colon">:</span> <span class="answer"> {{ employee.email }}</span></p>
                    <p>Mobile Number <span class="colon">:</span> <span
                            class="answer">{{ employee.mobile_number }}</span> </p>
                </div>
            </div>
        </div>
        <EditEmployeePopup :showPopup="showPopup" :employee="employee" @close="ResetData($event)"></EditEmployeePopup>
    </div>
</template>
<script>
    import EditEmployee from '../general/popup/EmployeeEditComponent.vue'
    export default {
        components: {
            EditEmployeePopup: EditEmployee
        },
        data() {
            return {
                showPopup: false
            }
        },
        props: ['employee'],
        mounted() {

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
            ResetData(event) {
                this.showPopup = false
                this.employee.name = event.name
                this.employee.position = event.position
                this.employee.date_joined = event.date_joined
                this.employee.birth_date = event.birth_date
                this.employee.mobile_number = event.mobile_number
            }
        }
    }

</script>

<style scoped>
    .card {
        min-height: 355px;
    }

    .name-info {
        position: absolute;
        right: 35px;
    }

    .name-info .personal-info {
        font-size: 10px;
    }

    .name-info .personal-name {
        font-size: 19px;
        color: black;
    }

    .name-info .position {
        font-size: 14px;
        font-style: italic;
        font-weight: 500;
    }

    .personal-info {
        position: absolute;
        top: 156px;
    }

    .personal-info .colon {
        left: 126px;
        position: absolute;
    }

    .personal-info .answer {
        left: 156px;
        position: absolute;
        width: 100%;
    }

    .personal-info p {
        font-size: 15px;
        font-weight: 600;
        line-height: 18px;
    }

    /*Profile card 2*/
    .profile-card-2 .card-img-block {
        float: left;
        width: 100%;
        height: 150px;
        overflow: hidden;
    }

    .profile-card-2 .card-body {
        position: relative;
    }

    .profile-card-2 .profile {
        border-radius: 10%;
        position: absolute;
        top: 10px;
        left: 20%;
        max-width: 200px;
        border: 3px solid rgba(255, 255, 255, 1);
        -webkit-transform: translate(-50%, 0%);
        transform: translate(-50%, 0%);
    }

    .profile-card-2 h5 {
        font-weight: 600;
        color: #6ab04c;
    }

    .profile-card-2 .card-text {
        font-weight: 300;
        font-size: 15px;
    }

    .profile-card-2 .icon-block {
        float: left;
        width: 100%;
    }

    .profile-card-2 .icon-block a {
        text-decoration: none;
    }

    .profile-card-2 i {
        display: inline-block;
        font-size: 16px;
        color: #6ab04c;
        text-align: center;
        border: 1px solid #6ab04c;
        width: 30px;
        height: 30px;
        line-height: 30px;
        border-radius: 50%;
        margin: 0 5px;
    }

    .profile-card-2 i:hover {
        background-color: #6ab04c;
        color: #fff;
    }

</style>
