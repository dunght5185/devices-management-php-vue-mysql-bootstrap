<content id="content">
   <div v-if="pesan.teks !== null" :class="'alert alert-'+pesan.tipe+' fadeInUp animated'">
      {{pesan.teks}}
      <button type="button" class="close" aria-label="Close" @click="pesan.teks = null">
          <span aria-hidden="true">&times;</span>
      </button>
   </div>
   <div class="search">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-3 col-md-6 mb-2">
               <select class="form-control" v-model="search.loaimay">
                  <option value="">--- Loại Máy ---</option>
                  <option v-for="option in loaimay" v-bind:value="option.id">{{ option.name }}</option>
               </select>
            </div>
            <div class="col-lg-3 col-md-6 mb-2">
               <select class="form-control" v-model="search.phongban">
                  <option value="">--- Phòng Ban ---</option>
                  <option v-for="option in phongban" v-bind:value="option.id">Phòng {{ option.name }}</option>
               </select>
            </div>
            <div class="col-lg-3 col-md-6 mb-2">
               <input type="text" class="form-control" v-model="search.name" placeholder="Tên nhân viên">
            </div>
            <div class="col-lg-3 col-md-6 mb-2">
               <input type="text" class="form-control" v-model="search.service_tag" placeholder="Mã thiết bị">
            </div>
         </div>
      </div>
   </div>
   <div class="table__wrapper table-responsive">
     <table class="table table-bordered table-striped table-hover">
       <thead>
         <tr>
            <th></th>
            <th class="text-center" v-for="column in columns">
               <a @click="sortBy(column.value)">
                  {{ column.name }}
                  <i v-if="column.value==currentSort" v-bind:class="(currentSortDir=='asc') ? 'fa fa-sort-amount-asc' : 'fa fa-sort-amount-desc'"></i>
               </a>
            </th>
         </tr>
       </thead>
       <tbody>
         <tr v-for="(item, index) in sortedDevice" v-on:click="isi_form(item)">
            <td class="text-center" width="30">{{ index + 1 }}</td>
            <td class="nowrap" width="180">{{ item.loaimay }}</td>
            <td class="nowrap">{{ item.name }}</td>
            <td class="nowrap text-center" width="160">{{ item.phongban }}</td>
            <td class="text-center" width="160">{{ item.service_tag }}</td>
            <td class="text-center" width="180">{{ item.express_code }}</td>
            <td class="text-center" width="160">{{ item.ngay_mua }}</td>
            <td class="text-center" width="160">{{ item.tinh_trang }}</td>
         </tr>
       </tbody>
     </table>
   </div>
</content>
<script type="text/javascript">
new Vue({
  	el: "#content",
  	data: {
		url: 'localhost:8081/it/device/crud.php',
		device: [],
      phongban: [],
      loaimay: [],
      search: {
         name: "", service_tag: "", loaimay: "", phongban: ""
      },
		pesan: {
			teks: null,
			tipe: null,
		},
      form: {
         id: null,
         idmay: null,
         idban: null,
			name: '',
         service_tag: '',
         express_code: '',
         ngay_mua: '',
         tinh_trang: '',
		},
      currentSort:'phongban',
      currentSortDir:'asc',
      columns: [
         {name: 'Loại Máy', value: 'loaimay'},
         {name: 'Nhân Viên', value: 'name'},
         {name: 'Phòng Ban', value: 'phongban'},
         {name: 'Mã Thiết Bị', value: 'service_tag'},
         {name: 'Code / IP', value: 'express_code'},
         {name: 'Ngày Mua', value: 'ngay_mua'},
         {name: 'Tình Trạng', value: 'tinh_trang'},
      ],
	},
	mounted: function(){
      this.start_form();
      this.show_loaimay();
      this.show_phongban();
		this.show_device();
	},
  	methods: {
      show_loaimay() {
         this.loading = true;

         axios.get(this.url, {
            params: { work: 'loaimay' }
         })

         .then(respon => {
            console.log(respon)

            let data       = respon.data
            this.loaimay   = data;
         })
         
         .catch(error => { console.log(error) })
      },
      show_phongban() {
			this.loading = true;

			axios.get(this.url, {
				params: { work: 'phongban' }
			})

			.then(respon => {
				console.log(respon)

				let data 	  = respon.data
				this.phongban = data;
			})
			
			.catch(error => { console.log(error) })
		},
      show_device() {
         this.loading = true;

         axios.get(this.url, {
            params: { work: 'device_it' }
         })

         .then(respon => {
            console.log(respon)

            let data    = respon.data
            this.device = data;
         })
         
         .catch(error => { console.log(error) })
      },
      start_form() {
         this.form.idmay = '';
         this.form.idban = '';
      },
      sortBy: function(sortKey){
         if(sortKey === this.currentSort) {
            this.currentSortDir = this.currentSortDir==='asc'?'desc':'asc';
         }
         this.currentSort = sortKey;
      }
   },
   computed: {
      filteredList() {
         return this.device.filter((item) => {
            let filtered = true
            let filterLoaimay  = this.search.loaimay, 
                filterPhongban = this.search.phongban

            var name          = item.name.toLowerCase().includes(this.search.name.toLowerCase())
            var service_tag   = item.service_tag.toLowerCase().includes(this.search.service_tag.toLowerCase())

            if(filterLoaimay && filterLoaimay.length > 0){
                filtered = item.idmay == filterLoaimay
            }
            
            if(filtered){
               if(filterPhongban && filterPhongban.length > 0){
                  filtered = item.idban == filterPhongban
               }
            }

            return name && service_tag && filtered
         })
      },
      sortedDevice() {
         return this.filteredList.sort((a,b) => {
            let modifier = 1;
            
            if(this.currentSortDir === 'desc') modifier = -1;
            if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
            if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
            
            return 0;
         });
      }
   }
});
</script>