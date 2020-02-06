<template>
    <b-navbar toggleable="sm" type="light" variant="info">
        <!-- MODAL PASSWORD -->
        <!-- bv::show::modal -->

        <div>
        <b-modal id="modalUserData" no-close-on-backdrop hide-footer>
            <template v-slot:modal-title>
                Setup User Data
            </template>
            <div class="d-block text-center">
            <h3>Hello From This Modal!</h3>
            </div>
            <b-button class="mt-3" block @click="$bvModal.hide('modalUserData')">Close Me</b-button>
        </b-modal>
        </div>



        <b-navbar-brand><b>INDO</b>GROSIR</b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav v-if="$auth.check(2)">
              <div v-for="(route, key) in routes.user">
                <!-- <b-nav-item v-if="route.modal" @click="$bvModal.show('modalSuppSite')">
                  {{route.name}}
                </b-nav-item> -->
                <b-nav-item v-bind:key="route.path" :to="{ name : route.path }" :key="key">
                  {{route.name}}
                </b-nav-item>
              </div>
            </b-navbar-nav>

            <b-navbar-nav v-if="$auth.check(1)">
                <b-nav-item v-for="(route, key) in routes.admin" v-bind:key="route.path" :to="{ name : route.path }" :key="key">{{route.name}}</b-nav-item>
            </b-navbar-nav>

             <b-navbar-nav class="ml-auto" v-if="$auth.check()">
                <b-nav-item-dropdown right>
                        <!-- Using 'button-content' slot -->
                    <template v-slot:button-content>
                        <strong>{{$auth.user().username}}</strong>
                    </template>
                    <b-dropdown-item href="#" @click="$bvModal.show('modalUserData')">Change Setting</b-dropdown-item>
                    <b-dropdown-item href="#" @click.prevent="$auth.logout()">Sign Out</b-dropdown-item>
                </b-nav-item-dropdown>
             </b-navbar-nav>
        </b-collapse>
    </b-navbar>


    </template>
<script>

import branchlist from '../components/branch-user-list.vue'

  export default {
    data() {
      return {
        // show:false,
        routes: {
          // LOGGED USER
          user: [
            { name: 'Inquiry', path: 'dashboard' },
            { name: 'Input TTF', path: 'User.InputTTF'},
            // { name: 'Input TTF', path },
            { name: 'Upload TTF', path: 'admin.dashboard' }
          ],
          // LOGGED ADMIN
          admin: [
            { name: 'Dashboard', path: 'admin.dashboard' }
          ]
        }
      }
    },
     components: {
      branchlist
    }

    // ,
    // mounted: function () {
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

