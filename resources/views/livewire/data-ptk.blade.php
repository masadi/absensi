<div>
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between mb-2">
                <div class="col-4">
                    <div class="d-inline">
                        <select class="form-select" wire:model="per_page" wire:change="loadPerPage">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
                <div class="col-4">
                    <input type="text" class="form-control" placeholder="Cari data..." wire:model="search">
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_ptk as $ptk)
                    <tr>
                        <td>{{$ptk->nama}}</td>
                        <td>{{$ptk->email}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row justify-content-between mt-2">
                <div class="col-4">
                    <p>Showing {{ $data_ptk->firstItem() }} to {{ $data_ptk->firstItem() + $data_ptk->count() - 1 }} of {{ $data_ptk->total() }} items</p>
                </div>
                <div class="col-4">
                    {{ $data_ptk->links('components.custom-pagination-links-view') }}
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="display:none">
      	<div class="col-md-4 mb-2">
            <div class="form-inline">
                
            </div>
        </div>
        <div class="col-md-4 offset-md-4">
            <div class="form-inline float-right">
                <label class="mr-2">Search</label>
                <input type="text" class="form-control" wire:change="search">
            </div>
        </div>
      </div>
      	    <!--b-table striped hover :items="items" :fields="fields" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" show-empty>
                <template v-slot:cell(actions)="row">
                    <b-dropdown size="sm" id="dropdown-dropleft" dropleft text="Aksi" variant="success">
                        <b-dropdown-item href="javascript:" @click="openShowModal(row)"><i class="fas fa-eye"></i> Detil</b-dropdown-item>
                        <b-dropdown-item href="javascript:" @click="uploadFoto(row.item.bangunan_id)"><i class="fas fa-upload"></i> Upload Foto</b-dropdown-item>
                        <b-dropdown-item href="javascript:" @click="inputKondisi(row)"><i class="fas fa-list"></i> Input Kondisi</b-dropdown-item>
                        <b-dropdown-item href="javascript:" @click="editData(row)"><i class="fas fa-edit"></i> Edit</b-dropdown-item>
                        <b-dropdown-item href="javascript:" @click="deleteData(row.item.bangunan_id)"><i class="fas fa-trash"></i> Hapus</b-dropdown-item>
                    </b-dropdown>
                </template>
            </b-table-->
      
      	<!-- BAGIAN INI AKAN MENAMPILKAN JUMLAH DATA YANG DI-LOAD -->
          <div class="row">
        <div class="col-md-6">
            
        </div>
      
      	<!-- BLOCK INI AKAN MENJADI PAGINATION DARI DATA YANG DITAMPILKAN -->
        <div class="col-md-6">
          	<!-- DAN KETIKA TERJADI PERGANTIAN PAGE, MAKA AKAN MENJALANKAN FUNGSI changePage -->
            <!--b-pagination
                v-model="meta.current_page"
                :total-rows="meta.total"
                :per-page="meta.per_page"
                align="right"
                @change="changePage"
                aria-controls="dw-datatable"
            ></b-pagination-->
        </div>
        </div>
</div>
