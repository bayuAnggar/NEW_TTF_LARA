<template>
    <div class="container-fluid">
        <template>
            <b-breadcrumb :items="items"></b-breadcrumb>
        </template>

        <div class="card card-default">
            <div class="card-header">User Dashboard</div>
                <div class="card-body">
                    <ttflist></ttflist>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import ttflist from '../../components/ttf-list.vue'

  export default {
       data() {
        return {
            items: [
                {
                    text: 'Inquiry TTF',
                    active: true
                }
            ]
        }
        },
    mounted() {
      //
    },
    components: {
      ttflist
    }
  }
</script>
