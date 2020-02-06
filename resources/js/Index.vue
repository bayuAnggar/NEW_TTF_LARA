<template>
  <div id="main">
    <header id="header">
      <navigationMenu></navigationMenu>
    </header>
    <body>
    <div id="content">
      <router-view></router-view>
    </div>
    </body>
  </div>
</template>

<script>
  import navigationMenu from './components/Menu.vue'
  export default {
    data() {
      return {
        //
        show :false
      }
    },
    components: {
      navigationMenu
    }
    // ,
    //  mounted: function () {
    //     this.$nextTick(function () {
    //         this.checkUser();
    //     })
    // }
    // ,
    //  methods: {
    //   checkUser() {
    //     alert(this.$auth.user().reset_flag );
    //     if(this.$auth.user().reset_flag == 'Y')
    //     {
    //         this.show = true
    //     }
    //   }
    // }
  }
</script>
