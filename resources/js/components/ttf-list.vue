<template>
  <div>
    <!-- <b-button @click="toggleBusy">Toggle Busy State</b-button> -->

    <!-- <b-table :items="items"  class="mt-3" outlined>
        :items="inq_ttf_views.data"
        -->
        <div>
        <b-modal
        id="modalResetPassword"
        centered
        size="lg"
        no-close-on-backdrop
        hide-footer

        hide-header-close
        v-model="show">

            <template v-slot:modal-header="{ close }">
            <strong>Change Your initial Password</strong>
            </template>

            <form @submit.prevent="createUser">
                <div class="modal-body">
                    <!--npm run dev

                        <div class="form-group">
                        <input v-model="form.name" type="text" name="name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Name">
                        <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                        <input v-model="form.email" type="text" name="email"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Email">
                        <has-error :form="form" field="email"></has-error>
                    </div>
                     <div class="form-group">
                        <input v-model="form.password" type="password" name="password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Password">
                        <has-error :form="form" field="password"></has-error>
                    </div>
                      <div class="form-group">
                        <input v-model="form.password" type="password" name="password"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('reconpassword') }" placeholder="Password">
                        <has-error :form="form" field="password"></has-error>
                    </div> -->
                    <div class="form-group">
                        <input v-validate="'required'" ref="password1" name="password1" type="password" class="form-control" placeholder="Password">
                        <has-error :form="form" field="password"></has-error>
                    </div>
                    <div class="form-group">
                        <input v-validate="'required|confirmed:$password1'" name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password" data-vv-as="password">
                        <has-error :form="form" field="password_confirmation"></has-error>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" block >Close</button>
                    <button type="submit" class="btn btn-primary">SAVE</button>
                </div>
            </form>

        </b-modal>
        </div>


    <b-table hover responsive bordered :items="ttf" :fields="fields" :busy="isBusy" show-empty align="center" valign="middle"  >
        <template v-slot:cell(TTF_NUM)="row" >

            <b-button
            class="btn btn-danger btn-sm"
            @click="info(row.item, row.index, $event.target)"
            :disabled="disarm"
            >
                <div v-if="disarm" class="lds-dual-ring">
                    <b-spinner small></b-spinner>
                    <span class="sr-only">Loading...</span>
                </div>
                <span v-else>{{row.item.TTF_NUM}}</span>
            </b-button>
        </template>

      <template v-slot:table-busy>
        <div class="text-center text-danger my-2">
          <b-spinner class="align-middle"></b-spinner>
          <strong>Loading...</strong>
        </div>
      </template>
    </b-table>

    <b-modal :id="infoModal.id" :title="infoModal.title" ok-only @hide="resetInfoModal">
	    <pre>{{ infoModal.content }}</pre>
	</b-modal>

  </div>
</template>

<script>
  export default {
    data() {
      return {
        show:false,
        isBusy: false,
        disarm:false,
        ttf: [],
        filter: null,
        currentPage: 1,
        perPage: 10,
        totalRows: null,
        selectedID: null,
        align:'center',
        fields: [
                { key: 'TTF_NUM', label: 'No. TTF' },
                { key: 'TTF_STATUS', label: 'Status', sortable: true},
                { key: 'TTF_DATE', label: 'Tgl.TTF', sortable: true },
                { key: 'TTF_RETURN_DATE', label: 'Tgl.Kembali', sortable: true},
                { key: 'TTF_GIRO_DATE', label: 'Tgl.Giro', sortable: true},
                { key: 'COUNT_FP', label: 'Total FP' },
                { key: 'TOTAL_FP_DPP', label: 'DPP FP' },
                { key: 'TOTAL_FP_TAX', label: 'TAX FP' },
                { key: 'COUNT_BPB', label: 'Total BPB' },
                { key: 'TOTAL_BPB_DPP', label: 'DPP BPB' },
                { key: 'TOTAL_BPB_TAX', label: 'DPP TAX' },
                { key: 'SELISIH_DPP', label: 'Sel.DPP' },
                { key: 'SELISIH_TAX', label: 'Sel.TAX' }
            ],
        search: '',
        infoModal: {
					    id: 'info-modal',
					    title: '',
					    content: ''
                    },
        // users: {},
        form: new Form({
                name: '',
                email: '',
                password: ''
        })
      }
    },
    mounted(){
        this.getResults();
    },
    methods: {
         getResults(ctx, callback) {
                this.isBusy = true;
                var suppId = this.$auth.user().supp_id;
                var orgId = this.$auth.user().org_id;
              axios.post('/ttf',{
                    supp_id: suppId,
                    org_id: orgId
                })
              .then((res) => {
                        this.ttf = res.data.ttf
                        this.totalRows = res.data.length;

                        //CHECK USER PERLU GANTI PASSWORD TO GA//
                        if(this.$auth.user().reset_flag == 'Y')
                        {
                            this.show = true
                        }

                        return this.ttf;

                    }, () => {
                        this.has_error = true
                    });
                // this.$http({
                //     url: 'ttf/${this.$auth.user().supp_id}',
                //     method: 'POST'
                //     })
                //     .then((res) => {
                //         this.ttf = res.data.ttf
                //         this.totalRows = res.data.length;
                //         return this.ttf;
                //     }, () => {
                //         this.has_error = true
                //     });
                     this.isBusy = false;
            },
        info(item, index, button) {
		 							// this.infoModal.title = `Row index: ${index}`
                                    // this.infoModal.content = item.TTF_ID
                                    this.disarm = true;
                                    axios({
                                            url: '/genttf',
                                            method: 'POST',
                                            data: {
                                                        ttf_id: item.TTF_ID,
                                                        ttf_num: item.TTF_NUM
                                                    },
                                            responseType: 'blob', // important
                                        }).then((response) => {
<<<<<<< HEAD
                                            window.URL = window.URL || window.webkitURL;
                                            const url = window.URL.createObjectURL(new Blob([response.data],{type: 'application/pdf'}));
                                            this.disarm = false;
           
                                            window.open(url,'_blank');
                                           
=======
                                            const url = window.URL.createObjectURL(new Blob([response.data]));
                                            // const link = document.createElement('a');
                                            // link.href = url;

                                            window.open(url,'_blank');
                                            this.disarm = false;
                                            // link.setAttribute('download', 'file.pdf');
                                            // document.body.appendChild(link);
                                            // link.click();
>>>>>>> 730a4f5e0a45fdfbd4987c405170fa8f2c6f1bc8
                                        });



							        // this.$root.$emit('bv::show::modal', this.infoModal.id, button)
							      },
		resetInfoModal() {
					        this.infoModal.title = ''
					        this.infoModal.content = ''
                          },
        // loadUsers(){
        //     axios.get('users').then(({ data }) => (this.users = data.data))
        // },
        createUser(){
            alert('HAHAHAH');
        }
    //         ,
    //   toggleBusy() {
    //     this.isBusy = !this.isBusy
    //   }
    },
    created() {
        // this.loadUsers()
    }
  }
</script>
