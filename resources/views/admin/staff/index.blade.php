@extends('layouts.admin')
@section('header_title', 'Staff Members')

@section('content')
<div class="space-y-6" x-data="staffManagement()">
    <!-- Header & Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Staff Members</h2>
            <p class="text-white/60 text-sm mt-1">Kelola akun kasir dan hak akses aplikasi.</p>
        </div>
        <button @click="openAddModal()" class="w-full sm:w-auto px-4 py-2 bg-primary hover:bg-primary/90 text-black text-sm font-bold rounded-xl transition-colors shadow-[0_0_15px_rgba(255,183,3,0.3)] flex items-center justify-center space-x-2">
            <span class="material-symbols-outlined text-[20px]">person_add</span>
            <span>Tambah Staff</span>
        </button>
    </div>

    <!-- Alert Messages -->

    <!-- Filters & Search -->
    <div class="bg-white/5 border border-white/10 rounded-2xl p-4 backdrop-blur-sm relative overflow-hidden mb-6">
        <form action="{{ route('admin.staff.index') }}" method="GET" class="relative z-10 flex flex-col sm:flex-row gap-4"
              x-data="{}"
              @submit.prevent="
                  let form = $event.target;
                  let params = new URLSearchParams(new FormData(form));
                  Array.from(params.keys()).forEach(key => {
                      if (!params.get(key)) params.delete(key);
                  });
                  window.location.href = form.action + '?' + params.toString();
              ">
            <!-- Search -->
            <div class="flex-1 relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-[20px]">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau no telepon..." class="w-full bg-black/40 border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white placeholder-white/40 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" @input.debounce.300ms="$el.form.requestSubmit()">
            </div>
            
            <!-- Role Filter -->
            <div class="sm:w-40">
                <select name="role" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors appearance-none [&>option]:bg-[#1A1A24]" @change="$el.form.requestSubmit()">
                    <option value="">Semua Role</option>
                    <option value="owner" {{ request('role') === 'owner' ? 'selected' : '' }}>Owner</option>
                    <option value="kasir" {{ request('role') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="inactive" {{ request('role') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            
            <!-- Reset Button -->
            @if(request()->hasAny(['search', 'role']))
                <a href="{{ route('admin.staff.index') }}" class="px-4 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-white text-sm font-medium flex items-center justify-center transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Staff Table -->
    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl overflow-hidden">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="text-xs text-slate-400 uppercase bg-white/5 border-b border-white/10">
                <tr>
                    <th class="px-6 py-4 font-medium">Nama Lengkap</th>
                    <th class="px-6 py-4 font-medium">Email</th>
                    <th class="px-6 py-4 font-medium">Role</th>
                    <th class="px-6 py-4 font-medium">Telepon</th>
                    <th class="px-6 py-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($staffs as $staff)
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-medium text-white">{{ $staff->full_name }}</div>
                    </td>
                    <td class="px-6 py-4">{{ $staff->email ?? '-' }}</td>
                    <td class="px-6 py-4">
                        @if($staff->role === 'owner')
                            <span class="px-2.5 py-1 text-xs rounded-lg bg-indigo-500/20 text-indigo-400 border border-indigo-500/20">Owner</span>
                        @elseif($staff->role === 'kasir')
                            <span class="px-2.5 py-1 text-xs rounded-lg bg-emerald-500/20 text-emerald-400 border border-emerald-500/20">Kasir</span>
                        @else
                            <span class="px-2.5 py-1 text-xs rounded-lg bg-slate-500/20 text-slate-400 border border-slate-500/20">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $staff->phone ?? '-' }}</td>
                    <td class="px-6 py-4 text-right">
                        <button @click="openEditModal({{ json_encode($staff) }})" class="p-2 text-blue-400 hover:bg-blue-400/10 rounded-lg transition-colors" title="Edit">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </button>
                        @if($staff->id !== auth()->id())
                        <button @click="openDeleteModal('{{ $staff->id }}', '{{ $staff->full_name }}')" class="p-2 text-rose-400 hover:bg-rose-400/10 rounded-lg transition-colors" title="Hard Delete">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">Belum ada data staff.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($staffs->hasPages())
        <div class="mt-6">
            {{ $staffs->appends(request()->query())->links() }}
        </div>
    @endif

    <!-- Add Modal -->
    <div x-show="isAddModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" style="display: none;" x-transition>
        <div class="bg-[#1A1A24] border border-white/10 rounded-2xl w-full max-w-md p-6 shadow-2xl relative" @click.away="isAddModalOpen = false">
            <h3 class="text-xl font-bold text-white mb-4">Tambah Staff</h3>
            <form action="{{ route('admin.staff.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Nama Lengkap</label>
                        <input type="text" name="full_name" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Email</label>
                        <input type="email" name="email" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Password</label>
                        <input type="password" name="password" required minlength="6" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Role</label>
                        <select name="role" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:border-blue-500 transition-colors [&>option]:bg-[#1A1A24]">
                            <option value="kasir" selected>Kasir</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="isAddModalOpen = false" class="px-4 py-2.5 text-sm font-medium text-white/70 hover:text-white bg-white/5 hover:bg-white/10 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary/90 text-black font-bold rounded-xl transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="isEditModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" style="display: none;" x-transition>
        <div class="bg-[#1A1A24] border border-white/10 rounded-2xl w-full max-w-md p-6 shadow-2xl relative" @click.away="isEditModalOpen = false">
            <h3 class="text-xl font-bold text-white mb-4">Edit Staff</h3>
            <form :action="'{{ url('dashboard/staff') }}/' + editData.id" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Nama Lengkap</label>
                        <input type="text" name="full_name" x-model="editData.full_name" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Telepon (Opsional)</label>
                        <input type="text" name="phone" x-model="editData.phone" class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:border-blue-500 transition-colors">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1">Role (Status)</label>
                        <select name="role" x-model="editData.role" required class="w-full px-4 py-2 bg-white/5 border border-white/10 rounded-xl text-white focus:outline-none focus:border-blue-500 transition-colors [&>option]:bg-[#1A1A24]">
                            <option value="kasir">Kasir</option>
                            <option value="owner">Owner</option>
                            <option value="inactive">Inactive (Soft Delete)</option>
                        </select>
                        <p class="text-xs text-slate-400 mt-1">Gunakan 'Inactive' untuk menonaktifkan akun sementara.</p>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="isEditModalOpen = false" class="px-4 py-2.5 text-sm font-medium text-white/70 hover:text-white bg-white/5 hover:bg-white/10 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary/90 text-black font-bold rounded-xl transition-colors">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-show="isDeleteModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm" style="display: none;" x-transition>
        <div class="bg-[#1A1A24] border border-rose-500/20 rounded-2xl w-full max-w-sm p-6 shadow-2xl relative" @click.away="isDeleteModalOpen = false">
            <div class="text-center">
                <div class="w-16 h-16 rounded-full bg-rose-500/10 flex items-center justify-center mx-auto mb-4 text-rose-500">
                    <span class="material-symbols-outlined text-3xl">warning</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Hapus Permanen?</h3>
                <p class="text-slate-400 text-sm mb-6">Anda yakin ingin menghapus <span class="text-white font-medium" x-text="deleteData.name"></span> secara permanen dari sistem? Aksi ini tidak dapat dibatalkan.</p>
                
                <form :action="'{{ url('dashboard/staff') }}/' + deleteData.id" method="POST" class="flex space-x-3">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="isDeleteModalOpen = false" class="flex-1 py-2 text-slate-300 hover:text-white hover:bg-white/5 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="flex-1 py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-medium transition-colors">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function staffManagement() {
    return {
        isAddModalOpen: false,
        isEditModalOpen: false,
        isDeleteModalOpen: false,
        editData: {
            id: '',
            full_name: '',
            phone: '',
            role: ''
        },
        deleteData: {
            id: '',
            name: ''
        },
        openAddModal() {
            this.isAddModalOpen = true;
        },
        openEditModal(staff) {
            this.editData = {
                id: staff.id,
                full_name: staff.full_name,
                phone: staff.phone || '',
                role: staff.role
            };
            this.isEditModalOpen = true;
        },
        openDeleteModal(id, name) {
            this.deleteData = { id, name };
            this.isDeleteModalOpen = true;
        }
    }
}
</script>
@endsection
