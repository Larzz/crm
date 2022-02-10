<template>
    <div>
        <div class="card profile-card-2">
            <div class="card-body pt-5">
                <div class="information">
                    <div class="name-info">
                        <h5 class="personal-name">{{ user.name }}</h5>
                        <h4 class="date-joined">Date Added: {{ formatDate(user.created_at) }} <span></span></h4>
                    </div>
                </div>
                <div class="personal-info">
                    <p>Email Address <span class="colon">: {{ user.email }}</span> <span class="answer"> </span></p>
                    <p>Mobile Number <span class="colon">: {{ user.mobile_number }}</span> <span class="answer"></span> </p>
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

<style>

</style>
