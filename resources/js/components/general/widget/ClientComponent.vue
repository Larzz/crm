<template>
    <div>
        <div class="card profile-card-2">
            <div class="card-body pt-5">
                <img src="https://randomuser.me/api/portraits/men/64.jpg" alt="profile-image" class="profile" />
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
                    <p>Gender <span class="colon">:</span> <span class="answer">Female</span></p>
                    <p>Email Address <span class="colon">:</span> <span class="answer"> {{ employee.email }}</span></p>
                    <p>Mobile Number <span class="colon">:</span> <span
                            class="answer">{{ employee.mobile_number }}</span> </p>
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
    }

</script>

<style>

</style>
