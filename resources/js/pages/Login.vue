<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-6">
        <div class="card card-default">
          <div class="card-header">Login</div>
          <div class="card-body">
            <!-- <div class="alert alert-danger" v-if="has_error && !success">
              <p v-if="error == 'login_error'">Validation Errors.</p>
              <p v-else>Error, unable to connect with these credentials.</p>
            </div> -->
            <div v-if="has_error && !success" >
                <b-alert
                :show="dismissCountDown"
                fade
                variant="danger"
                @dismissed="dismissCountDown=0"
                @dismiss-count-down="countDownChanged"
                >
                    <p v-if="error == 'login_error'">Unable to connect with these credentials.</p>
                    <p v-else>Error, unable to connect with these credentials.</p>
                    <!-- <b-progress
                        variant="warning"
                        :max="dismissSecs"
                        :value="dismissCountDown"
                        height="4px"
                    ></b-progress> -->
                </b-alert>
            </div>

            <form autocomplete="off" @submit.prevent="login" method="post">
              <div class="form-group">
                <label for="Username">Username</label>
                <input type="username" id="username" class="form-control" v-model="username" placeholder="USERNAME" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" v-model="password" placeholder="PASSWORD" required>
              </div>
              <!-- <button type="submit" class="btn btn-primary">Signin</button> -->
              <b-button size="lg" variant="success" type="submit">LOGIN</b-button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        username: null,
        password: null,
        success: false,
        has_error: false,
        error: '',
        dismissSecs: 2,
        dismissCountDown: 0
      }
    },
    mounted() {
      //
    },
    methods: {
      login() {
        // get the redirect object
        var redirect = this.$auth.redirect()
        var app = this

        this.$auth.login({
          data: {
            username: app.username,
            password: app.password
          },
          success: function() {
            // handle redirection
            app.success = true
            const redirectTo = redirect ? redirect.from.name : this.$auth.user().role === 1 ? 'admin.dashboard' : 'dashboard'
            // const redirectTo = 'admin.dashboard'
            this.$router.push({name: redirectTo})
          },
          error: function(res) {
            app.has_error = true
            this.dismissCountDown = this.dismissSecs
            app.error = res.response.data.error
          },
          rememberMe: false,
          fetchUser: true
        })
      },
      countDownChanged(dismissCountDown) {
        this.dismissCountDown = dismissCountDown
      }
    }
  }
</script>


